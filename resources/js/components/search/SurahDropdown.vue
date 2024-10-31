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
                v-for="data in (filteredSurah.length ? filteredSurah : surat)"
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
            selectedSurahLocal: this.selectedSurah ?? "", // Empty to ensure placeholder is shown
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
            // Update local selection to show placeholder if necessary
            this.selectedSurahLocal = newVal ?? "";
        },
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
