<template>
<div>
 <!-- Search Input Group -->
 <div>
  <div class="container input-group" style="align-items:center">
    <div class="input-group mb-3">
      <input type="text" class="form-control" @keyup="onType" v-model="searchTerm" placeholder="How can I assist you in understanding the meanings of the Holy Quran ?">
      <span class="input-group-text"><div @click="searchWord" style="cursor:pointer">Search</div></span>
      <span class="input-group-text"><div @click="toggleVoiceRecognition" style="cursor:pointer">🎤 {{ isListening ? 'Stop' : 'Speak' }}</div></span>
    </div>

   <div class="form-check form-check-inline">
    <input class="form-check-input mt-1" type="checkbox" v-model="filters.translation" id="translationCheckbox">
    <b class="form-check-label" for="translationCheckbox">Translation</b>
   </div>

   <div class="form-check form-check-inline">
    <input class="form-check-input mt-1" type="checkbox" v-model="filters.tafseer" id="tafseerCheckbox">
    <b class="form-check-label" for="tafseerCheckbox">Tafseer</b>
   </div>

   <div class="form-check form-check-inline">
    <input class="form-check-input mt-1" type="checkbox" v-model="filters.transliteration" id="transliterationCheckbox">
    <b class="form-check-label" for="transliterationCheckbox">Transliteration</b>
   </div>


    
    <!-- Optional: You can show a message when recording starts -->
    <p v-if="isListening">Listening...</p>

  </div>
 </div> 

 <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasResults" style="width: 60%;">
  <div class="offcanvas-header">
   <h5 class="offcanvas-title">Search Results</h5>
   <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body text-left custom-offcanvas">

   <div v-if="filteredResults.length">
    <div v-for="result in filteredResults" :key="result.id" class="result-item" >
    
     <div :id="'result-' + result.id" >
      <!-- Display Surah ID and Ayah ID -->
      <div class="text-left pb-2">
       <h4>{{ result.ayah.surah_id }} : {{ result.ayah.ayah_id }}</h4>
      </div>
      <!-- Display Ayah Text -->
      <h3 class="text-right">{{ result.ayah.ayah_text }}</h3>
      <!-- Display Translated Text -->
      <div v-if="filters.translation">
        <b>Translation:</b>
        <p v-html="highlightSearch(result.translation)"></p>
      </div>
      <div v-if="filters.tafseer">
        <b>Tafseer:</b>
        <p v-html="highlightSearch(result.tafseer)"></p>
      </div>
      <div v-if="filters.transliteration">
        <b>Transliteration:</b>
        <p v-html="highlightSearch(result.transliteration)"></p>
      </div>
     </div>

     <!--
        <div class="container pt-2 row text-center">
          <div class="col">
            <i class="bi bi-file-earmark-pdf h4 me-3 text-center" style="cursor: pointer;" @click="downloadPDF(result)"></i>
          </div> 
          <div class="col">
            <i class="bi bi-clipboard-check h4 me-3 text-center" style="cursor: pointer;" @click="copyTranslationText(result.translation)"></i>
          </div>
          <div class="col">
            <i class="bi bi-whatsapp h4 me-3 text-center" style="cursor: pointer;" @click="shareViaWhatsapp(result)"></i>
          </div>
        </div>
      -->

     <hr>
    </div>
   </div>
    <div v-else-if="!loading" class="text-center">
      <h5>No search results found.</h5>
    </div>

  </div>
 </div>

</div>
</template>

<style scoped>
.alert-container {
 position: absolute;
 /* Position it absolutely */
 top: 10px;
 /* Adjust this value to control vertical position */
 left: 10px;
 /* Adjust this value to control horizontal position */
 z-index: 1000;
 /* Ensure it appears above other content */
}

.alert {
 margin-bottom: 10px;
 /* Add some spacing between alerts */
}

.custom-offcanvas {
 background-color: #10584f;
 color: white;
}

.custom-offcanvas .result-item {
 margin-bottom: 15px;
}

.pdf-content {
 /* Adjust text properties */
 font-family: Arial, sans-serif;
 /* Set a specific font */
 font-size: 14px;
 /* Set a base font size */
 line-height: 1.5;
 /* Set line height for readability */
 color: black;
 /* Set default text color to black */
 padding: 10px;
 /* Add padding for better layout */
}

