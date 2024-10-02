<template>
<div>
 <!-- Search Input Group -->
 <div>
  <div class="container input-group" style="align-items:center">
   <input type="text" @focus="showSearchHistory" @blur="hideSearchHistory" @keyup="debouncedSearch" v-model="searchTerm" placeholder="How can I assist you in understanding the meanings of the Holy Quran?" class="form-control mr-3 main-search" />

   <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    </button>
    <ul class="dropdown-menu">
     <li>
      <a class="dropdown-item" href="#">
       <div class="form-check form-check-inline">
        <input class="form-check-input mt-1" type="checkbox" v-model="filters.translation" id="translationCheckbox">
        <p class="form-check-label" for="translationCheckbox">Translation</p>
       </div>
      </a>
     </li>
     <li>
      <a class="dropdown-item" href="#">
       <div class="form-check form-check-inline">
        <input class="form-check-input mt-1" type="checkbox" v-model="filters.tafseer" id="tafseerCheckbox">
        <span class="form-check-label" for="tafseerCheckbox">Tafseer</span>
       </div>
      </a>
     </li>
     <li>
      <a class="dropdown-item" href="#">
       <div class="form-check form-check-inline">
        <input class="form-check-input mt-1" type="checkbox" v-model="filters.transliteration" id="transliterationCheckbox">
        <p class="form-check-label" for="transliterationCheckbox">Transliteration</p>
       </div>
      </a>
     </li>
    </ul>
   </div>

   <button class="btn btn-success" @click="searchWord">Search</button>

   <!-- Voice input button -->
   <button class="btn btn-primary" @click="isListening ? stopVoiceRecognition() : startVoiceRecognition()">
    {{ isListening ? 'Stop' : 'Speak' }}
   </button>

   <!-- Optional: You can show a message when recording starts -->
   <p v-if="isListening">Listening...</p>

   <div v-if="searchHistoryVisible && searchHistory.length" class="dropdown-menu" style="display: block; width:100%;">

    <!-- Dropdown for search history -->
    <div v-if="searchHistoryDropdown && searchHistory.length" class="dropdown-menu" style="display: block; width:100%; position: absolute; z-index: 1000;">

     <div v-if="filteredSearchHistory.today.length">
      <span>Today</span>
      <ul>
       <li v-for="(term, index) in filteredSearchHistory.today" :key="'today-' + index" @click="selectFromHistory(term.term)" style="cursor:pointer; color:black">
        {{ term.term }}
       </li>
      </ul>
     </div>

     <div v-if="filteredSearchHistory.yesterday.length">
      <span>Yesterday</span>
      <ul>
       <li v-for="(term, index) in filteredSearchHistory.yesterday" :key="'yesterday-' + index" @click="selectFromHistory(term.term)" style="cursor:pointer">
        {{ term.term }}
       </li>
      </ul>
     </div>

     <div v-if="filteredSearchHistory.lastWeek.length">
      <span>Last Week</span>
      <ul>
       <li v-for="(term, index) in filteredSearchHistory.lastWeek" :key="'lastWeek-' + index" @click="selectFromHistory(term.term)" style="cursor:pointer">
        {{ term.term }}
       </li>
      </ul>
     </div>

     <div v-if="filteredSearchHistory.lastMonth.length">
      <span>Last Month</span>
      <ul>
       <li v-for="(term, index) in filteredSearchHistory.lastMonth" :key="'lastMonth-' + index" @click="selectFromHistory(term.term)" style="cursor:pointer">
        {{ term.term }}
       </li>
      </ul>
     </div>
    </div>

   </div>
  </div>

  <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasResults" style="width: 60%;">
   <div class="offcanvas-header">
    <h5 class="offcanvas-title">Search Results</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
   </div>
   <div class="offcanvas-body text-left custom-offcanvas">

    <!-- Loading Spinner -->
    <div v-if="loading" class="text-center">
     <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
     </div>
     <p>Loading results...</p>
    </div>

    <div v-if="filteredResults.length && !loading">
     <div v-for="result in filteredResults" :key="result.id" class="result-item">

      <div :id="'result-' + result.id">
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
      <hr>
     </div>
    </div>
    <div v-else-if="!loading" class="text-center">
     <h5>No search results found.</h5>
    </div>

   </div>
  </div>
 </div>
</div>
</template>

<style scoped>
.spinner-border {
 width: 3rem;
 height: 3rem;
}

.form-control {
 box-sizing: border-box;
 padding: 10px;
 font-size: 1rem;
}

.dropdown-menu {
 background-color: white;
 border: 1px solid lightgrey;
 border-radius: 5px;
}

.list-group-item {
 border: none;
}

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
 data() {
  return {
   searchHistoryDropdown: false,
   searchHistory: [],
   filteredSearchHistory: {
    today: [],
    yesterday: [],
    lastWeek: [],
    lastMonth: []
   },
   loading: false,
   searchTerm: '',
   filteredResults: [],
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
  startVoiceRecognition() {
   this.isListening = true;

   const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

   if (!SpeechRecognition) {
    alert('Speech Recognition is not supported in this browser. Please use Google Chrome or a compatible browser.');
    this.isListening = false;
    return;
   }

   this.recognition = new SpeechRecognition();
   this.recognition.lang = 'en-US';
   this.recognition.continuous = true;

   this.recognition.onresult = (event) => {
    const transcript = event.results[0][0].transcript;
    this.searchTerm = transcript;
    this.isListening = false;
    this.searchWord();
   };

   this.recognition.onend = () => {
    this.isListening = false;
   };

   this.recognition.onerror = (event) => {
    console.error('Speech recognition error:', event.error);
    this.isListening = false;
   };

   this.recognition.start();
  },

  stopVoiceRecognition() {
   if (this.recognition) {
    this.recognition.stop(); // Stop the recognition
    this.isListening = false;
   }
  },
  onType() {
   if (this.searchTerm.length >= 3) {}
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
   this.loading = true; // Set loading state to true before fetching data

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
      this.showOffcanvas(); // Show search results
     })
     .catch(error => {
      console.error("Error fetching search results:", error);
     })
     .finally(() => {
      this.loading = false; // Reset loading state
     });
   } else {
    this.filteredResults = [];
    this.loading = false; // Reset loading state if searchTerm is empty
   }
  },

  highlightSearch(translation) {
   if (!translation) {
    console.warn("The translation is undefined or null for this result:", translation);
    return '';
   }
   const regex = new RegExp(`(${this.searchTerm})`, 'gi');
   return translation.replace(regex, "<span class='highlight'>$1</span>");
  },

  showOffcanvas() {
   const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasResults'));
   offcanvas.show();
  },
  
 },

};
</script>
