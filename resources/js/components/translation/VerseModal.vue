<template>
  <div>
    <!-- Button to Trigger Modal -->
    <button style="background-color: rgba(0, 191, 166, 0.452); cursor:pointer" class="bi bi-shuffle h3 button-63" data-bs-toggle="modal" data-bs-target="#verseModal" @click="startInterval">
      Verse of the day
    </button>


    <!-- Modal -->
    <div class="modal fade" id="verseModal" tabindex="-1" aria-labelledby="verseModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="verseModalLabel">Random Quran Verse of the Day</h5>
            <div style="background-color: rgba(0, 191, 166, 0.452); cursor:pointer" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="stopInterval"></div>
          </div>
          <div class="modal-body" v-if="currentVerse">
            <p><strong>Ayah: </strong> {{ currentVerse.text }}</p>
            <p><strong>Translation: </strong> {{ currentVerse.translation }}</p>
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
export default {
  data() {
    return {
      verses: [
        { surah_id: 1, ayah_id: 1, text: 'بِسمِ اللَّهِ الرَّحمٰنِ الرَّحيمِ' },
        { surah_id: 1, ayah_id: 2, text: 'الحَمدُ لِلَّهِ رَبِّ العٰلَمينَ' },
        { surah_id: 1, ayah_id: 3, text: 'الرَّحمٰنِ الرَّحيمِ' },
        { surah_id: 1, ayah_id: 4, text: 'مٰلِكِ يَومِ الدّينِ' },
        { surah_id: 1, ayah_id: 5, text: 'إِيّاكَ نَعبُدُ وَإِيّاكَ نَستَعينُ' },
        { surah_id: 1, ayah_id: 6, text: 'اهدِنَا الصِّرٰطَ المُستَقيمَ' },
        { surah_id: 1, ayah_id: 7, text: 'صِرٰطَ الَّذينَ أَنعَمتَ عَلَيهِم غَيرِ المَغضوبِ عَلَيهِم وَلَا الضّالّينَ' },
        { surah_id: 2, ayah_id: 1, text: 'بِسمِ اللَّهِ الرَّحمٰنِ الرَّحيمِ الم' },
        { surah_id: 2, ayah_id: 2, text: 'ذٰلِكَ الكِتٰبُ لا رَيبَ فيهِ هُدًى لِلمُتَّقينَ' },
        { surah_id: 2, ayah_id: 3, text: 'الَّذينَ يُؤمِنونَ بِالغَيبِ وَيُقيمونَ الصَّلوٰةَ وَمِمّا رَزَقنٰهُم يُنفِقونَ' },
        { surah_id: 2, ayah_id: 4, text: 'وَالَّذينَ يُؤمِنونَ بِما أُنزِلَ إِلَيكَ وَما أُنزِلَ مِن قَبلِكَ وَبِالءاخِرَةِ هُم يوقِنونَ' },
        { surah_id: 2, ayah_id: 5, text: 'أُولٰئِكَ عَلىٰ هُدًى مِن رَبِّهِم وَأُولٰئِكَ هُمُ المُفلِحونَ' },
      ],
      translations: [
        { ayah_id: 1, translation: 'In the name of Allah, most benevolent, ever-merciful.' },
        { ayah_id: 2, translation: 'ALL PRAISE BE to Allah, Lord of all the worlds,' },
        { ayah_id: 3, translation: 'Most beneficent, ever-merciful,' },
        { ayah_id: 4, translation: 'King of the Day of Judgement.' },
        { ayah_id: 5, translation: 'You alone we worship, and to You alone turn for help.' },
        { ayah_id: 6, translation: 'Guide us (O Lord) to the path that is straight,' },
        { ayah_id: 7, translation: 'The path of those You have blessed, Not of those who have earned Your anger, nor those who have gone astray.' },
        { ayah_id: 8, translation: 'ALIF LAM MIM.' },
        { ayah_id: 9, translation: 'This is The Book free of doubt and involution, a guidance for those who preserve themselves from evil and follow the straight path,' },
        { ayah_id: 10, translation: 'Who believe in the Unknown and fulfil their devotional obligations, and spend in charity of what We have given them;' },
        { ayah_id: 11, translation: 'Who believe in what has been revealed to you and what was revealed to those before you, and are certain of the Hereafter.' },
      ],
      currentVerse: null,
      intervalId: null
    };
  },
  methods: {
    async fetchVerses() {
      try {
        const response = await axios.get('/api/verses'); // Replace with your API endpoint
        this.verses = response.data.verses;
        this.translations = response.data.translations;
        this.isLoading = false; // Data has been loaded
      } catch (error) {
        console.error('Error fetching verses:', error);
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
      this.intervalId = setInterval(this.getRandomVerse, 5000); // Change verse every 5 seconds
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
  font-size: 15px;
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