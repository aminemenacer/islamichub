<!-- TranslationActions.vue -->
<template>
  <ul>
    <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'translationNote')" style="color: rgba(0, 191, 166);cursor:pointer"></i>
    <TranslationNote ref="translationNote" :information="translation" />
    <WhatsAppShareTranslation :translationToShare="translation" />
    <TwitterShareTranslation :targetElementRef="'targetElement'" :translationText="translation" />
    <i @click="$emit('submit-form')" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
    <CopyTranslationText :textToCopy="translation" />
    <ScreenTranslationCapture :targetTranslationRef="'targetTranslationElement'" />
    <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
    <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#translationInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i>
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