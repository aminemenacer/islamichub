<template>
  <div>
   <!-- This component does not render any UI, it only contains the watch properties -->
  </div>
</template>

<script>
export default {
  props: {
    information: {
      type: Object,
      required: true,
    },
    verseNumber: {
      type: [String, Number],
      default: null,
    },
  },
  watch: {
    'information.ayah.surah.name_ar': {
      handler() {
        this.$emit('update-file-name');
      },
      deep: true,
      immediate: true,  // To handle the case when the information prop is already set
    },
    verseNumber(newVal, oldVal) {
      if (newVal !== oldVal && !isNaN(parseInt(newVal))) {
        this.$emit('update-selected-index', parseInt(newVal) - 1);
      }
    },
  },
};
</script>

<style scoped>
/* Add your styles here if necessary */
</style>
