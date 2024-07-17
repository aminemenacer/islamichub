<template>
  <div ref="targetElement" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
    <AyahInfo :information="information" />
    <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
      <MainAyah :information="information" />
      <div ref="heading3">
        <EnglishTranslation :information="information" />
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
  props: {
    information: {
      type: Object,
      required: true
    },
    expanded: {
      type: Boolean,
      default: false
    },
    showAlertText: {
      type: String,
      default: ''
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
      type: String,
      default: ''
    }
  },
  data() {
    return {
      isFullScreen: false,
      touchStartX: 0,
      touchStartY: 0,
      touchEndX: 0,
      touchEndY: 0,
      touchStartTime: 0,
    };
  },
  methods: {
    toggleFullScreen() {
      this.isFullScreen = !this.isFullScreen;
    },
    handleTouchStart(event) {
      this.touchStartX = event.changedTouches[0].screenX;
      this.touchStartY = event.changedTouches[0].screenY;
      this.touchStartTime = Date.now();
    },
    handleTouchMove(event) {
      this.touchEndX = event.changedTouches[0].screenX;
      this.touchEndY = event.changedTouches[0].screenY;
    },
    handleTouchEnd() {
      const touchEndTime = Date.now();
      const timeDiff = touchEndTime - this.touchStartTime;
      const deltaX = this.touchEndX - this.touchStartX;
      const deltaY = this.touchEndY - this.touchStartY;

      const minSwipeDistance = 50; // Minimum distance in pixels to be considered a swipe
      const maxTapDistance = 10; // Maximum distance in pixels to be considered a tap
      const maxSwipeDuration = 500; // Maximum duration in ms to be considered a swipe
      const maxTapDuration = 200; // Maximum duration in ms to be considered a tap

      // Check if it's a tap
      if (Math.abs(deltaX) < maxTapDistance && Math.abs(deltaY) < maxTapDistance && timeDiff < maxTapDuration) {
        this.onTap();
      }
      // Check if it's a swipe
      else if (
        Math.abs(deltaX) > minSwipeDistance &&
        timeDiff < maxSwipeDuration &&
        Math.abs(deltaX) > Math.abs(deltaY) // Ensure it's a horizontal swipe
      ) {
        if (deltaX > 0) {
          this.onSwipeRight();
        } else {
          this.onSwipeLeft();
        }
      }
    },
    onTap() {
      console.log("Tap detected");
    },
    onSwipeRight() {
      console.log("Swipe right detected");
      this.$emit('swipe-right');
    },
    onSwipeLeft() {
      console.log("Swipe left detected");
      this.$emit('swipe-left');
    },
    closeAlertText() {
      this.$emit('close-alert-text');
    }
  }
};
</script>

<style scoped>
/* Add your custom CSS styles here if needed */
</style>
