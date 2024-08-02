<!-- PdfDownload.vue -->
<template>
  <div>
    <i 
      class="bi bi-file-earmark-pdf text-right mr-2 h3" 
      @click="downloadPdf" 
      aria-expanded="false" 
      data-bs-placement="top" 
      title="Download PDF" 
      style="color: rgba(0, 191, 166); cursor:pointer"
    ></i>    
  </div>
</template>

<script>
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

export default {
  // name: 'PdfDownload', 'CsvDownload',
  props: {
    targetTranslationRef: {
      type: String,
      required: true
    }
  },
  methods: {
    downloadPdf() {
      const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];

      if (!targetTranslationElement) {
        console.error("Invalid element provided as first argument");
        return;
      }

      html2canvas(targetTranslationElement)
        .then(canvas => {
          const imgData = canvas.toDataURL('image/png');
          const pdf = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4',
          });

          // Add the image to the PDF
          pdf.addImage(imgData, 'PNG', 10, 10, 190, 0); // Adjust the dimensions as needed
          pdf.save('download.pdf');
        })
        .catch(error => {
          console.error('Failed to capture HTML content:', error);
        });
    }, 
    
  }
};
</script>
