<template>
  <div class="row">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
      <!-- Note Icon -->
      <div class="icon-container">
        <i class="bi bi-file-earmark-text h3" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'transliterationNote')"></i>
      </div>

      <!-- Screenshot Icon -->
      <div class="icon-container">
        <i class="bi bi-camera text-right mr-2 h3" @click="captureTransliteration" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" :style="{ cursor: 'pointer' }"></i>
      </div>

      <!-- Surah info -->
      <div class="icon-container">
        <i style="cursor:pointer" class="bi bi-info-circle h4 mr-2 pl-2" data-bs-toggle="modal" data-bs-target="#translationInfo" aria-expanded="false" data-bs-placement="top" title="Surah info"></i>
      </div>

      <!-- Bug Report Icon -->
      <div class="icon-container">
        <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-chat-left-text h4" aria-expanded="false" data-bs-placement="top"></i>
      </div>
    </div>

    <!-- Folder Selection Modal -->
    <FolderSelectionModal ref="folderSelectionModal" />
  </div>
</template>

<script defer>
import TransliterationNote from './translation/features/notes/TransliterationNote';
import WhatsAppShareTransliteration from './translation/features/whatsapp/WhatsAppShareTransliteration.vue';
import TwitterShareTransliteration from './translation/features/twitter/TwitterShareTransliteration.vue';
import ScreenTransliterationCapture from './translation/features/screen_capture/ScreenTransliterationCapture.vue';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

export default {
  name: 'TransliterationActions',
  components: {
    TransliterationNote,
    WhatsAppShareTransliteration,
    TwitterShareTransliteration,
    ScreenTransliterationCapture
  },
  props: {
    transliteration: { type: String, required: true },
    isVisible: { type: Boolean, required: true },
    targetTransliterationRef: { type: String, default: 'targetTransliterationElement' }
  },
  data() {
    return {
      isSubmitting: false,
      showAlert: false,
      showErrorAlert: false
    };
  },
  methods: {
    toggleFullScreen() {
      this.isFullScreen = !this.isFullScreen;
    },
    toggleExpand() {
      this.expanded = !this.expanded;
    },
    submitFormTransliteration() {
      const { transliteration, information, userId } = this;
      const formData2 = {
        surah_name: information.ayah.surah.name_en,
        ayah_num: information.ayah_id,
        ayah_verse_ar: information.ayah.ayah_text,
        ayah_verse_en: transliteration,
        user_id: userId
      };

      if (Object.values(formData2).includes('') || !information?.ayah) {
        this.showErrorAlert = true;
        this.hideAlertAfterDelay();
        return;
      }

      this.isSubmitting = true;
      axios.post('/bookmarks', formData2)
        .then(response => {
          console.log(response.data.message);
          localStorage.setItem(`bookmarkSubmitted_${information.ayah_id}`, true);
          this.showAlert = true;
        })
        .catch(error => {
          console.error("Error submitting bookmark:", error);
          this.showErrorAlert = true;
        })
        .finally(() => {
          this.isSubmitting = false;
          this.hideAlertAfterDelay();
        });
    },
    hideAlertAfterDelay() {
      setTimeout(() => {
        this.showAlert = false;
        this.showErrorAlert = false;
      }, 3000); // Hide alerts after 3 seconds
    },
    captureTransliteration() {
      this._captureContent('screenshot.png', html2canvas);
    },
    downloadTransliterationPdf() {
      this._captureContent('download.pdf', (targetElement) => {
        const canvas = html2canvas(targetElement);
        return canvas.then((canvas) => {
          const imgData = canvas.toDataURL('image/png');
          const pdf = new jsPDF();
          pdf.addImage(imgData, 'PNG', 10, 10, 190, 0);
          pdf.save('download.pdf');
        });
      });
    },
    _captureContent(filename, captureFunction) {
      const targetElement = this.$parent.$refs[this.targetTransliterationRef];
      if (!targetElement) {
        console.error("Invalid element provided as targetTransliterationRef");
        return;
      }

      const unwantedElements = [
        '.icon-container', '.settings', '.summary', '.href', '.mobile-only', '.bar', '.pitch', '.rate',
        '.container.text-center', '.custom-icon-play', '.bi-rewind-circle-fill', 
        '.bi-plus-circle-fill', '.bi-dash-circle-fill', '.bi-play-circle-fill', 
        '.bi-pause-circle-fill', '.bi-stop-circle-fill', '.custom-icon-decrease', '.word-count'
      ];

      this._toggleElementsVisibility(unwantedElements, 'none');
      setTimeout(() => {
        captureFunction(targetElement)
          .catch((error) => console.error("Failed to capture content:", error))
          .finally(() => this._toggleElementsVisibility(unwantedElements, ''));
      }, 200);
    },
    _toggleElementsVisibility(selectors, displayStyle) {
      selectors.forEach(selector => {
        document.querySelectorAll(selector).forEach(el => el.style.display = displayStyle);
      });
    },
    showSettingsOffcanvas() {
      new bootstrap.Offcanvas(document.getElementById('offcanvasRight')).show();
    }
  },
  watch: {
    isVisible() {
      this.$emit('toggle-change');
    }
  }
};
</script>
