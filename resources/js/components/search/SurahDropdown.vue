<template>
  <form class="mb-2 right-side-form" style="cursor: pointer; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;">
    <select class="form-control custom-dropdown" v-model="selectedSurah" @change="emitChange" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
      <option value="0" disabled>Select Surah</option>
      <option v-for="data in filteredSurah.length ? filteredSurah : surat" :key="data.id" :value="data.id">
        {{ data.id }} : {{ data.name_en }} - {{ data.name_ar }}
      </option>
    </select>
  </form>
</template>

<script>
export default {
  name: 'SurahDropdown',
  props: {
    selectedSurah: {
      type: Number,
      required: true
    },
    filteredSurah: {
      type: Array,
      required: true
    },
    surat: {
      type: Array,
      required: true
    }
  },
  methods: {
    emitChange() {
      this.$emit('change-surah');
    }
  }
}
</script>

<style scoped>
/* Add your styles here */
</style>
