<template>
  <div ref="targetTranslationElement" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
    <AyahInfo :information="information" />
    <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
      <MainAyah :information="information" />
      <div ref="heading3">
        <h4 class="text-left ayah-translation" style="line-height: 1.6em">
          {{ expanded ? information.translation : truncatedText(information.translation) }}
          <template v-if="showMoreLink && information.translation.length > 100">
            <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
          </template>
        </h4>
      </div>
      <Translator translator="Ahmed Ali" />
      <AlertModal 
        :showAlertText="showAlertText" 
        :showAlert="showAlert" 
        :showErrorAlert="showErrorAlert" 
        :showAlertTextNote="showAlertTextNote" 
        @close-alert-text="closeAlertText" 
      />
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
    information: {
      type: Object,
      required: true
    },
    isFullScreen: {
      type: Boolean,
      default: false
    },
    expanded: {
      type: Boolean,
      default: false
    },
    showMoreLink: {
      type: Boolean,
      default: true
    },
    showAlertText: {
      type: Boolean,
      default: false
    },
    showAlert: {
      type: Boolean,
      default: false
    },
    showErrorAlert: {
      type: Boolean,
      default: false
    },
    showAlertTextNote: {
      type: Boolean,
      default: false
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
    truncatedText(text) {
      return text.length > 100 ? text.slice(0, 100) + '...' : text;
    },
    closeAlertText() {
      this.$emit('close-alert-text');
    }
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

.swipeable-div {
  touch-action: pan-y;
}

.ayah-translation {
  font-size: 1.3rem;
}

.btn {
  display: flex;
  justify-content: flex-end;
  align-items: center;
}

@media (max-width: 576px) {
  .mobile-only {
    display: block;
  }

  .hide-on-mobile {
    display: none;
  }
}
</style>
