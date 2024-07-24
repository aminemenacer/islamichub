<template>
  <i 
    class="bi bi-camera text-right mr-2 h3" 
    @click="captureTranslation" 
    aria-expanded="false" 
    data-bs-placement="top" 
    title="Screenshot verse" 
    style="color: rgba(0, 191, 166); cursor:pointer"
  ></i>
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
  methods: {
    captureTranslation() {
      // Use $parent to access the parent's ref
      const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];

      if (!targetTranslationElement) {
        console.error("Invalid element provided as first argument");
        return;
      }

      // Capture screenshot for targetTranslationElement after 5 seconds
      setTimeout(() => {
        html2canvas(targetTranslationElement).then(canvas => {
          const dataUrl = canvas.toDataURL('image/png');
          this.downloadUrl = dataUrl;

          // Simulate click on download link after 2 seconds
          setTimeout(() => {
            const downloadLink = document.createElement('a');
            downloadLink.href = dataUrl;
            downloadLink.download = 'screenshot.png';
            downloadLink.click();
          }, 200); // 2000 milliseconds = 2 seconds
        }).catch(error => {
          console.error("Failed to capture screenshot:", error);
        });
      }, 200); // 1000 milliseconds = 1 seconds
    }
  }
};
</script>
