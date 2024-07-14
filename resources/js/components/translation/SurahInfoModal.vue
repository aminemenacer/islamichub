<!-- SurahInfoModal.vue -->
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
  name: 'SurahInfoModal',
  props: {
    information: {
      type: Object,
      required: true
    },
    ayahs: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      expanded: false,
      ayah_id: null,
      showMoreLink: true
    };
  },
  methods: {
    toggleExpand() {
      this.expanded = !this.expanded;
    },
    truncatedText(text) {
      if (text.length > 100) {
        this.showMoreLink = true;
        return text.slice(0, 100) + '...';
      }
      this.showMoreLink = false;
      return text;
    },
   
  }
};
</script>

<style scoped>

</style>
