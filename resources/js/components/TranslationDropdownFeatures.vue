<template>
  <div class="dropdown mobile-only">
    <div class="icon-container">
      <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166);" @click="goToFirstAyah" title="First verse"></i>
      <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166);" @click="goToPreviousAyah" title="Previous verse"></i>
      <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166);" @click="goToNextAyah" title="Next verse"></i>
      <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166);" @click="goToLastAyah" title="End verse"></i>
      <i class="bi bi-arrows-fullscreen h6" style="color: rgb(0, 191, 166); cursor: pointer" @click="toggleFullScreen" title="Full screen"></i>
      <i style="color: rgb(0, 191, 166); cursor: pointer" class="bi bi-three-dots-vertical h5 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#translationNote"><i class="bi bi-file-earmark-text text-right mr-2 h4" style="color: rgba(0, 191, 166);" title="Write a note"></i>Write a Note</a></li>
        <li><a class="dropdown-item" @click="shareTextViaWhatsApp3"><i class="bi bi-whatsapp text-right mr-2 h4" style="color: rgba(0, 191, 166);" title="Share on Whatsapp"></i>Share via WhatsApp</a></li>
        <li><a class="dropdown-item" @click="shareHeadingOnTwitter3"><i class="bi bi-twitter-x text-right mr-2 h4" style="color: rgb(0, 191, 166);" title="Share via X"></i>Share via X</a></li>
        <li><a class="dropdown-item" @click="submitForm"><i class="bi bi-bookmark text-right mr-2 h4" style="color: rgba(0, 191, 166);" title="Bookmark verse"></i>Bookmark Verse</a></li>
        <li><a class="dropdown-item" @click="copyText3"><i class="bi bi-clipboard-check text-right mr-2 h4" style="color: rgba(0, 191, 166);" title="Copy verse"></i>Copy Verse</a></li>
        <li><a class="dropdown-item" @click="captureScreenshot3"><i class="bi bi-camera text-right mr-2 h4" style="color: rgba(0, 191, 166);" title="Screenshot verse"></i>Screenshot Verse</a></li>
        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#translationInfo"><i class="bi bi-info-circle text-right mr-2 h4" style="color: rgba(0, 191, 166);" title="Surah info"></i>Surah Info</a></li>
        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-bug text-right mr-2 h4" style="color: rgba(0, 191, 166);" title="Report a bug"></i>Report a Bug</a></li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TranslationDropdownFeatures',
  methods: {
    goToFirstAyah() {
      this.$emit('go-to-first-ayah');
    },
    goToPreviousAyah() {
      this.$emit('go-to-previous-ayah');
    },
    goToNextAyah() {
      this.$emit('go-to-next-ayah');
    },
    goToLastAyah() {
      this.$emit('go-to-last-ayah');
    },
    toggleFullScreen() {
      this.$emit('toggle-full-screen');
    },
    shareTextViaWhatsApp3() {
      const textToShare = 'Check out this Ayah!';
      const whatsappUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(textToShare)}`;
      window.open(whatsappUrl, '_blank');
    },
    shareHeadingOnTwitter3() {
      const textToShare = 'Check out this Ayah!';
      const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(textToShare)}`;
      window.open(twitterUrl, '_blank');
    },
    submitForm() {
      alert('Form submitted!');
    },
    copyText3() {
      const textToCopy = 'Text to copy';
      navigator.clipboard.writeText(textToCopy).then(() => {
        alert('Text copied to clipboard!');
      }).catch(err => {
        console.error('Failed to copy text: ', err);
      });
    },
    captureScreenshot3() {
      alert('Screenshot captured!');
    }
  }
};
</script>

<style scoped>
/* Add any necessary styling here */
</style>
