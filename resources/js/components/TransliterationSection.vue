<template>
<div class="w-100 my-element" :class="{'full-screen': isFullScreen}">
  <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
  <div ref="targetTransliterationElement">
    <AyahInfo :information="information" />
    <div @touchstart="handleStart" @touchend="handleEnd" @mousedown="handleStart" @mouseup="handleEnd" @mouseleave="cancelHold" class="swipeable-div w-100">
      <div class="row">
        <div class="col-md-2 pt-2 d-flex align-items-center justify-content-center"></div>
        <div class="col-md-10">
          <MainAyah :information="information" />
        </div>
      </div>
      <div ref="targetTransliterationElement" class="row text-left mt-2">
        <div class="col-10">
          <h4 class="ayah-translation" style="line-height: 1.6em" :style="{ fontSize: fontSize + 'em', lineHeight: '1.6em' }">
            {{ expanded ? information.transliteration : information.transliteration }}
          </h4>
        </div>
        <div @touchstart.stop @touchend.stop v-if="isVisible" class="col-2 d-flex align-items-center justify-content-center flex-column">
          <i @click="increaseFontSize" class="bi bi-plus-circle-fill h3 custom-icon-increase" aria-label="Increase font size"></i>
          <i @click="decreaseFontSize" class="bi bi-dash-circle-fill h3 custom-icon-decrease" aria-label="Decrease font size"></i>
        </div>
      </div>

      <!-- text summary -->
      <div v-if="isVisible">
        <div class="container row">
            <button @click="getSummary" :disabled="loading" class="button-36">
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

      <div class="text-left word-count mt-2">
        <h6 class="text-left mt-3"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy" /><strong>Total Word count: </strong>{{ wordCount }}</h6>
      </div>
      <h6 class="text-left mt-3 word-count"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy" /><strong>Transliteration: </strong>Saheeh International</h6>
      <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
    </div>
    <div class="text-left mt-3 word-count">
      <h6 class="text-left"><img src="/images/art.png" class="pr-2" width="30px" alt="lamp" loading="lazy" /><strong>Reciter's name: </strong>Mishary Rashid Alafasy</h6>
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
</template>

<script>
import AyahInfo from './translation/AyahInfo.vue';
import MainAyah from './translation/MainAyah.vue';
import AlertModal from './modals/AlertModal.vue';
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
  name: 'TransliterationSection',
  components: {
    AyahInfo,
    MainAyah,
    AlertModal
  },
  props: {
    isVisible: Boolean,
    information: Object,
    isFullScreen: Boolean,
    showAlertText: Boolean,
    showAlert: Boolean,
    showErrorAlert: Boolean,
    showAlertTextNote: Boolean,
  },
  data() {
    return {
      summary: "", // Generated summary
      error: "", // Error message
      loading: false, // Loading state
      API_TOKEN: "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", // Hugging Face API token
      BASE_URL: "https://api-inference.huggingface.co/models/facebook/bart-large-cnn", // Hugging Face API URL
      selectedFormat: "Select a format",
      fontSize: parseFloat(localStorage.getItem('ayahFontSize')) || 1,
      expanded: false,
      isPaused: false,
      isReading: false,
    }
  },
  computed: {
    wordCount() {
      const text = this.information.transliteration || "";
      return text.trim().split(/\s+/).length;
    }
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
            inputs: this.information.transliteration,
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
    increaseFontSize() {
      this.fontSize += 0.2;
      this.saveFontSize();
    },
    decreaseFontSize() {
      if (this.fontSize > 1) {
        this.fontSize -= 0.2;
        this.saveFontSize();
      }
    },
    saveFontSize() {
      localStorage.setItem('ayahFontSize', this.fontSize);
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
          ["Translation", this.information.transliteration],
          ["Transliteration", "Saheeh International"],
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
      const filename = `transliteration_${formattedDate}.csv`;

      // Download the file
      saveAs(blob, filename);
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
                  text: this.information.transliteration,
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
                  text: "Transliteration:",
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
                  text: "Saheeh International",
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

      // Get the current date and format it as YYYY-MM-DD
      const date = new Date();
      const formattedDate = date.toISOString().split("T")[0]; // e.g., 2024-11-19

      // Append the date to the filename
      const filename = `transliteration_${formattedDate}.docx`;

      // Save the file with the dynamic filename
      saveAs(blob, filename);

    },
    toggleFullScreen() {
      this.$emit('toggle-full-screen');
    },
    toggleExpand() {
      this.expanded = !this.expanded;
    },
    closeAlertText() {
      this.$emit('close-alert-text');
    },
  },
  watch: {
    isVisible() {
      this.$emit('toggle-change');
    }
  },
}
</script>

<style scoped>
.swipeable-div {
  transition: transform 0.3s ease;
}
 
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

.close-btn {
  right: 5px;
  background-color: transparent;
  border: none;
  font-size: 1.2em;
  cursor: pointer;
  color: #333;
}

:root {
  --primary-color: rgb(13, 182, 145);
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

.word-count {
  margin-top: 10px;
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

/* Mobile Media Queries */
.mobile-only {
  display: none;
}

@media (max-width: 768px) {
  .mobile-only {
    display: flex;
  }
}

@media (max-width: 576px) {
  .mobile-only {
    display: flex;
  }

  .hide-on-mobile {
    display: none;
  }
}
</style>
