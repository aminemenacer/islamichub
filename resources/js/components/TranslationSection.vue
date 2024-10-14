<template>
<div class="w-100 my-element" :class="{'full-screen': isFullScreen}">
 <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
 <div >
  <AyahInfo :information="information" />
  <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
   <MainAyah :information="information" />
   <div ref="targetTranslationElement" class="row text-left">
    <h4 :style="{ fontSize: currentFontSize + 'px' }" class="text-left ayah-translation col-md-11" style="line-height: 1.6em">
     {{ expanded ? information.translation : truncatedText(information.translation) }}
     <template v-if="showMoreLink && information.translation.length > 100">
      <a class="href" href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
     </template>
    </h4>
    <!-- Display each word with a span for highlighting -->
    <!-- <div v-if="information.translation">
      <span v-for="(word, index) in words" :key="index" :class="{ highlight: index === currentWordIndex }">
        {{ word }}
      </span>
    </div> -->
    <Translator translator="Ahmed Ali" />
    <!-- Speech icons mobile only-->
    <div style="cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: space-between;" class="container pb-2 text-center mobile-only">
     <div class="row">
      <div class="col">
       <i class="bi bi-dash-circle-fill h3 custom-icon-decrease" aria-placeholder="Decrease text size" @click="decreaseFontSize"></i>
      </div>
      <div class="col">
       <i @click="toggleSpeech" style="cursor: pointer;" aria-placeholder="Play translation audio" :class="isReading ? 'bi-pause-circle-fill' : 'bi-play-circle-fill'" class="bi ml-2 mr-2 h3 custom-icon-play"></i>
      </div>
      <div class="col">
       <i class="bi bi-plus-circle-fill h3 custom-icon-increase" aria-placeholder="Increase text size" @click="increaseFontSize"></i>
      </div>
      <div class="col text-center">
       <i class="bi bi-wrench-adjustable-circle-fill h3 custom-icon-increase" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-placeholder="settings"></i>
      </div>

     </div>

    </div>
    <!--
     <button type="button" class="btn btn-success" @click="downloadAsCSV">Download as CSV</button>
     <button type="button" class="btn btn-success" @click="downloadAsWord">Download as Word</button>
     -->

    <!-- Speech Off-canvas -->
    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
     <div class="offcanvas-header">
      <h5><b>Speech Settings</b></h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
     </div>
     <div class="offcanvas-body">
      <div class="mb-3">
       <label for="formGroupExampleInput" class="form-label">Voices:</label>
       <select class="form-control" v-model="selectedVoice" @change="changeVoice($event.target.value)">
        <option v-for="voice in voices" :key="voice.name" :value="voice">
         {{ voice.name }} ({{ voice.lang }})
        </option>
       </select>
      </div>

      <div class="row">
       <div class="col">
        <label>
         Rate: <input class="rate" type="range" min="0.5" max="2" step="0.1" v-model="rate" @input="adjustRate($event.target.value)">
        </label>
       </div>
       <div class="col">
        <label>
         Pitch: <input class="pitch" type="range" min="0.5" max="2" step="0.1" v-model="pitch" @input="adjustPitch($event.target.value)">
        </label>
       </div>
      </div>

      <!-- Success message alert (hidden by default) -->
      <div v-if="successMessage" class="alert alert-success" role="alert">
       Settings saved successfully!
      </div>

      <!-- Buttons to save or cancel changes -->
      <div class="d-flex justify-content-end mt-3">
       <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
       <button type="button" class="btn btn-success" @click="saveSettings">Save changes</button>
      </div>
     </div>
    </div>

   </div>
  </div>
  <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />

 </div>
</div>
</template>

<script>
import AyahInfo from './translation/AyahInfo.vue';
import MainAyah from './translation/MainAyah.vue';
import Translator from './translation/Translator.vue';
import AlertModal from './modals/AlertModal.vue';
import ScreenReader from './accesibility/ScreenReader.vue';
import ScreenTranslationCapture from './translation/features/screen_capture/ScreenTranslationCapture.vue';
import Magnifier from './search/Magnifier.vue';

import html2canvas from "html2canvas";
import jsPDF from 'jspdf';
import {
 saveAs
} from 'file-saver';
import Papa from 'papaparse';
import {
 Document,
 Packer,
 Paragraph,
 TextRun
} from 'docx'

