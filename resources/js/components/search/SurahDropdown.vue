<template>
  <div class="surah-dropdown">
    <!-- Dropdown for selecting a Surah -->
    <select
      style="border: 2px solid #00bfa6;"
      class="form-control custom-dropdown card"
      aria-label="Select a Surah"
      :value="selectedSurahLocal" 
      @change="handleChange"
    >
      <!-- Default option to prompt selection -->
      <option value="" disabled>Select a Surah:</option>

      <!-- Dynamically render options from displayedSurahs -->
      <option 
        v-for="surah in displayedSurahs" 
        :key="surah.id" 
        :value="surah.id"
      >
        {{ surah.id }} : {{ surah.name_en }} - {{ surah.name_ar }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: "SurahDropdown",

  // Props passed to this component
  props: {
    selectedSurah: {
      type: Number, // Expected as a number for compatibility
      default: null,
    },
    filteredSurah: {
      type: Array, // Array for filtered results
      default: () => [],
    },
    surat: {
      type: Array, // Array for all Surahs
      default: () => [],
    },
  },

  data() {
    return {
      // Local copy of selectedSurah to manage internal state
      selectedSurahLocal: this.selectedSurah || null,
      selectedSurahId: ""
    };
  },

  computed: {
    // Return the filteredSurah if available, otherwise use surat
    displayedSurahs() {
      return this.filteredSurah.length ? this.filteredSurah : this.surat;
    },
  },

  watch: {
    // Sync selectedSurah prop with local state
    selectedSurah(newVal) {
      if (newVal !== this.selectedSurahLocal) {
        this.selectedSurahLocal = newVal;
      }
    },
    selectedSurahId(newSurahId) {
      console.log("Selected Surah ID:", newSurahId); // Debug the selected Surah
      if (newSurahId) {
          this.fetchAyat(newSurahId);
      }
  },
  },

  methods: {
    // Handle dropdown value change
    handleChange(event) {
      const newValue = Number(event.target.value); // Convert value to number
      console.log("Selected Surah:", newValue); // Debug: Log selected value

      // Check if the new value is different from the current local state
      if (newValue !== this.selectedSurahLocal) {
        this.selectedSurahLocal = newValue; // Update local state
        this.$emit("update:selectedSurah", newValue); // Emit the updated value
        this.$emit("change"); // Emit a generic change event
      }
    },
  },
};
</script>

<style scoped>
.surah-dropdown {
  width: 100%; /* Full width for the dropdown */
}

.form-control {
  width: 100%; /* Match parent width */
  padding: 8px 12px; /* Add spacing inside the dropdown */
  font-size: 1rem; /* Standard font size */
  line-height: 1.5; /* Line spacing */
  background-color: #fff; /* White background */
  background-clip: padding-box;
  border-radius: 5px; /* Rounded corners */
  border: 3px solid #00bfa6; /* Custom border color */
  transition: border-color 0.15s ease-in-out; /* Smooth transition for hover */
}

.custom-dropdown {
  appearance: auto; /* Default browser dropdown styling */
  outline: none; /* Remove outline */
}

.card {
  display: flex; /* Flexbox for alignment */
  border: 3px solid #00bfa6; /* Consistent border */
  border-radius: 8px; /* Rounded corners */
}

.card:focus {
  border-color: #00bfa6; /* Highlighted border color */
  box-shadow: 0 0 0 0.2rem rgba(0, 191, 166, 0.25); /* Subtle focus shadow */
}
</style>
