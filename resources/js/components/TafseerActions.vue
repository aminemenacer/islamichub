<template>
<div class="row">
    <div class="d-flex flex-wrap justify-content-between align-items-center" >
      <div class="">
        <i
          class="bi bi-file-earmark-text h4"
          aria-expanded="false"
          data-bs-placement="top"
          title="Write a note"
          @click="$emit('open-modal', 'tafseerNote')"
        ></i>
      </div>
      <div class="icon-container">
        <WhatsAppShareTafseer :tafseerToShare="tafseer" :iconColor="iconColor" />
      </div>
      <div class="icon-container">
        <TwitterShareTafseer
          :targetElementRef="targetTafseerRef"
          :tafseerText="tafseer"
          :iconColor="iconColor"
        />
      </div>
      <div class="icon-container">
        <i
          @click="openFolderSelectionModal"
          class="bi bi-bookmark h4"
          title="Select Folder to Bookmark"
          
        ></i>
      </div>
      <FolderSelectionModal
        ref="folderSelectionModal"
        :information="information"
        @folder-selected="handleFolderSelected"
      />
      <div class="icon-container">
        <CopyTafseerText :textToCopy="tafseer" :iconColor="iconColor"/>
      </div>
      <div class="icon-container">
        <i
          title="Report a bug"
          data-bs-toggle="modal"
          data-bs-target="#exampleModal"
          class="bi bi-bug h4"
          aria-expanded="false"
          data-bs-placement="top"
          
        ></i>
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
