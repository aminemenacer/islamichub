<template>
  <div>
    <form class="d-flex pb-2" role="search" @submit.prevent="scrollToAyah">
      <input class="form-control me-2" type="number" placeholder="Enter Verse Number" v-model="verseNumber" required>
      <button class="btn btn-success mb-1 ml-2" type="submit">Search</button>
    </form>

    <!-- Bootstrap error alert -->
    <div v-if="internalShowError" class="alert alert-danger alert-dismissible fade show" role="alert">
      Please enter a valid ayah number.
      <button type="button" class="btn-close" @click="dismissError" aria-label="Close"></button>
    </div>

    <div class="row container-fluid">
      <hr class="container" style="height: 4px; background: lightgrey;">

      <div class="icon-container pb-2">
        <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToFirstAyah" title="First verse"></i>
        <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToPreviousAyah" title="Previous verse"></i>
        <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToNextAyah" title="Next verse"></i>
        <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToLastAyah" title="Last verse"></i>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    ayat: Array,
    selectedIndexAyah: Number,
    showError: Boolean
  },
  data() {
    return {
      verseNumber: '',
      internalShowError: this.showError
    };
  },
  watch: {
    showError(newValue) {
      this.internalShowError = newValue;
    }
  },
  methods: {
    scrollToAyah() {
      const ayahIndex = this.ayat.findIndex(ayah => ayah.ayah_id === parseInt(this.verseNumber));
      if (ayahIndex !== -1) {
        this.$emit('select-ayah', ayahIndex);
        this.internalShowError = false;
        this.$emit('update:showError', false);
        this.scrollToSelectedAyah();
      } else {
        this.internalShowError = true;
        this.$emit('update:showError', true);
        setTimeout(() => {
          this.internalShowError = false;
          this.$emit('update:showError', false);
        }, 5000);
      }
    },
    dismissError() {
      this.internalShowError = false;
      this.$emit('update:showError', false);
    },
    goToFirstAyah() {
      this.$emit('select-ayah', 0);
      this.scrollToSelectedAyah();
    },
    goToPreviousAyah() {
      if (this.selectedIndexAyah > 0) {
        this.$emit('select-ayah', this.selectedIndexAyah - 1);
        this.scrollToSelectedAyah();
      }
    },
    goToNextAyah() {
      if (this.selectedIndexAyah < this.ayat.length - 1) {
        this.$emit('select-ayah', this.selectedIndexAyah + 1);
        this.scrollToSelectedAyah();
      }
    },
    goToLastAyah() {
      this.$emit('select-ayah', this.ayat.length - 1);
      this.scrollToSelectedAyah();
    },
    scrollToSelectedAyah() {
      this.$nextTick(() => {
        const selectedAyah = this.$refs.ayahList.querySelector('.selected');
        if (selectedAyah) {
          selectedAyah.scrollIntoView({ behavior: 'smooth' });
        } else {
          this.internalShowError = true;
          this.$emit('update:showError', true);
          setTimeout(() => {
            this.internalShowError = false;
            this.$emit('update:showError', false);
          }, 5000);
        }
      });
    }
  }
};
</script>

<style scoped>
.icon-container {
  display: flex;
  justify-content: space-between;
  padding: 10px;
}

.alert {
  margin-top: 10px;
}
</style>

