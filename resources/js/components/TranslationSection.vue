<template>
<div class="w-100 my-element" :class="{'full-screen': isFullScreen}">
 <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
 <div ref="targetTranslationElement">
  <AyahInfo :information="information" />
  <div  @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
   <MainAyah :information="information" />
   <div ref="heading3"  class="row text-left">
    <h4 :style="{ fontSize: currentFontSize + 'px' }" class="text-left ayah-translation col-md-11" style="line-height: 1.6em">
     {{ expanded ? information.translation : truncatedText(information.translation) }}
     <template v-if="showMoreLink && information.translation.length > 100">
      <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
     </template>
    </h4>
    <div class="col-md-1 mt-4" style="cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: space-between; height: 150px;">
      <i @click="toggleSpeech" style="cursor: pointer;" aria-placeholder="Play translation audio" :class="isReading ? 'bi-pause-circle-fill' : 'bi-play-circle-fill'" class="bi ml-2 mr-2 h3 mic"></i>
      <i class="bi bi-plus-circle-fill h3" aria-placeholder="Increase text size" @click="increaseFontSize"></i>
      <i class="bi bi-dash-circle-fill h3" aria-placeholder="Decrease text size" @click="decreaseFontSize"></i>
      <!--
      <i class="bi bi-filter-circle-fill h3" aria-placeholder="Reset text size" @click="resetFontSize"></i>
      -->
    </div>
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
  mounted() {
    const savedFontSize = localStorage.getItem('fontSize');
    if (savedFontSize) {
      this.currentFontSize = parseInt(savedFontSize, 10); // Set the font size from localStorage
    }
  },
 name: 'TranslationSection',
 components: {
  AyahInfo,
  MainAyah,
  Translator,
  AlertModal,
  ScreenReader,
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
    resetDisabled: true,
    utterance: null,
    currentFontSize: 20,
  }
 },
 methods: {
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
  toggleSpeech() {
    if (this.isReading) {
      this.stopReading();
    } else {
      this.readTextAloud();
    }
  },
  // Read the displayed text aloud
  readTextAloud() {
    const text = this.expanded ? this.information.translation : this.truncatedText(this.information.translation);
    this.utterance = new SpeechSynthesisUtterance(text);

    
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
