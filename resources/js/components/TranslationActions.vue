<template>
  <div class="row">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
      <!-- Note Icon -->
      <div class="icon-container">
        <i class="bi bi-file-earmark-text h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'translationNote')"></i>
      </div>

      <!-- Bookmark Icon -->
      <div class="icon-container">
        <i @click="openFolderSelectionModal" class="bi bi-bookmark h4" title="Select Folder to Bookmark"></i>
      </div>

      <!-- Screenshot Icon -->
      <div class="icon-container">
        <i class="bi bi-camera text-right mr-2 h3" @click="captureTranslation" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" :style="{ cursor: 'pointer' }"></i>
      </div>

      <!-- PDF Download Icon -->
      <div class="icon-container">
        <i class="bi bi-file-earmark-pdf text-right mr-2 h3" @click="downloadPdf" aria-expanded="false" data-bs-placement="top" title="Download PDF" :style="{ cursor: 'pointer' }"></i>
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

    <!-- Screenshot Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="previewModalLabel"><b>Screenshot Preview</b></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px; padding: 15px">
            <img v-if="previewImage" :src="previewImage" alt="Screenshot" class="img-fluid" />
            <div v-else>Loading...</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" @click="downloadImage('png')">Download PNG</button>
            <button type="button" class="btn btn-success" @click="downloadImage('jpg')">Download JPG</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CopyTranslationText from "./translation/features/copy_text/CopyTranslationText.vue";
import FolderSelectionModal from "./folder_manager/FolderSelectionModal.vue";
import html2canvas from "html2canvas";
import jsPDF from 'jspdf';

export default {
  name: "TranslationActions",
  components: {
    CopyTranslationText,
    FolderSelectionModal,
  },
  props: {
    translation: {
      type: String,
      required: true,
    },
    targetTranslationRef: {
      type: String,
      default: 'targetTranslationsElement',
    },
  },
  data() {
    return {
      previewImage: null,
    };
  },
  methods: {
    captureTranslation() {
      const targetTranslationsElement = this.$parent.$refs[this.targetTranslationRef];

        if (!targetTranslationsElement) {
            console.error("Invalid element provided as targetTranslationRef");
            return;
        }

        this.previewImage = null;

      setTimeout(() => {
        html2canvas(targetTranslationsElement).then((canvas) => {
          this.previewImage = canvas.toDataURL("image/png");

          // Show the modal
          const previewModal = new bootstrap.Modal(document.getElementById("previewModal"));
          previewModal.show();
        }).catch((error) => {
          console.error("Failed to capture screenshot:", error);
        });
      }, 200);
    },

    // Download the captured image in the selected format
    downloadImage(format) {
      if (!this.previewImage) return;

      const link = document.createElement("a");
      link.download = `screenshot.${format}`;

      if (format === "jpg") {
        const jpgDataUrl = this.previewImage.replace("image/png", "image/jpeg");
        link.href = jpgDataUrl;
      } else {
        link.href = this.previewImage;
      }

      link.click();
    },

    // Download the translation element as a PDF
    downloadPdf() {
      const targetTranslationsElement = this.$parent.$refs[this.targetTranslationRef];

      if (!targetTranslationsElement) {
        console.error("Invalid element provided as first argument");
        return;
      }

      html2canvas(targetTranslationsElement).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF({
          orientation: 'portrait',
          unit: 'mm',
          format: 'a4',
        });

        pdf.addImage(imgData, 'PNG', 10, 10, 190, 0);
        pdf.save('download.pdf');
      }).catch(error => {
        console.error('Failed to capture HTML content:', error);
      });
    },

    // Open folder selection modal for bookmarking
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
