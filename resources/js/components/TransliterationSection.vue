<template>
<div class="w-100 my-element" :class="{'full-screen': isFullScreen}">
  <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
  <div ref="targetTransliterationElement">
    <AyahInfo :information="information" />
    <div @touchstart="handleStart" @touchend="handleEnd" @mousedown="handleStart" @mouseup="handleEnd" @mouseleave="cancelHold" class="swipeable-div w-100">
      <div class="row">
        <div class="col-md-2 pt-2 d-flex align-items-center justify-content-center">
          <i @click="toggleSpeechAyah" class="bi-play-circle-fill h4 custom-icon-play-main" style="cursor: pointer;" aria-label="Play or pause translation audio"></i>
        </div>
        <div class="col-md-10">
          <MainAyah :information="information" />
        </div>
      </div>

      <div ref="targetTransliterationElement" class="row text-left mt-2">
        <!-- Text Column -->
        <div class="col-10">
          <h4 class="ayah-translation" style="line-height: 1.6em" :style="{ fontSize: fontSize + 'em', lineHeight: '1.6em' }">
            {{ expanded ? information.transliteration : information.transliteration }}
          </h4>
        </div>

        <!-- Icons Column (Stacked Vertically) -->
        <div v-if="isVisible" class="col-2 d-flex align-items-center justify-content-center flex-column">
          <i @click="increaseFontSize" class="bi bi-plus-circle-fill h3 custom-icon-increase" style="cursor: pointer;" aria-label="Increase font size">
          </i>

          <i @click="decreaseFontSize" class="bi bi-dash-circle-fill h3 custom-icon-decrease" style="cursor: pointer;" aria-label="Decrease font size">
          </i>
        </div>
      </div>

      <div class="text-left word-count mt-2">
        <h6 class="text-left mt-3"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" /><strong>Total Word count: </strong>{{ wordCount }}</h6>
      </div>
      <h6 class="text-left mt-3 word-count"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" /><strong>Transliteration: </strong>Saheeh International</h6>
      <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
    </div>
    <div class="text-left mt-3 word-count">
      <h6 class="text-left"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" /><strong>Reciter's name: </strong>Mishary Rashid Alafasy</h6>
    </div>
  </div>

</div>
</template>

<script>
import AyahInfo from './translation/AyahInfo.vue';
import MainAyah from './translation/MainAyah.vue';
import Translator from './translation/Translator.vue';
import AlertModal from './modals/AlertModal.vue';

export default {
  name: 'TranslationSection',
  components: {
    AyahInfo,
    MainAyah,
    Translator,
    AlertModal
  },
  props: {
    isVisible: {
      type: Boolean,
      required: true
    },
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
      expanded: false, // Local state to track expand/collapse
      showMoreLink: true,
      isPaused: false,
      isReading: false,
      isAudioPlaying: false,
      words: [],
      data: [],
      surat: [],
      ayat: [],
      tafseers: []
    }
  },
  computed: {

    wordCount() {
      const text = this.expanded ?
        this.information.transliteration : this.information.transliteration;
      return text ? text.trim().split(/\s+/).length : 0; // Calculate the word count
    },
    combinedText() {
      // Get the ayah_text from information
      const ayahText =
        typeof this.information.ayah_text === "object" ?
        this.information.ayah_text.text :
        this.information.ayah_text;

      // Return the formatted string
      return `Transliteration: ${this.ayah_text}`;
    }
  },
  mounted() {
    const savedFontSize = localStorage.getItem("fontSize");
    if (savedFontSize) {
      this.currentFontSize = parseInt(savedFontSize, 10);
    } else {
      this.currentFontSize = 14; // Default font size
    }
  },
  methods: {
    toggleSpeechAyah() {
      this.isReading = !this.isReading;
      this.isPaused = !this.isPaused;
      this.$emit('toggle-audio', this.isReading);
    },
    toggleAudio() {
      this.$emit('toggle-audio');
    },
    submitForm() {
      const formData = {
        // folder_id: this.selectedFolderId,
        surah_name: this.information.ayah.surah.name_en,
        ayah_num: this.information.ayah_id,
        ayah_verse_ar: this.information.ayah.ayah_text,
        ayah_verse_en: this.information.translation,
        user_id: this.userId
      };
      axios.post("/bookmarks", formData).then(response => {
        console.log(response.data.message);
        localStorage.setItem(
          `bookmarkSubmitted_${this.information.ayah_id}`,
          true
        );
        this.showAlert = true;
        this.showErrorAlert = false;
        this.hideAlertAfterDelay();
        // Display a confirmation message with the bookmarked ayah and folder
        // this.$refs.bookmarkConfirmation.textContent =
        //   `Successfully bookmarked ayah ${this.information.ayah_id} to folder "${this.selectedFolderId}"`;
      });
    },
    increaseFontSize() {
      this.fontSize += 0.2; // Increase font size
      this.saveFontSize();
    },
    decreaseFontSize() {
      if (this.fontSize > 1) {
        this.fontSize -= 0.2; // Decrease font size
        this.saveFontSize();
      }
    },
    saveFontSize() {
      localStorage.setItem('ayahFontSize', this.fontSize); // Store font size in local storage
    },
    toggleFullScreen() {
      this.$emit('toggle-full-screen');
    },
    handleTouchStart(event) {
      this.$emit('handle-touch-start', event);
    },
    handleTouchMove(event) {
      this.$emit('handle-touch-move', event);
    },
    handleTouchEnd(event) {
      this.$emit('handle-touch-end', event);
    },
    toggleExpand() {
      this.$emit('toggle-expand');
    },
    closeAlertText() {
      this.$emit('close-alert-text');
    },
    toggleExpand() {
      this.expanded = !this.expanded;
    },

  },
  created() {
    const savedFontSize = localStorage.getItem('ayahFontSize');
    this.fontSize = savedFontSize ? parseFloat(savedFontSize) : this.fontSize; // Set initial font size
  },
  watch: {
    isVisible() {
      this.$emit('toggle-change');
    },
  }

};
</script>

<style scoped>
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

.mobile-only {
  display: none;
  /* Hide by default */
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

@media (max-width: 768px) {

  /* Adjust this width as needed for your breakpoint */
  .mobile-only {
    display: flex;
    /* Show only on mobile */
  }
}

@media (max-width: 576px) {
  .mobile-only {
    display: block;
    display: flex;
  }

  .hide-on-mobile {
    display: none;
  }
}
</style>
