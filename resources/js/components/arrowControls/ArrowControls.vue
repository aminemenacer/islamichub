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
    surahs: {
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
      if (this.ayahs && this.ayahs.length > 0) {
        console.log('Going to the first Ayah');
        this.selectedIndexAyah = 0;
        this.updateAyah();
      } else {
        console.error('Ayahs are undefined or empty');
      }
    },
    goToPreviousAyah() {
      if (this.ayahs && this.ayahs.length > 0) {
        console.log('Going to the previous Ayah');
        if (this.selectedIndexAyah > 0) {
          this.selectedIndexAyah--;
        } else {
          // Logic to navigate to previous surah if available
        }
        this.updateAyah();
      } else {
        console.error('Ayahs are undefined or empty');
      }
    },
    goToNextAyah() {
      if (this.ayahs && this.ayahs.length > 0) {
        console.log('Going to the next Ayah');
        if (this.selectedIndexAyah < this.ayahs.length - 1) {
          this.selectedIndexAyah++;
        } else {
          // Logic to navigate to next surah if available
        }
        this.updateAyah();
      } else {
        console.error('Ayahs are undefined or empty');
      }
    },
    goToLastAyah() {
      if (this.ayahs && this.ayahs.length > 0) {
        console.log('Going to the last Ayah');
        this.selectedIndexAyah = this.ayahs.length - 1;
        this.updateAyah();
      } else {
        console.error('Ayahs are undefined or empty');
      }
    },
    updateAyah() {
      // Implement logic to update selected ayah
    }
  }
};
</script>

<style scoped>
/* Add your custom CSS styles here if needed */
</style>
