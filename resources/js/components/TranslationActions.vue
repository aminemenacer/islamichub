<template>
<div style="display: flex;">
 <li style="display: flex; align-items: center; margin-right: 5px;">
  <i class="bi bi-file-earmark-text h4 mr-2 pl-2" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'translationNote')" style="color: rgba(0, 191, 166); cursor:pointer;">
  </i>
 </li>
 <li style="display: flex; align-items: center; margin-right: 5px;">
  <WhatsAppShareTranslation class="pl-2" :translationToShare="translation" />
 </li>
 <li style="display: flex; align-items: center; margin-right: 5px;">
  <TwitterShareTranslation class="pl-2" :targetElementRef="'targetElement'" :translationText="translation" />
 </li>
 <li style="display: flex; align-items: center; margin-right: 5px;">
  <i @click="$emit('submit-form')" class="bi bi-bookmark mr-2 h4 pl-2" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166); cursor:pointer;">
  </i>
 </li>
 <li style="display: flex; align-items: center; margin-right: 5px;">
  <CopyTranslationText class="pl-2 pb-2" :textToCopy="translation" />
 </li>
 <li style="display:flex; align-items: center; margin-right: 5px;" >
  <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug h4 pl-1" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;">
  </i>
 </li>

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
