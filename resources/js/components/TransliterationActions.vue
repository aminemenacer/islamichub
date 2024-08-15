<!-- TransliterationActions.vue -->
<template>
<div class="row">
 <div style="padding:5px; display:flex">
  <div class="col-2">
   <i class="bi bi-file-earmark-text h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'transliterationNote')" style="color: rgba(0, 191, 166);cursor:pointer"></i>
  </div>
  <div class="col-2">
   <WhatsAppShareTransliteration :transliterationToShare="transliteration" />
  </div>
  <div class="col-2">
   <TwitterShareTransliteration :targetElementRef="'targetElement'" :transliterationText="transliteration" />
  </div>
  <div class="col-2">
   <i @click="$emit('submit-form')" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
  </div>
  <div class="col-2">
   <CopyTransliterationText :textToCopy="transliteration" />
  </div>
  <div class="col-2">
   <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
  </div>
 </div>
</div>
</template>

<script>
import TransliterationNote from './translation/features/notes/TransliterationNote'
import WhatsAppShareTransliteration from './translation/features/whatsapp/WhatsAppShareTransliteration.vue'
import TwitterShareTransliteration from './translation/features/twitter/TwitterShareTransliteration.vue'
import CopyTransliterationText from './translation/features/copy_text/CopyTransliterationText.vue'
import ScreenTransliterationCapture from './translation/features/screen_capture/ScreenTransliterationCapture.vue'
import html2canvas from 'html2canvas';

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
 props: {
  targetTransliterationRef: {
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
