<template>
  <div>
    <div class="action-icons" >
      <TransliterationNote ref="transliterationNote" :information="information.transliteration" />
      <WhatsAppShareTransliteration :transliterationToShare="information.transliteration" />
      <TwitterShareTransliteration :targetElementRef="'targetElement'" :transliterationText="information.transliteration" />
      <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
      <CopyTransliterationText :textToCopy="information.transliteration" />
      <ScreenTransliterationCapture :targetTransliterationRef="'targetTransliterationElement'" />
      <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
      <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
      <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#transliterationInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i>
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
import html2canvas from 'html2canvas';
import TransliterationNote from './translation/features/notes/TransliterationNote.vue'
import WhatsAppShareTransliteration from './translation/features/whatsapp/WhatsAppShareTransliteration.vue'
import TwitterShareTransliteration from './translation/features/twitter/TwitterShareTransliteration.vue'
import CopyTransliterationText from './translation/features/copy_text/CopyTransliterationText.vue'
import ScreenTransliterationCapture from './translation/features/screen_capture/ScreenTransliterationCapture.vue'
import axios from 'axios';

export default {
  name: 'ActionIcons',
  components: {
    TransliterationNote,
    WhatsAppShareTransliteration,
    TwitterShareTransliteration,
    CopyTransliterationText,
    ScreenTransliterationCapture
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
      showAlert: false,
      showErrorAlert: false,
    };
  },
  methods: {
    submitForm2() {
      const formData = {
        surah_name: this.information.ayah.surah.name_en,
        ayah_num: this.information.ayah_id,
        ayah_verse_ar: this.information.ayah.ayah_text,
        ayah_verse_en: this.information.transliteration,
      };

      axios.post('/bookmarks', formData)
        .then(response => {
          console.log(response.data.message);
          localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
          this.showAlert = true;
          this.showErrorAlert = false;
          this.hideAlertAfterDelay();
        })
        .catch(error => {
          console.error(error);
          this.showAlert = false;
          this.showErrorAlert = true;
          this.hideAlertAfterDelay();
        });
    },
    toggleFullScreen() {
      this.isFullScreen = !this.isFullScreen;
      const element = this.$refs.targetTransliterationElement;
      if (this.isFullScreen) {
        if (element.requestFullscreen) {
          element.requestFullscreen();
        } else if (element.mozRequestFullScreen) {
          element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
          element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
          element.msRequestFullscreen();
        }
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
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
}
.alert {
  position: fixed;
  top: 10px;
  right: 10px;
  z-index: 1000;
}
</style>
