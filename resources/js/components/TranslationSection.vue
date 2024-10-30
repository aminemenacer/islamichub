<template>
<div class="w-100 my-element" :class="{ 'full-screen': isFullScreen }">
  <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
  <div>
  <AyahInfo :information="information" />
  <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
    <div class="row">
      <div class="col-md-1 pt-2 d-flex align-items-center justify-content-center">
         <!-- Play Button -->
          <i 
            @click="playAudio" 
            :class="['bi', isReading ? (isPaused ? 'bi-play-circle-fill' : 'bi-pause-circle-fill') : 'bi-play-circle-fill', 'h4', 'custom-icon-play']"
            style="cursor: pointer;" 
            aria-label="Play audio"
          />
      </div>
      <div class="col-md-11">
        <MainAyah :information="information" />
      </div>
    </div>

    <div ref="targetTranslationElement" class="row text-left mt-2">
      <!-- Text Column -->
      <div class="col-10">
        <h4 class="ayah-translation" style="line-height: 1.6em" v-html="renderedText">
          {{ expanded ? information.translation : information.translation }}
        </h4>
      </div>

      <!-- Icons Column (Stacked Vertically) -->
      <div class="col-2 d-flex align-items-center justify-content-center flex-column">
        <!-- Rewind Button -->
        <i @click="rewindAudio" 
          :class="['bi', 'bi-rewind-circle-fill', 'h3', 'custom-icon-play']"
          :style="{ cursor: isPlaying ? 'pointer' : 'not-allowed', color: isPlaying ? '#000' : '#555', opacity: isPlaying ? 1 : 0.5 }"
          aria-label="Rewind translation audio">
        </i>

        <!-- Play/Pause Button -->
        <i @click="toggleSpeech" 
          :class="['bi', isReading ? (isPaused ? 'bi-play-circle-fill' : 'bi-pause-circle-fill') : 'bi-play-circle-fill', 'h3', 'custom-icon-play']"
          style="cursor: pointer;" 
          aria-label="Play or pause translation audio">
        </i>

        <!-- Stop Button -->
        <i @click="stopReading" 
          :class="['bi', 'bi-stop-circle-fill', 'h3', 'custom-icon-play']"
          :style="{ cursor: isPlaying ? 'pointer' : 'not-allowed', color: isPlaying ? '#000' : '#555', opacity: isPlaying ? 1 : 0.5 }"
          aria-label="Stop reading audio">
        </i>
      </div>
    </div>
      
    <div class="text-left word-count mt-2">
      <h6 class="text-left mt-3"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" /><strong>Total Words: </strong>{{ wordCount }}</h6>
    </div>

    <Translator translator="Ahmed Ali" />
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
</template>

<script>
import AyahInfo from "./translation/AyahInfo.vue";
import MainAyah from "./translation/MainAyah.vue";
import Translator from "./translation/Translator.vue";
import AlertModal from "./modals/AlertModal.vue";
import ScreenReader from "./accesibility/ScreenReader.vue";
import ScreenTranslationCapture from "./translation/features/screen_capture/ScreenTranslationCapture.vue";
import Magnifier from "./search/Magnifier.vue";

import html2canvas from "html2canvas";
import jsPDF from "jspdf";
import {
  saveAs
} from "file-saver";
import Papa from "papaparse";
import {
  Document,
  Packer,
  Paragraph,
  TextRun
} from "docx";

