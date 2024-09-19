<template>
  <div class="row">
    <div class="d-flex flex-wrap justify-content-between align-items-center" >
      <div class="">
        <i
          class="bi bi-file-earmark-text h4"
          aria-expanded="false"
          data-bs-placement="top"
          title="Write a note"
          @click="$emit('open-modal', 'translationNote')"
          
        ></i>
      </div>
      <div class="icon-container">
        <WhatsAppShareTranslation 
            :translationToShare="translation" 
            :iconColor="iconColor" 
        />
        </div>
        <div class="icon-container">
        <TwitterShareTranslation
            :targetElementRef="targetTranslationRef"
            :translationText="translation"
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
        <CopyTranslationText :textToCopy="translation" :iconColor="iconColor" />
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
import TranslationNote from "./translation/features/notes/TranslationNote";
import WhatsAppShareTranslation from "./translation/features/whatsapp/WhatsAppShareTranslation.vue";
import WhatsAppShareTafseer from "./translation/features/whatsapp/WhatsAppShareTafseer.vue";
import TwitterShareTranslation from "./translation/features/twitter/TwitterShareTranslation.vue";
import CopyTranslationText from "./translation/features/copy_text/CopyTranslationText.vue";
import FolderSelectionModal from "./folder_manager/FolderSelectionModal.vue";

import html2canvas from "html2canvas";

export default {
    name: "TranslationActions",
    components: {
        TranslationNote,
        WhatsAppShareTranslation,
        TwitterShareTranslation,
        CopyTranslationText,
        FolderSelectionModal,
    },
    props: {
        translation: {
            type: String,
            required: true,
        },
        
    },
    emits: ['openModal', 'submitForm', 'toggleFullScreen'],
    data() {
        return {
            downloadUrl: "",
            selectedFolderId: null,
            targetTranslationElement:null,
        };
    },
    methods: {
        shareTextViaWhatsApp() {
            this.$emit('share-whatsapp');
        },
        openFolderSelectionModal() {
            // Reference the modal via ref and call its method
            if (this.$refs.folderSelectionModal) {
                this.$refs.folderSelectionModal.show();
            } else {
                console.error("FolderSelectionModal component is not found.");
            }
        },
        handleFolderSelected(bookmark) {
            console.log("Folder selected and bookmark created:", bookmark);
            this.$emit("submit-form", bookmark);
        },
        captureTranslation() {
            const targetTranslationElement =
                this.$parent.$refs[this.targetTranslationRef];

            if (!targetTranslationElement) {
                console.error(
                    "Invalid element provided as targetTranslationRef"
                );
                return;
            }
            setTimeout(() => {
                html2canvas(targetTranslationElement).then((canvas) => {
                    const dataUrl = canvas.toDataURL("image/png");
                    this.downloadUrl = dataUrl;

                    setTimeout(() => {
                        const downloadLink = document.createElement("a");
                        downloadLink.href = dataUrl;
                        downloadLink.download = "screenshot.png";
                        downloadLink.click();
                    }, 2000);
                });
            }, 2000);
        },
        downloadScreenshot() {
            const downloadLink = document.createElement("a");
            downloadLink.href = this.downloadUrl;
            downloadLink.download = "screenshot.png";
            downloadLink.click();
        },
        handleFolderSelected(folderId) {
            console.log("Folder selected:", folderId);
        },
        shareHeadingOnTwitter() {
            this.$emit("share-twitter");
        },
        submitForm() {
            this.$emit("bookmark");
        },
        captureScreenshot() {
            this.$emit("screenshot");
        },
    },
};
</script>
