<template>
  <div v-show="showAyah" v-if="ayah && ayah.ayah_text" class="p-3 mb-2 bg-success-subtle text-success-emphasis" style="border-radius:5px; border: 1px solid #00BFA6;">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <h4 class="card-title text-center pb-2">
          <b class="text-center pb-1 pt-1">Ayah of the Day</b>
        </h4>
      </div>
      <div class="col-md-3"></div>
      <div class="col-md-1">
        <i class="bi bi-x h5" style="cursor:pointer" @click="closeAyah"></i>
      </div>
    </div>
    <h5 class="card-text container text-right pt-2" style="line-height:1.4em">"{{ ayah.ayah_text }}"</h5>
    <h6 class="container text-left">
      "{{ translation }}"
    </h6>
    <audio :src="ayah.audio_links" class="w-100 custom-audio container pb-1" controls></audio>
  </div>
</template>

<script>
export default {
  props: {
    ayat: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      showAyah: true,
      ayah: null,
      translation: 'Translation unavailable for this ayah.',
    };
  },
  created() {
    this.getRandomAyah();
    this.interval = setInterval(this.getRandomAyah, 5000); // Refresh every 30 seconds
  },
  beforeDestroy() {
    clearInterval(this.interval); // Clear interval on component destruction
  },
  methods: {
    getRandomAyah() {
      if (this.ayat.length > 0) {
        const randomIndex = Math.floor(Math.random() * this.ayat.length);
        const selectedAyah = this.ayat[randomIndex];
        if (selectedAyah) {
          this.ayah = selectedAyah;
          this.translation = selectedAyah.translation || 'Translation unavailable for this ayah.';
        }
      }
    },
    closeAyah() {
      this.showAyah = false; // Set the flag to false to hide the div
    },
  },
};
</script>

<style scoped>
</style>
