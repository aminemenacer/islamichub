<template>
<div class="row">
 <div class="d-flex flex-wrap justify-content-between align-items-center">
  <!-- Note Icon -->
  <div class="icon-container">
   <i class="bi bi-file-earmark-text h3" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'transliterationNote')"></i>
  </div>

  <!-- Screenshot Icon 
  <div class="icon-container">
   <i class="bi bi-camera text-right mr-2 h3" @click="captureTransliteration" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" :style="{ cursor: 'pointer' }"></i>
  </div>
  -->
  <!-- PDF Download Icon -->
  <div class="icon-container">
   <i class="bi bi-file-earmark-pdf text-right mr-2 h3" @click="downloadTransliterationPdf" aria-expanded="false" data-bs-placement="top" title="Download PDF" :style="{ cursor: 'pointer' }"></i>
  </div>
  
  <!-- surah info -->
  <div class="icon-container">
   <i style="cursor:pointer" class="bi bi-info-circle h4 mr-2 pl-2" data-bs-toggle="modal" data-bs-target="#translationInfo" aria-expanded="false" data-bs-placement="top" title="Surah info" :style="{ cursor: 'pointer' }"></i>
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

<script>
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
  transliteration: {
   type: String,
   required: true
  },
  targetTransliterationRef: {
   type: String,
   default: 'targetTransliterationElement'
  }
 },
 data() {
  return {};
 },
 computed: {
  combinedText() {
   return `Transliteration: ${this.information.transliteration}`;
  }
 },
 methods: {
  submitFormTransliteration() {
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
   const formData2 = {
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.information.transliteration,
    user_id: this.userId,
   };

   // Check if all required fields are filled
   if (!formData2.surah_name || !formData2.ayah_num || !formData2.ayah_verse_ar || !formData2.ayah_verse_en || !formData2.user_id) {
    console.error("Form data is incomplete:", formData2);
    this.showErrorAlert = true;
    this.hideAlertAfterDelay();
    return; // Exit if validation fails
   }

   // Submit the form using Axios
   this.isSubmitting = true;
   axios.post('/bookmarks', formData2)
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
  captureTransliteration() {
   const targetTransliterationElement = this.$parent.$refs[this.targetTransliterationRef];

   if (!targetTransliterationElement) {
    console.error("Invalid element provided as targetTransliterationRef");
    return;
   }

   // Select all the elements you want to hide
   const unwantedElements = [
    '.icon-container', // All icons (bookmark, screenshot, etc.)
    '.mobile-only', // WhatsApp and Twitter share buttons
    '.container.text-center', // Voice, Rate, and Pitch controls
    '.href' // Decrease text size button
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
    html2canvas(targetTransliterationElement)
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
  downloadTransliterationPdf() {
   const targetTransliterationElement = this.$parent.$refs[this.targetTransliterationRef];

   if (!targetTransliterationElement) {
    console.error("Invalid element provided as targetTransliterationRef");
    return;
   }

   // Select all the elements you want to hide
   const unwantedElements = [
    '.icon-container', // All icons (bookmark, screenshot, etc.)
    '.mobile-only', // WhatsApp and Twitter share buttons
    '.container.text-center', // Voice, Rate, and Pitch controls
    '.href' // Decrease text size button
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

   html2canvas(targetTransliterationElement)
    .then((canvas) => {
     const imgData = canvas.toDataURL('image/png');
     const pdf = new jsPDF({
      orientation: 'portrait',
      unit: 'mm',
      format: 'a4'
     });

     pdf.addImage(imgData, 'PNG', 10, 10, 190, 0);
     pdf.save('download.pdf');
     showElements(unwantedElements);
    })
    .catch((error) => {
     console.error('Failed to capture HTML content:', error);
     showElements(unwantedElements);
    });
  }
 }
};
</script>
