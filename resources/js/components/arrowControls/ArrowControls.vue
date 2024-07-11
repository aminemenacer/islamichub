<template>
  <div class="icon-container pb-2">    
    <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToFirstAyah" title="First verse"></i>
    <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToPreviousAyah" title="Previous verse"></i>
    <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToNextAyah" title="Next verse"></i>
    <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToLastAyah" title="Last verse"></i>
  </div>
</template>

<script>
export default {
  methods: {
    goToFirstAyah() {
      this.$emit('go-to-first-ayah');
    },
    goToPreviousAyah() {
      this.$emit('go-to-previous-ayah');
    },
    goToNextAyah() {
      this.$emit('go-to-next-ayah');
    },
    goToLastAyah() {
      this.$emit('go-to-last-ayah');
    }
  }
};
</script>

<style scoped>
/* Add scoped styles if necessary */
</style>
