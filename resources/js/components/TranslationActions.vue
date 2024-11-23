<template>
  <div class="row">
    <!-- Success Message Alert -->
    <div v-if="showAlert" class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> {{ successMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" @click="showAlert = false"></button>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center">
      <!-- Note Icon -->
      <div class="icon-container">
        <i
          class="bi bi-file-earmark-text h3"
          aria-expanded="false"
          data-bs-placement="top"
          title="Write a note"
          @click="handleAction('open-modal', 'translationNote')"
        ></i>
      </div>

      <!-- Screenshot Icon -->
      <div class="icon-container">
        <i
          class="bi bi-camera text-right mr-2 h3"
          @click="captureTranslation"
          aria-expanded="false"
          data-bs-placement="top"
          title="Screenshot verse"
        ></i>
      </div>

      <!-- Surah Info Icon -->
      <div class="icon-container">
        <i
          class="bi bi-info-circle h4 mr-2 pl-2"
          data-bs-toggle="modal"
          data-bs-target="#translationInfo"
          aria-expanded="false"
          data-bs-placement="top"
          title="Surah info"
          style="cursor: pointer;"
        ></i>
      </div>

      <!-- Bug Report Icon -->
      <div class="icon-container">
        <i
          title="Report a bug"
          data-bs-toggle="modal"
          data-bs-target="#exampleModal"
          class="bi bi-chat-left-text h4"
          aria-expanded="false"
          data-bs-placement="top"
        ></i>
      </div>
    </div>
  </div>
</template>


<script>
import FolderSelectionModal from "./folder_manager/FolderSelectionModal.vue";
import ScreenTranslationCapture from './translation/features/screen_capture/ScreenTranslationCapture.vue';
import html2canvas from "html2canvas";
import jsPDF from 'jspdf';

export default {
  name: "TranslationActions",
  components: {
    FolderSelectionModal,
    ScreenTranslationCapture
  },
  props: {
    translation: {
      type: String,
      required: true,
    },
    information: {
      type: Object,
      required: true,
    },
    targetTranslationRef: {
      type: String,
      default: 'targetTranslationElement',
    },
  },
  data() {
    return {
      showAlert: false,  // Controls the visibility of the success message
      showErrorAlert: false,
      isSubmitting: false,
      successMessage: "",  // Holds the success message text
    };
  },
  computed: {
    combinedText() {
      return `Translation: ${this.information.translation}`;
    }
  },
  mounted() {
    const modalElement = document.getElementById('translationInfo');
    if (modalElement) {
      this.modalInstance = new bootstrap.Modal(modalElement, {
        backdrop: 'static',
      });
    }
  },
  methods: {
    handleAction(action, modalId) {
      this.$emit(action, modalId);
    },
    captureTranslation() {
      const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];

      if (!targetTranslationElement) {
        console.error("Invalid element provided as targetTranslationRef");
        return;
      }

      // Temporarily modify padding for better screenshot capture
      const originalPadding = targetTranslationElement.style.padding;
      targetTranslationElement.style.padding = "10px";

      // Elements to hide before screenshot
      const unwantedElements = [
        '.icon-container', '.href', '.mobile-only', '.bar', '.pitch', '.rate',
        '.container.text-center', '.custom-icon-play', '.bi-rewind-circle-fill', 
        '.bi-plus-circle-fill', '.bi-dash-circle-fill', '.bi-play-circle-fill',
        '.bi-pause-circle-fill', '.bi-stop-circle-fill', '.custom-icon-decrease',
        '.word-count'
      ];

      this.toggleElements(unwantedElements, 'none');  // Hide unwanted elements

      this.$emit('update-success-message', 'Screenshot captured & downloaded successfully!');
      setTimeout(() => {
        this.$emit('update-success-message', ''); // Clear the message after 3 seconds
      }, 3000);
    },
    toggleElements(selectors, displayValue) {
      selectors.forEach(selector => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(el => el.style.display = displayValue);
      });
    },
    submitForm() {
      const formData = {
        surah_name: this.information.ayah.surah.name_en,
        ayah_num: this.information.ayah_id,
        ayah_verse_ar: this.information.ayah.ayah_text,
        ayah_verse_en: this.information.translation,
        user_id: this.userId,
      };

      if (this.isFormDataIncomplete(formData)) {
        this.showErrorAlert = true;
        this.hideAlertAfterDelay();
        return;
      }

      this.isSubmitting = true;
      axios.post('/bookmarks', formData)
        .then(response => {
          console.log(response.data.message);
          localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
          this.successMessage = 'Bookmark saved successfully!';
          this.showAlert = true; // Show success alert
          this.showErrorAlert = false;
          this.hideAlertAfterDelay();
        })
        .catch(error => {
          console.error("Error submitting bookmark:", error);
          this.successMessage = '';  // Clear success message
          this.showErrorAlert = true;
          this.hideAlertAfterDelay();
        })
        .finally(() => {
          this.isSubmitting = false;
        });
    },
    isFormDataIncomplete(formData) {
      return !formData.surah_name || !formData.ayah_num || !formData.ayah_verse_ar || !formData.ayah_verse_en || !formData.user_id;
    },
    hideAlertAfterDelay() {
      setTimeout(() => {
        this.showAlert = false;
        this.showErrorAlert = false;
      }, 3000);  // Hide alerts after 3 seconds
    },
    downloadTranslationPdf() {
      const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];

      if (!targetTranslationElement) {
        console.error("Invalid element provided for PDF export");
        return;
      }

      const unwantedElements = document.querySelectorAll('.icon-container, .href, .mobile-only, .bar, .pitch, .rate');
      unwantedElements.forEach(el => el.classList.add('hidden-for-pdf'));

      html2canvas(targetTranslationElement, {
        scrollX: -window.scrollX,
        scrollY: -window.scrollY,
        windowWidth: document.documentElement.offsetWidth,
        windowHeight: document.documentElement.scrollHeight
      }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF({
          orientation: 'portrait',
          unit: 'mm',
          format: 'a4',
        });

        const pdfWidth = 190;  // Adjust for margins on A4
        const imgHeight = (canvas.height * pdfWidth) / canvas.width;
        pdf.addImage(imgData, 'PNG', 10, 10, pdfWidth, imgHeight);
        pdf.save('download.pdf');

        unwantedElements.forEach(el => el.classList.remove('hidden-for-pdf'));
      }).catch(error => {
        console.error('Failed to capture HTML content for PDF:', error);
      });
    },
    openFolderSelectionModal() {
      if (this.$refs.folderSelectionModal) {
        this.$refs.folderSelectionModal.show();
      } else {
        console.error("FolderSelectionModal component is not found.");
      }
    },
  },
};
</script>

