<template>
  <div class="row">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
      <!-- Note Icon -->
      <div class="icon-container">
        <i
          class="bi bi-file-earmark-text h4"
          aria-expanded="false"
          data-bs-placement="top"
          title="Write a note"
          @click="$emit('openModal', 'tafseerNote')"
        ></i>
      </div>

      <!-- Bookmark Icon -->
      <div class="icon-container">
        <i
          @click="openFolderSelectionModal"
          class="bi bi-bookmark h4"
          title="Select Folder to Bookmark"
        ></i>
      </div>

      <!-- Screenshot Icon -->
      <div class="icon-container">
        <i
          class="bi bi-camera text-right mr-2 h3"
          @click="captureTafseer"
          aria-expanded="false"
          data-bs-placement="top"
          title="Screenshot verse"
          :style="{ cursor: 'pointer' }"
        ></i>
      </div>

      <!-- PDF Download Icon -->
      <div class="icon-container">
        <i
          class="bi bi-file-earmark-pdf text-right mr-2 h3"
          @click="downloadTafseerPdf"
          aria-expanded="false"
          data-bs-placement="top"
          title="Download PDF"
          :style="{ cursor: 'pointer' }"
        ></i>
      </div>

      <!-- Copy Tafseer Text Component -->
      <div class="icon-container">
        <CopyTafseerText :textToCopy="tafseer" />
      </div>

      <!-- Bug Report Icon -->
      <div class="icon-container">
        <i
          title="Report a bug"
          data-bs-toggle="modal"
          data-bs-target="#exampleModal"
          class="bi bi-bug h4"
          aria-expanded="false"
          data-bs-placement="top"
        ></i>
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
          <div class="modal-body text-center">
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
      previewImage: null,
    };
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
        html2canvas(targetTafseerElement).then((canvas) => {
          this.previewImage = canvas.toDataURL('image/png');

          const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
          previewModal.show();
        }).catch((error) => {
          console.error('Failed to capture screenshot:', error);
        });
      }, 200);
    },

    downloadImage(format) {
      if (!this.previewImage) return;

      const link = document.createElement('a');
      link.download = `screenshot.${format}`;

      if (format === 'jpg') {
        const jpgDataUrl = this.previewImage.replace('image/png', 'image/jpeg');
        link.href = jpgDataUrl;
      } else {
        link.href = this.previewImage;
      }

      link.click();
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
