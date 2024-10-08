<template>
<div>
 <!-- Search Input Group -->
 <div>

  <div class="container input-group" style="position: relative; width: 100%;">
   <input type="text" @keyup="debouncedSearch" v-model="searchTerm" placeholder="How can I help you understand the Quran?" class="form-control mr-3 mobile-only" />

   <ul v-if="suggestions.length" class="list-group suggestions" style=" top: 0; left: 0; width: 100%; z-index: 1000; max-height: 600px; overflow-y: auto;">
    <li class="list-group-item text-left list-group-item-success" v-for="(suggestion, index) in suggestions" :key="index" @click="selectSuggestion(suggestion)">
     {{ suggestion }}
    </li>
   </ul>

   <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
    <ul class="dropdown-menu">
     <li>
      <a class="dropdown-item" href="#">
       <div class="form-check form-check-inline">
        <input class="form-check-input mt-1" type="checkbox" v-model="filters.translation" id="translationCheckbox" />
        <p class="form-check-label" for="translationCheckbox">Translation</p>
       </div>
      </a>
     </li>
     <li>
      <a class="dropdown-item" href="#">
       <div class="form-check form-check-inline">
        <input class="form-check-input mt-1" type="checkbox" v-model="filters.tafseer" id="tafseerCheckbox" />
        <span class="form-check-label" for="tafseerCheckbox">Tafseer</span>
       </div>
      </a>
     </li>
     <li>
      <a class="dropdown-item" href="#">
       <div class="form-check form-check-inline">
        <input class="form-check-input mt-1" type="checkbox" v-model="filters.transliteration" id="transliterationCheckbox" />
        <p class="form-check-label" for="transliterationCheckbox">Transliteration</p>
       </div>
      </a>
     </li>
    </ul>
   </div>

    <!-- Voice input button -->
    <button class="btn btn-primary" @click="isListening ? stopVoiceRecognition() : startVoiceRecognition()">
      <i class="bi text-white h4" :class="isListening ? 'bi-stop-fill' : 'bi-mic-fill'" aria-hidden="true"></i>
    </button>

    <button class="btn btn-primary text-white" @click="searchWord"><i class="bi bi-search h4 text-white"></i></button>

  </div>
 </div>
 <!-- show a message when recording starts -->
 <b v-if="isListening">Listening...</b>

 <!-- Offcanvas for Search Results -->
 <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasResults" >
  <div class="offcanvas-header">
   <h5 class="offcanvas-title">Search Results</h5>
   <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body text-left ">
   <!-- Display Results -->
   <div v-if="filteredResults.length && !loading">
    <div v-for="result in filteredResults" :key="result.id" class="result-item">
     <div :id="'result-' + result.id">
      <div class="text-left pb-2">
       <h4>{{ result.ayah.surah_id }} : {{ result.ayah.ayah_id }}</h4>
      </div>
      <h3 class="text-right">{{ result.ayah.ayah_text }}</h3>
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
     <hr />
    </div>
   </div>
   <!-- No Results Found -->
   <div v-else-if="!loading" class="text-center">
    <h5>No search results found.</h5>
   </div>
   <div v-if="loading" class="text-center">
    <h5>Loading...</h5>
   </div>
  </div>
 </div>

</div>
</template>

<script>
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import {
 debounce
} from 'lodash';
import axios from 'axios';

