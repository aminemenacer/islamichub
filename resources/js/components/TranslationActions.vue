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
   <i class="bi bi-file-earmark-pdf text-right mr-2 h3" @click="downloadTranslationPdf" aria-expanded="false" data-bs-placement="top" title="Download PDF" :style="{ cursor: 'pointer' }"></i>
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

   html2canvas(targetTranslationElement)
    .then((canvas) => {
     const dataUrl = canvas.toDataURL("image/png");

     // Use Tesseract.js to extract text
     Tesseract.recognize(dataUrl, 'eng', { // Update 'eng' with your desired language code
       tessedit_char_whitelist: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!"#$%&()*+,-./:;<=>?@[\\]^_`{|}~ ' // Restrict character recognition (optional)
      })
      .then((result) => {
       const extractedText = result.text;
       console.log("Extracted Text:", extractedText);
       // Display the extracted text in an element (replace with your logic)
       document.getElementById('extracted-text').textContent = extractedText;
      })
      .catch((error) => {
       console.error("OCR error:", error);
      });
    })
    .catch((error) => {
     console.error("Failed to capture screenshot:", error);
    });
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
    console.error("Invalid element provided as targetTranslationRef");
    return;
   }

   // Select all the elements you want to hide
   const unwantedElements = [
    '.icon-container', // All icons (bookmark, screenshot, etc.)
    '.mobile-only', // WhatsApp and Twitter share buttons
    '.container.text-center', // Voice, Rate, and Pitch controls
    '.custom-icon-play', // Play button
    '.custom-icon-increase', // Increase text size button
    '.custom-icon-decrease' // Decrease text size button
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
      const imgData = canvas.toDataURL('image/png');
      const pdf = new jsPDF({
       orientation: 'portrait',
       unit: 'mm',
       format: 'a4',
      });

      pdf.addImage(imgData, 'PNG', 10, 10, 190, 0);
      pdf.save('download.pdf');

      // Restore the visibility of unwanted elements after capturing the screenshot
      showElements(unwantedElements);
     })
     .catch((error) => {
      console.error('Failed to capture HTML content:', error);
      // Restore the visibility even if there's an error
      showElements(unwantedElements);
     });
   }, 200);
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
