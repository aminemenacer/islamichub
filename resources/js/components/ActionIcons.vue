<template>
<div>
  <div class="action-icons">
    <TranslationNote ref="translationNote" :information="information.translation" />
    <WhatsAppShareTranslation :translationToShare="information.translation" />
    <TwitterShareTranslation :targetElementRef="'targetElement'" :translationText="information.translation" />
    <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
    <CopyTranslationText :textToCopy="information.translation" />
    <ScreenTranslationCapture :targetTranslationRef="'targetTranslationElement'" />
    <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
    <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
    <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#translationInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i>
  </div>
  <div v-if="showAlert" class="alert alert-success" role="alert">
      Bookmark saved successfully!
    </div>
    <div v-if="showErrorAlert" class="alert alert-danger" role="alert">
      An error occurred while saving the bookmark.
    </div>
  </div>
</template>

<script>
import TranslationNote from './translation/features/notes/TranslationNote.vue'
import WhatsAppShareTranslation from './translation/features/whatsapp/WhatsAppShareTranslation.vue'
import TwitterShareTranslation from './translation/features/twitter/TwitterShareTranslation.vue'
import BookmarkTranslation from './translation/features/bookmarking/BookmarkTranslation.vue'
import CopyTranslationText from './translation/features/copy_text/CopyTranslationText.vue'
import ScreenTranslationCapture from './translation/features/screen_capture/ScreenTranslationCapture.vue'
import axios from 'axios';

export default {
  name: 'ActionIcons',
  components: {
    TranslationNote,
    WhatsAppShareTranslation,
    TwitterShareTranslation,
    BookmarkTranslation,
    CopyTranslationText,
    ScreenTranslationCapture
  },
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
      showAlert: false,
      showErrorAlert: false,
      
    };
  },
  methods: {
    submitForm() {
      const formData = {
        surah_name: this.information.ayah.surah.name_en,
        ayah_num: this.information.ayah_id,
        ayah_verse_ar: this.information.ayah.ayah_text,
        ayah_verse_en: this.information.translation,
      };

      axios.post('/bookmarks', formData)
        .then(response => {
          console.log(response.data.message);
          // Set the submitted status for the selected bookmark
          localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
          // Log the updated bookmarkSubmitted object
          console.log(this.bookmarkSubmitted);
          this.showAlert = true; // Show success alert
          this.showErrorAlert = false; // Hide error alert
          this.hideAlertAfterDelay(); // Start timer to hide alert
        })
        .catch(error => {
          console.error(error);
          this.showAlert = false; // Hide success alert
          this.showErrorAlert = true; // Show error alert
          this.hideAlertAfterDelay(); // Start timer to hide alert
        });
    },
    toggleFullScreen() {
      this.isFullScreen = !this.isFullScreen;
    },
    toggleExpand() {
      this.expanded = !this.expanded;
    },
    hideAlertAfterDelay() {
      setTimeout(() => {
        this.showAlert = false;
        this.showErrorAlert = false;
      }, 3000);
    }
  }
};
</script>

<style scoped>
.action-icons {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}
.alert {
  position: fixed;
  top: 10px;
  right: 10px;
  z-index: 1000;
}
</style>
