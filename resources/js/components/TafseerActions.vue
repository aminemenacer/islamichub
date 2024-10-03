<template>
<div class="row">
 <div class="d-flex flex-wrap justify-content-between align-items-center">
  <!-- Note Icon -->
  <div class="icon-container">
   <i class="bi bi-file-earmark-text h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('openModal', 'tafseerNote')"></i>
  </div>

  <!-- Bookmark Icon -->
  <div class="icon-container">
   <i @click="openFolderSelectionModal" class="bi bi-bookmark h4" title="Select Folder to Bookmark"></i>
  </div>

  <!-- Screenshot Icon -->
  <div class="icon-container">
   <i class="bi bi-camera text-right mr-2 h3" @click="captureTafseer" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" :style="{ cursor: 'pointer' }"></i>
  </div>

  <!-- PDF Download Icon -->
  <div class="icon-container">
   <i class="bi bi-file-earmark-pdf text-right mr-2 h3" @click="downloadTafseerPdf" aria-expanded="false" data-bs-placement="top" title="Download PDF" :style="{ cursor: 'pointer' }"></i>
  </div>

  <!-- Copy Tafseer Text Component -->
  <div class="icon-container">
   <CopyTafseerText :textToCopy="tafseer" />
  </div>

  <!-- Bug Report Icon -->
  <div class="icon-container">
   <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug h4" aria-expanded="false" data-bs-placement="top"></i>
  </div>
 </div>

</div>
</template>

<script>
import CopyTafseerText from './translation/features/copy_text/CopyTafseerText.vue';
import FolderSelectionModal from './folder_manager/FolderSelectionModal.vue';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

export default {
 name: 'TafseerActions',
 components: {
  CopyTafseerText,
  FolderSelectionModal,
 },
 props: {
  tafseer: {
   type: String,
   required: true,
  },
  targetTafseerRef: {
   type: String,
   default: 'targetTafseerElement',
  },
 },
 data() {
  return {
  };
 },
 computed: {
    combinedText() {
      return `Tafseer: ${this.information.tafseer}`;
    }
  },
 methods: {
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
