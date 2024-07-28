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
        {{ expanded ? tafseer : truncatedText(tafseer) }}
        <template v-if="showMoreLink">
          <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
        </template>
      </h5>
      <h6 class="text-left mt-3"><strong>Tafseer: </strong>Ibn Kathir</h6>
      <br>
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
export default {
  name: 'TafseerSection',
  props: {
    information: Object,
    isFullScreen: Boolean,
    expanded: Boolean,
    showMoreLink: Boolean,
    showAlertText: String,
    showAlert: Boolean,
    showErrorAlert: Boolean,
    showAlertTextNote: String,
    tafseer: String,
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
    closeAlertText() {
      this.$emit('close-alert-text')
    },
    truncatedText(text) {
      if (!text) return '';
      return text.length > this.maxLength ? text.substring(0, this.maxLength) + '...' : text;
    }
  },
  components: {
    AyahInfo: () => import('./AyahInfo.vue'),
    AlertModal: () => import('./AlertModal.vue')
  }
}
</script>

<style scoped>
/* Add any necessary styling here */
</style>
