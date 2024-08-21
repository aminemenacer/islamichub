<template>
  <div>
    <!-- Button to Trigger Modal -->
    <button style="background-color: rgba(0, 191, 166, 0.452); cursor:pointer; font-style:bolder" class="bi bi-shuffle h1 button-63" data-bs-toggle="modal" data-bs-target="#verseModal" @click="startInterval">
    </button>

    <!-- Modal -->
    <div class="modal fade" id="verseModal" tabindex="-1" aria-labelledby="verseModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="verseModalLabel">Verse of the Day</h5>
            <div style="background-color: rgba(0, 191, 166, 0.452); cursor:pointer" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="stopInterval"></div>
          </div>
          <div class="modal-body" v-if="currentVerse">
            <p><strong>Ayah: </strong> {{ currentVerse.ayah_text }}</p>
            <p><strong>Translation: </strong> {{ currentVerse.translation }}</p>
            <!--
            <audio :src="currentVerse.audio_links" controls></audio>
            -->
          </div>
          <div class="modal-body" v-else>
            <p>Loading...</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      verses: [],
      translations: [],
      currentVerse: null,
      intervalId: null
    };
  },
  async created() {
    await this.fetchVerses();
    await this.fetchTranslations();
  },
  methods: {
    async fetchVerses() {
      try {
        const response = await axios.get('/verses');
        this.verses = response.data.verses;
      } catch (error) {
        console.error('Error fetching verses:', error);
      }
    },
    async fetchTranslations() {
      try {
        const response = await axios.get('/translations');
        this.translations = response.data.translations;
      } catch (error) {
        console.error('Error fetching translations:', error);
      }
    },
    getRandomVerse() {
      if (this.verses.length > 0 && this.translations.length > 0) {
        const randomIndex = Math.floor(Math.random() * this.verses.length);
        const selectedVerse = this.verses[randomIndex];
        const translation = this.translations.find(t => t.ayah_id === selectedVerse.ayah_id)?.translation;

        this.currentVerse = {
          ...selectedVerse,
          translation,
        };
      }
    },
    startInterval() {
      this.getRandomVerse(); // Show a verse immediately when modal opens
      this.intervalId = setInterval(this.getRandomVerse, 50000); // Change verse every 5 seconds
    },
    stopInterval() {
      clearInterval(this.intervalId);
    }
  },
  beforeUnmount() {
    this.stopInterval(); // Clear interval when component is destroyed to avoid memory leaks
  }
};
</script>

<style scoped>
.button-63 {
  align-items: center;
  background-image: linear-gradient(144deg,#AF40FF, #5B42F3 50%,#00DDEB);
  border: 0;
  border-radius: 7px;
  box-sizing: border-box;
  color: #FFFFFF;
  display: flex;
  font-family: Phantomsans, sans-serif;
  font-size: 18px;
  justify-content: center;
  line-height: 1em;
  padding: 15px;
  text-decoration: none;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  white-space: nowrap;
  cursor: pointer;
}
</style>
