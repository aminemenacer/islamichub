<template>
<div class="w-100 my-element" :class="{ 'full-screen': isFullScreen }">
  <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary ">Close</button>
  <div>
    <AyahInfo :information="information" />
    <div class="swipeable-div w-100">
      <div class="row">
        <div class="col-md-1 pt-2 d-flex align-items-center justify-content-center">

          <!-- <i 
              @click="toggleSpeechAyah" 
              class="bi-play-circle-fill h4 custom-icon-play-main"
              style="cursor: pointer;" 
              aria-label="Play or pause translation audio"
            ></i>
            -->
        </div>

        <div class="col-md-11">
          <MainAyah :information="information" />
        </div>
      </div>

      <div ref="targetTranslationElement" class="row text-left mt-2">

        <div class="col-10">
          <h4 class="ayah-translation" style="line-height: 1.6em" :style="{ fontSize: fontSize + 'em', lineHeight: '1.6em' }">
            {{ expanded ? information.translation : information.translation }}
          </h4> 
          <!-- text summary -->
          <div v-if="isVisible">
            <div class="container row">
              <button @click="getSummary" :disabled="loading" class="summary button-36">
                <span v-if="loading" class="spinner"></span>
                {{ loading ? "Summarizing..." : "Generate Summary" }}
              </button>
            </div>

            <div v-if="summary" class="summary">
              <button class="close-btn" @click="closeSummary">x</button>
              <p class="summary-textarea">{{ summary }}</p>
            </div>

            <div v-if="error" class="error summary" >
              <p>{{ error }}</p>
            </div>
          </div>
        </div>
       

        <!-- Icons Column (Stacked Vertically) -->
        <div v-if="isVisible" class="col-2 d-flex align-items-center justify-content-center flex-column">
          <!-- Play/Pause Button -->
          <i  @click="toggleSpeech" :class="['bi', isReading ? (isPaused ? 'bi-play-circle-fill' : 'bi-pause-circle-fill') : 'bi-play-circle-fill', 'h3', 'custom-icon-play']" style="cursor: pointer;" aria-label="Play or pause translation audio">
          </i>
          <!-- Stop Button -->
          <i  @click="stopReading" :class="['bi', 'bi-stop-circle-fill', 'h3', 'custom-icon-play']" style="cursor: pointer;" :disabled="!isAudioPlaying" aria-label="Stop reading audio">
          </i>

          <!-- <i class="bi bi-plus-circle-fill h3 custom-icon-increase" aria-placeholder="Increase text size" @click="increaseFontSize"></i>
          <i class="bi bi-dash-circle-fill h3 custom-icon-decrease" aria-placeholder="Decrease text size" @click="decreaseFontSize"></i> -->

          <i class="bi bi-gear-fill settings text-right h3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-expanded="false" data-bs-placement="top" title="Settings" :style="{ cursor: 'pointer' }">
          </i>

        </div>
      </div>

      <!-- Speech Off-canvas -->
      <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
          <h3><b>Speech Settings</b></h3>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

          <!-- Tab content -->
          <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="Speech Settings" role="tabpanel" aria-labelledby="tab1-tab">
              <div class="row mb-3">
                <label for="formGroupExampleInput" class="form-label">Voices:</label>
                <select id="voiceSelect" class="form-control" v-model="selectedVoiceName" @change="changeVoice(selectedVoiceName)">
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

      

      <div class="text-left word-count mt-2">
        <h6 class="text-left mt-3"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy" /><strong>Total Word count: </strong>{{ wordCount }}</h6>
      </div>
      <div class="text-left word-count mt-2">
        <Translator translator="Ahmed Ali" />
      </div>
      <!-- <div class="text-left word-count mt-2">
        <h6 class="text-left mt-3"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy" /><strong>Reciter's name: </strong>Mishary Rashid Alafasy</h6>
      </div> -->
    </div> 

    <!-- <div v-if="isVisible" class="row">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Export as
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
          <li><a class="dropdown-item active" href="#" @click.prevent="handleDownload('csv')">CSV file</a></li>
          <li><a class="dropdown-item" href="#" @click.prevent="handleDownload('docx')">Word document</a></li>
          <li><a class="dropdown-item" href="#" @click.prevent="handleDownload('pdf')">PDF format</a></li>
        </ul>
      </div>
    </div> -->

    <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
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
import OffcanvasSetting from "./modals/OffcanvasSetting.vue";
import TransliterationSection from "./TransliterationSection.vue";

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
    OffcanvasSetting,
    // CustomizationModal,
    TransliterationSection,
    AyahInfo,
    MainAyah,
    Translator,
    AlertModal,
    ScreenReader,
    Magnifier
  },
  props: {
    successMessage: {
      type: String,
      default: ''
    },
    isVisible: {
      type: Boolean,
      required: true
    },
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
      isPlaying: Boolean,
    }
  },
  emits: ['toggle-audio'],
  computed: {
    wordCount() {
      const text = this.expanded ?
        this.information.translation : this.information.translation;
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
      summary: "", // Generated summary
      error: "", // Error message
      loading: false, // Loading state
      API_TOKEN: "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", // Hugging Face API token
      BASE_URL: "https://api-inference.huggingface.co/models/facebook/bart-large-cnn", // Hugging Face API URL
      isAuthenticated: false,
      userId: null,
      successMessage: "",
      isSwipeEnabled: true, // Track swipe enabled state
      swipeDisabled: false, // Flag to disable swipe behavior
      touchStartX: 0,
      touchStartY: 0,
      expanded: false,
      renderedText: '',
      selectedFormat: "Select a format",
      fontSize: parseFloat(localStorage.getItem('ayahFontSize')) || 1,
      holdTimeout: null,
      holdDuration: 1000,
      tapCount: 0,
      lastTap: 0,
      lastTapTime: 0,
      doubleTapThreshold: 300,
      isHolding: false,
      tapTimeout: null,
      isPaused: false,
      isReading: false,
      isAudioPlaying: false,
      resetDisabled: true,
      utterance: null,
      selectedVoiceName: "",
      selectedVoice: null,
      successMessage: false,
      rate: 1,
      pitch: 1,
      surahUrl: "",
      voices: [],
      selectedVoiceName: localStorage.getItem("selectedVoice") || "",
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
    this.clearHighlight();
    this.stopReading();
    this.$emit("ayah-text", this.information.ayah.ayah_text);
    // Load saved settings from local storage on page load
    const savedVoiceName = localStorage.getItem('selectedVoice');
    const savedRate = localStorage.getItem('rate');
    const savedPitch = localStorage.getItem('pitch');
    const savedFontSize = localStorage.getItem("fontSize");
   
    
    if (savedVoiceName) this.selectedVoiceName = JSON.parse(savedVoiceName); // Use selectedVoiceName instead of selectedVoice
    if (savedRate) this.rate = parseFloat(savedRate);
    if (savedPitch) this.pitch = parseFloat(savedPitch);
    if (savedFontSize) {
      this.currentFontSize = parseInt(savedFontSize, 10);
    } else {
      this.currentFontSize = 14; // Default font size
    } 
    // Load voices initially
    this.loadVoices();
    if ('speechSynthesis' in window) {
      window.speechSynthesis.onvoiceschanged = this.loadVoices;
    }
    // Ensure voices are fully loaded before attempting to play
    window.speechSynthesis.onvoiceschanged = () => {
      this.loadVoices();
      this.voicesLoaded = true; // Set a flag to confirm voices are loaded
    };
  },

  methods: {
    async getSummary() {
      this.loading = true;
      this.error = ""; // Reset error message
      this.summary = ""; // Reset summary
      this.loading = true; // Set loading state

      try {
        const response = await axios.post(
          this.BASE_URL, {
            inputs: this.information.translation,
            parameters: {
              max_length: 150, // Maximum length of the summary
              min_length: 50, // Minimum length of the summary
              do_sample: true, // Disable randomness for consistent output
            },

          }, {
            headers: {
              Authorization: `Bearer ${this.API_TOKEN}`,
              "Content-Type": "application/json",
            },
          }
        );
        this.summary = response.data[0].summary_text; // Update summary with API response
      } catch (err) {
        console.error("Error generating summary:", err); // Log error for debugging
        this.error = "Failed to generate summary. Please try again."; // User-friendly error message
      } finally {
        this.loading = false; // Reset loading state
      }
    },
    closeSummary() {
      this.summary = ""; // Clear the summary to hide the textarea
    },
    clearSuccessMessage() {
      setTimeout(() => {
        this.successMessage = '';
      }, 3000); // Clear after 3 seconds
    },
    showSuccess(message) {
      this.successMessage = message;

      // Clear message after 5 seconds
      setTimeout(() => {
        this.successMessage = '';
      }, 3000);
    },
    loadVoices() {
      this.voices = window.speechSynthesis.getVoices();
      if (this.selectedVoiceName) {
        const voice = this.voices.find(v => v.name === this.selectedVoiceName);
        if (!voice) this.selectedVoiceName = this.voices[0]?.name || '';
      } else if (this.voices.length > 0) {
        this.selectedVoiceName = this.voices[0].name; // Fallback to the first available voice
      }
    },
    clearHighlight() {
      // Force an update by resetting the content
      this.renderedText = ''; // Clear first to ensure reactivity
      this.$nextTick(() => {
        this.renderedText = `<span>${this.information.translation}</span>`;
      });
    },
    handleDownload(format) {
      if (!format) {
        alert("Please select a valid format.");
        return;
      }
      switch (format) {
        case "csv":
          this.downloadAsCsv();
          break;
        case "docx":
          this.downloadAsWord();
          break;
        case "pdf":
          this.downloadAsPdf();
          break;
        default:
          alert("Unknown format selected.");
      }
    },
    downloadAsPdf() {
      // Simple jsPDF code with basic Arabic support
      const doc = new jsPDF();

      // Set the font to "courier" (a basic font that may support Arabic characters)
      doc.setFont("courier");

      // Title in English (for context)
      doc.setFontSize(24);
      doc.setTextColor("#1F4E79");
      doc.text("Quran Translation Document", 105, 20, {
        align: "center"
      });
      doc.line(10, 25, 200, 25);

      let yPosition = 35;

      // Translation Header in English
      doc.setFont("Helvetica", "bold");
      doc.setFontSize(18);
      doc.setTextColor("#2B5797");
      doc.text("Translation:", 10, yPosition);
      yPosition += 10;

      // Example English translation text (replace with actual translation content)
      const translationContent = this.information.translation;
      const textWidth = 190;
      const splitTranslationContent = doc.splitTextToSize(translationContent, textWidth);

      if (yPosition + (splitTranslationContent.length * 8) > doc.internal.pageSize.height - 20) {
        doc.addPage();
        yPosition = 20;
      }

      doc.text(splitTranslationContent, 10, yPosition);
      yPosition += splitTranslationContent.length * 8;

      // Arabic Ayah Text Header
      yPosition += 10;
      doc.setFont("Helvetica", "bold");
      doc.setFontSize(18);
      doc.setTextColor("#2B5797");
      doc.text("Ayah:", 10, yPosition);
      yPosition += 10;

      // Arabic Ayah text (this is where you need the Arabic text)
      const translationText = this.information.ayah.ayah_text; // Arabic example
      const splitTranslationText = doc.splitTextToSize(translationText, textWidth);

      // Right-align Arabic text
      doc.text(splitTranslationText, 10, yPosition, {
        align: "right"
      }); // Right-align for Arabic text
      yPosition += splitTranslationText.length * 8;

      // Ensure the text is not cut off
      if (yPosition > doc.internal.pageSize.height - 20) {
        doc.addPage();
        yPosition = 20;
      }

      // Translator Header
      doc.setFont("Helvetica", "bold");
      doc.setFontSize(18);
      doc.setTextColor("#2B5797");
      doc.text("Translator:", 10, yPosition);
      yPosition += 10;

      // Translator Name
      doc.setFont("Helvetica", "normal");
      doc.setFontSize(14);
      doc.setTextColor("#000000");
      doc.text("Ahmed Ali", 10, yPosition);

      // Save the document
      doc.save("translation.pdf");
    },

    downloadAsCsv() {
      // Helper function to escape special characters in CSV
      const escapeCsvValue = (value) => {
        if (typeof value === "string") {
          // Escape quotes by doubling them and wrap in double quotes if necessary
          return `"${value.replace(/"/g, '""')}"`;
        }
        return value;
      };

      // Prepare the CSV content
      const csvContent = [
          ["Title", "Content"],
          ["Ayah", this.information.ayah.ayah_text],
          ["Translation", this.information.translation],
          ["Translator", "Ahmed Ali"],
        ]
        .map((row) => row.map(escapeCsvValue).join(",")) // Escape and join each row
        .join("\n");

      // Create a blob for the CSV content
      const blob = new Blob([csvContent], {
        type: "text/csv;charset=utf-8;",
      });

      // Get the current date and format it as YYYY-MM-DD
      const date = new Date();
      const formattedDate = date.toISOString().split("T")[0]; // e.g., 2024-11-19

      // Append the date to the filename
      const filename = `translation_${formattedDate}.csv`;

      // Download the file
      saveAs(blob, filename);
    },

    applySettings(fontSize, rate, pitch, selectedVoice) {
      // Update font size, speech rate, pitch, and selected voice
      this.fontSize = fontSize;
      this.rate = rate;
      this.pitch = pitch;
      this.selectedVoice = selectedVoice;

      // Optionally, save these settings to local storage
      localStorage.setItem('fontSize', fontSize);
      localStorage.setItem('rate', rate);
      localStorage.setItem('pitch', pitch);
      localStorage.setItem('selectedVoice', selectedVoice);

      // Optionally, you can also apply the changes to speech synthesis if needed
      if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(this.information.translation);
        utterance.rate = rate;
        utterance.pitch = pitch;
        utterance.voice = window.speechSynthesis.getVoices().find(voice => voice.name === selectedVoice);
        window.speechSynthesis.speak(utterance);
      }
    },

    // Additional methods if needed, such as toggling expanded state, etc.

    toggleSpeechAyah() {
      this.$emit('toggle-audio', this.isReading);
    },
    handleStart(event) {
      if (this.swipeDisabled) {
        // Prevent further processing if swipe is disabled
        return;
      }

      if (this.isSwipeEnabled) {
        const target = event.target;
        if (target.closest('[data-swipe-exclude]')) {
          this.swipeDisabled = true; // Flag to disable swipe handling
          return;
        }

        this.swipeDisabled = false; // Allow swipe if not excluded
        this.touchStartX = event.changedTouches ? event.changedTouches[0].clientX : event.clientX;

        // Start hold timer
        this.holdTimeout = setTimeout(() => {
          this.isHolding = true;
          this.toggleSpeech();
        }, this.holdDuration);
      }
    },
    handleEnd(event) {
      if (this.swipeDisabled) {
        // Prevent further processing if swipe is disabled
        return;
      }

      if (this.isSwipeEnabled) {
        const target = event.target;
        if (target.hasAttribute('data-swipe-exclude')) {
          return;
        }

        clearTimeout(this.holdTimeout);

        if (this.isHolding) {
          // If it was a hold, reset holding state
          this.isHolding = false;
        } else {
          // Check for double-tap if it was not a hold
          const currentTime = new Date().getTime();
          if (currentTime - this.lastTapTime <= this.doubleTapThreshold) {
            this.toggleExpand();
            this.lastTapTime = 0; // Reset last tap time after double-tap
          } else {
            this.lastTapTime = currentTime; // Update last tap time for next tap
          }
        }
      }
    },
    
    toggleAudio() {
      this.$emit('toggle-audio');
    },
    toggleExpand() {
      this.expanded = !this.expanded;
    },

    submitForm() {
      if (!this.isAuthenticated()) {
        console.log('Redirecting to login page...');
        window.location.href = '/login'; // Use the correct login URL
        return;
      }
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
    increaseFontSize() {
      this.fontSize += 0.2; // Increase font size
      this.saveFontSize();
    },
    decreaseFontSize() {
      if (this.fontSize > 1) {
        this.fontSize -= 0.2; // Decrease font size
        this.saveFontSize();
      }
    },
    saveFontSize() {
      localStorage.setItem('ayahFontSize', this.fontSize); // Store font size in local storage
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
      localStorage.setItem("selectedVoice", voiceName);
    },
    adjustRate(value) {
      this.rate = parseFloat(value);
    },
    adjustPitch(value) {
      this.pitch = parseFloat(value);
    },

    async downloadAsWord() {
      const doc = new Document({
        sections: [{
          children: [
            new Paragraph({
              children: [
                new TextRun({
                  text: "Quran Translation Document",
                  bold: true,
                  size: 48,
                  color: "1F4E79",
                }),
              ],
              alignment: "CENTER",
              spacing: {
                before: 600,
                after: 600
              },
            }),
            new Paragraph({
              children: [
                new TextRun({
                  text: "Ayah:",
                  bold: true,
                  size: 32,
                  color: "2B5797",
                  underline: true,
                }),
              ],
              spacing: {
                before: 300,
                after: 300
              },
            }),

            new Paragraph({
              children: [
                new TextRun({
                  text: this.information.ayah.ayah_text,
                  size: 28,
                  color: "333333",
                }),
              ],
              spacing: {
                after: 600
              },
              indent: {
                left: 360
              },
            }),

            new Paragraph({
              children: [
                new TextRun({
                  text: "Translation:",
                  bold: true,
                  size: 32,
                  color: "2B5797",
                  underline: true,
                }),
              ],
              spacing: {
                before: 300,
                after: 300
              },
            }),
            new Paragraph({
              children: [
                new TextRun({
                  text: this.information.translation,
                  size: 28,
                  color: "333333",
                }),
              ],
              spacing: {
                after: 600
              },
              indent: {
                left: 360
              },
            }),
            new Paragraph({
              children: [
                new TextRun({
                  text: "Translator:",
                  bold: true,
                  size: 32,
                  color: "2B5797",
                  underline: true,
                }),
              ],
              spacing: {
                before: 300,
                after: 300
              },
            }),
            new Paragraph({
              children: [
                new TextRun({
                  text: "Ahmed Ali",
                  size: 28,
                  color: "000000",
                }),
              ],
              spacing: {
                after: 600
              },
              indent: {
                left: 360
              },
            }),
          ],
        }, ],
      });

      const blob = await Packer.toBlob(doc);
      const date = new Date();
      const formattedDate = date.toISOString().split("T")[0]; // e.g., 2024-11-19

      // Append the date to the filename
      const filename = `translation_${formattedDate}.docx`;

      // Save the file with the dynamic filename
      saveAs(blob, filename);
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

      if (!this.selectedVoiceName || !this.voices.length) {
        alert("Please select a voice before speaking.");
        return;
      }

      const utterance = new SpeechSynthesisUtterance(this.textToSpeak);
      const voice = this.voices.find(v => v.name === this.selectedVoiceName);

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
    // Pause reading
    pauseReading() {
      const audioPlayer = this.$refs.audioPlayer;

      if (this.isReading && !this.isPaused) {
        // Pause both audio and speech synthesis
        if (audioPlayer && !audioPlayer.paused) {
          audioPlayer.pause(); // Pause the audio player
        }
        window.speechSynthesis.pause(); // Pause the speech synthesis
        this.isPaused = true; // Set paused state
        console.log("Speech paused.");
      }
    },
    // Resume reading
    resumeReading() {
      const audioPlayer = this.$refs.audioPlayer;

      if (this.isPaused) {
        // Resume both audio and speech synthesis
        if (audioPlayer && audioPlayer.paused) {
          audioPlayer.play(); // Resume the audio player
        }
        window.speechSynthesis.resume(); // Resume the paused speech
        this.isPaused = false; // Reset paused state
        console.log("Speech resumed.");
      }
    },
    // Stop reading
    stopReading() {
      // Stop the audio by pausing and resetting to the start
      const audioPlayer = this.$refs.audioPlayer;
      if (audioPlayer) {
        audioPlayer.pause();
        audioPlayer.currentTime = 0; // Reset to start position
      }

      window.speechSynthesis.cancel(); // Stop the speech synthesis
      this.clearHighlight(); // Clear any highlighted text
      this.isReading = false; // Stop reading state
      this.isPaused = false; // Reset pause state
      this.isAudioPlaying = false; // Reset audio playing state
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
  watch: {
    currentAyah: {
      immediate: true,
      handler(newAyah) {
        // Check if newAyah is defined and has a translation property
        if (newAyah && newAyah.translation) {
          this.renderedText = newAyah.translation;
        } else {
          this.renderedText = ''; // Handle the case where translation is undefined
        }
      },
    },
    successMessage(newValue) {
      if (newValue) {
        this.clearSuccessMessage();
      }
    },
    isVisible() {
      this.$emit('toggle-change');
    }
  }
};
</script>

<style scoped>
.summary {
  margin-top: 20px;
  font-size: 1em;
}

.summary-textarea {
  display: block;
  width: 100%;
  min-height: 100px;
  /* Adjust height as needed */
  padding: 10px;
  font-family: inherit;
  font-size: inherit;
  color: #333;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  border-radius: 4px;
  line-height: 1.5em;
  white-space: pre-wrap;
  /* Preserve formatting */
  overflow: auto;
  /* Allow scrolling if content overflows */
  resize: vertical;
  /* Allow user to resize vertically */
}

.close-btn {
  right: 5px;
  background-color: transparent;
  border: none;
  font-size: 1.2em;
  cursor: pointer;
  color: #333;
}

.button-36 {
  background-image: linear-gradient(92.88deg, #455EB5 9.16%, #5643CC 43.89%, #673FD7 64.72%);
  border-radius: 8px;
  border-style: none;
  box-sizing: border-box;
  color: #FFFFFF;
  cursor: pointer;
  font-family: "Inter UI", "SF Pro Display", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
  font-size: 15px;
  height: 2.4rem;
  padding: 0 1.3rem;
  text-align: center;
  text-shadow: rgba(0, 0, 0, 0.25) 0 3px 8px;
  transition: all .5s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-36:hover {
  box-shadow: rgba(80, 63, 205, 0.5) 0 1px 30px;
  transition: color 0.3s ease;
  transition-duration: .1s;
}


.summary {
  margin-top: 20px;
}

.error {
  margin-top: 20px;
  color: red;
}

.document-export-container {
  max-width: 600px;
  margin: 50px auto;
  padding: 20px;
  text-align: center;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.title {
  font-size: 24px;
  color: #1f4e79;
  margin-bottom: 10px;
}

.description {
  font-size: 16px;
  color: #333;
  margin-bottom: 20px;
}

/* .dropdown {
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 200px;
} */

.btn {
  font-size: 16px;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

.btn-primary {
  background-color: #1f4e79;
  color: #fff;
}

.btn-primary:hover {
  transition: color 0.3s ease;
  background-color: #163a5d;
}

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
