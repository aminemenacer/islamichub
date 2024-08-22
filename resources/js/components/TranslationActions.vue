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
        <i @click="openFolderSelectionModal" class="bi bi-bookmark" title="Bookmark verse" style="cursor:pointer;"></i>
      </div>
      <div class="col-2">
        <CopyTranslationText :textToCopy="translation" />
      </div>
      <div class="col-2">
        <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug h4 " aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;">
        </i>
      </div>
      <!-- Folder Selection Modal -->
      <FolderSelectionModal :information="bookmarkInfo" @folder-selected="handleFolderSelected" />
    </div>
  </div>
</template>

<script>
import TranslationNote from './translation/features/notes/TranslationNote'
import WhatsAppShareTranslation from './translation/features/whatsapp/WhatsAppShareTranslation.vue'
import TwitterShareTranslation from './translation/features/twitter/TwitterShareTranslation.vue'
import CopyTranslationText from './translation/features/copy_text/CopyTranslationText.vue'
import ScreenTranslationCapture from './translation/features/screen_capture/ScreenTranslationCapture.vue'
import FolderSelectionModal from './folder_manager/FolderSelectionModal.vue'
import html2canvas from 'html2canvas';

export default {
  name: 'TranslationActions',
  components: {
    TranslationNote,
    WhatsAppShareTranslation,
    TwitterShareTranslation,
    CopyTranslationText,
    ScreenTranslationCapture,
    FolderSelectionModal
  },
  props: {
    translation: {
      type: String,
      required: true
    },
    targetTranslationRef: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      downloadUrl: '',
      bookmarkInfo: {
        surah_name: '', 
        ayah_num: '', 
        ayah_verse_ar: '', 
        ayah_verse_en: ''
      }
    }
  },
  methods: {
    openFolderSelectionModal() {
      const modalElement = document.getElementById('folderSelectionModal');
      if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
      } else {
        console.error('Modal element not found.');
      }
    },
    handleFolderSelected(bookmark) {
      // Handle the selected folder (or bookmark) here
      console.log('Folder selected:', bookmark);
      // You can use the bookmark data as needed
    },
    captureTranslation() {
      const targetTranslationElement = this.$parent.$refs[this.targetTranslationRef];
      if (!targetTranslationElement) {
        console.error("Invalid element provided as targetTranslationRef");
        return;
      }

      setTimeout(() => {
        html2canvas(targetTranslationElement).then(canvas => {
          const dataUrl = canvas.toDataURL('image/png');
          this.downloadUrl = dataUrl;

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
