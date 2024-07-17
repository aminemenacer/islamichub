<template>
  <div class="icon-container pb-2">
    <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToFirstAyah" title="First verse"></i>
    <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToPreviousAyah" title="Previous verse"></i>
    <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToNextAyah" title="Next verse"></i>
    <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToLastAyah" title="Last verse"></i>
  </div>
</template>

<script>
export default {
  props: {
    surah: {
      type: Array,
      required: true
    },
    selectedSurah: {
      type: [String, Number],
      required: true
    },
    ayahs: {
      type: Array,
      required: true
    }
  },
  methods: {
    goToFirstAyah() {
   this.selectAyah(0);
  },
  goToPreviousAyah() {
   if (this.selectedIndexAyah > 0) {
    this.selectAyah(this.selectedIndexAyah - 1);
   } else {
    this.selectAyah(this.ayahs.length - 1);
   }
  },
  goToNextAyah() {
   if (this.selectedIndexAyah < this.ayahs.length - 1) {
    this.selectAyah(this.selectedIndexAyah + 1);
   } else {
    this.selectAyah(0);
   }
  },
  goToLastAyah() {
   this.selectAyah(this.ayahs.length - 1);
  },
  }
};
</script>

<style scoped>
/* Add your custom CSS styles here if needed */
</style>
