<template>
  <div ref="targetTranslationElement" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
    <AyahInfo :information="information" />
    <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
      <MainAyah :information="information" />
      <div ref="heading3">
        <h5 class="text-left ayah-translation" ref="heading3" style="line-height: 1.6em">
          {{ expanded ? information.translation : truncatedText(information.translation) }}
          <template v-if="showMoreLink">
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
export default {
  name: 'TranslationSection',
  props: {
    information: Object,
    isFullScreen: Boolean,
    expanded: Boolean,
    showMoreLink: Boolean,
    showAlertText: String,
    showAlert: Boolean,
    showErrorAlert: Boolean,
    showAlertTextNote: String,
    ayat: Array,
    selectedIndexAyah: Number,
    maxLength: Number
  },
  methods: {
    toggleFullScreen() {
      this.$emit('toggle-full-screen');
    },
    handleTouchStart(event) {
      this.$emit('touch-start', event);
    },
    handleTouchMove(event) {
      this.$emit('touch-move', event);
    },
    handleTouchEnd(event) {
      this.$emit('touch-end', event);
    },
    toggleExpand() {
      this.$emit('toggle-expand');
    },
    closeAlertText() {
      this.$emit('close-alert-text');
    },
    truncatedText(text) {
      if (!text) return '';
      return text.length > this.maxLength ? text.substring(0, this.maxLength) + '...' : text;
    }
  },
  components: {
    AyahInfo: () => import('./AyahInfo.vue'),
    MainAyah: () => import('./MainAyah.vue'),
    Translator: () => import('./Translator.vue'),
    AlertModal: () => import('./AlertModal.vue')
  }
};
</script>
