<template>
    <select
        class="form-control mobile-only hide-on-full-screen hide-on-tablet right-side-form card"
        v-model="selectedAyahId"
        @change="handleAyahChange"
        style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px"
    >
        <option>Select Ayah</option>
        <option
            v-for="(ayah, index) in ayat"
            :key="index"
            :value="index"
        >
            {{ ayah.ayah_text }} : {{ ayah.ayah_id }}
        </option>
    </select>

    <!-- Section to display the selected Ayah and additional information -->
    
</template>

<script>
import axios from "axios";

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
            selectedAyahId: 0,
            ayat: [],
            tafseer: null,
            information: null,
            highlightedAyahId: null,
            highlightedAyah: null,
        };
    },
    methods: {
        async handleAyahChange() {
            const selectedAyahIndex = parseInt(this.selectedAyahId);
            const selectedAyah = this.ayat[selectedAyahIndex];
            if (selectedAyah) {
                const ayahId = selectedAyah.id;
                this.highlightedAyahId = ayahId;
                this.highlightedAyah = selectedAyah;

                try {
                    const tafseerResponse = await axios.get(
                        `/tafseer/${ayahId}/fetch`
                    );
                    this.tafseer = tafseerResponse.data;

                    const infoResponse = await axios.get("/get_informations", {
                        params: { id: ayahId },
                    });
                    this.information = infoResponse.data;

                    // Emit the information and tafseer data to the parent component
                    this.$emit("update-information", this.information);
                    this.$emit("update-tafseer", this.tafseer);
                } catch (error) {
                    console.error(
                        "Error fetching information or tafseer:",
                        error
                    );
                }
            }
        },
        async fetchAyat() {
            try {
                const response = await axios.get("/get_ayat", {
                    params: { surah_id: this.selectedSurahId },
                });
                this.ayat = response.data;

                // Automatically select and display the first Ayah if available
                if (this.ayat.length > 0) {
                    this.selectedAyahId = 0; // Select the first Ayah by default
                    this.handleAyahChange(); // Trigger Ayah change to load its content
                }
            } catch (error) {
                console.error("Error fetching ayat:", error);
            }
        },
    },
    watch: {
        selectedSurahId: {
            handler(newValue) {
                if (newValue) {
                    this.fetchAyat();
                }
            },
            immediate: true,
        },
    },
};
</script>

<style>
.highlighted-ayah {
    background-color: #26c789; /* Light blue background to indicate highlight */
    padding: 10px;
    border-radius: 5px;
    font-weight: bold;
    margin-top: 20px;
}
</style>
