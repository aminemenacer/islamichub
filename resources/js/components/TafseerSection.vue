<template>
<div class="w-100 my-element" :class="{'full-screen': isFullScreen}">
 <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
 <div ref="targetTafseerElement">
  <AyahInfo :information="information" />
  <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
   <MainAyah :information="information" />
   <div ref="heading1" class="text-left">
    <h4 class="text-left ayah-translation" style="line-height: 1.6em">
     {{ expanded ? information.tafseer : truncatedText(information.tafseer) }}
     <template v-if="information.tafseer.length > 100">
      <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
     </template>
    </h4>
   </div>
   <h6 class="text-left mt-3"><strong>Tafseer: </strong>Ibn Kathir</h6>
   <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
  </div>
  <!-- WhatsApp Share Button -->
  <div class="row mobile-only">
   <div class="col-6 pr-2">
    <!-- Add right padding to create space between the buttons -->
    <button @click="shareOnWhatsApp" class="btn btn-sm btn-success w-100 d-flex align-items-center justify-content-center">
     <i style="color:white" class="bi bi-whatsapp h4"></i>
     <span>Share via WhatsApp</span>
    </button>
   </div>
   <div class="col-6 pl-2">
    <!-- Add left padding to create space between the buttons -->
    <button @click="shareOnTwitter" class="btn btn-sm btn-dark w-100 d-flex align-items-center justify-content-center">
     <i style="color:white" class="bi bi-twitter-x mr-2 h4"></i>
     <span>Share via X</span>
    </button>
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
  };
 },
 methods: {
  shareOnWhatsApp() {
   // const ayahInfo = this.tafseer.ayahInfo || "No Ayah Info available"; // Fallback message
   const mainAyah = this.tafseer.mainAyah || "No Main Ayah available"; // Fallback message
   const ayahTafseer = this.expanded ? this.information.tafseer : this.truncatedText(this.information.tafseer);

   const message = `
      Tafseer: ${ayahTafseer}
    `;

   const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}`;
   window.open(url, '_blank');
  },
  shareOnTwitter() {
   // const ayahInfo = this.information.ayahInfo || "No Ayah Info available"; // Fallback message
   // const mainAyah = this.information.mainAyah || "No Main Ayah available"; // Fallback message
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
