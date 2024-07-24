<template>
  <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
    <MainAyah :information="information" />
    <div>
      <h5 ref="heading3" class="text:right">{{ information.translation }}</h5>
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
</template>

<script>
export default {
  props: {
    ayat: {
      type: Array,
      required: true
    },
    selectedIndexAyah: {
      type: Number,
      default: null
    },
    showError: {
      type: Boolean,
      default: false
    },
    information: {
      type: Object,
      required: true
    },
    showAlertText: {
      type: Boolean,
      required: true
    },
    showAlert: {
      type: Boolean,
      required: true
    },
    showErrorAlert: {
      type: Boolean,
      required: true
    },
    showAlertTextNote: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      touchStartX: 0,
      touchStartY: 0,
      touchStartTime: 0,
      touchEndX: 0,
      touchEndY: 0
    };
  },
  methods: {
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
        this.$emit('tap');
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
    onSwipeLeft() {
      this.goToNextAyah();
      console.log('Swiped left');
    },
    onSwipeRight() {
      this.goToPreviousAyah();
      console.log('Swiped right');
    },
    goToFirstAyah() {
      this.selectAyah(0);
    },
    goToPreviousAyah() {
      if (this.selectedIndexAyah > 0) {
        this.selectAyah(this.selectedIndexAyah - 1);
      }
    },
    goToNextAyah() {
      if (this.selectedIndexAyah < this.ayat.length - 1) {
        this.selectAyah(this.selectedIndexAyah + 1);
      }
    },
    goToLastAyah() {
      this.selectAyah(this.ayat.length - 1);
    },
    selectAyah(index) {
      this.$emit('update-selected-ayah', index);
    },
    closeAlertText() {
      this.$emit('close-alert-text');
    }
  }
};
</script>

<style scoped>
/* Add any specific styles if necessary */
</style>


<style scoped>
/* Add any specific styles if necessary */
</style>
