<!-- AyahOfTheDay.vue -->
<template>
  <div v-if="ayah && ayah.ayah_text" class="p-3 mb-2 bg-success-subtle text-success-emphasis" style="border:2px; border-radius:5px;border: 1px solid #00BFA6;" >
    <h4 class="card-title text-center pb-2"><b class="text-center pb-1 pt-1">Ayah of the Day</b></h4>
    <h5 class="card-text container text-right" style="line-height:1.4em">"{{ ayah.ayah_text }}"</h5>
    <h6 class="container text-left container">"{{ ayah.translation || 'Translation unavailable for this ayah.' }}"</h6>
    <!-- <audio :src="ayah.audio_links" class='w-100 custom-audio container pb-1' controls></audio> -->
  </div>
</template>

<script>
export default {
  props: {
    ayat: {
      type: Array,
      required: true,
    },
    ayat: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      ayah: null, // Initialize ayah as null
      translation: '',
      information: {
        ayah: {
          surah: {
            name_en: '', // Initialize as required
          },
          ayah_text: '', // Example ayah text
        },
        translation: '', // Example translation
        transliteration: '', // Example transliteration
      },
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
          console.log("Selected Ayah:", this.ayah); // Check if ayah object includes translation
          console.log("Translation:", this.translation); // Log translation to ensure it's set
        }
      }
    },
  },
};
</script>

<style scoped>
audio.custom-audio {
  width: 100% !important;
  background-color: #0fa59163 !important;
  border: none !important;
  border-radius: 8px !important;
  bottom: 0px;
}

/* Custom styling for WebKit audio controls, specific to .custom-audio class */
.custom-audio::-webkit-media-controls-panel {
  background-color: #0fa59163 !important;
}

.custom-audio::-webkit-media-controls-play-button,
.custom-audio::-webkit-media-controls-mute-button,
.custom-audio::-webkit-media-controls-seek-back-button,
.custom-audio::-webkit-media-controls-seek-forward-button,
.custom-audio::-webkit-media-controls-rewind-button,
.custom-audio::-webkit-media-controls-return-to-realtime-button,
.custom-audio::-webkit-media-controls-toggle-closed-captions-button {
  color: white !important;
}

.custom-audio::-webkit-media-controls-timeline-container {
  background-color: #ebebeb !important;
}

.custom-audio::-webkit-media-controls-current-time-display,
.custom-audio::-webkit-media-controls-time-remaining-display {
  color: rgb(0, 0, 0) !important;
}

/* .custom-audio::-webkit-media-controls-timeline {
  background-color: #00574a !important;
} */

.custom-audio::-webkit-media-controls-volume-slider-container {
  background-color: #ffffff !important;
}

.custom-audio::-webkit-media-controls-volume-slider {
  background-color: #008c7a !important;
}
</style>
