<template>
<div class="w-100 my-element" :class="{ 'full-screen': isFullScreen }">
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">
        Close
    </button>
    <div ref="targetTafseerElement">
        <AyahInfo :information="information" />
        <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
            <MainAyah :information="information" />
            <div ref="targetTafseerElement" class="text-left">
                <h4 class="text-left ayah-translation" style="line-height: 1.6em">
                    {{ expanded ? tafseer : tafseer }}
                </h4>
                <div class="word-count">
									<h6 class="text-left mt-3"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" /><strong>Total Words: </strong>{{ wordCount }}</h6>
                </div>
            </div>

            <h6 class="text-left">
                <img src="/images/art.png" class="pr-2" width="30px" alt="lamp" /><strong>Tafseer: </strong>Ibn Kathir
            </h6>
            <!-- Speech icons mobile only-->
            <div style="cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: space-between;" class="container pb-2 text-center mobile-only">
                <div class="row">
                    <div class="col">
                        <i @click="rewindSpeech" :class="['bi', 'bi-rewind-circle-fill', 'ml-2', 'mr-2', 'h3', 'custom-icon-play', isReading ? 'text-muted' : '']" style="cursor: pointer;" aria-label="Rewind translation audio"></i>
                    </div>

                    <div class="col">
                        <i @click="toggleSpeech" :class="['bi', isReading ? (isPaused ? 'bi-play-circle-fill' : 'bi-pause-circle-fill') : 'bi-play-circle-fill', 'ml-2', 'mr-2', 'h3', 'custom-icon-play']" style="cursor: pointer;" aria-label="Play or pause translation audio"></i>
                    </div>

                    <div class="col">
                        <i @click="pauseReading" :class="['bi', 'bi-pause-circle-fill', 'ml-2', 'mr-2', 'h3', 'custom-icon-play', !isReading || isPaused ? 'text-muted' : '']" style="cursor: pointer;" aria-label="Pause translation audio"></i>
                    </div>

                    <div class="col">
                        <i @click="stopReading" :class="['bi', 'bi-stop-circle-fill', 'ml-2', 'mr-2', 'h3', 'custom-icon-play', !isReading ? 'text-muted' : '']" style="cursor: pointer;" aria-label="Stop translation audio"></i>
                    </div>

                    <div class="col">
                        <i @click="fastForwardSpeech" style="cursor: pointer;" aria-label="Fast forward audio" class="bi bi-fast-forward-circle-fill ml-2 mr-2 h3 custom-icon-play"></i>
                    </div>
                </div>
            </div>
            <!-- Speech Off-canvas -->
            <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRightTafseer" aria-labelledby="offcanvasRightLabel">
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
            <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
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
            renderedText: this.tafseer,
            isPaused: false,
            isReading: false,
            resetDisabled: true,
            utterance: null,
            currentFontSize: 20,
            selectedVoiceName: '',
            selectedVoice: null,
            successMessage: false,
            words: [],
            currentWordIndex: 0,
            ayahAudio: null, // Store the audio URL
            ayahId: 1,
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
    computed: {
        wordCount() {
            const text = this.expanded ? this.tafseer : this.tafseer;
            return text ? text.trim().split(/\s+/).length : 0; // Calculate the word count
        },
    },
    mounted() {
        if (this.information?.ayah?.id) {
          this.fetchTafseer(this.information.ayah.id);
        }
        // Load saved settings from local storage on page load
        const savedVoiceName = localStorage.getItem('selectedVoice');
        const savedRate = localStorage.getItem('rate');
        const savedPitch = localStorage.getItem('pitch');
        const savedFontSize = localStorage.getItem('fontSize');

        if (savedVoiceName) this.selectedVoiceName = JSON.parse(savedVoiceName); // Use selectedVoiceName instead of selectedVoice
        if (savedRate) this.rate = parseFloat(savedRate);
        if (savedPitch) this.pitch = parseFloat(savedPitch);
        if (savedFontSize) {
            this.currentFontSize = parseInt(savedFontSize, 10);
        } else {
            this.currentFontSize = 20; // Default font size
        }

        // Load voices initially
        this.loadVoices();
        // Ensure voices are fully loaded before attempting to play
        window.speechSynthesis.onvoiceschanged = () => {
            this.loadVoices();
            this.voicesLoaded = true; // Set a flag to confirm voices are loaded
        };
    },
    methods: {
        saveSettings() {
            // Save settings to local storage
            localStorage.setItem('selectedVoice', JSON.stringify(this.selectedVoiceName));
            localStorage.setItem('rate', this.rate);
            localStorage.setItem('pitch', this.pitch);
            // Show success message
            this.successMessage = true;
            // Close the modal after a short delay
            setTimeout(() => {
                this.successMessage = false;
                const offcanvasElement = document.getElementById('offcanvasRight'); // Change to the correct element ID
                const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasElement);
                if (offcanvasInstance) {
                    offcanvasInstance.hide(); // Close the offcanvas
                }
            }, 1000); // 1 second delay
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
            this.voices = window.speechSynthesis.getVoices();
            // Set the selected voice if it exists in the voices array
            const voice = this.voices.find(v => v.name === this.selectedVoiceName);
            if (voice) {
                this.selectedVoiceName = voice.name; // Set selectedVoiceName to a valid voice
            } else if (this.voices.length > 0) {
                this.selectedVoiceName = this.voices[0].name; // Fallback to the first available voice
            }
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
            localStorage.setItem('selectedVoice', JSON.stringify(voiceName));
        },
        adjustRate(value) {
            this.rate = parseFloat(value);
        },
        adjustPitch(value) {
            this.pitch = parseFloat(value);
        },
        toggleSpeech() {
            if (this.isReading) {
                if (this.isPaused) {
                    this.resumeReading(); // Resume speech if paused
                } else {
                    this.pauseReading(); // Pause speech if currently reading
                }
            } else {
                this.readTextAloud(); // Start reading if not currently reading
            }
        },
        // Read the displayed text aloud
        // Read the displayed text aloud
        readTextAloud() {
            const text = this.tafseer;

            // Cancel any ongoing speech first to ensure a clean start
            window.speechSynthesis.cancel();

            this.renderedText = text; // Set initial rendered text
            this.utterance = new SpeechSynthesisUtterance(text);

            // Set voice and speech properties
            this.utterance.rate = 1;
            this.utterance.pitch = 1;

            // Handle word boundary event for highlighting
            this.utterance.onboundary = (event) => {
                if (event.name === 'word') {
                    const currentWord = text.slice(event.charIndex).split(' ')[0]; // Get the currently spoken word
                    this.highlightText(event.charIndex, currentWord); // Highlight the word
                }
            };

            // Handle end of speech event
            this.utterance.onend = () => {
                this.isReading = false;
                this.isPaused = false;
                this.clearHighlight(); // Clear highlight after reading
            };

            // Start speaking
            this.isReading = true;
            window.speechSynthesis.speak(this.utterance);
        },
        highlightText(charIndex, currentWord) {
            const text = this.tafseer;
            const before = text.slice(0, charIndex);
            const after = text.slice(charIndex + currentWord.length);

            // Update the rendered text with highlighting
            this.renderedText = `
                <span>${before}</span>
                <span style="background-color: yellow;">${currentWord}</span>
                <span>${after}</span>
            `;
        },

        clearHighlight() {
            this.renderedText = `<span style="font-size: ${this.currentFontSize}px;">${this.tafseer}</span>`;
        },
        //Pause reading
        pauseReading() {
            if (this.isReading && !this.isPaused) {
                window.speechSynthesis.pause(); // Pause the speech synthesis
                this.isPaused = true; // Set paused state
                console.log("Speech paused.");
            }
        },
        // Resume reading
        resumeReading() {
            if (this.isPaused) {
                window.speechSynthesis.resume(); // Resume the paused speech
                this.isPaused = false; // Reset paused state
                console.log("Speech resumed.");
            }
        },
        // Stop reading
        stopReading() {
            window.speechSynthesis.cancel(); // Stop the speech synthesis
            this.isReading = false; // Reset reading state
            this.isPaused = false; // Reset paused state
            console.log("Speech stopped.");
        },
        // Rewind the speech
        rewindSpeech() {
            // Stop current speech and start again
            this.stopReading();
            this.readTextAloud(); // Restart the speech from the beginning
            console.log("Speech rewinded.");
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
