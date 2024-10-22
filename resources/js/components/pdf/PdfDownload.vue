<!-- PdfDownload.vue -->
<template>
<div>
    <i class="bi bi-file-earmark-pdf text-right mr-2 h3" @click="downloadPdf" aria-expanded="false" data-bs-placement="top" title="Download PDF" :style="{ iconColor: iconColor, cursor: 'pointer' }"></i>
</div>
</template>

<script>
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

export default {
    name: 'PdfDownload',
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

          // Select all the elements you want to hide
          const unwantedElements = document.querySelectorAll(
              '.icon-container, .href, .mobile-only, .bar, .pitch, .rate, .container.text-center, .custom-icon-play, .custom-icon-increase, .custom-icon-decrease'
          );

          // Create a map to store original display styles
          const originalDisplayStyles = new Map();

          // Hide the unwanted elements and store their original display styles
          unwantedElements.forEach(el => {
              originalDisplayStyles.set(el, el.style.display);
              el.style.display = 'none';
          });

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

                  // Restore the visibility of unwanted elements
                  unwantedElements.forEach(el => {
                      el.style.display = originalDisplayStyles.get(el) || '';
                  });
              })
              .catch(error => {
                  console.error('Failed to capture HTML content:', error);
              });
          }

    }
};
</script>
