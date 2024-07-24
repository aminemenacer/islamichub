<template>
  <div class="modal fade" id="translationInfo" tabindex="-1" aria-labelledby="surahInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="surahInfoModalLabel"><strong>Information</strong></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="container text-left">
            <div class="mb-3 container">
              <label for="formGroupExampleInput" class="form-label">Surah Name (English):</label>
              <p class="mt-2 text-dark text-left">{{ information.ayah.surah.name_en }}</p>
            </div>
            <div class="mb-3 container">
              <label for="formGroupExampleInput" class="form-label text-left">Surah Information:</label>
              <p class="text-left">
                {{ expanded ? information.ayah.surah.text : truncatedText(information.ayah.surah.text) }}
                <template v-if="showMoreLink">
                  <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
                </template>
              </p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    information: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      expanded: false
    };
  },
  computed: {
    showMoreLink() {
      return this.information.ayah.surah.text && this.information.ayah.surah.text.length > 100; // Adjust the length as needed
    }
  },
  methods: {
    toggleExpand() {
      this.expanded = !this.expanded;
    },
    truncatedText(text) {
      if (!text) return '';
      return text.length > 100 ? text.substring(0, 100) + '...' : text; // Adjust the length as needed
    }
  }
};
</script>

<style scoped>
/* Add any specific styles if necessary */
</style>
