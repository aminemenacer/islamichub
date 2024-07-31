<!-- TranslationActions.vue -->
<template>
  <ul>
    <li style="display:flex"><i class="bi bi-file-earmark-text text-right mr-2 h4 pl-2 mt-2" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'translationNote')" style="color: rgba(0, 191, 166);cursor:pointer"></i><p>Write a note</p></li>
    <li style="display:flex"><WhatsAppShareTranslation :translationToShare="translation" class="pl-2"/><p>WhatsApp</p></li>
    <li style="display:flex"><TwitterShareTranslation :targetElementRef="'targetElement'" class="pl-2" :translationText="translation" /><p>Twitter</p></li>
    <li style="display:flex"><i @click="$emit('submit-form')" class="bi bi-bookmark text-right mr-2 h4 pl-2" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i><p>Bookmark</p></li>
    <li style="display:flex"><CopyTranslationText :textToCopy="translation" class="pl-2"/><p>Copt text</p></li>
    <li style="display:flex"><i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 pl-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i><p>Report a bug</p></li>
    <li style="display:flex"><i class="bi bi-info-circle h4 mr-2 pl-2" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#translationInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i><p>Surah info</p></li>
  </ul>
</template>

<script>
import TranslationNote from './translation/features/notes/TranslationNote'
import WhatsAppShareTranslation from './translation/features/whatsapp/WhatsAppShareTranslation.vue'
import TwitterShareTranslation from './translation/features/twitter/TwitterShareTranslation.vue'
import CopyTranslationText from './translation/features/copy_text/CopyTranslationText.vue'
import ScreenTranslationCapture from './translation/features/screen_capture/ScreenTranslationCapture.vue'

export default {
  name: 'TranslationActions',
  components: {
    TranslationNote,
    WhatsAppShareTranslation,
    TwitterShareTranslation,
    CopyTranslationText,
    ScreenTranslationCapture
  },
  props: {
    translation: {
      type: String,
      required: true
    }
  },
  emits: ['open-modal', 'submit-form']
}
</script>