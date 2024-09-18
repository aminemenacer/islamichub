<template>
  <div>
    <!-- Screenshot icon -->
    <i 
      class="bi bi-camera text-right mr-2 h3" 
      @click="captureTransliteration" 
      aria-expanded="false" 
      data-bs-placement="top" 
      title="Screenshot verse" 
      
    ></i>

    <!-- Modal -->
    <div class="modal fade" id="previewTransliterationModal" tabindex="-1" aria-labelledby="previewTransliterationModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="previewTransliterationModalLabel"><b>Screenshot Preview</b></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px; padding:15px">
            <img v-if="previewImage" :src="previewImage" alt="Screenshot" class="img-fluid"/>
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
import html2canvas from 'html2canvas';

export default {
  props: {
    targetTransliterationRef: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      previewImage: null
    };
  },
  methods: {
  captureTransliteration() {
    const targetTransliterationElement = this.$parent.$refs[this.targetTransliterationRef];

    if (!targetTransliterationElement) {
      console.error("Invalid element provided as targetTransliterationRef");
      return;
    }

    this.previewImage = null;

    setTimeout(() => {
      html2canvas(targetTransliterationElement).then(canvas => {
        this.previewImage = canvas.toDataURL('image/png');

        // Show the modal after ensuring it exists
        const modalElement = document.getElementById('previewTransliterationModal');
        if (modalElement) {
          const previewTransliterationModal = new bootstrap.Modal(modalElement);
          previewTransliterationModal.show();
        } else {
          console.error('Modal element not found!');
        }
      }).catch(error => {
        console.error("Failed to capture screenshot:", error);
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
  }
}

};
</script>