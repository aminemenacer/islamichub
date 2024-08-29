<template>
  <div ref="targetGroupElement" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
    <AyahInfo :information="information" />
    <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">

      <MainAyah :information="information" />

      <!-- Translation Section -->
      <i :class="isVisibleTranslation ? 'bi bi-dash-circle' : 'bi bi-plus-circle'" @click="toggleContentTranslation"></i>
      <div ref="heading3" class="text-left">
        <b class="text-left pb-2">Translation:</b>
        <p class="text-left ayah-translation" style="line-height: 1.6em" v-if="isVisibleTranslation">
          {{ expanded ? information.translation : truncatedText(information.translation) }}
          <template v-if="showMoreLink && information.translation.length > 100">
            <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
          </template>
        </p>
      </div>

      <hr>

      <!-- Tafseer Section -->
      <i :class="isVisibleTafseer ? 'bi bi-dash-circle' : 'bi bi-plus-circle'" @click="toggleContentTafseer"></i>
      <div ref="heading3" class="text-left">
        <b class="text-left pb-2">Tafseer:</b>
        <p class="ayah-translation" style="line-height: 1.6em" v-if="isVisibleTafseer">
          {{ expanded ? information.tafseer : truncatedText(information.tafseer) }}
          <template v-if="showMoreLink && information.tafseer.length > 100">
            <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
          </template>
        </p>
      </div>

      <hr>

      <!-- Transliteration Section -->
      <i :class="isVisibleTransliteration ? 'bi bi-dash-circle' : 'bi bi-plus-circle'" @click="toggleContentTransliteration"></i>
      <div ref="heading3" class="text-left">
        <b class="text-left pb-2">Transliteration:</b>
        <p class="text-left ayah-translation" style="line-height: 1.6em" v-if="isVisibleTransliteration">
          {{ expanded ? information.transliteration : truncatedText(information.transliteration) }}
          <template v-if="showMoreLink && information.transliteration.length > 100">
            <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
          </template>
        </p>
      </div>

    </div>
    <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
  </div>
</template>

<script>
import AyahInfo from './translation/AyahInfo.vue';
import MainAyah from './translation/MainAyah.vue';
import Translator from './translation/Translator.vue';
import AlertModal from './modals/AlertModal.vue';

export default {
 name: 'GroupSection',
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

 data() {
  return {
   isVisibleTranslation: true,
   isVisibleTafseer: true,
   isVisibleTransliteration: true,
  }
 },
 methods: {
  toggleContentTranslation() {
   this.isVisibleTranslation = !this.isVisibleTranslation;
  },
  toggleContentTafseer() {
   this.isVisibleTafseer = !this.isVisibleTafseer;
  },
  toggleContentTransliteration() {
   this.isVisibleTransliteration = !this.isVisibleTransliteration;
  },
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
