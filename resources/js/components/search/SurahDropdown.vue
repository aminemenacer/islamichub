<template>
  <form class="mb-2 right-side-form" style="cursor: pointer; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius:5px;">
    <select class="form-control custom-dropdown" v-model="selectedSurah" @change="getAyat" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
      <option value="0">
        <span disabled>Select Surah</span>
      </option>
      <option v-for="data in surats" :key="data.id" :value="data.id">
        {{ data.id }} : {{ data.name_en }} - {{ data.name_ar }}
      </option>
    </select>
  </form>
</template>

<script>
import axios from 'axios';

export default {
  name: 'SurahDropdown',
  props: {
    surats: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      selectedSurah: 0
    };
  },
  methods: {
    async getAyat() {
      if (this.selectedSurah > 0) {
        try {
          console.log(`Fetching ayahs for surat ${this.selectedSurah}`);
          const response = await axios.get(`/api/ayahs/${this.selectedSurah}`);
          this.$emit('update-ayahs', response.data);
          if (response.data.length > 0) {
            this.$emit('update-selected-ayah', response.data[0].id);
            this.$emit('update-selected-index-ayah', 0);
          }
        } catch (error) {
          console.error('Error fetching ayahs:', error);
        }
      } else {
        this.$emit('update-ayahs', []);
        this.$emit('update-selected-ayah', null);
        this.$emit('update-selected-index-ayah', null);
      }
    }
  }
};
</script>

<style scoped>
.right-side-form {
  padding: 10px;
}
.custom-dropdown {
  padding: 10px;
  border-radius: 5px;
}
</style>
