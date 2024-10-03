<template>
  <div class="row">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
      <!-- Note Icon -->
      <div class="icon-container">
        <i class="bi bi-file-earmark-text h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'transliterationNote')"></i>
      </div>

      <!-- Bookmark Icon -->
      <div class="icon-container">
        <i @click="openFolderSelectionModal" class="bi bi-bookmark h4" title="Select Folder to Bookmark"></i>
      </div>

      <!-- Screenshot Icon -->
      <div class="icon-container">
        <i class="bi bi-camera text-right mr-2 h4" @click="captureTransliteration" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" :style="{ cursor: 'pointer' }"></i>
      </div>

      <!-- PDF Download Icon -->
      <div class="icon-container">
        <i class="bi bi-file-earmark-pdf text-right mr-2 h4" @click="downloadTransliterationPdf" aria-expanded="false" data-bs-placement="top" title="Download PDF" :style="{ cursor: 'pointer' }"></i>
      </div>

      <!-- Copy Translation Text Icon -->
      <div class="icon-container">
        <CopyTransliterationText :textToCopy="transliteration" />
      </div>

      <!-- Bug Report Icon -->
      <div class="icon-container">
        <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug h4" aria-expanded="false" data-bs-placement="top"></i>
      </div>
    </div>


    <!-- Folder Selection Modal -->
    <FolderSelectionModal ref="folderSelectionModal" />
  </div>
</template>

<script>
import TransliterationNote from './translation/features/notes/TransliterationNote';
import WhatsAppShareTransliteration from './translation/features/whatsapp/WhatsAppShareTransliteration.vue';
import TwitterShareTransliteration from './translation/features/twitter/TwitterShareTransliteration.vue';
import CopyTransliterationText from './translation/features/copy_text/CopyTransliterationText.vue';
import ScreenTransliterationCapture from './translation/features/screen_capture/ScreenTransliterationCapture.vue';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

export default {
  name: 'TransliterationActions',
  components: {
    TransliterationNote,
    WhatsAppShareTransliteration,
    TwitterShareTransliteration,
    CopyTransliterationText,
    ScreenTransliterationCapture
  },
  props: {
    transliteration: {
      type: String,
      required: true
    },
    targetTransliterationRef: {
      type: String,
      default: 'targetTransliterationElement'
    }
  },
  data() {
    return {
    };
  },
  computed: {
    combinedText() {
      return `Transliteration: ${this.information.transliteration}`;
    }
  },
  methods: {
    captureTransliteration() {
      const targetTransliterationElement = this.$parent.$refs[this.targetTransliterationRef];

      if (!targetTransliterationElement) {
        console.error("Invalid element provided as targetTransliterationRef");
        return;
      }

      setTimeout(() => {
        html2canvas(targetTransliterationElement)
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

    downloadTransliterationPdf() {
      const targetTransliterationElement = this.$parent.$refs[this.targetTransliterationRef];

      if (!targetTransliterationElement) {
        console.error("Invalid element provided as targetTransliterationRef");
        return;
      }

      html2canvas(targetTransliterationElement)
        .then((canvas) => {
          const imgData = canvas.toDataURL('image/png');
          const pdf = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
          });

          pdf.addImage(imgData, 'PNG', 10, 10, 190, 0);
          pdf.save('screenshot.pdf');
        })
        .catch((error) => {
          console.error('Failed to capture HTML content:', error);
        });
    }
  }
};
</script>
