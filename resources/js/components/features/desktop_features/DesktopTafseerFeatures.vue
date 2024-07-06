<template>
<div class="icon-container w-100 hide-on-mobile pb-3">
 <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" data-bs-toggle="modal" data-bs-target="#tafseerNote" style="color: rgba(0, 191, 166);cursor:pointer"></i>
 <i class="bi bi-whatsapp text-right mr-2 h4" @click="shareTextViaWhatsApp1" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166);cursor:pointer"></i>
 <i style=" color:rgb(0, 191, 166); cursor:pointer" @click="shareHeadingOnTwitter1" class="mr-2 bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X"></i>
 <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
 <i class="bi bi-clipboard-check text-right mr-2 h4" @click="copyText1" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
 <i class="bi bi-camera text-right mr-2 h3" @click="captureScreenshot1" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166); cursor:pointer"></i>
 <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#bugTafseer" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166);cursor:pointer"></i>
 <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
 <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#tafseerInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i>
</div>
</template>

<script>
import html2canvas from 'html2canvas';

export default {
 methods: {
  shareTextViaWhatsApp1() {
   const text1 = this.$refs.targetElement1.innerText;
   const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(text1)}`;
   window.open(url, '_blank');
  },
  shareHeadingOnTwitter1() {
   try {
    const headingText1 = this.$refs.targetElement1.textContent.trim();
    const encodedHeading = encodeURIComponent(headingText1);
    const twitterUrl = `https://twitter.com/intent/tweet?text=${encodedHeading}`;
    window.open(twitterUrl, "_blank") || console.error("Failed to open Twitter sharing dialog.");
   } catch (error) {
    console.error("Error:", error);
   }
  },
  submitForm() {
   const formData = {
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.information.translation,
   };

   axios.post('/bookmarks', formData)
    .then(response => {
     console.log(response.data.message);
     // Set the submitted status for the selected bookmark
     localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
     // Log the updated bookmarkSubmitted object
     console.log(this.bookmarkSubmitted);
     this.showAlert = true; // Show success alert
     this.showErrorAlert = false; // Hide error alert
     this.hideAlertAfterDelay(); // Start timer to hide alert
    })
    .catch(error => {
     console.error(error);
     this.showAlert = false; // Hide success alert
     this.showErrorAlert = true; // Show error alert
     //  Swal.fire({
     //   title: "Error!",
     //   text: "You need to be logged in to create a bookmark.",
     //   icon: "error",
     //   confirmButtonText: "OK"
     //  });
     this.hideAlertAfterDelay(); // Start timer to hide alert
    });
  },
  copyText3() {
   console.log(this.$refs.heading3);
   var textToCopy3 = this.$refs.heading3.innerText;
   console.log(textToCopy3);
   // Copy the text to the clipboard
   this.copyToClipboard(textToCopy3);
   this.showAlertText = true; // Show success alert
   this.showErrorAlert = false; // Hide error alert
   this.hideAlertAfterDelay(); // Start timer to hide alert
  },
  captureScreenshot1() {
   const targetElement1 = this.$refs.targetElement1;

   // Capture screenshot for targetElement after 5 seconds
   setTimeout(() => {
    html2canvas(targetElement1).then(canvas => {
     const dataUrl = canvas.toDataURL('image/png');
     this.downloadUrl = dataUrl;

     // Simulate click on download link after 2 seconds
     setTimeout(() => {
      const downloadLink = document.createElement('a');
      downloadLink.href = dataUrl;
      downloadLink.download = 'screenshot.png';
      downloadLink.click();
     }, 4); // 2000 milliseconds = 2 seconds
    });
   }, 4); // 5000 milliseconds = 5 seconds
  },
  toggleFullScreen() {
   this.isFullScreen = !this.isFullScreen;
  },
  goToFirstAyah() {
   this.selectAyah(0);
  },
  goToPreviousAyah() {
   if (this.selectedIndexAyah > 0) {
    this.selectAyah(this.selectedIndexAyah - 1);
   } else {
    this.selectAyah(this.ayahs.length - 1);
   }
  },
  goToNextAyah() {
   if (this.selectedIndexAyah < this.ayahs.length - 1) {
    this.selectAyah(this.selectedIndexAyah + 1);
   } else {
    this.selectAyah(0);
   }
  },
  goToLastAyah() {
   this.selectAyah(this.ayahs.length - 1);
  },
 }
}
</script>

<style scoped>
.icon-container {
 display: flex;
 justify-content: space-between;
 align-items: center;
}

.mobile-only {
 display: none;
}

@media (max-width: 768px) {
 .hide-on-mobile {
  display: none;
 }

 .mobile-only {
  display: block;
 }
}
</style>
