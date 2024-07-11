<template>
  <ul class="col-md-12 mt-1 scrollable-list" style="list-style-type: none; overflow-y: auto; max-height: 400px; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
    <li v-for="item in filteredSurah" :key="item.id" @click="selectSurah(item.id)" style="cursor: pointer; padding: 5px; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;" class="highlight-on-hover">
      <div style="display: flex; align-items: center;">
        <img src="/images/art.png" style="width: 23px" class="mb-1 mr-2" />
        <p style="font-size: 18px;" class="mt-2">{{ item.name_en }} - {{ item.name_ar }}</p>
      </div>
    </li>
  </ul>
</template>

<script>
import axios from 'axios';

export default {
  name: 'SurahList',
  props: {
    initialSurahs: Array,
    initialSurah: Number
  },
  data() {
    return {
      surahs: [],
      surah: this.initialSurah || null,
      ayahs: [],
      selectedAyah: null,
      selectedIndexAyah: null,
      maxLength: 100, // example default value
      information: { translation: '' } // example structure
    };
  },
  computed: {
    filteredSurah() {
      // Implement your filtering logic if needed
      return this.surahs;
    },
    filteredAyahs() {
      if (!this.surah) return [];
      return this.ayahs.filter(ayah => ayah.surah_id === this.surah);
    }
  },
  methods: {
    async fetchSurahs() {
      try {
        const response = await axios.get('/api/surahs');
        this.surahs = response.data;
        console.log('Fetched surahs:', this.surahs);
      } catch (error) {
        console.error('Error fetching surahs:', error);
      }
    },
    async getAyahs() {
      if (this.surah > 0) {
        try {
          const response = await axios.get(`/api/ayahs/${this.surah}`);
          this.ayahs = response.data;
          if (this.ayahs.length > 0) {
            this.selectedAyah = this.ayahs[0].id;
          }
        } catch (error) {
          console.error('Error fetching ayahs:', error);
        }
      } else {
        this.ayahs = [];
        this.selectedAyah = null;
      }
    },
    selectSurah(surahId) {
      this.surah = surahId;
      this.getAyahs();
    },
    // Additional methods related to Ayah and Surah
  },
  mounted() {
    this.fetchSurahs();
    if (this.surah) {
      this.getAyahs();
    }
  }
};
</script>

<style scoped>
/* Add scoped styles here if needed */
</style>
