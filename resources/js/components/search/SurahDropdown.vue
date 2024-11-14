<template>
    <div class="surah-dropdown">
        <form class="right-side-form" @submit.prevent>

            <select class="form-control custom-dropdown card" aria-label="Default select example" v-model="selectedSurahLocal" @change="handleChange">
                <option value="defaultOption" selected disabled>Please select a Surah:</option>
                <option v-for="surah in displayedSurahs"
                    :key="surah.id"
                    :value="surah.id">{{ surah.id }} : {{ surah.name_en }} - {{ surah.name_ar }}</option>
            </select>

        </form>
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
            selectedSurahLocal: "defaultOption", // Start with an empty string if no surah is selected
        };
    },

    computed: {
        displayedSurahs() {
            return this.filteredSurah.length ? this.filteredSurah : this.surat;
        },
    },

    methods: {
        handleChange(event) {
            const value = event.target.value;
            this.selectedSurahLocal = value;
            this.$emit("update:selectedSurah", value ? Number(value) : null);
            this.$emit("change");
        },
    },
};
</script>

<style scoped>
.surah-dropdown {
    width: 100%;
}

.right-side-form {
    cursor: pointer;
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