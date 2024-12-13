<template>
  <div class="w-100 my-element" :class="{ 'full-screen': isFullScreen }" >
    <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
    
    <div>
      <AyahInfo :information="information" />
      <div
        
        class="swipeable-div w-100"
       >
        <div class="row">
          <div class="col-md-2 pt-2 d-flex align-items-center justify-content-center">
            <!-- <i 
              @click="toggleSpeechAyah" 
              class="bi-play-circle-fill h4 custom-icon-play-main"
              style="cursor: pointer;" 
              aria-label="Play or pause translation audio"
            ></i> -->
          </div>
          <div class="col-md-10">
            <MainAyah :information="information" />
          </div>
        </div>

        <!-- Tafseer and Control Icons -->
        <div ref="targetTafseerElement" class="row text-left mt-2">

          <div class="col-10">
            <h4 class="ayah-translation" style="line-height: 1.6em" :style="{ fontSize: fontSize + 'em', lineHeight: '1.6em' }" >
              {{ expanded ? tafseer : tafseer }}
            </h4>
            <!-- text summary -->
            <div v-if="isVisible">
              <div class="container row">
                <button @click="getSummary" :disabled="loading" class="button-36 summary">
                  <span v-if="loading" class="spinner"></span>
                  {{ loading ? "Summarizing..." : "Generate Summary" }}
                </button>
              </div>
              
              <div v-if="summary" class="summary">
                <button class="close-btn" @click="closeSummary">x</button>
                <p class="summary-textarea">{{ summary }}</p>
              </div>

              <div v-if="error" class="error">
                <p>{{ error }}</p>
              </div> 
            </div>
          </div>

          <!-- Control Icons Column (Stacked Vertically) -->
          <div @touchstart.stop @touchend.stop v-if="isVisible" class="col-2 d-flex align-items-center justify-content-center flex-column">
            <i 
              @click="toggleSpeech" 
              :class="['bi', isReading ? (isPaused ? 'bi-play-circle-fill' : 'bi-pause-circle-fill') : 'bi-play-circle-fill', 'h3', 'custom-icon-play']"
              style="cursor: pointer;" 
              aria-label="Play or pause translation audio"
            ></i>

            <i 
              @click="stopReading" 
              class="bi bi-stop-circle-fill h3 custom-icon-play"
              :disabled="!isAudioPlaying"
              style="cursor: pointer;"
              aria-label="Stop reading audio"
            ></i>
            
            <i 
              @click="increaseFontSize" 
              class="bi bi-plus-circle-fill h3 custom-icon-increase"
              style="cursor: pointer;" 
              aria-label="Increase font size"
            ></i>

            <i 
              @click="decreaseFontSize" 
              class="bi bi-dash-circle-fill h3 custom-icon-decrease"
              style="cursor: pointer;" 
              aria-label="Decrease font size"
            ></i> 
           
          </div>
        </div>

        

        <!-- Word Count and Additional Information -->
        <div v-if="wordCount" class="word-count">
          <h6 class="text-left mt-3">
            <img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy"/>
            <strong>Total Word count: </strong>{{ wordCount }}
          </h6>
          <h6 class="text-left mt-3">
            <img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy"/>
            <strong>Tafseer: </strong>Tafseer Ibn Kathir
          </h6>
          <!-- <h6 class="text-left mt-3">
            <img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy"/>
            <strong>Reciter's name: </strong>Mishary Rashid Alafasy
          </h6> -->
        </div>

        <!-- <div v-if="isVisible" class="row">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Export as
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item active" href="#" @click.prevent="handleDownload('csv')">CSV file</a></li>
              <li><a class="dropdown-item" href="#" @click.prevent="handleDownload('docx')">Word document</a></li>
            </ul>
          </div>
        </div> -->
        
      </div>
    </div>

    <!-- Alert Modal -->
    <AlertModal 
      :showAlertText="showAlertText" 
      :showAlert="showAlert" 
      :showErrorAlert="showErrorAlert" 
      :showAlertTextNote="showAlertTextNote" 
      @close-alert-text="closeAlertText" 
    />
  </div>
</template>

