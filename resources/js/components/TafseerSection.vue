<template>
  <div ref="targetTafseerElement" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
    <AyahInfo :information="information" />
    <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
    <MainAyah :information="information" />
      <div ref="heading1" class="text-left">
        <h4 class="text-left ayah-translation" style="line-height: 1.6em">
          {{ expanded ? information.translation : truncatedText(information.translation) }}
          <template v-if="information.translation.length > 100">
            <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
          </template>
        </h4>
      </div>
      <h6 class="text-left mt-3"><strong>Tafseer: </strong>Ibn Kathir</h6>
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
    showAlertText: Boolean,
    showAlert: Boolean,
    showErrorAlert: Boolean,
    showAlertTextNote: Boolean,
  },
  data() {
    return {
      expanded: false,  // Local state to track expand/collapse
    };
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
      this.expanded = !this.expanded;  // Toggle expanded state locally
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
  font-size: 1.2rem;
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
