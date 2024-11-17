<template>
  <div class="w-100 my-element" :class="{'full-screen': isFullScreen}">
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
    <div ref="targetTransliterationElement">
      <AyahInfo :information="information" />
      <div @touchstart="handleStart" @touchend="handleEnd" @mousedown="handleStart" @mouseup="handleEnd" @mouseleave="cancelHold" class="swipeable-div w-100">
        <div class="row">
          <div class="col-md-2 pt-2 d-flex align-items-center justify-content-center"></div>
          <div class="col-md-10">
            <MainAyah :information="information" />
          </div>
        </div>
        <div ref="targetTransliterationElement" class="row text-left mt-2">
          <div class="col-10">
            <h4 class="ayah-translation" style="line-height: 1.6em" :style="{ fontSize: fontSize + 'em', lineHeight: '1.6em' }" >
              {{ expanded ? information.transliteration : information.transliteration }}
            </h4>
          </div>
          <div v-if="isVisible" class="col-2 d-flex align-items-center justify-content-center flex-column">
            <i @click="increaseFontSize" class="bi bi-plus-circle-fill h3 custom-icon-increase" aria-label="Increase font size"></i>
            <i @click="decreaseFontSize" class="bi bi-dash-circle-fill h3 custom-icon-decrease" aria-label="Decrease font size"></i>
          </div>
        </div>
        <div class="text-left word-count mt-2">
          <h6 class="text-left mt-3"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy"/><strong>Total Word count: </strong>{{ wordCount }}</h6>
        </div>
        <h6 class="text-left mt-3 word-count"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy"/><strong>Transliteration: </strong>Saheeh International</h6>
        <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
      </div>
      <div class="text-left mt-3 word-count">
        <h6 class="text-left"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy"/><strong>Reciter's name: </strong>Mishary Rashid Alafasy</h6>
      </div>
    </div>
  </div>
</template>

<script>
import AyahInfo from './translation/AyahInfo.vue';
import MainAyah from './translation/MainAyah.vue';
import AlertModal from './modals/AlertModal.vue';
import { saveAs } from "file-saver";
import Papa from "papaparse";
import { Document, Packer, Paragraph, TextRun } from "docx";

export default {
  name: 'TransliterationSection',
  components: {
    AyahInfo,
    MainAyah,
    AlertModal
  },
  props: {
    isVisible: Boolean,
    information: Object,
    isFullScreen: Boolean,
    showAlertText: Boolean,
    showAlert: Boolean,
    showErrorAlert: Boolean,
    showAlertTextNote: Boolean,
  },
  data() {
    return {
      fontSize: parseFloat(localStorage.getItem('ayahFontSize')) || 1,
      expanded: false,
      isPaused: false,
      isReading: false,
    }
  },
  computed: {
    wordCount() {
      const text = this.information.transliteration || "";
      return text.trim().split(/\s+/).length;
    }
  },
  methods: {
    increaseFontSize() {
      this.fontSize += 0.2;
      this.saveFontSize();
    },
    decreaseFontSize() {
      if (this.fontSize > 1) {
        this.fontSize -= 0.2;
        this.saveFontSize();
      }
    },
    saveFontSize() {
      localStorage.setItem('ayahFontSize', this.fontSize);
    },
    downloadAsCSVTransliteration() {
      const data = [
        {
          "Transliteration": this.information.transliteration || "N/A",
          "Author": "Saheeh International"
        }
      ];

      const csv = Papa.unparse(data);
      const filename = `transliteration_${new Date().toISOString().split("T")[0]}.csv`;
      saveAs(new Blob([csv], { type: "text/csv;charset=utf-8;" }), filename);
    },
    async downloadAsWordTransliteration() {
      const doc = new Document({
        sections: [
          {
            children: [
              new Paragraph({
                children: [new TextRun("Quran Transliteration Document").bold()],
                alignment: "CENTER",
              }),
              new Paragraph({
                children: [new TextRun("Prepared by Islamic Connect").italics()],
                alignment: "CENTER",
              }),
              new Paragraph({
                children: [new TextRun("Transliteration:").bold()],
                spacing: { after: 200 },
              }),
              new Paragraph({
                children: [new TextRun(this.information.transliteration)],
              }),
            ]
          }
        ]
      });
      const blob = await Packer.toBlob(doc);
      saveAs(blob, "Transliteration.docx");
    },
    toggleFullScreen() {
      this.$emit('toggle-full-screen');
    },
    toggleExpand() {
      this.expanded = !this.expanded;
    },
    closeAlertText() {
      this.$emit('close-alert-text');
    },
  },
  watch: {
    isVisible() {
      this.$emit('toggle-change');
    }
  },
}
</script>

<style scoped>
.swipeable-div {
  transition: transform 0.3s ease;
}
</style>


<style scoped>
/* General Settings */
:root {
  --primary-color: rgb(13, 182, 145);
}

.full-screen {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 1000;
  background-color: white;
  padding: 20px;
}

.word-count {
  margin-top: 10px;
}

.swipeable-div {
  touch-action: pan-y;
}

.ayah-translation {
  font-size: 1.2rem;
}

.btn {
  display: flex;
  justify-content: flex-end;
  align-items: center;
}

.custom-icon-play:hover {
  color: rgb(13, 182, 145);
  /* Default color */
  transition: color 0.3s ease;
  /* Smooth transition */
}

.custom-icon-increase:hover {
  color: rgb(13, 182, 145);
  /* Default color */
  transition: color 0.3s ease;
  /* Smooth transition */
}

.custom-icon-decrease:hover {
  color: rgb(13, 182, 145);
  /* Default color */
  transition: color 0.3s ease;
  /* Smooth transition */
}

/* Mobile Media Queries */
.mobile-only {
  display: none;
}

@media (max-width: 768px) {
  .mobile-only {
    display: flex;
  }
}

@media (max-width: 576px) {
  .mobile-only {
    display: flex;
  }

  .hide-on-mobile {
    display: none;
  }
}
</style>
