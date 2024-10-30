<template>
    <form
        class="right-side-form"
        style="cursor: pointer; border-radius: 5px;"
    >
        <select
            class="form-control custom-dropdown card"
            v-model="selectedSurahLocal"
            @change="handleChange"
        >
            <!-- Default placeholder option -->
            <option value="" disabled>Select a Surah</option>
            <!-- Dynamic options for surahs -->
            <option
                v-for="data in filteredSurah.length ? filteredSurah : surat"
                :key="data.id"
                :value="data.id"
            >
                {{ data.id }} : {{ data.name_en }} - {{ data.name_ar }}
            </option>
        </select>
    </form>
</template>

<script>
export default {
    name: "SurahDropdown",
    props: {
        selectedSurah: {
            type: Number,
            default: null, // Default to null
        },
        filteredSurah: Array,
        surat: Array,
    },
    data() {
        return {
            selectedSurahLocal: this.selectedSurah || "", // Empty to start with "Select a Surah"
        };
    },
    methods: {
        handleChange() {
            this.$emit("update:selectedSurah", this.selectedSurahLocal);
            this.$emit("change");
        },
    },
    watch: {
        selectedSurah(newVal) {
            // Sync changes from parent to child, defaulting to ""
            this.selectedSurahLocal = newVal || "";
        },
    },
    mounted() {
        // Ensure selectedSurahLocal is set to "" if the prop is initially null or undefined
        if (!this.selectedSurah) {
            this.selectedSurahLocal = "";
        }
    },
};
</script>

<style scoped>
.card {
    display: flex;
    border: 1px solid #00BFA6;
    border-radius: 10px;
}
</style>
