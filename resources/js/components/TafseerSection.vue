<template>
  <div ref="targetTafseerElement" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
    <AyahInfo :information="information" />
    <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
      <!-- main stack top -->
      <div class="btn">
        <h5 class="text-right ayah-translation" name="ayah_text" style="line-height: 1.6em">
          {{ information.ayah.ayah_text }}
        </h5>
      </div>
      <!-- main stack below -->
      <h5 class="text-left ayah-translation" ref="heading1" style="line-height: 1.6em">
        {{ tafseer }}
      </h5>


      <h6 class="text-left mt-3"><strong>Tafseer: </strong>Ibn Kathir</h6>
      <!-- Include the AlertModal component -->
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
import AlertModal from './modals/AlertModal.vue';

export default {
  name: 'TafseerSection',
  components: {
    AyahInfo,
    MainAyah,
    AlertModal,
  },
  props: {
    information: Object,
    isFullScreen: Boolean,
    expanded: Boolean,
    showMoreLink: Boolean,
    showAlertText: Boolean,
    showAlert: Boolean,
    showErrorAlert: Boolean,
    showAlertTextNote: Boolean,
    tafseer:{
      type: String,  // Adjust based on the actual data type
      default: ''
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
      return text.length > 300 ? text.slice(0, 300) + '...' : text;
    },
    closeAlertText() {
      this.$emit('close-alert-text');
    }
  }
};
</script>

<style scoped>
.ayah-translation {
  line-height: 1.6em;
}
</style>
