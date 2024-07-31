<!-- TransliterationActions.vue -->
<template>
  <ul>
    <li style="display:flex"><i class="bi bi-file-earmark-text text-right mr-2 mt-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'transliterationNote')" style="color: rgba(0, 191, 166);cursor:pointer"></i><p>Write a note</p></li>
    <li style="display:flex"><WhatsAppShareTransliteration :transliterationToShare="transliteration" /><p>WhatsApp</p></li>
    <li style="display:flex"><TwitterShareTransliteration :targetElementRef="'targetElement'" :transliterationText="transliteration" /><p>Twitter</p></li>
    <li style="display:flex"><i @click="$emit('submit-form')" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i><p>Bookmark</p></li>
    <li style="display:flex"><CopyTransliterationText :textToCopy="transliteration" /><p>Copt text</p></li>
    <li style="display:flex"><ScreenTransliterationCapture :targetTransliterationRef="'targetTransliterationElement'" /><p>Screenshot</p></li>
    <li style="display:flex"><i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2  h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i><p>Report a bug</p></li>
    <li style="display:flex"><i class="bi bi-info-circle h4 mr-2" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#transliterationInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i><p>Surah info</p></li>
  </ul>
</template>

<script>
import TransliterationNote from './translation/features/notes/TransliterationNote'
import WhatsAppShareTransliteration from './translation/features/whatsapp/WhatsAppShareTransliteration.vue'
import TwitterShareTransliteration from './translation/features/twitter/TwitterShareTransliteration.vue'
import CopyTransliterationText from './translation/features/copy_text/CopyTransliterationText.vue'
import ScreenTransliterationCapture from './translation/features/screen_capture/ScreenTransliterationCapture.vue'

export default {
  name: 'TransliterationActions',
  components: {
    TransliterationNote,
    WhatsAppShareTransliteration,
    TwitterShareTransliteration,
    CopyTransliterationText,
    ScreenTransliterationCapture
  },
  props: {
    transliteration: {
      type: String,
      required: true
    }
  },
  emits: ['open-modal', 'submit-form']
}
</script>