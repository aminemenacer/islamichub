<template>
  <!-- Dropdown Features -->
  <div class="dropdown mobile-only">
    <div class="icon-container">
      <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166);" @click="goToFirstAyah" title="First verse"></i>
      <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166);" @click="goToPreviousAyah" title="Previous verse"></i>
      <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166);" @click="goToNextAyah" title="Next verse"></i>
      <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166);" @click="goToLastAyah" title="End verse"></i>
      <i class="bi bi-arrows-fullscreen h6" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
      <i style="color:rgb(0, 191, 166); cursor:pointer" class="bi bi-three-dots-vertical h5 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tafseerNote"><i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" style="color: rgba(0, 191, 166);"></i>Write a Note</a></li>
        <li><a class="dropdown-item" @click="shareTextViaWhatsApp1"><i class="bi bi-whatsapp text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166);"></i>Share via WhatsApp</a></li>
        <li><a class="dropdown-item" @click="shareHeadingOnTwitter1"><i style=" color:rgb(0, 191, 166); cursor:pointer" class="mr-2 bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X"></i>Share via X</a></li>
        <li><a class="dropdown-item" @click="submitForm"><i class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);"></i>Bookmark Verse</a></li>
        <li><a class="dropdown-item" @click="copyText1"><i class="bi bi-clipboard-check text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166);"></i>Copy Verse</a></li>
        <li><a class="dropdown-item" @click="captureScreenshot1"><i class="bi bi-camera text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166);"></i>Screenshot Verse</a></li>
        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tafseerInfo"><i class="bi bi-info-circle text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Surah info" style="color: rgba(0, 191, 166);"></i>Surah Info</a></li>
        <li><a class="dropdown-item" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#bugTafseer"><i class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Report a bug" style="color: rgba(0, 191, 166);"></i>Report a bug</a></li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    shareTextViaWhatsApp3() {
      this.$emit('shareTextViaWhatsApp');
    },
    submitForm() {
      this.$emit('submitForm');
    },
    copyText3() {
      this.$emit('copyText');
    },
    captureScreenshot3() {
      this.$emit('captureScreenshot');
    },
    toggleFullScreen() {
      this.$emit('toggleFullScreen');
    },
    goToFirstAyah() {
      this.$emit('goToFirstAyah');
    },
    goToPreviousAyah() {
      this.$emit('goToPreviousAyah');
    },
    goToNextAyah() {
      this.$emit('goToNextAyah');
    },
    goToLastAyah() {
      this.$emit('goToLastAyah');
    }
  }
}
</script>

<style scoped>
.icon-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.mobile-only {
  display: none;
}

@media (max-width: 768px) {
  .hide-on-mobile {
    display: none;
  }
  .mobile-only {
    display: block;
  }
}
</style>
