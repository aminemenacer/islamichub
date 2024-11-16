<template>
  <div class="surah-dropdown">
    <!-- Direct binding to selectedSurahLocal without v-model -->
    <select
      class="form-control custom-dropdown card"
      aria-label="Select a Surah"
      :value="selectedSurahLocal" 
      @change="handleChange"
    >
      <option value="" disabled>Select a Surah:</option>
      <option v-for="surah in displayedSurahs" 
              :key="surah.id" 
              :value="surah.id">
        {{ surah.id }} : {{ surah.name_en }} - {{ surah.name_ar }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: "SurahDropdown",

  props: {
    selectedSurah: {
      type: Number,
      default: null,
    },
    filteredSurah: {
      type: Array,
      default: () => [],
    },
    surat: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
      // Initialize the local selection value based on the selectedSurah prop
      selectedSurahLocal: this.selectedSurah || null, 
    };
  },

  computed: {
    // Directly return filteredSurah or surat without additional calculations
    displayedSurahs() {
      return this.filteredSurah.length ? this.filteredSurah : this.surat;
    },
  },

  watch: {
    // Watch selectedSurah prop and update local value to avoid mismatch
    selectedSurah(newVal) {
      if (newVal !== this.selectedSurahLocal) {
        this.selectedSurahLocal = newVal;
      }
    },
  },

  methods: {
    handleChange(event) {
      const newValue = event.target.value;

      // Only emit the value change if it is different from the previous selection
      if (Number(newValue) !== this.selectedSurahLocal) {
        this.$emit("update:selectedSurah", Number(newValue) || null);
        this.$emit("change");
      }
    },
  },
};
</script>

<style scoped>
.surah-dropdown {
  width: 100%;
}

.form-control {
  width: 100%;
  padding: 8px 12px;
  font-size: 1rem;
  line-height: 1.5;
  background-color: #fff;
  background-clip: padding-box;
  border-radius: 5px;
  transition: border-color 0.15s ease-in-out;
}

.custom-dropdown {
  appearance: auto;
  outline: none;
}

.card {
  display: flex;
  border: 1px solid #00bfa6;
  border-radius: 10px;
}

.card:focus {
  border-color: #00bfa6;
  box-shadow: 0 0 0 0.2rem rgba(0, 191, 166, 0.25);
}
</style>
