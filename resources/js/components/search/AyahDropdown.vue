<template>
  <div class="tab-content mb-1" id="nav-tabContent" v-if="!dropdownHidden">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
      <form style="cursor: pointer; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius:5px;">
        <select
          class="form-control mobile-only hide-on-full-screen hide-on-tablet right-side-form"
          v-model="selectedAyahId"
          @change="handleAyahChange"
          style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;"
        >
          <option value="0" disabled>
            Select Ayah
          </option>
          <option v-for="(ayah, index) in ayat" :key="index" :value="index">
            {{ ayah.ayah_text }} : {{ ayah.ayah_id }}
          </option>
        </select>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    selectedSurahId: {
      type: Number,
      required: true
    },
    dropdownHidden: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      selectedAyahId: 0,
      ayat: [],
      tafseer: null,
      information: null
    };
  },
  methods: {
    async handleAyahChange() {
      const selectedAyahIndex = parseInt(this.selectedAyahId);
      const selectedAyah = this.ayat[selectedAyahIndex];
      if (selectedAyah) {
        const ayahId = selectedAyah.ayah_id;
        try {
          const tafseerResponse = await axios.get(`/tafseer/${ayahId}/fetch`);
          this.tafseer = tafseerResponse.data;

          const infoResponse = await axios.get('/get_informations', {
            params: { id: ayahId },
          });
          this.information = infoResponse.data;

          // Emit the information and tafseer data to the parent component
          this.$emit('update-information', this.information);
          this.$emit('update-tafseer', this.tafseer);
        } catch (error) {
          console.error('Error fetching information or tafseer:', error);
        }
      }
    },
    async fetchAyat() {
      try {
        const response = await axios.get('/get_ayat', { params: { surah_id: this.selectedSurahId } });
        this.ayat = response.data;
      } catch (error) {
        console.error('Error fetching ayat:', error);
      }
    }
  },
  watch: {
    selectedSurahId: {
      handler(newValue) {
        if (newValue) {
          this.fetchAyat();
        }
      },
      immediate: true
    }
  }
};
</script>

<style scoped>
.tab-content {
  margin-bottom: 1rem;
}

.form-control {
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  border-radius: 5px;
}
</style>
