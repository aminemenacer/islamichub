<template>
<div class="row">
 <div class="d-flex flex-wrap justify-content-between align-items-center">
  <!-- Note Icon -->
  <div class="icon-container">
   <i class="bi bi-file-earmark-text h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'translationNote')"></i>
  </div>

  <!-- Bookmark Icon -->
  <div class="icon-container">
   <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse"></i>
  </div>

  <!-- Screenshot Icon -->
  <div class="icon-container">
   <i class="bi bi-camera text-right mr-2 h4" @click="captureTranslation" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" :style="{ cursor: 'pointer' }"></i>
  </div>

  

  <!-- PDF Download Icon -->
  <div class="icon-container">
   <i class="bi bi-file-earmark-pdf text-right mr-2 h4" @click="downloadTranslationPdf" aria-expanded="false" data-bs-placement="top" title="Download PDF" :style="{ cursor: 'pointer' }"></i>
  </div>

  <!-- Copy Translation Text Icon -->
  <div class="icon-container">
   <CopyTranslationText :textToCopy="translation" />
  </div>


  <!-- Bug Report Icon -->
  <div class="icon-container">
   <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug h4" aria-expanded="false" data-bs-placement="top"></i>
  </div>
 </div>

 <!-- Folder Selection Modal -->
 <FolderSelectionModal ref="folderSelectionModal" />
</div>
</template>

<script>
import CopyTranslationText from "./translation/features/copy_text/CopyTranslationText.vue";
import FolderSelectionModal from "./folder_manager/FolderSelectionModal.vue";
import ScreenTranslationCapture from './translation/features/screen_capture/ScreenTranslationCapture.vue';
import html2canvas from "html2canvas";
import jsPDF from 'jspdf';

export default {
 name: "TranslationActions",
 components: {
  CopyTranslationText,
  FolderSelectionModal,
  ScreenTranslationCapture
 },
 props: {
  translation: {
   type: String,
   required: true,
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
 methods: {
 
  captureTranslation() {
   const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];

   if (!targetTranslationElement) {
    console.error("Invalid element provided as targetTranslationRef");
    return;
   }
   setTimeout(() => {
    html2canvas(targetTranslationElement)
     .then((canvas) => {
      const dataUrl = canvas.toDataURL("image/png");

      // Automatically trigger download of the image
      const link = document.createElement("a");
      link.href = dataUrl;
      link.download = "screenshot.png";
      link.click();
     })
     .catch((error) => {
      console.error("Failed to capture screenshot:", error);
     });
   }, 200);
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

   html2canvas(targetTranslationElement)
    .then((canvas) => {
     const imgData = canvas.toDataURL('image/png');
     const pdf = new jsPDF({
      orientation: 'portrait',
      unit: 'mm',
      format: 'a4',
     });

     pdf.addImage(imgData, 'PNG', 10, 10, 190, 0);
     pdf.save('download.pdf');
    })
    .catch((error) => {
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
