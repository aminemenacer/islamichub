<template>
  <div>
    <!-- Surah Selection Dropdown -->
    <form class="mb-2 right-side-form">
      <select class="form-control custom-dropdown" v-model="selectedSurahId" @change="getAyat">
        <option value="0" disabled>Select Surah</option>
        <option v-for="surah in filteredSurah.length ? filteredSurah : surat" :key="surah.id" :value="surah.id">
          {{ surah.id }} : {{ surah.name_en }} - {{ surah.name_ar }}
        </option>
      </select>
    </form>

    <!-- Ayah Selection Dropdown -->
    <form v-if="!dropdownHidden" class="mt-2">
      <select class="form-control custom-dropdown" v-model="selectedAyahId" @change="handleAyahChange">
        <option value="0" disabled>Select Ayah</option>
        <option v-for="(ayah, index) in ayat" :key="index" :value="ayah.id">{{ ayah.ayah_text }} : {{ ayah.ayah_id }}</option>
      </select>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'SurahDropdown',
  props: {
    filteredSurah: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      surat: [],
      ayat: [],
      selectedSurahId: 0,
      selectedAyahId: 0,
      dropdownHidden: true,
      information: null,
      tafseer: null
    };
  },
  mounted() {
    this.getSurat();
  },
  methods: {
    async getSurat() {
      try {
        const response = await axios.get('/get_surat');
        this.surat = response.data;
      } catch (error) {
        console.error('Error fetching surahs:', error);
      }
    },
    async getAyat() {
      if (this.selectedSurahId > 0) {
        try {
          const response = await axios.get('/get_ayat', {
            params: { surah_id: this.selectedSurahId }
          });
          this.ayat = response.data;
          this.dropdownHidden = false;
        } catch (error) {
          console.error('Error fetching ayat:', error);
        }
      } else {
        this.ayat = [];
        this.dropdownHidden = true;
      }
    },
    async handleAyahChange() {
      const selectedAyah = this.ayat.find(ayah => ayah.id === this.selectedAyahId);
      if (selectedAyah) {
        try {
          const tafseerResponse = await axios.get(`/tafseer/${this.selectedAyahId}/fetch`);
          this.tafseer = tafseerResponse.data;

          const infoResponse = await axios.get('/get_informations', {
            params: { id: this.selectedAyahId }
          });
          this.information = infoResponse.data;

          this.$emit('updateInformation', this.information);
          this.$emit('updateTafseer', this.tafseer);
        } catch (error) {
          console.error('Error fetching information or tafseer:', error);
        }
      }
    },
    
  }
};
</script>

<style scoped>
.mb-2 {
  margin-bottom: 1rem;
}
.right-side-form {
  cursor: pointer;
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  border-radius: 5px;
}
.custom-dropdown {
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}
.mt-2 {
  margin-top: 0.5rem;
}
</style>