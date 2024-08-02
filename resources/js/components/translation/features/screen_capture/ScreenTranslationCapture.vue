<template>
  <div>
    <!-- Screenshot icon -->
    <i 
      class="bi bi-camera text-right mr-2 h3" 
      @click="captureTranslation" 
      aria-expanded="false" 
      data-bs-placement="top" 
      title="Screenshot verse" 
      style="color: rgba(0, 191, 166); cursor:pointer"
    ></i>

    <!-- Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="previewModalLabel"><b>Screenshot Preview</b></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px; padding:15px">
            <img v-if="downloadUrl" :src="downloadUrl" alt="Screenshot" class="img-fluid"/>
            <div v-else>Loading...</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" @click="downloadScreenshot">Download</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import html2canvas from 'html2canvas';

export default {
  props: {
    targetTranslationRef: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      downloadUrl: ''
    };
  },
  methods: {
    captureTranslation() {
      const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];

      if (!targetTranslationElement) {
        console.error("Invalid element provided as targetTranslationRef");
        return;
      }

      // Clear any previous URL
      this.downloadUrl = '';

      setTimeout(() => {
        html2canvas(targetTranslationElement).then(canvas => {
          this.downloadUrl = canvas.toDataURL('image/png');

          // Show the modal
          const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
          previewModal.show();
        }).catch(error => {
          console.error("Failed to capture screenshot:", error);
        });
      }, 200);
    },
    downloadScreenshot() {
      const downloadLink = document.createElement('a');
      downloadLink.href = this.downloadUrl;
      downloadLink.download = 'screenshot.png';
      downloadLink.click();
    }
  }
};
</script>
