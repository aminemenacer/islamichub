<template>
<div class="row">
 <div style="padding:5px; display:flex">
  <div class="col-2">
   <i class="bi bi-file-earmark-text text-right h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('openModal', 'tafseerNote')"></i>
  </div>
  <div class="col-2">
   <WhatsAppShareTafseer :tafseerToShare="tafseer" :iconColor="iconColor" />
  </div>
  <div class="col-2">
   <TwitterShareTafseer :targetElementRef="'targetElement'" :tafseerText="tafseer" :iconColor="iconColor" />
  </div>
  <div class="col-2">
   <i @click="$emit('submitForm')" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse"></i>
  </div>
  <div class="col-2">
   <CopyTafseerText :textToCopy="tafseer" />
  </div>
  <div class="col-2">
   <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right h4" aria-expanded="false" data-bs-placement="top"></i>
  </div>
 </div>
</div>
</template>

<script>
import TafseerNote from './translation/features/notes/TafseerNote.vue';
import WhatsAppShareTafseer from './translation/features/whatsapp/WhatsAppShareTafseer.vue';
import TwitterShareTafseer from './translation/features/twitter/TwitterShareTafseer.vue';
import CopyTafseerText from './translation/features/copy_text/CopyTafseerText.vue';
import ScreenTafseerCapture from './translation/features/screen_capture/ScreenTafseerCapture.vue';
import PdfDownload from './pdf/PdfDownload.vue';
import html2canvas from 'html2canvas';

export default {
 name: 'TafseerActions',
 components: {
  TafseerNote,
  WhatsAppShareTafseer,
  TwitterShareTafseer,
  CopyTafseerText,
  ScreenTafseerCapture,
  PdfDownload
 },
 data() {
  return {
   targetTafseerElementRef: null
  };
 },

 props: {
  tafseer: {
   type: String,
   required: true
  }
 },

 emits: ['openModal', 'submitForm', 'toggleFullScreen'],
 methods: {
  captureTafseer() {
   const targetTafseerElement = this.$parent.$refs[this.targetTafseerRef];

   if (!targetTafseerElement) {
    console.error("Invalid element provided as targetTafseerRef");
    return;
   }

   setTimeout(() => {
    html2canvas(targetTafseerElement).then(canvas => {
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
  shareTextViaWhatsApp() {
   this.$emit('share-whatsapp');
  },
  shareHeadingOnTwitter() {
   this.$emit('share-twitter');
  },
  submitForm() {
   this.$emit('bookmark');
  },
  captureScreenshot() {
   this.$emit('screenshot');
  }
 }
};
</script>
