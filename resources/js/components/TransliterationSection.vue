<template>
<div class="w-100 my-element" :class="{'full-screen': isFullScreen}">
 <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
 <div ref="targetTranslationElement">
  <AyahInfo :information="information" />
  <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
   <MainAyah :information="information" />
   <div ref="heading3">
    <h4 class="text-left ayah-translation" style="line-height: 1.6em">
     {{ expanded ? information.transliteration : truncatedText(information.transliteration) }}
     <template v-if="showMoreLink && information.translation.length > 100">
      <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
     </template>
    </h4>
   </div>
   <h6 class="text-left "><strong>Transliteration: </strong>Saheeh International</h6>
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

export default {
 name: 'TranslationSection',
 components: {
  AyahInfo,
  MainAyah,
  Translator,
  AlertModal
 },
 props: {
  information: Object,
  isFullScreen: Boolean,
  showAlertText: Boolean,
  showAlert: Boolean,
  showErrorAlert: Boolean,
  showAlertTextNote: Boolean,
 },
 data(){
   return{
    expanded: false,  // Local state to track expand/collapse
   }
 },
 methods: {
  shareOnWhatsApp() {
    const ayahInfo = this.information.ayahInfo || "No Ayah Info available"; // Fallback message
    const mainAyah = this.information.mainAyah || "No Main Ayah available"; // Fallback message
    const ayahTransliteration = this.expanded ? this.information.transliteration : this.truncatedText(this.information.transliteration);

    const message = `
        Ayah Info: ${ayahInfo}
        Main Ayah: ${mainAyah}
        Transliteration: ${ayahTransliteration}
      `;

    const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
  },
  shareOnTwitter() {
   const ayahInfo = this.information.ayahInfo || "No Ayah Info available"; // Fallback message
   const mainAyah = this.information.mainAyah || "No Main Ayah available"; // Fallback message
   const ayahTransliteration = this.expanded ? this.information.transliteration : this.truncatedText(this.information.transliteration);

   const message = `
        Ayah Info: ${ayahInfo}
        Main Ayah: ${mainAyah}
        Transliteration: ${ayahTransliteration}
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
 }
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
