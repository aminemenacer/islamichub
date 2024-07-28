<template>
  <div ref="targetElement2" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
    <h5 class="mr-2">
      {{ information.ayah.surah.name_en }} {{ information.ayah.surah_id }}: {{ information.ayah.ayah_id }}
    </h5>
    <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
      <!-- main stack top -->
      <div class="btn">
        <h5 class="text-right ayah-translation" name="ayah_text" style="line-height: 1.6em">
          {{ information.ayah.ayah_text }}
        </h5>
      </div>
      <!-- main stack below -->
      <h5 class="text-left ayah-translation" ref="heading2" style="line-height: 1.6em">
        {{ expanded ? information.transliteration : truncatedText(information.transliteration) }}
        <template v-if="showMoreLink">
          <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
        </template>
      </h5>
      <h6 class="text-left mt-3"><strong>Transliteration: </strong>Saheeh International</h6>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TranslationSectionTwo',
  props: {
    information: Object,
    isFullScreen: Boolean,
    expanded: Boolean,
    showMoreLink: Boolean,
    maxLength: Number
  },
  methods: {
    toggleFullScreen() {
      this.$emit('toggle-full-screen')
    },
    handleTouchStart(event) {
      this.$emit('touch-start', event)
    },
    handleTouchMove(event) {
      this.$emit('touch-move', event)
    },
    handleTouchEnd(event) {
      this.$emit('touch-end', event)
    },
    toggleExpand() {
      this.$emit('toggle-expand')
    },
    truncatedText(text) {
      if (!text) return '';
      return text.length > this.maxLength ? text.substring(0, this.maxLength) + '...' : text;
    }
  }
}
</script>
