<!-- TransliterationActions.vue -->
<template>
<div class="row">
    <div class="d-flex flex-wrap justify-content-between align-items-center" >
      <div class="">
        <i
          class="bi bi-file-earmark-text h4"
          aria-expanded="false"
          data-bs-placement="top"
          title="Write a note"
          @click="$emit('open-modal', 'transliterationNote')"
          
        ></i>
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
        <CopyTransliterationText :textToCopy="transliteration" :iconColor="iconColor" />
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
