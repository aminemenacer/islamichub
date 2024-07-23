<template>
  <div>
    <!-- Search Form -->
    <form class="d-flex pb-2" role="search" @submit.prevent="handleSearch">
      <input class="form-control me-2" type="number" placeholder="Enter Verse Number" v-model="verseNumber" required>
      <button class="btn btn-success mb-1 ml-2" type="submit">Search</button>
    </form>

    <!-- Error Alert -->
    <ErrorAlert :showError="showError" @dismiss-error="dismissError" />

    <div class="row container-fluid">
      <hr class="container" style="height: 4px; background: lightgrey;">

      <div class="icon-container pb-2">
        <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="$emit('go-to-first-ayah')" title="First verse"></i>
        <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="$emit('go-to-previous-ayah')" title="Previous verse"></i>
        <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="$emit('go-to-next-ayah')" title="Next verse"></i>
        <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="$emit('go-to-last-ayah')" title="Last verse"></i>
      </div>

      <div class="custom-scrollbar pb-5" style="overflow-y: auto; max-height: 600px; background: white;">
        <ul class="col-md-12 list-group container-fluid root" id="toggle" ref="ayahList" style="list-style-type: none; padding: 10px">
          <li v-for="(ayah, index) in ayat" :key="index" @click="selectAyah(index)" :class="{ selected: selectedIndexAyah === index, highlighted: parseInt(verseNumber) === ayah.ayah_id }" style="padding: 10px; border-radius:10px">
            <h5 class="text-right" style="display: flex;"> Verse: {{ ayah.ayah_id }} </h5>
            <h5 class="text-right">{{ ayah.ayah_text }}</h5>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    ayat: {
      type: Array,
      required: true
    },
    selectedIndexAyah: {
      type: Number,
      default: null
    },
    showError: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      verseNumber: null
    };
  },
  methods: {
    handleSearch() {
      this.$emit('scroll-to-ayah', this.verseNumber);
    },
    dismissError() {
      this.$emit('dismiss-error');
    },
    selectAyah(index) {
      this.$emit('select-ayah', index);
    }
  }
};
</script>

<style scoped>
/* Add your styles here if necessary */
</style>
