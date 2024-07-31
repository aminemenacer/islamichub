<template>
  <div class="icon-container w-100 hide-on-mobile pb-3">
    <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('openModal', 'tafseerNote')" style="color: rgba(0, 191, 166);cursor:pointer">
    </i>
    <TafseerNote ref="tafseerNote" :information="tafseer" />
    <WhatsAppShareTafseer :tafseerToShare="tafseer" />
    <TwitterShareTafseer :targetElementRef="'targetElement'" :tafseerText="tafseer" />
    <i @click="$emit('submitForm')" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
    <CopyTafseerText :textToCopy="tafseer" />
    <ScreenTafseerCapture :targetTafseerRef="'targetTafseerElement'" />
    <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
    <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166);cursor:pointer" @click="$emit('toggleFullScreen')" title="Full screen"></i>
    <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#tafseerInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i>
  </div>
</template>

<script>
import TafseerNote from './translation/features/notes/TafseerNote.vue'
import WhatsAppShareTafseer from './translation/features/whatsapp/WhatsAppShareTafseer.vue'
import TwitterShareTafseer from './translation/features/twitter/TwitterShareTafseer.vue'
import CopyTafseerText from './translation/features/copy_text/CopyTafseerText.vue'
import ScreenTafseerCapture from './translation/features/screen_capture/ScreenTafseerCapture.vue'
export default {
  name: 'TafseerActions',
  components: {
   TafseerNote,
    WhatsAppShareTafseer,
    TwitterShareTafseer,
    CopyTafseerText,
    ScreenTafseerCapture
  },
  props: {
    tafseer: {
      type: String,
      required: true
    }
  },
  emits: ['openModal', 'submitForm', 'toggleFullScreen'],
  methods: {
    shareTextViaWhatsApp() {
      this.$emit('share-whatsapp')
    },
    shareHeadingOnTwitter() {
      this.$emit('share-twitter')
    },
    submitForm() {
      this.$emit('bookmark')
    },
    captureScreenshot() {
      this.$emit('screenshot')
    }
  }
}
</script>