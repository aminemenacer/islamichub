<template>
  <div>
    <!-- Form for searching Ayah -->
    <form class="d-flex pb-2" role="search" @submit.prevent="handleSearch">
      <input class="form-control me-2" type="number" placeholder="Enter Verse Number" v-model="verseNumber" required>
      <button class="btn btn-success mb-1 ml-2" type="submit">Search</button>
    </form>

    <!-- Error alert -->
    <ErrorAlert :showError="showError" @dismiss-error="handleDismissError" />

    <!-- Navigation Icons -->
    <div class="icon-container pb-2">
      <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="handleGoToFirstAyah" title="First verse"></i>
      <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="handleGoToPreviousAyah" title="Previous verse"></i>
      <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="handleGoToNextAyah" title="Next verse"></i>
      <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="handleGoToLastAyah" title="Last verse"></i>
    </div>

    <!-- List of Ayat -->
    <div class="custom-scrollbar pb-5" style="overflow-y: auto; max-height: 600px; background: white;">
      <ul class="col-md-12 list-group container-fluid root" style="list-style-type: none; padding: 10px">
        <li v-for="(ayah, index) in ayat" :key="index" @click="handleSelectAyah(index)" :class="{ selected: selectedIndexAyah === index, highlighted: verseNumber && parseInt(verseNumber) === ayah.ayah_id }" style="padding: 10px; border-radius:10px">
          <h5 class="text-right" style="display: flex;">Verse: {{ ayah.ayah_id }}</h5>
          <h5 class="text-right">{{ ayah.ayah_text }}</h5>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import ErrorAlert from './ErrorAlert.vue'; // Import the ErrorAlert component

export default {
  name: 'AyatList',
  components: {
    ErrorAlert
  },
  props: {
    ayat: Array,
    selectedIndexAyah: Number,
    verseNumber: String,
    showError: Boolean
  },
  methods: {
    handleSearch() {
      this.$emit('search');
    },
    handleGoToFirstAyah() {
      this.$emit('go-to-first-ayah');
    },
    handleGoToPreviousAyah() {
      this.$emit('go-to-previous-ayah');
    },
    handleGoToNextAyah() {
      this.$emit('go-to-next-ayah');
    },
    handleGoToLastAyah() {
      this.$emit('go-to-last-ayah');
    },
    handleSelectAyah(index) {
      this.$emit('select-ayah', index);
    },
    handleDismissError() {
      this.$emit('dismiss-error');
    }
  }
};
</script>

<style scoped>
/* Add scoped styles if necessary */
</style>
