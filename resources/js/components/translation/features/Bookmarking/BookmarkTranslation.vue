<template>
  <div>
    <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
    <div v-if="showAlert" class="alert alert-success" role="alert">
      Bookmark saved successfully!
    </div>
    <div v-if="showErrorAlert" class="alert alert-danger" role="alert">
      An error occurred while saving the bookmark.
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'BookmarkTranslation',
  props: {
    information: {
      type: Object,
      required: true,
      default: () => ({
        surah: { name_en: '' },
        ayah_text: '',
        ayah_id: null,
        translation: ''
      }),
      validator(value) {
        return (
          value.surah &&
          value.surah.name_en !== undefined &&
          value.ayah_text !== undefined &&
          value.ayah_id !== undefined &&
          value.translation !== undefined
        );
      }
    }
  },
  data() {
    return {
      showAlert: false,
      showErrorAlert: false,
    };
  },
  methods: {
    submitForm() {
      const { surah, ayah_text, ayah_id, translation } = this.information;
      if (!surah || !ayah_text || ayah_id === null || !translation) {
        console.error('Information prop is incomplete or missing.');
        this.showErrorAlert = true;
        this.hideAlertAfterDelay();
        return;
      }
      const formData = {
        surah_name: surah.name_en,
        ayah_num: ayah_id,
        ayah_verse_ar: ayah_text,
        ayah_verse_en: translation,
      };
      axios.post('/bookmarks', formData)
        .then(response => {
          console.log(response.data.message);
          localStorage.setItem(`bookmarkSubmitted_${ayah_id}`, true);
          this.showAlert = true;
          this.showErrorAlert = false;
          this.hideAlertAfterDelay();
        })
        .catch(error => {
          console.error(error);
          this.showAlert = false;
          this.showErrorAlert = true;
          this.hideAlertAfterDelay();
        });
    },
    hideAlertAfterDelay() {
      setTimeout(() => {
        this.showAlert = false;
        this.showErrorAlert = false;
      }, 3000); // Hide alerts after 3 seconds
    }
  }
};
</script>

<style scoped>
.alert {
  position: fixed;
  top: 10px;
  right: 10px;
  z-index: 1000;
}
</style>
