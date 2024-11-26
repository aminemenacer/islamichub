<template>
  <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h2><b>Speech Settings</b></h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="SpeechSettings" role="tabpanel" aria-labelledby="tab1-tab">
                <div class="row mb-3">
                    <label for="formGroupExampleInput" class="form-label">Voices:</label>
                    <select class="form-control" v-model="selectedVoiceName" @change="changeVoice(selectedVoiceName)">
                        <option v-for="voice in voices" :key="voice.name" :value="voice.name">
                            {{ voice.name }} ({{ voice.lang }})
                        </option>
                    </select>
                </div>
                <div class="row">
                    <div class="col">
                        <label>
                            Rate: 
                            <input class="rate" type="range" min="0.5" max="2" step="0.1" v-model="rate" @input="adjustRate($event.target.value)">
                        </label>
                    </div>
                    <div class="col">
                        <label>
                            Pitch: 
                            <input class="pitch" type="range" min="0.5" max="2" step="0.1" v-model="pitch" @input="adjustPitch($event.target.value)">
                        </label>
                    </div>
                    <div class="col">
                        <label>
                            Increase size: <i class="bi bi-plus-circle-fill h3 custom-icon-increase" @click="increaseFontSize"></i>
                        </label>
                    </div>
                    <div class="col">
                        <label>
                            Decrease size: <i class="bi bi-dash-circle-fill h3 custom-icon-decrease" @click="decreaseFontSize"></i>
                        </label>
                    </div>
                </div>

                <div v-if="successMessage" class="alert alert-success" role="alert">
                    Settings saved successfully!
                </div>

                <div class="d-flex w-100 justify-content-end mt-3">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="button" class="btn btn-success" @click="saveSettings">Save changes</button>
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
        isAccessibilitySettingsVisible: false,
        voices: [],
        selectedVoiceName: localStorage.getItem('selectedVoice') || '',
        rate: localStorage.getItem('rate') || 1,
        pitch: localStorage.getItem('pitch') || 1,
        successMessage: false,
        currentFontSize: parseInt(localStorage.getItem('fontSize') || '16'),
    };
},
methods: {
  loadVoices() {
        this.voices = window.speechSynthesis.getVoices();
        if (this.selectedVoiceName) {
            this.selectedVoiceName = this.voices.find(v => v.name === this.selectedVoiceName)?.name || this.voices[0]?.name;
        } else if (this.voices.length) {
            this.selectedVoiceName = this.voices[0].name;
        }
    },
    changeVoice(voiceName) {
        this.selectedVoiceName = voiceName;
        localStorage.setItem('selectedVoice', JSON.stringify(voiceName));
    },
    adjustRate(value) {
        this.rate = parseFloat(value);
        localStorage.setItem('rate', value);
    },
    adjustPitch(value) {
        this.pitch = parseFloat(value);
        localStorage.setItem('pitch', value);
    },
    increaseFontSize() {
        this.currentFontSize += 2;
        this.saveFontSize();
    },
    decreaseFontSize() {
        if (this.currentFontSize > 10) {
            this.currentFontSize -= 2;
            this.saveFontSize();
        }
    },
    saveFontSize() {
        localStorage.setItem('fontSize', this.currentFontSize);
    },
    saveSettings() {
      localStorage.setItem('selectedVoice', this.selectedVoiceName);
      localStorage.setItem('rate', this.rate);
      localStorage.setItem('pitch', this.pitch);
      this.successMessage = true;
      setTimeout(() => {
        this.successMessage = false;
        const offcanvasElement = document.getElementById('offcanvasRight');
        const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasElement);
        if (offcanvasInstance) offcanvasInstance.hide();
    }, 1000);
  }
},
mounted() {
    this.loadVoices();
    window.speechSynthesis.onvoiceschanged = this.loadVoices;
}
}
</script>

<style scoped>
.custom-offcanvas {
  width: 400px;
  /* Add your custom styles here */
}

.custom-icon-increase, .custom-icon-decrease {
  cursor: pointer;
  color: #007bff;
}
</style>
