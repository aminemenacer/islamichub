<template>
<div style="display:flex">
 <li style="display:flex" @click="$emit('openModal', 'tafseerNote')">
  <i class="bi bi-file-earmark-text text-right mr-2 h4 pl-2" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="$emit('openModal', 'tafseerNote')" style="color: rgba(0, 191, 166);cursor:pointer"></i>
 </li>
 <li style="display:flex">
  <WhatsAppShareTafseer class="pl-2" :tafseerToShare="tafseer" />
 </li>
 <li style="display:flex">
  <TwitterShareTafseer class="pl-2" :targetElementRef="'targetElement'" :tafseerText="tafseer" />
 </li>
 <li style="display:flex" @click="$emit('submitForm')">
  <i @click="$emit('submitForm')" class="bi bi-bookmark text-right mr-2 h4 pl-2" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
 </li>
 <li style="display:flex">
  <CopyTafseerText :textToCopy="tafseer" class="pl-2" />
 </li>
 <li style="display:flex">
  <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4 pl-2" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
 </li>
 <li style="display:flex">
  <i class="bi bi-camera text-right mr-2 h3" @click="captureTafseer" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166); cursor:pointer"></i>
 </li>
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
