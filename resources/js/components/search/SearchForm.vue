<template>
  <form class="search-form d-flex container h2" @submit.prevent="search">
    <input class="form-control me-2 display-1" type="search" id="search" name="search" v-model="searchTerm" placeholder="What do you want to read today?" autocomplete="off" @keyup="search">
    <button v-if="showClearButton" class="btn btn-outline-secondary h2" @click="clearResults">Clear</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      searchTerm: '',
      showClearButton: false
    };
  },
  methods: {
    search() {
      this.showClearButton = this.searchTerm.length > 0;
      this.$emit('search', this.searchTerm);
    },
    clearResults() {
      this.searchTerm = '';
      this.showClearButton = false;
      this.$emit('clear');
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