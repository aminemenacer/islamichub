<template>
  <ul class="text-decoration:none" >
    <li style="display:flex"><i class="bi bi-file-earmark-text text-right mr-2 h4 mt-2 pl-2" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('openModal', 'tafseerNote')" style="color: rgba(0, 191, 166);cursor:pointer"></i><p>Write a note</p></li>
    <li style="display:flex"><WhatsAppShareTafseer class="pl-2" :tafseerToShare="tafseer" /><p>WhatsApp</p></li>
    <li style="display:flex"><TwitterShareTafseer class="pl-2" :targetElementRef="'targetElement'" :tafseerText="tafseer" /><p>Twitter</p></li>
    <li style="display:flex"><i @click="$emit('submitForm')" class="bi bi-bookmark text-right mr-2 h4 pl-2" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i><p>Bookmark</p></li>
    <li style="display:flex"><CopyTafseerText :textToCopy="tafseer" class="pl-2"/><p>Copt text</p></li>
    <li style="display:flex"><i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4 pl-2" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i><p>Report a bug</p></li>
    <li style="display:flex"><i class="bi bi-info-circle h4 mr-2 pl-2" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#tafseerInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i><p>Surah info</p></li>
  </ul>
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