<template>
  <form class="d-flex pb-2 card" role="search" @submit.prevent="onSubmit">
    <input class="form-control me-2" type="number" placeholder="Enter Verse Number" v-model.number="localVerseNumber" required>
    <button class="btn btn-success mb-1 ml-2" type="submit">Search</button>
  </form>
</template>

<script>
export default {
  name: 'SearchForm',
  props: {
    verseNumber: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      localVerseNumber: this.verseNumber
    };
  },
  methods: {
    onSubmit() {
      if (this.localVerseNumber) {
        this.$emit('submit', this.localVerseNumber);
      }
    }
  },
  watch: {
    verseNumber(newValue) {
      this.localVerseNumber = newValue;
    }
  }
};
</script>

<style scoped>
.card {
 display: flex;
 border: 3px solid #00BFA6;
 border-radius: 10px;
}
</style>