.translation-text {
 color: black;
 /* Ensure translation text is visible */
 margin-top: 10px;
 /* Add spacing above the translation */
}
.suggestions-list {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.suggestions-list li {
  padding: 10px;
  cursor: pointer;
}

.suggestions-list li:hover {
  background-color: #f1f1f1;
}
</style>

<script>
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

export default {
  mounted() {
    // Initialize SpeechRecognition instance
    this.recognition = new window.SpeechRecognition();
    this.recognition.lang = 'en-US';
    this.recognition.continuous = true; // Keep listening until stopped

    // Handle result from speech recognition
    this.recognition.onresult = (event) => {
      const transcript = event.results[0][0].transcript;
      this.searchTerm = transcript; // Update searchTerm with the voice input
      this.searchWord(); // Trigger search after receiving voice input
    };

    // Stop listening when recognition ends
    this.recognition.onend = () => {
      this.isListening = false; // Update state when recognition ends
    };
  },
 data() {
  return {
   searchTerm: '',
   filteredResults: [],
   suggestions: [],
   filters: {
    translation: true, // Default filter for translation enabled
    tafseer: false, // Default filter for tafseer disabled
    transliteration: false // Default filter for transliteration disabled
   },
   isListening: false,
   recognition: null,
  };
 },
 props: {
  result: Object
 },
 methods: {
  toggleVoiceRecognition() {
      if (!this.isListening) {
        this.startVoiceRecognition();
      } else {
        this.stopVoiceRecognition();
      }
    },
    startVoiceRecognition() {
      this.isListening = true; // Set listening state to true
      this.recognition.start(); // Start voice recognition
    },
    stopVoiceRecognition() {
      this.isListening = false; // Set listening state to false
      this.recognition.stop(); // Stop voice recognition
    },
  onType() {
    if (this.searchTerm.length >= 3) {
      this.fetchSuggestions();
    } else {
      this.suggestions = []; // Clear suggestions if less than 3 characters
    }
  },
  downloadPDF(result) {
   const element = document.getElementById(`result-${result.id}`);

   // Ensure the text is visible before capturing
   element.style.color = 'black'; // Set text color to black for visibility

   html2canvas(element).then((canvas) => {
    const imgData = canvas.toDataURL('image/png');
    const pdf = new jsPDF({
     orientation: 'portrait',
     unit: 'mm',
     format: 'a4',
    });
    const fileName = `Surah_${result.ayah.surah_id}_Ayah_${result.ayah.ayah_id}.pdf`;

    pdf.addImage(imgData, 'PNG', 10, 10, 190, 0); // Adjust the dimensions as needed
    // Save the PDF with a dynamic name
    pdf.save(fileName);

    // Reset text color back to original after capture
    element.style.color = ''; // Reset to original or any preferred color
   }).catch((error) => {
    console.error('Error capturing the element:', error);
   });
  },
  copyText(result) {
   // Logic to copy the text from the result
   const textToCopy = `${result.ayah.surah_id}:${result.ayah.ayah_id} - ${result.ayah.ayah_text}\n${result.translation}`;
   navigator.clipboard.writeText(textToCopy);
   alert('Text copied to clipboard');
  },
  shareViaWhatsapp(result) {
   const surahInfo = `${result.ayah.surah_id}:${result.ayah.ayah_id}`;
   const ayahText = `Ayah: ${result.ayah.ayah_text}`;
   const ayahTranslation = `Ayah Translation: ${result.ayah.ayah_text}`;
   const note = `Note: ${result.translation}`;

   const message = `${surahInfo}\n${ayahText}\n${ayahTranslation}\n${note}`;
   const encodedMessage = encodeURIComponent(message); // Encode special characters
   const whatsappUrl = `https://wa.me/?text=${encodedMessage}`;
   window.open(whatsappUrl, '_blank');
  },
  searchWord() {
   if (this.searchTerm.length > 0) {
    axios
     .get("/search-translations", {
      params: {
       query: this.searchTerm,
       filters: this.filters
      }
     })
     .then(response => {
      this.filteredResults = response.data;
      this.showOffcanvas();
     })
     .catch(error => {
      console.error(error);
     });
   } else {
    this.filteredResults = [];
   }
  },
  fetchSuggestions() {
    this.loading = true;
    axios
      .get("/search-translations", {
        params: {
          query: this.searchTerm,
        },
      })
      .then((response) => {
        this.suggestions = response.data.suggestions || [];
      })
      .catch((error) => {
        console.error(error);
      })
      .finally(() => {
        this.loading = false;
      });
  },
  selectSuggestion(suggestion) {
    this.searchTerm = suggestion.translation; // Update searchTerm with the selected suggestion
    this.suggestions = []; // Clear suggestions after selection
  },
  highlightSearch(translation) {
   if (!translation) {
    console.warn("The translation is undefined or null for this result:", translation);
    return '';
   }
   const regex = new RegExp(`(${this.searchTerm})`, 'gi');
   return translation.replace(regex, "<span class='highlight'>$1</span>");
  },
  copyTranslationText(text) {
   this.copyToClipboard(text)
    .then(() => {
     this.showAlertText = true;
     this.showErrorAlert = false;
     this.hideAlertAfterDelay();
    })
    .catch(() => {
     this.showAlertText = false;
     this.showErrorAlert = true;
     this.hideAlertAfterDelay();
    });
  },
  copyToClipboard(text) {
   return navigator.clipboard.writeText(text);
  },
  hideAlertAfterDelay() {
   setTimeout(() => {
    this.showAlertText = false;
    this.showErrorAlert = false;
   }, 2000);
  },
  showOffcanvas() {
   const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasResults'));
   offcanvas.show();
  },
  onInputChange() {
   this.searchWord(); // Automatically search as you type
  }
 }
};
</script>