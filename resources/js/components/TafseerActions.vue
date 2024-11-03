<template>
<div class="row">
  <div class="d-flex flex-wrap justify-content-between align-items-center">
    <!-- Note Icon -->
    <div class="icon-container">
      <i class="bi bi-file-earmark-text h3" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('openModal', 'tafseerNote')"></i>
    </div>

    <!-- Screenshot Icon -->
  <div class="icon-container">
   <i class="bi bi-camera text-right mr-2 h3" @click="captureTafseer" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" :style="{ cursor: 'pointer' }"></i>
  </div>
  

    <!-- PDF Download Icon -->
    <!-- <div class="icon-container">
      <i class="bi bi-file-earmark-pdf text-right mr-2 h3" @click="downloadTafseerPdf" aria-expanded="false" data-bs-placement="top" title="Download PDF" :style="{ cursor: 'pointer' }"></i>
    </div> -->

    <!-- surah info -->
    <div class="icon-container">
      <!-- Trigger icon for Surah info modal -->
      <i class="bi bi-info-circle h4 mr-2 pl-2" data-bs-toggle="modal" :data-bs-target="'#' + sectionType + 'Info'" aria-expanded="false" data-bs-placement="top" :title="sectionType + ' Info'" :style="{ cursor: 'pointer' }">
      </i>
    </div>

    <!-- Bug Report Icon -->
    <div class="icon-container">
      <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-chat-left-text h4" aria-expanded="false" data-bs-placement="top"></i>
    </div>
  </div>

</div>
</template>

<script>
import FolderSelectionModal from './folder_manager/FolderSelectionModal.vue';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

export default {
  name: 'TafseerActions',
  components: {
    FolderSelectionModal,
  },
  props: {
    tafseer: {
      type: String,
      required: true,
    },
    information: {
      type: Object,
      required: true
    },
    targetTafseerRef: {
      type: String,
      default: 'targetTafseerElement',
    },
  },
  data() {
    return {
      surat: [],
      ayat: [],
      tafseers: [],
      information: {
        ayah: {
          surah: {
            name_en: '', // Initialize as required
          },
          ayah_text: '', // Example ayah text
        },
        translation: '', // Example translation
        transliteration: '', // Example transliteration
        tafseer: ''
      },
    };
  },
  computed: {
    combinedText() {
      return `Tafseer: ${this.tafseer}`;
    }
  },
  methods: {
    submitFormTafseer() {
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
      const formData1 = {
        surah_name: this.information.ayah.surah.name_en,
        ayah_num: this.information.ayah_id,
        ayah_verse_ar: this.information.ayah.ayah_text,
        ayah_verse_en: this.tafseer,
        user_id: this.userId,
      };

      // Check if all required fields are filled
      if (!formData1.surah_name || !formData1.ayah_num || !formData1.ayah_verse_ar || !formData1.ayah_verse_en || !formData1.user_id) {
        console.error("Form data is incomplete:", formData1);
        this.showErrorAlert = true;
        this.hideAlertAfterDelay();
        return; // Exit if validation fails
      }

      // Submit the form using Axios
      this.isSubmitting = true;
      axios.post('/bookmarks', formData1)
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
    showSettingsOffcanvasTafseer() {
      // Use Bootstrap Offcanvas show method to open the panel
      let offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasRight'));
      offcanvas.show();
    },
    captureTafseer() {
      const targetTafseerElement = this.$parent.$refs[this.targetTafseerRef];

      if (!targetTafseerElement) {
        console.error("Invalid element provided as targetTafseerRef");
        return;
      }

      // Store the original padding of the target element
      const originalPadding = targetTafseerElement.style.padding;

      // Set the desired padding
      targetTafseerElement.style.padding = "10px"; // Adjust this value as needed


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
        html2canvas(targetTafseerElement)
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

    downloadTafseerPdf() {
      // Reference the correct target element
      const targetTafseerElement = this.$parent.$refs[this.targetTafseerRef];

      if (!targetTafseerElement) {
        console.error("Invalid element provided as first argument");
        return;
      }

      // Hide unwanted elements
      const unwantedElements = document.querySelectorAll(
        '.icon-container, .href, .mobile-only, .bar, .pitch, .rate, .container.text-center, ' +
        '.custom-icon-play, .bi-rewind-circle-fill, .bi-plus-circle-fill, .bi-dash-circle-fill, ' +
        '.bi-play-circle-fill, .bi-pause-circle-fill, .bi-stop-circle-fill, .custom-icon-decrease'
      );
      
      unwantedElements.forEach(el => el.style.display = 'none'); // Fully hide elements

      // Generate the PDF
      html2canvas(targetTafseerElement, {
        scrollX: -window.scrollX,
        scrollY: -window.scrollY,
        windowWidth: document.documentElement.offsetWidth,
        windowHeight: targetTafseerElement.scrollHeight, // Capture full target element height
        scale: 2 // Increase scale for better quality
      })
      .then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF({
          orientation: 'portrait',
          unit: 'mm',
          format: 'a4',
        });

        const pdfWidth = 190; // Adjust for margins on A4
        const imgHeight = (canvas.height * pdfWidth) / canvas.width;

        pdf.addImage(imgData, 'PNG', 10, 10, pdfWidth, imgHeight);
        pdf.save('download.pdf');

        // Restore visibility after PDF creation
        unwantedElements.forEach(el => el.style.display = '');
      })
      .catch(error => {
        console.error('Failed to capture HTML content:', error);
      });
    },


    openFolderSelectionModal() {
      if (this.$refs.folderSelectionModal) {
        this.$refs.folderSelectionModal.show();
      } else {
        console.error('FolderSelectionModal component is not found.');
      }
    },
  },
};
</script>
