<template>
<div ref="targetElement1" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
 <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
 <h5 class="mr-2">{{ information.ayah.surah.name_en }} {{ information.ayah.surah_id }}: {{ information.ayah.ayah_id }}</h5>

 <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
  <!-- main stack top -->
  <div class="btn">
   <h5 class="text-right ayah-tafseer" name="ayah_text" style="line-height: 1.6em">
    {{ information.ayah.ayah_text }}
   </h5>
  </div>
  <!-- main stack below -->
  <h5 class="text-left ayah-tafseer" ref="heading1" style="line-height: 1.6em">
   {{ expanded ? tafseer : truncatedText(tafseer) }}
   <template v-if="showMoreLink">
    <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
   </template>
  </h5>
  <h6 class="text-left mt-3"><strong>Tafseer: </strong>Ibn Kathir</h6>
  <br>
  <!-- Bootstrap Alert Component -->
  <div v-if="showAlertText" class="alert alert-success alert-dismissible fade show" role="alert">
   Text copied successfully!
  </div>
  <!-- Bookmark Component -->
  <div v-if="showAlert" class="alert alert-success" role="alert">
   Bookmark created successfully!
  </div>
  <div v-if="showErrorAlert" class="alert alert-danger" role="alert">
   Login to your account to be able to bookmark verses.
  </div>
 </div>
</div>
</template>

<script>
export default {
 name: 'AyahTafseer',
 props: {
  information: {
   type: Object,
   required: true
  }
 },
 data() {
  return {
   isFullScreen: false,
   expanded: false,
   showMoreLink: true, // Set to false if no 'Show More' link needed
   showAlertText: false,
   showAlert: false,
   showErrorAlert: false,
   showAlertTextNote: false,
   touchStartX: 0,
   touchEndX: 0
  };
 },
 methods: {
  toggleFullScreen() {
   this.isFullScreen = !this.isFullScreen;
  },
  toggleExpand() {
   this.expanded = !this.expanded;
  },
  truncatedText(text) {
   const maxLength = 200; // Define your desired max length here
   if (text.length > maxLength) {
    return text.substring(0, maxLength) + '...';
   } else {
    return text;
   }
  },
  handleTouchStart(event) {
   this.touchStartX = event.changedTouches[0].screenX;
  },
  handleTouchMove(event) {
   this.touchEndX = event.changedTouches[0].screenX;
  },
  handleTouchEnd() {
   if (this.touchEndX < this.touchStartX) {
    this.goToNextAyah();
   } else if (this.touchEndX > this.touchStartX) {
    this.goToPreviousAyah();
   }
   this.touchStartX = 0;
   this.touchEndX = 0;
  },
  goToNextAyah() {
   // Logic to go to the next verse
   alert('Going to next verse!'); // Replace with actual logic to navigate to the next verse
  },
  goToPreviousAyah() {
   // Logic to go to the previous verse
   alert('Going to previous verse!'); // Replace with actual logic to navigate to the previous verse
  },
 },
}
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

.ayah-tafseer {
 font-size: 1.2rem;
}

.btn {
 display: flex;
 justify-content: flex-end;
 align-items: center;
}

.btn .bi {
 margin-left: 10px;
}

@media (max-width: 576px) {
 .mobile-only {
  display: block;
 }

 .hide-on-mobile {
  display: none;
 }
}
</style>