export default {
  name: "TranslationSection",
  components: {
    AyahInfo,
    MainAyah,
    Translator,
    AlertModal,
    ScreenReader,
    Magnifier
  },
  props: {
    iconColor: {
      type: String,
      default: "rgba(0, 191, 166)"
    },
    translation: {
      type: String,
      required: true
    },
    information: {
      type: Object,
      required: true
    },
    targetTranslationRef: {
      type: String,
      default: "targetTranslationElement"
    },
    isFullScreen: {
      type: Boolean,
      default: false
    },
    expanded: {
      type: Boolean,
      default: false
    },
    showMoreLink: {
      type: Boolean,
      default: true
    },
    showAlertText: {
      type: Boolean,
      default: false
    },
    showAlert: {
      type: Boolean,
      default: false
    },
    showErrorAlert: {
      type: Boolean,
      default: false
    },
    showAlertTextNote: {
      type: Boolean,
      default: false
    },
    props: {
      isReading: Boolean,
      isPaused: Boolean
    }

  },
  computed: {
    wordCount() {
      const text = this.expanded ?
        this.information.translation :
        this.information.translation;
      return text ? text.trim().split(/\s+/).length : 0; // Calculate the word count
    },

    combinedText() {
      // Get the ayah_text from information
      const ayahText =
        typeof this.information.ayah_text === "object" ?
        this.information.ayah_text.text :
        this.information.ayah_text;

      // Return the formatted string
      return `Translation: ${this.ayah_text}`;
    }
  },
  data() {
    return {

      fontSize: 1.6,
      renderedText: "",
      isPaused: false,
      isReading: false,
      resetDisabled: true,
      utterance: null,
      currentFontSize: 1.6,
      selectedVoiceName: "",
      selectedVoice: null,
      successMessage: false,
      rate: 1,
      pitch: 1,
      surahUrl: "",
      voices: [],
      summary: "",
      words: [],
      currentWordIndex: 0,
      ayahAudio: null, // Store the audio URL
      ayahId: 1, // Example ayah ID
      data: [],
      surat: [],
      ayat: [],
      tafseers: []
    };
  },

  mounted() {
    this.renderedText = this.information.translation;
    // Load saved settings from local storage on page load
    const savedVoiceName = localStorage.getItem("selectedVoice");
    const savedRate = localStorage.getItem("rate");
    const savedPitch = localStorage.getItem("pitch");
    const savedFontSize = localStorage.getItem("fontSize");

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
    playAudio() {
      this.$emit('toggle-audio'); // Show the audio player in the parent component
    },
    pauseAudio() {
      this.$emit('pause-audio'); // Trigger pause method in the parent
    },
    toggleExpand() {
      this.expanded = !this.expanded;
    },
    submitForm() {
      const formData = {
        // folder_id: this.selectedFolderId,
        surah_name: this.information.ayah.surah.name_en,
        ayah_num: this.information.ayah_id,
        ayah_verse_ar: this.information.ayah.ayah_text,
        ayah_verse_en: this.information.translation,
        user_id: this.userId
      };
      axios.post("/bookmarks", formData).then(response => {
        console.log(response.data.message);
        localStorage.setItem(
          `bookmarkSubmitted_${this.information.ayah_id}`,
          true
        );
        this.showAlert = true;
        this.showErrorAlert = false;
        this.hideAlertAfterDelay();
        // Display a confirmation message with the bookmarked ayah and folder
        // this.$refs.bookmarkConfirmation.textContent =
        //   `Successfully bookmarked ayah ${this.information.ayah_id} to folder "${this.selectedFolderId}"`;
      });
    },
    saveSettings() {
      // Save settings to local storage
      localStorage.setItem(
        "selectedVoice",
        JSON.stringify(this.selectedVoiceName)
      );
      localStorage.setItem("rate", this.rate);
      localStorage.setItem("pitch", this.pitch);
      // Show success message
      this.successMessage = true;
      // Close the modal after a short delay
      setTimeout(() => {
        this.successMessage = false;
        const offcanvasElement = document.getElementById("offcanvasRight"); // Change to the correct element ID
        const offcanvasInstance = bootstrap.Offcanvas.getInstance(
          offcanvasElement
        );
        if (offcanvasInstance) {
          offcanvasInstance.hide(); // Close the offcanvas
        }
      }, 1000); // 1 second delay
    },
    closeModal() {
      const modalElement = document.getElementById("speechModal");
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
    // increaseFontSize() {
    //   this.fontSize += 0.2; // Increase font size
    //   this.saveFontSize();
    // },
    // decreaseFontSize() {
    //   if (this.fontSize > 1) {
    //     this.fontSize -= 0.2; // Decrease font size
    //     this.saveFontSize();
    //   }
    // },
    // saveFontSize() {
    //   localStorage.setItem('ayahFontSize', this.fontSize); // Store font size in local storage
    // },

    selectBestVoice() {
      const preferredVoices = [
        "Google UK English Female",
        "Microsoft Zira Desktop - English (United States)",
        "Samantha",
        "Google US English",
        "Microsoft David Desktop - English (United States)"
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
      localStorage.setItem("selectedVoice", JSON.stringify(voiceName));
    },
    adjustRate(value) {
      this.rate = parseFloat(value);
    },
    adjustPitch(value) {
      this.pitch = parseFloat(value);
    },
    downloadAsCSV() {
      const data = [{
        Translation: this.information.translation,
        Translator: "Ahmed Ali"
      }];
      const csv = Papa.unparse(data);
      const blob = new Blob([csv], {
        type: "text/csv;charset=utf-8;"
      });
      saveAs(blob, "translation.csv");
    },
    async downloadAsWord() {
      const doc = new Document({
        sections: [{
          children: [
            new Paragraph({
              children: [
                new TextRun("Translation:"),
                new TextRun({
                  text: this.information.translation,
                  bold: true
                })
              ]
            }),
            new Paragraph({
              children: [
                new TextRun("Translator:"),
                new TextRun({
                  text: "Ahmed Ali",
                  italics: true
                })
              ]
            })
          ]
        }]
      });
      const blob = await Packer.toBlob(doc);
      saveAs(blob, "translation.docx");
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
    readTextAloud() {
      const text = this.information.translation;

      // Cancel any ongoing speech first to ensure a clean start
      window.speechSynthesis.cancel();

      this.renderedText = text; // Set initial rendered text
      this.utterance = new SpeechSynthesisUtterance(text);

      // Set voice and speech properties
      this.utterance.rate = 1;
      this.utterance.pitch = 1;

      // Handle word boundary event for highlighting
      this.utterance.onboundary = event => {
        if (event.name === "word") {
          const currentWord = text.slice(event.charIndex).split(" ")[0]; // Get the currently spoken word
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
      const text = this.information.translation;
      const before = text.slice(0, charIndex);
      const after = text.slice(charIndex + currentWord.length);

      // Update the rendered text with highlighting
      this.renderedText = `
        <span>${before}</span>
        <span style="background-color: rgba(0, 191, 166, 4.133);padding:4px;border-radius:5px">${currentWord}</span>
        <span>${after}</span>
      `;
    },

    clearHighlight() {
      this.renderedText = `<span style="font-size: ${this.currentFontSize}px;">${this.information.translation}</span>`;
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
      this.$emit("toggle-expand");
    },
    closeAlertText() {
      this.$emit("close-alert-text");
    }
  },
  created() {
    const savedFontSize = localStorage.getItem('ayahFontSize');
    this.fontSize = savedFontSize ? parseFloat(savedFontSize) : this.fontSize; // Set initial font size
  },
};
</script>

<style scoped>

audio {
  display: block;
  border-radius: 30px;
  margin: 0 auto;
  width: 100%;
  border: 2px double rgba(0, 191, 166);
  background-color: white;
}

.word-count {
  margin-top: 10px;
}

.controls {
  margin-top: 10px;
}

.ayah-container {
  margin-bottom: 20px;
}

.ayah-text {
  font-size: 18px;
  margin-bottom: 10px;
}

.ayah-audio {
  margin-bottom: 20px;
}

.custom-offcanvas {
  background-color: #10584f;
  color: white;
  width: 40%;
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

.text-muted {
  color: lightgrey;
}

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

@media (max-width: 768px) {

  /* Adjust this width as needed for your breakpoint */
  .mobile-only {
    display: flex;
    flex-direction: column !important;
    /* Show only on mobile */
  }

  .custom-offcanvas {
    background-color: #10584f;
    color: white;
    width: 100%;
  }
}

@media (max-width: 576px) {
  .mobile-only {
    display: block;
    display: flex;
  }

  .custom-offcanvas {
    background-color: #10584f;
    color: white;
    width: 100%;
  }

  .hide-on-mobile {
    display: none;
  }
}
</style>
