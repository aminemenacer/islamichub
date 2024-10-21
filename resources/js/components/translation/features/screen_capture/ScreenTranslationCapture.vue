<template>
  <div>
    <!-- Screenshot icon -->
    <i 
      class="bi bi-camera text-right mr-2 h3" 
      @click="captureTranslation" 
      aria-expanded="false" 
      data-bs-placement="top" 
      title="Screenshot verse" 
      :style="{ iconColor: iconColor, cursor: 'pointer' }"
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
    targetTranslationRef: {
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
    captureTranslation() {
  const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];

  if (!targetTranslationElement) {
    console.error("Invalid element provided as targetTranslationRef");
    return;
  }

  // Select all the elements you want to hide
  const unwantedElements = document.querySelectorAll(
    '.icon-container, .href, .mobile-only, .bar, .pitch, .rate, .container.text-center'
  );

  // Hide the unwanted elements
  unwantedElements.forEach(el => el.style.display = 'none');

  setTimeout(() => {
    html2canvas(targetTranslationElement, {
      allowTaint: true,  // Capture cross-origin content if necessary
      useCORS: true,     // Allow cross-origin images
    }).then((canvas) => {
      const dataUrl = canvas.toDataURL("image/png");

      // Automatically trigger download of the image
      const link = document.createElement("a");
      link.href = dataUrl;
      link.download = "screenshot.png";
      link.click();

      // Restore the visibility of unwanted elements
      unwantedElements.forEach(el => el.style.display = '');
    }).catch((error) => {
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