<template>
    <div class="w-100 my-element" :class="{ 'full-screen': isFullScreen }">
        <button
            v-if="isFullScreen"
            @click="toggleFullScreen"
            class="close-button mb-3 text-left btn btn-secondary"
        >
            Close
        </button>
        <div ref="targetTafseerElement">
            <AyahInfo :information="information" />
            <div
                @touchstart="handleTouchStart"
                @touchmove="handleTouchMove"
                @touchend="handleTouchEnd"
                class="swipeable-div w-100"
            >
                <MainAyah :information="information" />
                <div ref="targetTafseerElement" class="text-left">
                    <h4
                        :style="{ fontSize: currentFontSize + 'px' }"
                        class="text-left ayah-translation"
                        style="line-height: 1.6em"
                    >
                        {{ expanded ? tafseer : tafseer }}
                        <!-- {{ tafseer }} -->
                        
                    </h4>
                </div>

                <h6 class="text-left">
                    <img
                        src="/images/art.png"
                        class="pr-2"
                        width="30px"
                        alt="lamp"
                    /><strong>Tafseer: </strong>Ibn Kathir
                </h6>
                <div style="cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: space-between;" class="container pb-2 text-center mobile-only">
                    <div class="row">
                        <div class="col">
                            <i @click="rewindSpeech" style="cursor: pointer;" aria-label="Rewind tafseer audio" class="bi bi-rewind-circle-fill ml-2 mr-2 h3 custom-icon-play"></i>
                        </div>
                        <div class="col">
                            <i @click="toggleSpeech" style="cursor: pointer;" aria-label="Play or pause translation audio" :class="isReading ? 'bi-pause-circle-fill' : 'bi-play-circle-fill'" class="bi ml-2 mr-2 h3 custom-icon-play"></i>
                        </div>
                        <div class="col">
                            <i @click="stopReading" style="cursor: pointer;" aria-label="Stop tafseer audio" class="bi bi-stop-circle-fill ml-2 mr-2 h3 custom-icon-play"></i>
                        </div>
                        <div class="col">
                            <i  style="cursor: pointer;" aria-label="Stop tafseer audio" class="bi bi-fast-forward-circle-fill ml-2 mr-2 h3 custom-icon-play"></i>
                        </div>
                    </div>
                </div>
                <!-- Speech Off-canvas -->
    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
     <div class="offcanvas-header">
      <h2><b>Speech Settings</b></h2>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
     </div>
     <div class="offcanvas-body">

      <!-- Tab content -->
      <div class="tab-content mt-3" id="myTabContent">
       <div class="tab-pane fade show active" id="Speech Settings" role="tabpanel" aria-labelledby="tab1-tab">
       <div class="row mb-3">
        <label for="formGroupExampleInput" class="form-label">Voices:</label>
          <select class="form-control" v-model="selectedVoiceName">
            <option v-for="voice in voices" :key="voice.name" :value="voice.name">
              {{ voice.name }} ({{ voice.lang }})
            </option>
          </select>
        </div>

        <div class="row">
         <div class="col">
          <label>
           Rate: <input class="rate" type="range" min="0.5" max="2" step="0.1" v-model="rate" @input="adjustRate($event.target.value)">
          </label>
         </div>
         <div class="col">
          <label>
           Pitch: <input class="pitch" type="range" min="0.5" max="2" step="0.1" v-model="pitch" @input="adjustPitch($event.target.value)">
          </label>
         </div>
         
         <div class="col">
          <label> 
            Increase size: <i class="bi bi-plus-circle-fill h3 custom-icon-increase" aria-placeholder="Increase text size" @click="increaseFontSize"></i>
          </label>
         </div>
         <div class="col">
          <label>
            Decrease size: <i class="bi bi-dash-circle-fill h3 custom-icon-decrease" aria-placeholder="Decrease text size" @click="decreaseFontSize"></i>
          </label>
         </div>
        </div>

        <!-- Success message alert (hidden by default) -->
        <div v-if="successMessage" class="alert alert-success" role="alert">
         Settings saved successfully!
        </div>

        <!-- Buttons to save or cancel changes -->
        <div class="d-flex w-100 justify-content-end mt-3">
         <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
         <button type="button" class="btn btn-success" @click="saveSettings">Save changes</button>
        </div>
       </div>   
      </div>
     </div>
    </div> 

       
                <AlertModal
                    :showAlertText="showAlertText"
                    :showAlert="showAlert"
                    :showErrorAlert="showErrorAlert"
                    :showAlertTextNote="showAlertTextNote"
                    @close-alert-text="closeAlertText"
                />
            </div>
        </div>
    </div>