<script defer>
import AyahInfo from "./translation/AyahInfo.vue";
import MainAyah from "./translation/MainAyah.vue";
import AlertModal from "./modals/AlertModal.vue";
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
	name: "TafseerSection",
	components: {
		AyahInfo,
		MainAyah,
		AlertModal,
	},
	props: {
		isVisible: {
      type: Boolean,
      required: true
    },
		information: Object,
		isFullScreen: Boolean,
		showAlertText: Boolean,
		showAlert: Boolean,
		showErrorAlert: Boolean,
		showAlertTextNote: Boolean,
	},
	computed: {
		wordCount() {
			const text = this.expanded ?
					this.tafseer :
					this.tafseer;
			return text ? text.trim().split(/\s+/).length : 0; // Calculate the word count
		},

		combinedText() {
			// Get the ayah_text from information
			const ayahText =
					typeof this.information.ayah_text === "object" ?
					this.information.ayah_text.text :
					this.information.ayah_text;

			// Return the formatted string
			return `Tafseer: ${this.ayah_text}`;
		}
	},
	data() {
		return {
      summary: "", // Generated summary
      error: "", // Error message
      loading: false, // Loading state
      API_TOKEN: "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", // Hugging Face API token
      BASE_URL: "https://api-inference.huggingface.co/models/facebook/bart-large-cnn", // Hugging Face API URL
			selectedFormat: "Select a format",
			// renderedText: this.tafseer,
			fontSize: parseFloat(localStorage.getItem('ayahFontSize')) || 1,
			holdDuration: 1000,
			tapCount: 0,
			lastTap: 0,
			lastTapTime: 0,
			doubleTapThreshold: 300,
			isHolding: false,
			tapTimeout: null,
			holdTimeout: null,
			holdDuration: 1000,
			isPaused: false,
			isReading: false,
			resetDisabled: true,
			utterance: null,
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
		isVisible() {
      this.$emit('toggle-change');
    },
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
		this.renderedText = this.tafseer;
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
			this.currentFontSize = 14; // Default font size
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
    closeSummary() {
      this.summary = ""; // Clear the summary to hide the textarea
    },
    async getSummary() {
      this.error = ""; // Reset error message
      this.summary = ""; // Reset summary
      this.loading = true; // Set loading state
      try {
        const response = await axios.post(
          this.BASE_URL,
          { 
            inputs: this.tafseer,
            parameters: {
              max_length: 150, // Maximum length of the summary
              min_length: 50,  // Minimum length of the summary
              do_sample: true, // Disable randomness for consistent output
            }, 
          },
          {
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
        // case "pdf":
        //   this.downloadAsPdf();
        //   break;
        default:
          alert("Unknown format selected.");
      }
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
          ["Translation", this.tafseer],
          ["Translator", "Tafseer Ibn Kathir"],
        ]
        .map((row) => row.map(escapeCsvValue).join(",")) // Escape and join each row
        .join("\n");

      // Create a blob for the CSV content
      const blob = new Blob([csvContent], {
        type: "text/csv;charset=utf-8;",
      });

      const date = new Date();
      const formattedDate = date.toISOString().split("T")[0]; // e.g., 2024-11-19

      // Append the date to the filename
      const filename = `tafseer_${formattedDate}.csv`;

      // Save the file with the dynamic filename
      saveAs(blob, filename);
    },
		async downloadAsWord() {
      const doc = new Document({
        sections: [
          {
            properties: {},
            children: [
              // Title Section
              new Paragraph({
                children: [
                  new TextRun({
                    text: "Quran Tafseer Document",
                    bold: true,
                    size: 48, // 24pt font size
                    color: "1F4E79" // Dark blue
                  })
                ],
                alignment: "CENTER",
                spacing: { after: 400 } // Adds space below title
              }),

              // Subtitle Section (Optional)
              new Paragraph({
                children: [
                  new TextRun({
                    text: "Prepared by Islamic Connect",
                    italics: true,
                    size: 24, // 12pt font size
                    color: "808080" // Gray color
                  })
                ],
                alignment: "CENTER",
                spacing: { after: 600 }
              }),

              // Translation Header
              new Paragraph({
                children: [
                  new TextRun({
                    text: "Tafseer:",
                    bold: true,
                    size: 32, // 16pt font size for header
                    color: "2B5797" // Slightly lighter blue
                  })
                ],
                spacing: { after: 200 } // Adds space after header
              }),

              // Translation Content
              new Paragraph({
                children: [
                  new TextRun({
                    text: this.tafseer,
                    bold: false,
                    size: 28, // 14pt font size for content
                    color: "000000" // Black color for readability
                  })
                ],
                spacing: { after: 400 } // Adds space after translation
              }),

              // Translator Header
              new Paragraph({
                children: [
                  new TextRun({
                    text: "Tafseer:",
                    bold: true,
                    size: 32,
                    color: "2B5797"
                  })
                ],
                spacing: { after: 200 }
              }),

              // Translator Content
              new Paragraph({
                children: [
                  new TextRun({
                    text: "Tafseer Ibn Kathir",
                    italics: true,
                    size: 28,
                    color: "000000"
                  })
                ]
              }),
            ]
          }
        ]
      });
      const blob = await Packer.toBlob(doc);
      
      const date = new Date();
      const formattedDate = date.toISOString().split("T")[0]; // e.g., 2024-11-19

      // Append the date to the filename
      const filename = `tafseer_${formattedDate}.docx`;

      // Save the file with the dynamic filename
      saveAs(blob, filename);
    },
		toggleSpeechAyah() {
      this.isReading = !this.isReading;
      this.isPaused = !this.isPaused;
      this.$emit('toggle-audio', this.isReading);
    },
		handleStart() {
      // Start hold timer
      this.holdTimeout = setTimeout(() => {
        this.isHolding = true;
        this.toggleSpeech();
      }, this.holdDuration);
    },

    // Handle the swipe end event
    handleEnd() {
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
    },
    cancelHold() {
      // Cancel hold if user leaves the area before holding duration
      clearTimeout(this.holdTimeout);
      this.isHolding = false;
    },

		playAudio() {
			this.$emit('toggle-audio'); // Show the audio player in the parent component
		},
		pauseAudio() {
			this.$emit('pause-audio'); // Trigger pause method in the parent
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
					<span style="background-color: rgba(0, 191, 166, 4.133);padding:4px;border-radius:5px">${currentWord}</span>
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
	// created() {
	// 		const savedFontSize = localStorage.getItem('ayahFontSize');
	// 		this.fontSize = savedFontSize ? parseFloat(savedFontSize) : this.fontSize; // Set initial font size
	// },
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
  min-height: 100px; /* Adjust height as needed */
  padding: 10px;
  font-family: inherit;
  font-size: inherit;
  color: #333;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  border-radius: 4px;
  line-height: 1.5em;
  white-space: pre-wrap; /* Preserve formatting */
  overflow: auto; /* Allow scrolling if content overflows */
  resize: vertical; /* Allow user to resize vertically */
}

.close-btn {
  right: 5px;
  background-color: transparent;
  border: none;
  font-size: 1.2em;
  cursor: pointer;
  color: #333;
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
