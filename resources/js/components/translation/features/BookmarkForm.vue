<!-- BookmarkForm.vue -->
<template>
  <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
</template>

<script>
import axios from 'axios';

export default {
  name: 'BookmarkForm',
  props: {
    information: {
      type: Object,
      required: true
    }
  },
  methods: {
    submitForm() {
      const formData = {
        surah_name: this.information.ayah.surah.name_en,
        ayah_num: this.information.ayah_id,
        ayah_verse_ar: this.information.ayah.ayah_text,
        ayah_verse_en: this.information.translation,
      };

      axios.post('/bookmarks', formData)
        .then(response => {
          console.log(response.data.message);
          // Set the submitted status for the selected bookmark
          localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
          // Emit events to show/hide alerts
          this.$emit('show-alert', true);
          this.$emit('show-error-alert', false);
        })
        .catch(error => {
          console.error(error);
          // Emit events to show/hide alerts
          this.$emit('show-alert', false);
          this.$emit('show-error-alert', true);
        });
    }
  }
};
</script>
