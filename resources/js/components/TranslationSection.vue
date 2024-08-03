<template>
  <div ref="targetTranslationElement" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
    <AyahInfo :information="information" />
    <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
      <MainAyah :information="information" />
      <div ref="heading3">
        <h5 class="text-left ayah-translation" ref="heading3" style="line-height: 1.6em">
          {{ expanded ? information.translation : truncatedText(information.translation) }}
          <template v-if="showMoreLink && information.translation.length > 100">
            <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
          </template>
        </h5>
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
    information: Object,
    isFullScreen: Boolean,
    expanded: Boolean,
    showMoreLink: Boolean,
    showAlertText: Boolean,
    showAlert: Boolean,
    showErrorAlert: Boolean,
    showAlertTextNote: Boolean
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
