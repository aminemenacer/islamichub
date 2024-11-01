<template>
<div class="w-100 my-element" :class="{'full-screen': isFullScreen}">
  <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
  <div ref="targetTransliterationElement">
    <AyahInfo :information="information" />
    <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
      <MainAyah :information="information" />
      <div ref="heading2">
        <h4 class="text-left ayah-translation" style="line-height: 1.6em">
          {{ expanded ? information.transliteration : information.transliteration }}
        </h4>
      </div>
      <div class="text-left word-count mt-2">
        <h6 class="text-left mt-3"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" /><strong>Total Word count: </strong>{{ wordCount }}</h6>
      </div>
      <h6 class="text-left mt-3"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" /><strong>Transliteration: </strong>Saheeh International</h6>
      <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
    </div>
    <div class="text-left mt-3">
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
    information: Object,
    isFullScreen: Boolean,
    showAlertText: Boolean,
    showAlert: Boolean,
    showErrorAlert: Boolean,
    showAlertTextNote: Boolean,
  },
  data() {
    return {
      expanded: false, // Local state to track expand/collapse
      showMoreLink: true,
      words: [],
    }
  },
  computed: {
    wordCount() {
      const text = this.expanded ? this.transliteration : this.transliteration;
      return text ? text.trim().split(/\s+/).length : 0; // Calculate the word count
    },
    combinedText() {
      // Get the ayah_text from information
      const ayahText =
        typeof this.information.ayah_text === "object" ?
        this.information.ayah_text.text :
        this.information.ayah_text;

      // Return the formatted string
      return `Translation: ${this.ayah_text}`;
    }
  },
  methods: {

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
