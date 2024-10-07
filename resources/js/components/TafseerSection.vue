<template>
<div class="w-100 my-element" :class="{'full-screen': isFullScreen}">
 <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
 <div ref="targetTafseerElement">
  <AyahInfo :information="information" />
  <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
   <MainAyah :information="information" />
   <div ref="targetTafseerElement" class="text-left">
    <h4 class="text-left ayah-translation" style="line-height: 1.6em">
     {{ expanded ? information.tafseer : truncatedText(information.tafseer) }}
     <template v-if="information.tafseer.length > 100">
      <a class="href" href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
     </template>
    </h4>
   </div>
   <h6 class="text-left "><strong>Tafseer: </strong>Ibn Kathir</h6>
   <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
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
</div>
</template>

<script>
import AyahInfo from './translation/AyahInfo.vue';
import MainAyah from './translation/MainAyah.vue';
import AlertModal from './modals/AlertModal.vue';

export default {
 name: 'TafseerSection',
 components: {
  AyahInfo,
  MainAyah,
  AlertModal,
 },
 props: {
  information: Object,
  isFullScreen: Boolean,
  showAlertText: Boolean,
  showAlert: Boolean,
  showErrorAlert: Boolean,
  showAlertTextNote: Boolean,
 },
 data() {
  return {
   expanded: false, // Local state to track expand/collapse
   surahUrl: '',
  };
 },
 methods: {
  shareOnWhatsApp(tafseer, url) {
   // Check if translation or URL is missing
   if (!tafseer || !url) {
    console.error('Translation or URL is missing');
    return;
   }
   // Encode the message for sharing
   const encodedMessage = encodeURIComponent(`${tafseer} ${url}`);
   const whatsappUrl = `https://api.whatsapp.com/send?text=${encodedMessage}`;

   // Open WhatsApp in a new tab
   window.open(whatsappUrl, '_blank');
  },
  shareOnTwitter() {
   const ayahTafseer = this.expanded ? this.information.tafseer : this.truncatedText(this.information.tafseer);

   const message = `
      Tafseer: ${ayahTafseer}
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
   this.expanded = !this.expanded; // Toggle expanded state locally
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
