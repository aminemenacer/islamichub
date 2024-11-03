<template>
<div class="row">
  <div class="d-flex flex-wrap justify-content-between align-items-center">
    <!-- Note Icon -->
    <div class="icon-container">
      <i class="bi bi-file-earmark-text h3" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'translationNote')"></i>
    </div>

    <!-- Screenshot Icon -->
    <div class="icon-container">
    <i class="bi bi-camera text-right mr-2 h3" @click="captureTranslation" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" :style="{ cursor: 'pointer' }"></i>
    </div>
    

    <!-- PDF Download Icon -->
    <!-- <div class="icon-container">
      <i class="bi bi-file-earmark-pdf text-right mr-2 h3" @click="downloadTranslationPdf" aria-expanded="false" data-bs-placement="top" title="Download PDF" :style="{ cursor: 'pointer' }"></i>
    </div> -->

    <!-- surah info icon -->
    <div class="icon-container">
      <!-- Trigger icon for Surah info modal -->
      <i class="bi bi-info-circle h4 mr-2 pl-2" 
        data-bs-toggle="modal" 
        :data-bs-target="'#' + sectionType + 'Info'"
        aria-expanded="false" 
        data-bs-placement="top" 
        :title="sectionType + ' Info'"
        :style="{ cursor: 'pointer' }">
      </i>
    </div>

    <!-- Bug Report Icon -->
    <div class="icon-container">
      <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-chat-left-text h4" aria-expanded="false" data-bs-placement="top"></i>
    </div>
  </div>

  <!-- Folder Selection Modal -->
  <!-- <FolderSelectionModal ref="folderSelectionModal" /> -->
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
      required: true
    },
    targetTranslationRef: {
      type: String,
      default: 'targetTranslationElement',
    },

  },
  data() {
    return {
      surat: [],
      ayat: [],
      tafseers: [],
      ayah_id: null,
      userId: null, // Make sure userId is set as needed
      information: {
        ayah: {
          surah: {
            name_en: '', // Initialize as required
          },
          ayah_text: '', // Example ayah text
        },
        translation: '', // Example translation
        transliteration: '', // Example transliteration
      },
      showAlert: false,
      showErrorAlert: false,
      isSubmitting: false,
    };

  },
  computed: {
    combinedText() {
      return `Translation: ${this.information.translation}`;
    }
  },
  methods: {
    submitForm() {
      const formData = {
        // folder_id: this.selectedFolderId,
        surah_name: this.information.ayah.surah.name_en,
        ayah_num: this.information.ayah_id,
        ayah_verse_ar: this.information.ayah.ayah_text,
        ayah_verse_en: this.information.translation,
        user_id: this.userId,
      };
      axios.post('/bookmarks', formData)
        .then(response => {
          console.log(response.data.message);
          localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
          this.showAlert = true;
          this.showErrorAlert = false;
          this.hideAlertAfterDelay();
          // Display a confirmation message with the bookmarked ayah and folder
          // this.$refs.bookmarkConfirmation.textContent = 
          //   `Successfully bookmarked ayah ${this.information.ayah_id} to folder "${this.selectedFolderId}"`;
        })
    },
    captureTranslation() {
      const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];

      if (!targetTranslationElement) {
        console.error("Invalid element provided as targetTranslationRef");
        return;
      }

      // Select all the elements you want to hide
      const unwantedElements = [
        '.icon-container, .href, .mobile-only, .bar, .pitch, .rate, .container.text-center, ' +
        '.custom-icon-play, .bi-rewind-circle-fill, .bi-plus-circle-fill, .bi-dash-circle-fill, ' +
        '.bi-play-circle-fill, .bi-pause-circle-fill, .bi-stop-circle-fill, .custom-icon-decrease, .word-count'
      ];

      // Function to hide elements
      const hideElements = (selectorArray) => {
        selectorArray.forEach(selector => {
          const elements = document.querySelectorAll(selector);
          elements.forEach(el => {
            el.style.display = 'none';
          });
        });
      };

      // Function to show elements
      const showElements = (selectorArray) => {
        selectorArray.forEach(selector => {
          const elements = document.querySelectorAll(selector);
          elements.forEach(el => {
            el.style.display = '';
          });
        });
      };

      // Hide unwanted elements
      hideElements(unwantedElements);

      setTimeout(() => {
        html2canvas(targetTranslationElement)
          .then((canvas) => {
            const dataUrl = canvas.toDataURL("image/png");

            // Automatically trigger download of the image
            const link = document.createElement("a");
            link.href = dataUrl;
            link.download = "screenshot.png";
            link.click();
            showElements(unwantedElements);
          })
          .catch((error) => {
            console.error("Failed to capture screenshot:", error);
            showElements(unwantedElements);
          });
      }, 200);
    },
    showSettingsOffcanvas() {
      // Use Bootstrap Offcanvas show method to open the panel
      let offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
      offcanvas.show();
    },
    submitForm() {
      // Debug log to check current information
      console.log('Current information:', this.information);

      // Check if ayah information is present
      if (!this.information || !this.information.ayah) {
        console.error("Ayah information is missing.");
        this.showErrorAlert = true;
        this.hideAlertAfterDelay();
        return; // Exit if required data is missing
      }

      // Prepare form data for submission
      const formData = {
        surah_name: this.information.ayah.surah.name_en,
        ayah_num: this.information.ayah_id,
        ayah_verse_ar: this.information.ayah.ayah_text,
        ayah_verse_en: this.information.translation,
        user_id: this.userId,
      };

      // Check if all required fields are filled
      if (!formData.surah_name || !formData.ayah_num || !formData.ayah_verse_ar || !formData.ayah_verse_en || !formData.user_id) {
        console.error("Form data is incomplete:", formData);
        this.showErrorAlert = true;
        this.hideAlertAfterDelay();
        return; // Exit if validation fails
      }

      // Submit the form using Axios
      this.isSubmitting = true;
      axios.post('/bookmarks', formData)
        .then(response => {
          console.log(response.data.message);
          // Mark bookmark as submitted in localStorage
          localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
          this.showAlert = true;
          this.showErrorAlert = false;
          this.hideAlertAfterDelay();
        })
        .catch(error => {
          console.error("Error submitting bookmark:", error);
          this.showErrorAlert = true;
          this.hideAlertAfterDelay();
        })
        .finally(() => {
          this.isSubmitting = false; // Re-enable submit button
        });
    },
    hideAlertAfterDelay() {
      setTimeout(() => {
        this.showAlert = false;
        this.showErrorAlert = false;
      }, 3000); // Hide alerts after 3 seconds
    },
    downloadTranslationPdf() {
      const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];

      if (!targetTranslationElement) {
        console.error("Invalid element provided as first argument");
        return;
      }

      // Select elements to hide before generating the PDF
      const unwantedElements = document.querySelectorAll(
        '.icon-container, .href, .mobile-only, .bar, .pitch, .rate, .container.text-center, ' +
        '.custom-icon-play, .bi-rewind-circle-fill, .bi-plus-circle-fill, .bi-dash-circle-fill, ' +
        '.bi-play-circle-fill, .bi-pause-circle-fill, .bi-stop-circle-fill, .custom-icon-decrease'
      );

      // Add the hidden class to hide elements
      unwantedElements.forEach(el => {
        el.classList.add('hidden-for-pdf');
      });

      html2canvas(targetTranslationElement, {
        scrollX: -window.scrollX,
        scrollY: -window.scrollY,
        windowWidth: document.documentElement.offsetWidth,
        windowHeight: document.documentElement.scrollHeight // Full page height
      })
      .then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF({
          orientation: 'portrait',
          unit: 'mm',
          format: 'a4',
        });

        // Adjust image dimensions to fit A4, considering PDF margins
        const pdfWidth = 190; // Adjust for margins on A4
        const imgHeight = (canvas.height * pdfWidth) / canvas.width;

        pdf.addImage(imgData, 'PNG', 10, 10, pdfWidth, imgHeight);
        pdf.save('download.pdf');

        // Remove the hidden class after saving the PDF
        unwantedElements.forEach(el => {
          el.classList.remove('hidden-for-pdf');
        });
      })
      .catch(error => {
        console.error('Failed to capture HTML content:', error);
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
