<template>
  <!-- Ayah Dropdown -->
  <select
    class="form-control right-side-form card desktop-hidden mobile-visible"
    v-model="selectedAyahId"
    @change="handleAyahChange"
    style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px"
    :disabled="isLoading"
    :class="dropdownClasses"
  >
    <option value="">Select Ayah</option>
    <!-- Iterate over Ayat and display each in the dropdown -->
    <option
      v-for="ayah in ayat"
      :key="ayah.id"
      :value="ayah.id"
    >
      {{ ayah.ayah_text }} : {{ ayah.ayah_id }}
    </option>
  </select>
</template>

<script>
import axios from "axios";
import debounce from "lodash.debounce"; // Import lodash debounce to manage frequent calls

export default {
  props: {
    // Surah ID passed from the parent component
    selectedSurahId: {
      type: Number,
      required: true,
    },
    // Whether the dropdown should be hidden
    dropdownHidden: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      selectedAyahId: "", // Selected Ayah ID (default is empty)
      ayat: [], // Array of Ayat to display in the dropdown
      tafseer: null, // Tafseer data for the selected Ayah
      information: null, // Additional information for the selected Ayah
      highlightedAyahId: null, // Highlighted Ayah ID
      highlightedAyah: null, // Highlighted Ayah object
      isLoading: false, // Tracks loading state for dropdown and data
      cachedData: {}, // Cache for storing fetched data (tafseer, information)
    };
  },
  computed: {
    // Dynamically calculate dropdown visibility based on screen size and selected Surah
    dropdownClasses() {
      const isMobile = window.innerWidth <= 767; // Detect if device is mobile
      return {
        "desktop-hidden": !isMobile && !this.selectedSurahId,
        "mobile-visible": isMobile || this.selectedSurahId,
      };
    },
  },
  methods: {
    // Handle Ayah change when a new Ayah is selected
    async handleAyahChange() {
      if (!this.selectedAyahId) return; // Skip if no Ayah is selected

      // Check cache for the selected Ayah's data
      if (this.cachedData[this.selectedAyahId]) {
        const cached = this.cachedData[this.selectedAyahId];
        this.tafseer = cached.tafseer;
        this.information = cached.information;
        this.highlightedAyahId = this.selectedAyahId;
        this.highlightedAyah = this.ayat.find(ayah => ayah.id === this.selectedAyahId);
        return;
      }

      // Fetch data if not cached
      this.isLoading = true;
      try {
        const selectedAyah = this.ayat.find(ayah => ayah.id === this.selectedAyahId);
        if (!selectedAyah) return;

        const ayahId = selectedAyah.id;
        this.highlightedAyahId = ayahId;
        this.highlightedAyah = selectedAyah;

        // Fetch Tafseer and Information
        const [tafseerResponse, infoResponse] = await Promise.all([
          axios.get(`/tafseer/${ayahId}/fetch`),
          axios.get("/get_informations", { params: { id: ayahId } }),
        ]);

        this.tafseer = tafseerResponse.data;
        this.information = infoResponse.data;

        // Cache the fetched data
        this.cachedData[ayahId] = { tafseer: this.tafseer, information: this.information };

        // Emit data to the parent component
        this.$emit("update-information", this.information);
        this.$emit("update-tafseer", this.tafseer);
      } catch (error) {
        console.error("Error fetching information or tafseer:", error);
      } finally {
        this.isLoading = false; // Reset loading state
      }
    },

    // Fetch Ayat for the selected Surah (Debounced for performance)
    fetchAyat: debounce(async function () {
      this.isLoading = true;
      try {
        const response = await axios.get("/get_ayat", {
          params: { surah_id: this.selectedSurahId },
        });
        this.ayat = response.data;

        // Automatically select and highlight the first Ayah
        if (this.ayat.length > 0) {
          this.selectedAyahId = this.ayat[0].id; // Default selection
          this.handleAyahChange(); // Trigger loading of first Ayah's data
        }
      } catch (error) {
        console.error("Error fetching ayat:", error);
      } finally {
        this.isLoading = false;
      }
    }, 300), // Debounced with 300ms delay
  },
  watch: {
    // Watch for changes in the selected Surah and fetch corresponding Ayat
    selectedSurahId: {
      handler(newSurahId) {
        if (newSurahId) this.fetchAyat(); // Fetch Ayat when a Surah is selected
      },
      immediate: true, // Fetch Ayat immediately on mount
    },
  },
};
</script>

<style scoped>
.desktop-hidden {
  display: none;
}

@media (min-width: 768px) {
  .desktop-hidden {
    display: none; /* Hide on desktops if no Surah is selected */
  }
}

@media (max-width: 767px) {
  .mobile-visible {
    display: block; /* Always show dropdown on mobile */
  }
}

.highlighted-ayah {
  background-color: #26c789; /* Highlight color */
  padding: 10px;
  border-radius: 5px;
  font-weight: bold;
  margin-top: 20px;
}
</style>
