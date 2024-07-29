<!-- ShareTranslation.vue -->
<template>
  <div class="share-translation">
    <WhatsAppShareTranslation :translationToShare="translation" />
    <TwitterShareTranslation targetElementRef="targetElement" :translationText="translation" />
  </div>
</template>

<script>
import WhatsAppShareTranslation from './WhatsAppShareTranslation.vue'
import TwitterShareTranslation from './TwitterShareTranslation.vue'

export default {
  name: 'ShareTranslation',
  components: {
    WhatsAppShareTranslation,
    TwitterShareTranslation
  },
  props: {
    translation: {
      type: String,
      required: true
    }
  }
}
</script>