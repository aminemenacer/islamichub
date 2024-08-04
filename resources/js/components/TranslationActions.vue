<template>
<ul style="display: flex; list-style: none; padding: 0; margin: 0;">
 <li style="display: flex; align-items: center; margin-right: 15px;">
  <i class="bi bi-file-earmark-text h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('open-modal', 'translationNote')" style="color: rgba(0, 191, 166); cursor:pointer;">
  </i>
 </li>
 <li style="display: flex; align-items: center; margin-right: 15px;">
  <WhatsAppShareTranslation :translationToShare="translation" />
 </li>
 <li style="display: flex; align-items: center; margin-right: 15px;">
  <TwitterShareTranslation :targetElementRef="'targetElement'" :translationText="translation" />
 </li>
 <li style="display: flex; align-items: center; margin-right: 15px;">
  <i @click="$emit('submit-form')" class="bi bi-bookmark h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166); cursor:pointer;">
  </i>
 </li>
 <li style="display: flex; align-items: center; margin-right: 15px;">
  <CopyTranslationText :textToCopy="translation" />
 </li>
 <PdfDownload :targetTranslationRef="'targetTranslationElement'" />
 <li style="display: flex; align-items: center; margin-right: 15px;">
  <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;">
  </i>
 </li>
 <li style="display: flex; align-items: center; margin-right: 15px;">
  <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166); cursor:pointer;" data-bs-target="#translationInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info">
  </i>
 </li>
 <!-- Screenshot icon -->
 <i class="bi bi-camera text-right mr-2 h3" @click="captureTranslation" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166); cursor:pointer"></i>

</ul>
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