</template>

<script>
import AyahInfo from "./translation/AyahInfo.vue";
import MainAyah from "./translation/MainAyah.vue";
import AlertModal from "./modals/AlertModal.vue";

export default {
 name: "TafseerSection",
 components: {
  AyahInfo,
  MainAyah,
  AlertModal,
 },
 props: {
  information: Object,
  isFullScreen: Boolean,
  showAlertText: Boolean,
  showAlert: Boolean,
  showErrorAlert: Boolean,
  showAlertTextNote: Boolean,
 },
 data() {
  return {
   tafseer: "", // Store tafseer data here
   expanded: false, // Local state to track expand/collapse
   rate: 1,
   pitch: 1,
   surahUrl: '',
   voices: [],
   ayahId: 1, // Example ayah ID
   data: [],
   surat: [],
   ayat: [],
   tafseers: [],
  };
 },
 watch: {
  // Watch for changes to `information.ayah.id`
  "information.ayah.id": {
   immediate: true, // Run on initial component mount as well
   handler(newId, oldId) {
    if (newId !== oldId) {
     this.fetchTafseer(newId); // Refetch tafseer when ayah ID changes
    }
   },
  },
 },
 mounted(){
  // Load saved settings from local storage on page load
  const savedVoice = localStorage.getItem('selectedVoice');
  const savedRate = localStorage.getItem('rate');
  const savedPitch = localStorage.getItem('pitch');

  if (savedVoice) this.selectedVoice = JSON.parse(savedVoice);
  if (savedRate) this.rate = parseFloat(savedRate);
  if (savedPitch) this.pitch = parseFloat(savedPitch);

  const savedFontSize = localStorage.getItem('fontSize');
  if (savedFontSize) {
   this.currentFontSize = parseInt(savedFontSize, 10); // Set the font size from localStorage
  }
  this.loadVoices();
  // Listen for voiceschanged event to reload voices
  window.speechSynthesis.onvoiceschanged = () => {
   this.loadVoices();
  };
 },
 methods: {
  saveSettings() {
   // Save settings to local storage
   localStorage.setItem('selectedVoice', JSON.stringify(this.selectedVoice));
   localStorage.setItem('rate', this.rate);
   localStorage.setItem('pitch', this.pitch);

   // Show success message
   this.successMessage = true;

   // Close the modal after a short delay
   setTimeout(() => {
    this.successMessage = false;
    const modalElement = document.getElementById('speechModal');
    const modalInstance = bootstrap.Modal.getInstance(modalElement);

    if (modalInstance) {
     modalInstance.hide();
     // Dispose of the modal to remove the grey background
     modalInstance.dispose();
    }
   }, 3000);
  },
  closeModal() {
   const modalElement = document.getElementById('speechModal');
   const modalInstance = bootstrap.Modal.getInstance(modalElement);

   if (modalInstance) {
    modalInstance.hide();
    // Dispose of the modal to remove the grey background
    modalInstance.dispose();
   }
  },
  loadVoices() {
   this.voices = speechSynthesis.getVoices();
  },
  increaseFontSize() {
   this.currentFontSize += 2; // Increase font size by 2px
   this.saveFontSize();
  },
  decreaseFontSize() {
   if (this.currentFontSize > 10) {
    this.currentFontSize -= 2; // Decrease font size by 2px, limit to 10px minimum
    this.saveFontSize();
   }
  },
  resetFontSize() {
   this.currentFontSize = 20; // Reset to default font size
   this.saveFontSize(); // Save the font size (e.g., to local storage or any other mechanism)
   this.resetDisabled = true; // Disable the reset button after resetting the font size
  },
  selectBestVoice() {
   const preferredVoices = [
    'Google UK English Female',
    'Microsoft Zira Desktop - English (United States)',
    'Samantha',
    'Google US English',
    'Microsoft David Desktop - English (United States)',
   ];

   for (const preferredVoice of preferredVoices) {
    const voice = this.voices.find(v => v.name === preferredVoice);
    if (voice) {
     this.selectedVoice = voice;
     return;
    }
   }
   if (this.voices.length > 0) {
    this.selectedVoiceName = this.voices[0].name;
   }
   // If no preferred voice is found, choose the first available voice
   this.selectedVoice = this.voices[0];
  },
  changeVoice(voiceName) {
   this.selectedVoiceName = voiceName;
  },
  adjustRate(value) {
   this.rate = parseFloat(value);
  },
  adjustPitch(value) {
   this.pitch = parseFloat(value);
  },
  toggleSpeech() {
   if (this.isReading) {
    this.stopReading();
   } else {
    this.readTextAloud();
   }
  },
  // Read the displayed text aloud
  readTextAloud() {
   const text = this.expanded ? this.tafseer : this.tafseer;
   this.utterance = new SpeechSynthesisUtterance(text);

   // Find selected voice if available
   const selectedVoice = this.voices.find(voice => voice.name === this.selectedVoiceName);
   if (selectedVoice) {
    this.utterance.voice = selectedVoice;
   }
   // Set speech rate and pitch
   this.utterance.rate = this.rate;
   this.utterance.pitch = this.pitch;
   // Handle the end of speech event
   this.utterance.onend = () => {
    this.isReading = false; // Update state when speech ends
   };
   // Start speaking
   this.isReading = true;
   window.speechSynthesis.speak(this.utterance);
  },
  // Stop reading
  stopReading() {
   window.speechSynthesis.cancel();
   this.isReading = false;
  },
  rewindSpeech() {
   this.stopReading();
   this.readTextAloud(); // Replay the current ayah
  },
  async fetchTafseer(ayahId) {
   try {
    const tafseerResponse = await axios.get(
        `/tafseer/${ayahId}/fetch`
    );
    this.tafseer = tafseerResponse.data; // Assign the fetched data to the local state
   } catch (error) {
    console.error("Error fetching tafseer:", error);
   }
  },
  toggleFullScreen() {
      this.$emit("toggle-full-screen");
  },
  handleTouchStart(event) {
      this.$emit("handle-touch-start", event);
  },
  handleTouchMove(event) {
      this.$emit("handle-touch-move", event);
  },
  handleTouchEnd(event) {
      this.$emit("handle-touch-end", event);
  },
  toggleExpand() {
      this.expanded = !this.expanded; // Toggle expanded state locally
  },
  closeAlertText() {
      this.$emit("close-alert-text");
  },
 },
 mounted() {
  if (this.information?.ayah?.id) {
      this.fetchTafseer(this.information.ayah.id);
  }
 },
};
</script>

<style scoped>
.full-screen {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1000;
    background-color: white;
    padding: 20px;
}

.swipeable-div {
    touch-action: pan-y;
}

.ayah-translation {
    font-size: 1.2rem;
}

.btn {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.mobile-only {
    display: none;
    /* Hide by default */
}

.custom-icon-play:hover {
 color: rgb(13, 182, 145);
 /* Default color */
 transition: color 0.3s ease;
 /* Smooth transition */
}

.custom-icon-increase:hover {
 color: rgb(13, 182, 145);
 /* Default color */
 transition: color 0.3s ease;
 /* Smooth transition */
}

.custom-icon-decrease:hover {
 color: rgb(13, 182, 145);
 /* Default color */
 transition: color 0.3s ease;
 /* Smooth transition */
}

@media (max-width: 768px) {
    /* Adjust this width as needed for your breakpoint */
    .mobile-only {
        display: flex;
        /* Show only on mobile */
    }
}

@media (max-width: 576px) {
    .mobile-only {
        display: block;
        display: flex;
    }

    .hide-on-mobile {
        display: none;
    }
}
</style>