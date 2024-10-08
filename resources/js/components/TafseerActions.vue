<template>
<div class="row">
 <div class="d-flex flex-wrap justify-content-between align-items-center">
  <!-- Note Icon -->
  <div class="icon-container">
   <i class="bi bi-file-earmark-text h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('openModal', 'tafseerNote')"></i>
  </div>

  <!-- Bookmark Icon -->
  <div class="icon-container"><i @click="submitFormTafseer" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" title="Bookmark verse"></i>

   <!-- Screenshot Icon -->
   <div class="icon-container">
    <i class="bi bi-camera text-right mr-2 h3" @click="captureTafseer" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" :style="{ cursor: 'pointer' }"></i>
   </div>

   <!-- PDF Download Icon -->
   <div class="icon-container">
    <i class="bi bi-file-earmark-pdf text-right mr-2 h3" @click="downloadTafseerPdf" aria-expanded="false" data-bs-placement="top" title="Download PDF" :style="{ cursor: 'pointer' }"></i>
   </div>

   <!-- Bug Report Icon -->
   <div class="icon-container">
    <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug h4" aria-expanded="false" data-bs-placement="top"></i>
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
   return `Tafseer: ${this.information.tafseer}`;
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
    ayah_verse_en: this.information.tafseer,
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
  captureTafseer() {
   const targetTafseerElement = this.$parent.$refs[this.targetTafseerRef];

   if (!targetTafseerElement) {
    console.error("Invalid element provided as targetTafseerRef");
    return;
   }

   this.previewImage = null;

   setTimeout(() => {
    html2canvas(targetTafseerElement)
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

  downloadTafseerPdf() {
   const targetTafseerElement = this.$parent.$refs[this.targetTafseerRef];

   if (!targetTafseerElement) {
    console.error('Invalid element provided as targetTafseerRef');
    return;
   }

   html2canvas(targetTafseerElement).then((canvas) => {
    const imgData = canvas.toDataURL('image/png');
    const pdf = new jsPDF({
     orientation: 'portrait',
     unit: 'mm',
     format: 'a4',
    });

    pdf.addImage(imgData, 'PNG', 10, 10, 190, 0);
    pdf.save('download.pdf');
   }).catch((error) => {
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