export default {
 mounted() {
  const dropdown = document.querySelector('.dropdown');
  if (dropdown) {
   dropdown.addEventListener('click', this.toggleDropdown);
  }
 },

 data() {
  return {
   data: [],
   loading: false,
   searchTerm: '',
   suggestions: [],

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

  onInput() {
   if (this.searchTerm.length > 2) {
    this.fetchSuggestions();
   } else {
    this.suggestions = [];
    this.filteredResults = [];
   }
  },
  fetchSuggestions() {
   const params = {
    query: this.searchTerm,
    filters: this.filters,
   };

   this.loading = true;
   axios.get('/search-translations', {
     params
    })
    .then((response) => {
     this.suggestions = response.data.suggestions;
     this.filteredResults = response.data.results;
     this.loading = false;
     if (this.filteredResults.length > 0) {
      this.showOffcanvas();
     }
    })
    .catch((error) => {
     console.error(error);
     this.suggestions = [];
     this.filteredResults = [];
     this.loading = false;
    });
  },
  selectSuggestion(suggestion) {
   this.searchTerm = suggestion;
   this.suggestions = [];
   this.fetchSuggestions();
  },
  saveSearch(searchTerm) {
   if (!this.recentSearches.includes(searchTerm)) {
    this.recentSearches.unshift(searchTerm); // Add new search term
    if (this.recentSearches.length > 10) {
     this.recentSearches.pop(); // Limit to 10 searches
    }
    localStorage.setItem('recentSearches', JSON.stringify(this.recentSearches)); // Save in localStorage
   }
  },
  // Selects a search result
  selectResult(result) {
   this.searchTerm = result.content; // Update searchTerm with the result content
   this.filteredResults = []; // Clear search results
   this.showSuggestions = false; // Hide suggestions
   this.saveSearch(result.content); // Save the search term
  },
  submitSearch() {
   const query = this.searchTerm.toLowerCase();
   if (query && !this.recentSearches.includes(query)) {
    this.recentSearches.push(query);
    localStorage.setItem('recentSearches', JSON.stringify(this.recentSearches));
   }
   this.filterSuggestions();
  },
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
   this.recognition.continuous = false;

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
    this.recognition.stop();
    this.isListening = false;
   }
  },
  fetchResults(term) {
   // Mocking a search operation
   return new Promise((resolve) => {
    setTimeout(() => {
     // Replace with actual data fetching logic
     const results = this.mockData.filter(result =>
      result.ayah.ayah_text.toLowerCase().includes(term.toLowerCase())
     );
     resolve(results);
    }, 1000);
   });
  },

  highlightSearch(text) {
   const searchTerm = this.searchTerm.toLowerCase();
   const regex = new RegExp(`(${searchTerm})`, 'gi');
   return text.replace(regex, '<strong>$1</strong>');
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
      this.showOffcanvas(); // Show search results (you can replace this with showing search results within a dropdown)
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

  highlightSearch(text) {
   const query = this.searchTerm;
   const regex = new RegExp(`(${query})`, 'gi');
   return text.replace(regex, '<span class="highlight">$1</span>');
  },
  showOffcanvas() {
   const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasResults'));
   offcanvas.show();
  },
  debouncedSearch: _.debounce(function () {
   this.fetchSuggestions();
  }, 300)

 },

};
</script>

<style scoped>

@media (max-width: 576px) {
 .mobile-only {
  display: block;
  display: flex;
  width: 100%;
 }
 .hide-on-mobile {
  display: none;
 }
}

.search-container {
 position: relative;
}

.suggestions {
 position: relative;
 background: white;
 border: 1px solid #ccc;
 border-radius: 4px;
 margin-top: 5px;
 width: 100%;
 max-height: 150px;
 /* Limit dropdown height */
 overflow-y: auto;
 /* Enable scrolling */
 z-index: 10;
 /* Ensure dropdown appears above other content */
}

.highlight {
 background-color: yellow;
 font-weight: bold;
}

.recent-searches {
 position: relative;
 width: 300px;
 /* Adjust the width as needed */
}

.search-input {
 width: 100%;
 padding: 10px;
 font-size: 16px;
 border: 1px solid #ccc;
 border-radius: 4px;
}

.suggestions {
 position: absolute;
 background: white;
 border: 1px solid #ccc;
 border-radius: 4px;
 margin-top: 5px;
 width: 100%;
 max-height: 150px;
 /* Limit dropdown height */
 overflow-y: auto;
 /* Enable scrolling */
 z-index: 10;
 /* Ensure dropdown appears above other content */
}

.suggestions li {
 padding: 8px;
 cursor: pointer;
}

.suggestions li:hover {
 background-color: #f0f0f0;
 /* Highlight on hover */
}

.btn-primary {
 background-color: #00BFA6 !important;
 border-radius: 10px;
}

.btn-primary:focus {
 box-shadow: none;
}

.text {
 font-size: 13px;
}

.flex-row {
 border: 1px solid #F2F2F4;
 border-radius: 10px;
 margin: 0 1px 0;
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
