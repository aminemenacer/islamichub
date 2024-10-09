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
    <button class="btn btn-success" @click="isListening ? stopVoiceRecognition() : startVoiceRecognition()">
      <i class="bi text-white " :class="isListening ? 'bi-stop-fill' : 'bi-mic-fill'" aria-hidden="true"></i>
    </button>
    <!--
    <button class="btn btn-info text-white" @click="searchWord"><i class="bi bi-search h4 text-white"></i></button>
    -->
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
       <b>Translation: </b>
       <span v-html="highlightSearch(result.translation)"></span>
      </div>
      <div v-if="filters.tafseer">
       <b>Tafseer: </b>
       <p v-html="highlightSearch(result.tafseer)"></p>
      </div>
      <div v-if="filters.transliteration">
       <b>Transliteration: </b>
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
  // Trigger suggestions based on input length
  onInput() {
    if (this.searchTerm.length > 2) {
      this.fetchSuggestions();
    } else {
      this.suggestions = [];
      this.filteredResults = [];
    }
  },

  // Fetch suggestions based on the search term
  fetchSuggestions() {
    const params = {
      query: this.searchTerm,
      filters: this.filters,
    };

    this.loading = true;
    axios
      .get('/search-translations', { params })
      .then((response) => {
        this.suggestions = response.data.suggestions || []; // Fallback to empty array
        this.filteredResults = response.data.results || []; // Fallback to empty array
        this.loading = false;

        
      })
      .catch((error) => {
        console.error('Error fetching suggestions:', error);
        this.suggestions = [];
        this.filteredResults = [];
      })
      .finally(() => {
        this.loading = false;
      });
  },

  // Select a suggestion and fetch its results
  selectSuggestion(suggestion) {
    this.searchTerm = suggestion;
    this.suggestions = [];
    this.fetchResults(suggestion); // Fetch results based on selected suggestion
    this.showOffcanvas();
  },

  
  // Select a search result
  selectResult(result) {
    this.searchTerm = result.content; // Update searchTerm with the result content
    this.filteredResults = []; // Clear search results
    this.suggestions = []; // Clear suggestions
    this.saveSearch(result.content); // Save the search term
  },

  // Submit search and save term if not already present
  submitSearch() {
    const query = this.searchTerm.toLowerCase();
    if (query && !this.recentSearches.includes(query)) {
      this.recentSearches.push(query);
      localStorage.setItem('recentSearches', JSON.stringify(this.recentSearches));
    }
    this.filterSuggestions(); // Trigger suggestions based on updated searchTerm
  },

  // Start voice recognition
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
      this.fetchSuggestions(); // Fetch suggestions immediately after speech input
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

  // Stop voice recognition
  stopVoiceRecognition() {
    if (this.recognition) {
      this.recognition.stop();
      this.isListening = false;
    }
  },

  // Fetch results based on search term (mock implementation)
  fetchResults(suggestion) {
    const params = {
      query: suggestion,
      filters: this.filters,
    };

    axios.get('/search-translations', { params })
      .then((response) => {
        this.filteredResults = response.data.results || [];
        console.log('Filtered results:', this.filteredResults); // Log filtered results for debugging
      })
      .catch((error) => {
        console.error('Error fetching results:', error);
        this.filteredResults = [];
      });
  },


  // Highlight the search term in the text
  highlightSearch(text) {
    const searchTerm = this.searchTerm.trim();
    if (!searchTerm) return text;

    const regex = new RegExp(`(${searchTerm})`, 'gi');
    return text.replace(regex, '<strong style="background-color: #3EB489;">$1</strong>');
  },


  // Download a PDF of the result
  downloadPDF(result) {
    const element = document.getElementById(`result-${result.id}`);
    element.style.color = 'black'; // Ensure visibility

    html2canvas(element).then((canvas) => {
      const imgData = canvas.toDataURL('image/png');
      const pdf = new jsPDF({
        orientation: 'portrait',
        unit: 'mm',
        format: 'a4',
      });
      const fileName = `Surah_${result.ayah.surah_id}_Ayah_${result.ayah.ayah_id}.pdf`;

      pdf.addImage(imgData, 'PNG', 10, 10, 190, 0); // Adjust the dimensions as needed
      pdf.save(fileName);
      element.style.color = ''; // Reset to original or preferred color
    }).catch((error) => {
      console.error('Error capturing the element:', error);
    });
  },

  // Copy text to clipboard
  copyText(result) {
    const textToCopy = `${result.ayah.surah_id}:${result.ayah.ayah_id} - ${result.ayah.ayah_text}\n${result.translation}`;
    navigator.clipboard.writeText(textToCopy)
      .then(() => {
        alert('Text copied to clipboard');
      })
      .catch((error) => {
        console.error('Error copying text:', error);
      });
  },

  // Share via WhatsApp
  shareViaWhatsapp(result) {
    const surahInfo = `${result.ayah.surah_id}:${result.ayah.ayah_id}`;
    const ayahText = `Ayah: ${result.ayah.ayah_text}`;
    const ayahTranslation = `Ayah Translation: ${result.translation}`;
    const note = `Note: ${result.translation}`;

    const message = `${surahInfo}\n${ayahText}\n${ayahTranslation}\n${note}`;
    const encodedMessage = encodeURIComponent(message); // Encode special characters
    const whatsappUrl = `https://wa.me/?text=${encodedMessage}`;
    window.open(whatsappUrl, '_blank');
  },

  // Search for translations
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
          this.filteredResults = response.data || []; // Ensure valid data
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

  // Show the offcanvas component for results
  showOffcanvas() {
    const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasResults'));
    offcanvas.show();
  },

  // Debounced search to limit the number of fetch calls
  debouncedSearch: _.debounce(function () {
    this.fetchSuggestions();
  }, 300)
}


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
 background-color: #3EB489;
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
