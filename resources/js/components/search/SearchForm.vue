<template>
  <form class="search-form d-flex container h2" @submit.prevent="search">
    <input class="form-control me-2 display-3" type="search" id="search" name="search" v-model="searchTerm" placeholder="What do you want to read today?" autocomplete="off" @keyup="search">
    <button v-if="showClearButton" class="btn btn-outline-secondary h2" @click="clearResults">Clear</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      showClearButton: false,
      searchTerm: '',
      filteredSurah: [], // Ensure this is initialized as an array
      surahs: []
    };
  },
  methods: {
    search() {
      const searchTerm = this.searchTerm.trim().toLowerCase();
      if (searchTerm === '') {
        this.filteredSurah = [];
        this.showClearButton = false;
        return;
      }
      
      // Ensure surahs is defined and has data before filtering
      if (!Array.isArray(this.surahs)) {
        console.error('Error: surahs is not an array');
        return;
      }

      // Filter surahs based on search term
      this.filteredSurah = this.surahs.filter(surah => {
        const nameEn = surah.name_en.toLowerCase();
        const nameAr = surah.name_ar.toLowerCase();
        return nameEn.includes(searchTerm) || nameAr.includes(searchTerm);
      });

      this.showClearButton = true;
    },
    clearResults() {
      this.searchTerm = '';
      this.filteredSurah = [];
      this.showClearButton = false;
    }
  }
};
</script>

<style scoped>
/* Add your custom CSS styles here if needed */
</style>
