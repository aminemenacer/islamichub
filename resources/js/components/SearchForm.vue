<template>
  <form class="search-form d-flex pb-1 pt-2 container" @submit.prevent="search">
   <input class="form-control me-2" type="search" id="search" name="search" v-model="searchTerm" placeholder="What do you want to read?" autocomplete="off" @keyup="search">
   <button v-if="showClearButton" class="btn btn-outline-secondary" @click="clearResults">Clear</button>
 </form>
</template>

<script>
export default {
  data() {
    return {
      searchTerm: '',
      showClearButton: false,
    };
  },
  methods: {
    search() {
      // Handle the search functionality
      console.log('Searching for:', this.searchTerm);
      this.showClearButton = this.searchTerm.length > 0;
    },
    clearResults() {
      this.searchTerm = '';
      this.showClearButton = false;
    }
  }
};
</script>

<style scoped>
.search-form {
  color: rgba(0, 191, 166);
}
.search-form .form-control {
  box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
  border-radius: 10px;
}
</style>
