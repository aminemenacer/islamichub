<template>
  <i 
    class="bi bi-camera text-right mr-2 h3" 
    @click="captureScreenshot" 
    aria-expanded="false" 
    data-bs-placement="top" 
    title="Screenshot verse" 
    style="color: rgba(0, 191, 166); cursor: pointer"
  ></i>
</template>

<script>
import html2canvas from 'html2canvas';

export default {
  name: 'ScreenshotButton',
  props: {
    targetElement: {
      type: Object,
      required: true
    }
  },
  methods: {
    captureScreenshot() {
      const targetElement = this.targetElement;

      if (!targetElement) {
        console.warn('No target element provided for screenshot.');
        return;
      }

      // Capture screenshot for targetElement after 5 seconds
      setTimeout(() => {
        html2canvas(targetElement).then(canvas => {
          const dataUrl = canvas.toDataURL('image/png');
          this.$emit('screenshot-captured', dataUrl);

          // Simulate click on download link after 2 seconds
          setTimeout(() => {
            const downloadLink = document.createElement('a');
            downloadLink.href = dataUrl;
            downloadLink.download = 'screenshot.png';
            downloadLink.click();
          }, 2000); // 2000 milliseconds = 2 seconds
        });
      }, 5000); // 5000 milliseconds = 5 seconds
    }
  }
};
</script>
