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
    <!-- Iterate over ayat and display each in the dropdown -->
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
import debounce from 'lodash.debounce';  // Import lodash debounce to prevent frequent API calls

export default {
    props: {
        selectedSurahId: {
            type: Number,
            required: true,
        },
        dropdownHidden: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            selectedAyahId: "", // Default value is an empty string to signify no selection
            ayat: [],
            tafseer: null,
            information: null,
            highlightedAyahId: null,
            highlightedAyah: null,
            isLoading: false, // Track loading state
            cachedData: {}, // Cache for storing previously fetched tafseer and information
        };
    },
    computed: {
        dropdownClasses() {
            const isMobile = window.innerWidth <= 767;
            // Hide dropdown on desktop/tablet if no Surah is selected
            return {
                'desktop-hidden': !isMobile && !this.selectedSurahId,
                'mobile-visible': isMobile || this.selectedSurahId, // Always visible on mobile or if Surah selected
            };
        },
    },
    methods: {
        async handleAyahChange() {
            if (!this.selectedAyahId) {
                return; // No Ayah selected, do not proceed
            }

            if (this.cachedData[this.selectedAyahId]) {
                const cached = this.cachedData[this.selectedAyahId];
                this.tafseer = cached.tafseer;
                this.information = cached.information;
                this.highlightedAyahId = this.selectedAyahId;
                this.highlightedAyah = this.ayat.find(ayah => ayah.id === this.selectedAyahId);
                return;
            }

            this.isLoading = true;

            const selectedAyah = this.ayat.find(ayah => ayah.id === this.selectedAyahId);
            if (selectedAyah) {
                const ayahId = selectedAyah.id;
                this.highlightedAyahId = ayahId;
                this.highlightedAyah = selectedAyah;

                try {
                    // Fetch tafseer and information based on the selected Ayah ID
                    const tafseerResponse = await axios.get(`/tafseer/${ayahId}/fetch`);
                    const infoResponse = await axios.get("/get_informations", {
                        params: { id: ayahId },
                    });

                    this.tafseer = tafseerResponse.data;
                    this.information = infoResponse.data;

                    // Cache the data for future use
                    this.cachedData[ayahId] = { tafseer: this.tafseer, information: this.information };

                    // Emit the information and tafseer data to the parent component
                    this.$emit("update-information", this.information);
                    this.$emit("update-tafseer", this.tafseer);
                } catch (error) {
                    console.error("Error fetching information or tafseer:", error);
                } finally {
                    this.isLoading = false;
                }
            }
        },

        // Debounced version of fetchAyat to avoid frequent API calls
        fetchAyat: debounce(async function() {
            try {
                this.isLoading = true;
                const response = await axios.get("/get_ayat", {
                    params: { surah_id: this.selectedSurahId },
                });
                this.ayat = response.data;

                // Automatically select and display the first Ayah if available
                if (this.ayat.length > 0) {
                    this.selectedAyahId = this.ayat[0].id; // Select the first Ayah by default
                    this.handleAyahChange(); // Trigger Ayah change to load its content
                }
            } catch (error) {
                console.error("Error fetching ayat:", error);
            } finally {
                this.isLoading = false;
            }
        }, 300),  // Adjust debounce time as needed
    },
    watch: {
        selectedSurahId: {
            handler(newValue) {
                if (newValue) {
                    this.fetchAyat();  // Call debounced function to fetch Ayat
                }
            },
            immediate: true,
        },
    },
};
</script>

<style scoped>
.desktop-hidden {
  display: none;
}

@media (min-width: 768px) {
  /* Hide AyahDropdown on desktop/tablet if no Surah is selected */
  .desktop-hidden {
    display: none;
  }
}

@media (max-width: 767px) {
  /* Always show AyahDropdown on mobile (screens smaller than 768px) */
  .mobile-visible {
    display: block;
  }
}

.highlighted-ayah {
    background-color: #26c789; /* Light blue background to indicate highlight */
    padding: 10px;
    border-radius: 5px;
    font-weight: bold;
    margin-top: 20px;
}
</style>
