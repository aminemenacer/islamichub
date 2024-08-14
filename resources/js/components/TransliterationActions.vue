<!-- TransliterationActions.vue -->
<template>
<div style="display:flex">
 <li style="display:flex; align-items: center; margin-right: 5px;"><i class="bi bi-file-earmark-text text-right mr-2 pl-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'transliterationNote')" style="color: rgba(0, 191, 166);cursor:pointer"></i>
 </li>
 <li style="display:flex; align-items: center; margin-right: 5px;">
  <WhatsAppShareTransliteration class="pl-2" :transliterationToShare="transliteration" />
 </li>
 <li style="display:flex; align-items: center; margin-right: 5px;">
  <TwitterShareTransliteration class="pl-2" :targetElementRef="'targetElement'" :transliterationText="transliteration" />
 </li>
 <li style="display:flex; align-items: center; margin-right: 5px;"><i @click="$emit('submit-form')" class="bi bi-bookmark text-right mr-2 pl-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
 </li>
 <li style="display:flex; align-items: center; margin-right: 5px;">
  <CopyTransliterationText class="pl-2 pb-2" :textToCopy="transliteration" />
 </li>
 <li style="display:flex; align-items: center; margin-right: 5px;">
  <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 pl-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
 </li>
</div>
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
 emits: ['open-modal', 'submit-form'],
 methods: {
  captureTransliteration() {
   const targetTransliterationElement = this.$parent.$refs[this.targetTransliterationRef];

   if (!targetTransliterationElement) {
    console.error("Invalid element provided as targetTransliterationRef");
    return;
   }

   setTimeout(() => {
    html2canvas(targetTransliterationElement).then(canvas => {
     const dataUrl = canvas.toDataURL('image/png');
     this.downloadUrl = canvas.toDataURL('image/png');

     // Simulate click on download link after 2 seconds
     setTimeout(() => {
      const downloadLink = document.createElement('a');
      downloadLink.href = dataUrl;
      downloadLink.download = 'screenshot.png';
      downloadLink.click();
     }, 2); // 2000 milliseconds = 2 seconds
    });
   }, 2);
  },

  downloadScreenshot() {
   const downloadLink = document.createElement('a');
   downloadLink.href = this.downloadUrl;
   downloadLink.download = 'screenshot.png';
   downloadLink.click();
  }
 },
}
</script>
