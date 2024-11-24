<template>
  <div
    class="scrollmenu"
    @touchstart="handleTouchStart"
    @touchmove.prevent
    @touchend="handleTouchEnd"
    style=""
  >
    <a
      href="#"
      v-for="data in customSurat"
      :key="data.id"
      @click.prevent="selectSurah(data.id)"
    >
      <div class="flex justify-content-center mr-1">
        <span class="badge button-23" :class="{ active: surah === data.id }">{{ data.name }}</span>
      </div>
    </a>
  </div>
</template>

<script>
export default {
  props: {
    customSurahs: Array,
    modelValue: Number,
  },
  data() {
    return {
      customSurat: [
        { id: 1, name: 'Al-Fatiha' },
        { id: 2, name: 'Al-Baqarah' },
        { id: 18, name: 'Al-Kahf' },
        { id: 67, name: 'Al-Mulk' },
        { id: 108, name: 'Al-Kawthar' },
        { id: 36, name: 'Ya Seen' },
        { id: 109, name: 'Al-Kafiroon' },
        { id: 112, name: 'Al-Ikhlas' },
        { id: 113, name: 'Al-Falaq' },
        { id: 114, name: 'Al-Nas' },
      ],
      touchStartX: 0,
      touchEndX: 0,
      touchStartTime: 0,
    };
  },
  computed: {
    surah() {
      return this.modelValue;
    },
  },
  methods: {
    // Track touch start position to detect swipe gestures
    handleTouchStart(event) {
      this.touchStartX = event.changedTouches[0].screenX;
      this.touchStartTime = Date.now();
    },
    // Detect swipe direction on touch end
    handleTouchEnd(event) {
      const touchEndX = event.changedTouches[0].screenX;
      const timeDiff = Date.now() - this.touchStartTime;
      const deltaX = touchEndX - this.touchStartX;

      const minSwipeDistance = 50;  // Minimum distance in pixels to be considered a swipe
      const maxSwipeDuration = 500; // Maximum duration in ms to be considered a swipe

      // Prevent swipe actions (right/left) but keep tap behavior intact
      if (Math.abs(deltaX) > minSwipeDistance && timeDiff < maxSwipeDuration) {
        // Here, we simply return and stop the swipe gesture action from happening.
        // We don't handle swipes, so it won't trigger left or right swipe behavior.
        return;
      }
    },

    // Handle selecting a surah (tap gesture)
    selectSurah(surahId) {
      this.$emit('update:modelValue', surahId);
    },
  },
};
</script>

<style scoped>

.scrollmenu {
  white-space: nowrap;
  overflow-x: auto;
  scrollbar-width: thin; /* Firefox */
  scrollbar-color: transparent transparent; /* Firefox */
}

.scrollmenu::-webkit-scrollbar {
  width: 0px;
}

.scrollmenu.scrolling::-webkit-scrollbar {
  width: 8px;
}

.scrollmenu::-webkit-scrollbar-thumb {
  background-color: #888;
  border-radius: 4px;
}

.scrollmenu a {
  display: inline-block;
  text-align: center;
  text-decoration: none;
}

.badge.active {
  background-color: rgba(0, 191, 166, 0.2);
  color: rgb(5, 32, 29);
  border: 1px solid rgba(0, 191, 166);
}

.badge {
  background-color: rgba(0, 191, 166);
  font-size: 1em;
  border-radius: 8px;
  padding: 8px;
}
.badge:hover {
  background: rgb(9, 94, 68);
  font-size: 1em;
  border-radius: 8px;
  padding: 8px;
}
</style>
