<template>
<div class="row">
 <div style="padding:5px; display:flex">
  <div class="col-2">
   <i class="bi bi-file-earmark-text h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'translationNote')" style="color: rgba(0, 191, 166); cursor:pointer;">
   </i>
  </div>
  <div class="col-2">
   <WhatsAppShareTranslation :translationToShare="translation" />
  </div>
  <div class="col-2">
   <TwitterShareTranslation :targetElementRef="'targetElement'" :translationText="translation" />
  </div>
  <div class="col-2">
   <i @click="$emit('submit-form')" class="bi bi-bookmark mr-2 h4 " aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166); cursor:pointer;">
   </i>
  </div>
  <div class="col-2">
   <CopyTranslationText :textToCopy="translation" />
  </div>
  <div class="col-2">
   <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug h4 " aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;">
   </i>
  </div>
 </div>
</div>
 
</template>

<script>
import TranslationNote from './translation/features/notes/TranslationNote'
import WhatsAppShareTranslation from './translation/features/whatsapp/WhatsAppShareTranslation.vue'
import TwitterShareTranslation from './translation/features/twitter/TwitterShareTranslation.vue'
import CopyTranslationText from './translation/features/copy_text/CopyTranslationText.vue'
import ScreenTranslationCapture from './translation/features/screen_capture/ScreenTranslationCapture.vue'
import html2canvas from 'html2canvas';

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
 props: {
  targetTranslationRef: {
   type: String,
   required: true
  }
 },
 emits: ['open-modal', 'submit-form'],
 data() {
  return {
   downloadUrl: '',
  }
 },
 methods: {
  captureTranslation() {
   const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];

   if (!targetTranslationElement) {
    console.error("Invalid element provided as targetTranslationRef");
    return;
   }

   setTimeout(() => {
    html2canvas(targetTranslationElement).then(canvas => {
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
 }
}
</script>