export default {
 name: 'TranslationSection',
 components: {
  AyahInfo,
  MainAyah,
  Translator,
  AlertModal,
  ScreenReader,
  Magnifier
 },
 props: {
  iconColor: {
   type: String,
   default: 'rgba(0, 191, 166)'
  },
  translation: {
   type: String,
   required: true,
  },
  information: {
   type: Object,
   required: true
  },
  targetTranslationRef: {
   type: String,
   default: 'targetTranslationElement',
  },
  isFullScreen: {
   type: Boolean,
   default: false
  },
  expanded: {
   type: Boolean,
   default: false
  },
  showMoreLink: {
   type: Boolean,
   default: true
  },
  showAlertText: {
   type: Boolean,
   default: false
  },
  showAlert: {
   type: Boolean,
   default: false
  },
  showErrorAlert: {
   type: Boolean,
   default: false
  },
  showAlertTextNote: {
   type: Boolean,
   default: false
  }
 },
 computed: {
  combinedText() {
   // Get the ayah_text from information
   const ayahText = typeof this.information.ayah_text === 'object' ?
    this.information.ayah_text.text :
    this.information.ayah_text;

   // Return the formatted string
   return `Translation: ${this.ayah_text}`;
  }
 },
 data() {
  return {
   isReading: false,
   resetDisabled: true,
   utterance: null,
   currentFontSize: 20,
   selectedVoiceName: '',
   selectedVoice: null,
   successMessage: false,
   rate: 1,
   pitch: 1,
   surahUrl: '',
   voices: [],
   summary: '',
   words: [],
   currentWordIndex: 0,

  }
 },
 mounted() {
  // Load saved settings from local storage on page load
  const savedVoice = localStorage.getItem('selectedVoice');
  const savedRate = localStorage.getItem('rate');
  const savedPitch = localStorage.getItem('pitch');

  if (savedVoice) this.selectedVoice = JSON.parse(savedVoice);
  if (savedRate) this.rate = parseFloat(savedRate);
  if (savedPitch) this.pitch = parseFloat(savedPitch);

  const savedFontSize = localStorage.getItem('fontSize');
  if (savedFontSize) {
   this.currentFontSize = parseInt(savedFontSize, 10); // Set the font size from localStorage
  }
  this.loadVoices();
  if (speechSynthesis.onvoiceschanged !== undefined) {
   speechSynthesis.onvoiceschanged = this.loadVoices;
  }
 },
 methods: {
  
  toggleExpand() {
   this.expanded = !this.expanded;
  },
  submitForm() {
   const formData = {
    // folder_id: this.selectedFolderId,
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.information.translation,
    user_id: this.userId,
   };
   axios.post('/bookmarks', formData)
    .then(response => {
     console.log(response.data.message);
     localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
     this.showAlert = true;
     this.showErrorAlert = false;
     this.hideAlertAfterDelay();
     // Display a confirmation message with the bookmarked ayah and folder
     // this.$refs.bookmarkConfirmation.textContent = 
     //   `Successfully bookmarked ayah ${this.information.ayah_id} to folder "${this.selectedFolderId}"`;
    })
  },
  
  
  saveSettings() {
   // Save settings to local storage
   localStorage.setItem('selectedVoice', JSON.stringify(this.selectedVoice));
   localStorage.setItem('rate', this.rate);
   localStorage.setItem('pitch', this.pitch);

   // Show success message
   this.successMessage = true;

   // Close the modal after a short delay
   setTimeout(() => {
    this.successMessage = false;
    const modalElement = document.getElementById('speechModal');
    const modalInstance = bootstrap.Modal.getInstance(modalElement);

    if (modalInstance) {
     modalInstance.hide();
     // Dispose of the modal to remove the grey background
     modalInstance.dispose();
    }
   }, 3000);
  },
  closeModal() {
   const modalElement = document.getElementById('speechModal');
   const modalInstance = bootstrap.Modal.getInstance(modalElement);

   if (modalInstance) {
    modalInstance.hide();
    // Dispose of the modal to remove the grey background
    modalInstance.dispose();
   }
  },
  
  loadVoices() {
   this.voices = speechSynthesis.getVoices();
   if (this.voices.length > 0) {
    this.selectBestVoice();
   }
  },
  increaseFontSize() {
   this.currentFontSize += 2; // Increase font size by 2px
   this.saveFontSize();
  },
  decreaseFontSize() {
   if (this.currentFontSize > 10) {
    this.currentFontSize -= 2; // Decrease font size by 2px, limit to 10px minimum
    this.saveFontSize();
   }
  },
  // resetFontSize() {
  //   this.currentFontSize = 20; // Reset to default font size
  //   this.saveFontSize(); // Save the font size (e.g., to local storage or any other mechanism)
  //   this.resetDisabled = true; // Disable the reset button after resetting the font size
  // },
  saveFontSize() {
   // Save the current font size to localStorage
   localStorage.setItem('fontSize', this.currentFontSize);
  },
  selectBestVoice() {
   const preferredVoices = [
    'Google UK English Female',
    'Microsoft Zira Desktop - English (United States)',
    'Samantha',
    'Google US English',
    'Microsoft David Desktop - English (United States)',
   ];

   for (const preferredVoice of preferredVoices) {
    const voice = this.voices.find(v => v.name === preferredVoice);
    if (voice) {
     this.selectedVoice = voice;
     return;
    }
   }

   if (this.voices.length > 0) {
    this.selectedVoiceName = this.voices[0].name;
   }

   // If no preferred voice is found, choose the first available voice
   this.selectedVoice = this.voices[0];
  },
  changeVoice(voiceName) {
   this.selectedVoiceName = voiceName;
  },
  adjustRate(value) {
   this.rate = parseFloat(value);
  },
  adjustPitch(value) {
   this.pitch = parseFloat(value);
  },

  truncatedText(text) {
   return text.length > 100 ? text.substring(0, 100) + '...' : text;
  },
  downloadAsCSV() {
   const data = [{
    Translation: this.information.translation,
    Translator: "Ahmed Ali"
   }];
   const csv = Papa.unparse(data);
   const blob = new Blob([csv], {
    type: "text/csv;charset=utf-8;"
   });
   saveAs(blob, "translation.csv")
  },
  async downloadAsWord() {
   const doc = new Document({
    sections: [{
     children: [
      new Paragraph({
       children: [
        new TextRun("Translation:"),
        new TextRun({
         text: this.information.translation,
         bold: true,
        }),
       ],
      }),
      new Paragraph({
       children: [
        new TextRun("Translator:"),
        new TextRun({
         text: "Ahmed Ali",
         italics: true,
        }),
       ],
      }),
     ],
    }, ],
   });
   const blob = await Packer.toBlob(doc);
   saveAs(blob, "translation.docx")
  },
  stopSpeech() {
   if (this.isReading) {
    window.speechSynthesis.cancel();
    this.isReading = false;
   }
  },
  toggleSpeech() {
   if (this.isReading) {
    window.speechSynthesis.cancel(); // Stop reading if already playing
    this.isReading = false;
   } else {
    this.readTextAloud(); // Start reading
   }
  },
  // Read the displayed text aloud

  readTextAloud() {
   const text = this.expanded ? this.information.translation : this.truncatedText(this.information.translation);
   this.utterance = new SpeechSynthesisUtterance(text);

   const selectedVoice = this.voices.find(voice => voice.name === this.selectedVoiceName);
   if (this.selectedVoice) {
    this.utterance.voice = this.selectedVoice;
   }

   this.utterance.rate = this.rate;
   this.utterance.pitch = this.pitch;

   // Handle end of speech event
   this.utterance.onend = () => {
    this.isReading = false;
   };

   // Start speaking
   this.isReading = true;
   window.speechSynthesis.speak(this.utterance);
  },
  getCurrentWordIndex(charIndex) {
   let cumulativeLength = 0;
   for (let i = 0; i < this.words.length; i++) {
    cumulativeLength += this.words[i].length + 1; // Account for spaces between words
    if (charIndex < cumulativeLength) {
     return i;
    }
   }
   return 0;
  },
  stopSpeech() {
   if (this.isReading) {
    window.speechSynthesis.cancel();
    this.isReading = false;
   }
  },
  setAyahText(text) {
   this.ayahText = text; // Capture the ayah text from the child component
  },
  toggleFullScreen() {
   this.$emit('toggle-full-screen');
  },
  handleTouchStart(event) {
   this.$emit('handle-touch-start', event);
  },
  handleTouchMove(event) {
   this.$emit('handle-touch-move', event);
  },
  handleTouchEnd(event) {
   this.$emit('handle-touch-end', event);
  },
  toggleExpand() {
   this.$emit('toggle-expand');
  },
  truncatedText(text) {
   return text.length > 100 ? text.slice(0, 100) + '...' : text;
  },
  closeAlertText() {
   this.$emit('close-alert-text');
  }
 },

};
</script>

