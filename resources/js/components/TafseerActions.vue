<template>
  <div class="row">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
      <!-- Note Icon -->
      <div class="icon-container">
        <i class="bi bi-file-earmark-text h3" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('openModal', 'tafseerNote')"></i>
      </div>

      <!-- Screenshot Icon -->
      <div class="icon-container">
        <i class="bi bi-camera text-right mr-2 h3" @click="debouncedCaptureTafseer" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" :style="{ cursor: 'pointer' }"></i>
      </div>

      <!-- Surah Info -->
      <div class="icon-container">
        <i class="bi bi-info-circle h4 mr-2 pl-2" data-bs-toggle="modal" data-bs-target="#translationInfo" aria-expanded="false" data-bs-placement="top" title="Surah info"></i>
      </div>

      <!-- Bug Report Icon -->
      <div class="icon-container">
        <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-chat-left-text h4" aria-expanded="false" data-bs-placement="top"></i>
      </div>
    </div>
  </div>
</template>

<script>
import { debounce } from 'lodash';
import FolderSelectionModal from './folder_manager/FolderSelectionModal.vue';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

export default {
  name: 'TafseerActions',
  components: {
    FolderSelectionModal,
  },
  props: {
    tafseer: {
      type: String,
      required: true,
    },
    information: {
      type: Object,
      required: true,
    },
    targetTafseerRef: {
      type: String,
      default: 'targetTafseerElement',
    },
  },
  data() {
    return {
      surat: [],
      ayat: [],
      tafseers: [],
    };
  },
  computed: {
    combinedText() {
      return `Tafseer: ${this.tafseer}`;
    }
  },
  methods: {
    submitFormTafseer() {
      const formData1 = {
        surah_name: this.information.ayah.surah.name_en,
        ayah_num: this.information.ayah_id,
        ayah_verse_ar: this.information.ayah.ayah_text,
        ayah_verse_en: this.tafseer,
        user_id: this.userId,
      };

      if (!formData1.surah_name || !formData1.ayah_num || !formData1.ayah_verse_ar || !formData1.ayah_verse_en || !formData1.user_id) {
        console.error("Form data is incomplete:", formData1);
        this.showErrorAlert = true;
        this.hideAlertAfterDelay();
        return;
      }

      this.isSubmitting = true;
      axios.post('/bookmarks', formData1)
        .then(response => {
          localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
          this.showAlert = true;
          this.showErrorAlert = false;
          this.hideAlertAfterDelay();
        })
        .catch(error => {
          console.error("Error submitting bookmark:", error);
          this.showErrorAlert = true;
          this.hideAlertAfterDelay();
        })
        .finally(() => {
          this.isSubmitting = false;
        });
    },

    // Debounced version of captureTafseer to limit repeated calls
    debouncedCaptureTafseer: debounce(function() {
      this.captureTafseer();
    }, 500), // Adjust debounce time as necessary

    captureTafseer() {
      const targetTafseerElement = this.$parent.$refs[this.targetTafseerRef];
      if (!targetTafseerElement) return;

      const originalPadding = targetTafseerElement.style.padding;
      targetTafseerElement.style.padding = "10px"; // Adjust value as needed

      // Hide unwanted elements using class toggling instead of direct style manipulation
      const hideElements = () => {
        document.body.classList.add('hide-unwanted-elements');
      };

      const showElements = () => {
        document.body.classList.remove('hide-unwanted-elements');
      };

      hideElements();

      setTimeout(() => {
        html2canvas(targetTafseerElement).then((canvas) => {
          const dataUrl = canvas.toDataURL("image/png");
          const link = document.createElement("a");
          link.href = dataUrl;
          link.download = "screenshot.png";
          link.click();
          showElements();
        }).catch((error) => {
          console.error("Failed to capture screenshot:", error);
          showElements();
        });
      }, 200);
    },

    downloadTafseerPdf() {
      const targetTafseerElement = this.$parent.$refs[this.targetTafseerRef];
      if (!targetTafseerElement) return;

      // Hide unwanted elements using class toggling
      const unwantedElements = document.querySelectorAll('.icon-container, .href, .mobile-only');
      unwantedElements.forEach(el => el.style.display = 'none');

      html2canvas(targetTafseerElement, {
        scrollX: -window.scrollX,
        scrollY: -window.scrollY,
        windowWidth: document.documentElement.offsetWidth,
        windowHeight: targetTafseerElement.scrollHeight,
        scale: 2
      })
      .then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('portrait', 'mm', 'a4');
        const pdfWidth = 190;
        const imgHeight = (canvas.height * pdfWidth) / canvas.width;

        pdf.addImage(imgData, 'PNG', 10, 10, pdfWidth, imgHeight);
        pdf.save('download.pdf');

        unwantedElements.forEach(el => el.style.display = '');
      })
      .catch(error => console.error('Failed to capture HTML content:', error));
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

<style scoped>
.hide-unwanted-elements .icon-container,
.hide-unwanted-elements .href,
.hide-unwanted-elements .mobile-only,
.hide-unwanted-elements .bar {
  display: none !important;
}
</style>
