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