<style scoped>
.custom-offcanvas {
 background-color: #10584f;
 color: white;
}

.custom-icon-play:hover {
 color: rgb(13, 182, 145);
 /* Default color */
 transition: color 0.3s ease;
 /* Smooth transition */
}

.custom-icon-increase:hover {
 color: rgb(13, 182, 145);
 /* Default color */
 transition: color 0.3s ease;
 /* Smooth transition */
}

.custom-icon-decrease:hover {
 color: rgb(13, 182, 145);
 /* Default color */
 transition: color 0.3s ease;
 /* Smooth transition */
}

.text-muted {
 color: lightgrey;
}

.full-screen {
 position: fixed;
 top: 0;
 left: 0;
 right: 0;
 bottom: 0;
 z-index: 1000;
 background-color: white;
 padding: 20px;
}

.swipeable-div {
 touch-action: pan-y;
}

.ayah-translation {
 font-size: 1.2rem;
}

.btn {
 display: flex;
 justify-content: flex-end;
 align-items: center;
}

.mobile-only {
 display: none;
 /* Hide by default */
}

@media (max-width: 768px) {

 /* Adjust this width as needed for your breakpoint */
 .mobile-only {
  display: flex;
  /* Show only on mobile */
 }
}

@media (max-width: 576px) {
 .mobile-only {
  display: block;
  display: flex;
 }

 .hide-on-mobile {
  display: none;
 }
}
</style>
