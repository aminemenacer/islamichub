<template>
    <form
        class="mb-2 right-side-form"
        style="
            cursor: pointer;
            border-radius: 5px;
        "
    >
        <select
            class="form-control custom-dropdown"
            v-model="selectedSurahLocal"
            @change="handleChange"
        >
            <option value="0" disabled>Select Surah</option>
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
        selectedSurah: Number,
        filteredSurah: Array,
        surat: Array,
    },
    data() {
        return {
            selectedSurahLocal: this.selectedSurah,
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
            this.selectedSurahLocal = newVal;
        },
    },
};
</script>

<style scoped>
/* Add scoped styles if necessary */
</style>
