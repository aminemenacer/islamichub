<template>
    <div class="row">
        <div class="d-flex flex-wrap" style="padding: 5px">
            <div class="col-2">
                <i
                    class="bi bi-file-earmark-text h4"
                    aria-expanded="false"
                    data-bs-placement="top"
                    title="Write a note"
                    @click="$emit('open-modal', 'translationNote')"
                    style="color: rgba(0, 191, 166); cursor: pointer"
                ></i>
            </div>
            <div class="col-2">
                <WhatsAppShareTranslation :translationToShare="translation" />
            </div>
            <div class="col-2">
                <TwitterShareTranslation
                    :targetElementRef="targetTranslationRef"
                    :translationText="translation"
                />
            </div>
            <div class="col-2">
                <i
                    @click="openFolderSelectionModal"
                    class="bi bi-bookmark h4"
                    title="Select Folder to Bookmark"
                    style="cursor: pointer"
                ></i>
            </div>
            <FolderSelectionModal
                ref="folderSelectionModal"
                :information="information"
                @folder-selected="handleFolderSelected"
            />

            <div class="col-2">
                <CopyTranslationText :textToCopy="translation" />
            </div>
            <div class="col-2">
                <i
                    title="Report a bug"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    class="bi bi-bug h4"
                    aria-expanded="false"
                    data-bs-placement="top"
                    style="color: rgba(0, 191, 166); cursor: pointer"
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
        WhatsAppShareTafseer,
        TwitterShareTranslation,
        CopyTranslationText,
        FolderSelectionModal,
    },
    props: {
        translation: {
            type: String,
            required: true,
        },
        targetTranslationRef: {
            type: String,
            required: true,
        },
        tafseer: {
            type: String,
            required: true,
        },
        information: {
            type: Object,
            required: true,
        },
    },
    emits: ["open-modal", "submit-form"],
    data() {
        return {
            downloadUrl: "",
            selectedFolderId: null,
        };
    },
    methods: {
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
        shareTextViaWhatsApp() {
            this.$emit("share-whatsapp");
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
