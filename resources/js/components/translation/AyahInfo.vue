<template>
  <div class="container">
    <h5 class="mr-2 container">
      <p class="container"> {{ information.ayah.surah.name_en }} {{ information.ayah.surah_id }}: {{ information.ayah.ayah_id }} {{ information.ayah.surah.name_ar}}</p>
    </h5>
  </div>
</template>

<script>
export default {
  name: 'AyahInfo',
  props: {
    information: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped>

.mr-2 {
  margin-right: 10px;
}
</style>