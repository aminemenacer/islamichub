<template>
  <div class="icon-container w-100 hide-on-mobile pb-3">
    <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" data-bs-toggle="modal" data-bs-target="#translationNote" style="color: rgba(0, 191, 166); cursor: pointer"></i>
    <i class="bi bi-whatsapp text-right mr-2 h4" @click="shareTextViaWhatsApp3" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166); cursor: pointer"></i>
    <i style="color: rgb(0, 191, 166); cursor: pointer" @click="shareHeadingOnTwitter3" class="mr-2 bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X"></i>
    <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166); cursor: pointer"></i>
    <i @click="copyText3" class="bi bi-clipboard-check text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166); cursor: pointer"></i>
    <i class="bi bi-camera text-right mr-2 h3" @click="captureScreenshot3" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166); cursor: pointer"></i>
    <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#bugTranslation" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer"></i>
    <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166); cursor: pointer" @click="toggleFullScreen" title="Full screen"></i>
    <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166); cursor: pointer" data-bs-target="#translationInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i>
  </div>
</template>

<script>
export default {
  methods: {
    shareTextViaWhatsApp3() {
      this.$emit('shareTextViaWhatsApp');
    },
    shareHeadingOnTwitter3() {
      try {
        const headingText1 = this.$refs.targetElement1.textContent.trim();
        const encodedHeading = encodeURIComponent(headingText1);
        const twitterUrl = `https://twitter.com/intent/tweet?text=${encodedHeading}`;
        window.open(twitterUrl, "_blank") || console.error("Failed to open Twitter sharing dialog.");
      } catch (error) {
        console.error("Error:", error);
      }
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
