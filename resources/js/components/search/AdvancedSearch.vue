<template>
<div>
 <!-- Search Input Group -->
 <div class="container input-group">
  <input type="text" v-model="searchTerm" placeholder="Type any word to search for ayah translation..." class="form-control" />
  <button class="btn btn-success" @click="searchWord">Search</button>
 </div>

 <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasResults" style="width: 60%;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Search Results</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body text-left custom-offcanvas">
    <div v-if="filteredResults.length">
      <div v-for="result in filteredResults" :key="result.id" class="result-item">
        <div :id="'result-' + result.id">
          <!-- Display Surah ID and Ayah ID -->
          <div class="text-left pb-2">
            <h4>{{ result.ayah.surah_id }} : {{ result.ayah.ayah_id }}</h4>
          </div>
          <!-- Display Ayah Text -->
          <h3 class="text-right">{{ result.ayah.ayah_text }}</h3>
          <!-- Display Translated Text -->
          <p v-html="highlightSearch(result.translation)"></p>
        </div>

        <div class="container pt-2 row text-center">
          <div class="col">
            <i class="bi bi-file-earmark-pdf h4 me-3 text-center" style="cursor: pointer;" @click="downloadPDF(result)"></i>
          </div> 
          <div class="col">
            <i class="bi bi-clipboard-check h4 me-3 text-center" style="cursor: pointer;" @click="copyTranslationText(result)"></i>
          </div>

          <div class="col">
            <i class="bi bi-whatsapp h4 me-3 text-center" style="cursor: pointer;" @click="shareViaWhatsapp(result)"></i>
          </div>
          <div class="col">
            <i class="bi bi-download h4 me-3 text-center" style="cursor: pointer;" ></i>
          </div>
        </div>

        <hr>
      </div>
    </div>
    <div v-else>
      <p>No results found.</p>
    </div>


  </div>
</div>

<!-- Alert Messages -->
    <div v-if="showAlertText" class="alert alert-success" role="alert">
      Text copied successfully!
    </div>
    <div v-if="showErrorAlert" class="alert alert-danger" role="alert">
      Failed to copy text!
    </div>
</div>
</template>

<style scoped>
.alert-container {
  position: absolute; /* Position it absolutely */
  top: 10px; /* Adjust this value to control vertical position */
  left: 10px; /* Adjust this value to control horizontal position */
  z-index: 1000; /* Ensure it appears above other content */
}

.alert {
  margin-bottom: 10px; /* Add some spacing between alerts */
}
.custom-offcanvas {
  background-color: #10584f;
  color: white;
}

.custom-offcanvas .result-item {
  margin-bottom: 15px;
}

.pdf-content {
  /* Adjust text properties */
  font-family: Arial, sans-serif; /* Set a specific font */
  font-size: 14px; /* Set a base font size */
  line-height: 1.5; /* Set line height for readability */
  color: black; /* Set default text color to black */
  padding: 10px; /* Add padding for better layout */
}

.translation-text {
  color: black; /* Ensure translation text is visible */
  margin-top: 10px; /* Add spacing above the translation */
}

</style>

<script>
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

export default {
 data() {
  return {
   searchTerm: '',
   filteredResults: [],

  };
 },
  props: {
    result: Object
  },
 methods: {
    downloadPDF(result) {
      const element = document.getElementById(`result-${result.id}`);
      
      // Ensure the text is visible before capturing
      element.style.color = 'black'; // Set text color to black for visibility
      
      html2canvas(element).then((canvas) => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4',
          });
        const fileName = `Surah_${result.ayah.surah_id}_Ayah_${result.ayah.ayah_id}.pdf`;

        pdf.addImage(imgData, 'PNG', 10, 10, 190, 0); // Adjust the dimensions as needed
        // Save the PDF with a dynamic name
        pdf.save(fileName);

        // Reset text color back to original after capture
        element.style.color = ''; // Reset to original or any preferred color
      }).catch((error) => {
        console.error('Error capturing the element:', error);
      });
    },
  copyText(result) {
    // Logic to copy the text from the result
    const textToCopy = `${result.ayah.surah_id}:${result.ayah.ayah_id} - ${result.ayah.ayah_text}\n${result.translation}`;
    navigator.clipboard.writeText(textToCopy);
    alert('Text copied to clipboard');
  },
  shareViaWhatsapp(result) {
    const message = `Ayah Info: ${result.ayah.surah_id} ${result.ayah.ayah_id}, Ayah: ${result.ayah.ayah_text}, Ayah Translation: ${result.ayah.ayah_text}\nNote: ${result.translation}`;
    const encodedMessage = encodeURIComponent(message); // Encode special characters
    const whatsappUrl = `https://wa.me/?text=${encodedMessage}`;
    window.open(whatsappUrl, '_blank');
  },
  searchWord() {
   if (this.searchTerm.length > 0) {
    axios
     .get("/search-translations", {
      params: {
       query: this.searchTerm
      }
     })
     .then(response => {
      this.filteredResults = response.data;
      this.showOffcanvas();
     })
     .catch(error => {
      console.error(error);
     });
   } else {
    this.filteredResults = [];
   }
  },
  highlightSearch(translation) {
   if (!translation) {
    console.warn("The translation is undefined or null for this result:", translation);
    return '';
   }
   const regex = new RegExp(`(${this.searchTerm})`, 'gi');
   return translation.replace(regex, "<span class='highlight'>$1</span>");
  },
  copyTranslationText(text) {
      this.copyToClipboard(text)
        .then(() => {
          this.showAlertText = true;
          this.showErrorAlert = false;
          this.hideAlertAfterDelay();
        })
        .catch(() => {
          this.showAlertText = false;
          this.showErrorAlert = true;
          this.hideAlertAfterDelay();
        });
    },
    copyToClipboard(text) {
      return navigator.clipboard.writeText(text);
    },
    hideAlertAfterDelay() {
      setTimeout(() => {
        this.showAlertText = false;
        this.showErrorAlert = false;
      }, 2000);
    },
  showOffcanvas() {
   const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasResults'));
   offcanvas.show();
  },
  onInputChange() {
   this.searchWord(); // Automatically search as you type
  }
 }
};
</script>

