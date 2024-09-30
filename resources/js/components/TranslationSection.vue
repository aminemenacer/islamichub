<template>
<div class="w-100 my-element" :class="{'full-screen': isFullScreen}">
 <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
 <div ref="targetTranslationElement">
  <AyahInfo :information="information" />
  <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
   <MainAyah :information="information" />
   <div ref="heading3" class="text-left">
    <h4 class="text-left ayah-translation" style="line-height: 1.6em">
     {{ expanded ? information.translation : truncatedText(information.translation) }}<i @click="readTextAloud" style="cursor:pointer;" class="bi ml-2 mr-2 h3 bi-play-circle-fill mic"></i>
     <template v-if="showMoreLink && information.translation.length > 100">
      <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
     </template>
    </h4>
    <Translator translator="Ahmed Ali"  />
    
    <!--
    <hr>
    <div>
      <label for="voice-select">Choose a voice to read translation:</label>
      <select class="form-control" id="voice-select" v-model="selectedVoice" @change="setVoice">
        <option v-for="(voice, index) in voices" :key="index" :value="index">
          {{ voice.name }} ({{ voice.lang }})
        </option>
      </select>
      <div class="row" style="padding:10px">
        <div class="col-md-4">
          <div type="button" class="btn btn-success text-center" @click="readTextAloud">
            Read Aloud
          </div>
        </div>
        <div class="col-md-4">
          <div type="button" class="btn btn-secondary text-left" @click="stopReading" :disabled="!isReading">
            Stop Reading
          </div>
        </div>
        <div class="col-md-4">
          
        </div>
      </div>
    </div>
    -->
   </div>
   <div>
   </div>
    <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
  </div>
 </div>
 <!-- WhatsApp Share Button -->
 <div class="row mobile-only pt-3" style="color:white">
  <div class="col-6 ">
    <!-- Add right padding to create space between the buttons -->
    <div @click="shareOnWhatsApp" style="cursor: pointer;">
      <i class="bi bi-whatsapp  h3" style="color:black"></i>
      <p style="font-size: 13px; margin: 0;color:black" class="pt-2">Share via WhatsApp</p>
    </div>
  </div>

  <div class="col-6 pr-2">
    <!-- Add right padding to create space between the buttons -->
    <div @click="shareOnTwitter" style="cursor: pointer;">
      <i class="bi bi-twitter-x  h3" style="color:black"></i>
      <p style="font-size: 13px; margin: 0;color:black" class="pt-2">Share via X</p>
    </div>
  </div>
 </div>
</div>
</template>

<script>
import AyahInfo from './translation/AyahInfo.vue';
import MainAyah from './translation/MainAyah.vue';
import Translator from './translation/Translator.vue';
import AlertModal from './modals/AlertModal.vue';
import ScreenReader from './accesibility/ScreenReader.vue';

export default {
 name: 'TranslationSection',
 components: {
  AyahInfo,
  MainAyah,
  Translator,
  AlertModal,
  ScreenReader
 },
 props: {
  iconColor: {
   type: String,
   default: 'rgba(0, 191, 166)'
  },
  information: {
   type: Object,
   required: true
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

 data() {
  return {
    isReading: false,
    utterance: null,
    voices: [],
    selectedVoice: null,
  }
 },
 methods: {
  // Read the displayed text aloud
  readTextAloud() {
    const text = this.expanded ? this.information.translation : this.truncatedText(this.information.translation);
    this.utterance = new SpeechSynthesisUtterance(text);

    if (this.voices.length > 0 && this.selectedVoice !== null) {
      this.utterance.voice = this.voices[this.selectedVoice];
    }

    // Handle end of speech event
    this.utterance.onend = () => {
      this.isReading = false;
    };

    // Start speaking
    this.isReading = true;
    window.speechSynthesis.speak(this.utterance);
  },
  // Stop reading
  stopReading() {
    window.speechSynthesis.cancel();
    this.isReading = false;
  },
  setAyahText(text) {
   this.ayahText = text; // Capture the ayah text from the child component
  },
  shareOnWhatsApp() {
   const ayahInfo = this.information.ayahInfo || "No Ayah Info available"; // Fallback message
   const mainAyah = this.information.mainAyah || "No Main Ayah available"; // Fallback message
   const ayahTranslation = this.expanded ? this.information.translation : this.truncatedText(this.information.translation);

   const message = `
      Ayah Info: ${ayahInfo}
      Main Ayah: ${mainAyah}
      Translation: ${ayahTranslation}
    `;

   const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}`;
   window.open(url, '_blank');
  },
  shareOnTwitter() {
   const ayahInfo = this.information.ayahInfo || "No Ayah Info available"; // Fallback message
   const mainAyah = this.information.mainAyah || "No Main Ayah available"; // Fallback message
   const ayahTranslation = this.expanded ? this.information.translation : this.truncatedText(this.information.translation);

   const message = `
      Ayah Info: ${ayahInfo}
      Main Ayah: ${mainAyah}
      Translation: ${ayahTranslation}
    `;

   const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(message)}`;
   window.open(url, '_blank');
  },
  getVoices() {
    this.voices = window.speechSynthesis.getVoices();
    if (this.voices.length > 0) {
      this.selectedVoice = 0; // Default to the first voice in the list
    }
  },
  setVoice() {
    this.selectedVoice = parseInt(this.selectedVoice);
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
 created() {
   this.getVoices();
   window.speechSynthesis.onvoiceschanged = this.getVoices;
 },
};
</script>

<style scoped>
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
