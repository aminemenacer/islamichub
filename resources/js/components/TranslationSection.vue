<template>
<div class="tab-pane active" id="home" role="tabpanel" v-if="information != null">
 <div class="icon-container pb-3">
  <div class="icon-container w-100 hide-on-mobile pb-3">
   <!-- Icon Buttons -->
   <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" data-bs-toggle="modal" data-bs-target="#translationNote" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
   <i class="bi bi-whatsapp text-right mr-2 h4" @click="shareTextViaWhatsApp3" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
   <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
   <i @click="copyText3" class="bi bi-clipboard-check text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
   <i class="bi bi-camera text-right mr-2 h3" @click="captureScreenshot3" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
   <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#bugTranslation" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
   <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166); cursor: pointer;" @click="toggleFullScreen" title="Full screen"></i>
   <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166); cursor: pointer;" data-bs-target="#translationInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i>
  </div>

  <!-- Mobile Icons -->
  <div class="dropdown mobile-only">
   <div class="icon-container">
    <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166);" @click="goToFirstAyah()" title="First verse"></i>
    <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166);" @click="goToPreviousAyah()" title="Previous verse"></i>
    <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166);" @click="goToNextAyah()" title="Next verse"></i>
    <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166);" @click="goToLastAyah()" title="End verse"></i>
    <i class="bi bi-arrows-fullscreen h6" style="color: rgb(0, 191, 166); cursor: pointer;" @click="toggleFullScreen" title="Full screen"></i>
    <i style="color: rgb(0, 191, 166); cursor: pointer;" class="bi bi-three-dots-vertical h5 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>
    <ul class="dropdown-menu">
     <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#translationNote"><i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" style="color: rgba(0, 191, 166);"></i>Write a Note</a></li>
     <li><a class="dropdown-item" @click="shareTextViaWhatsApp3"><i class="bi bi-whatsapp text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166);"></i>Share via WhatsApp</a></li>
     <li><a class="dropdown-item" @click="submitForm"><i class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);"></i>Bookmark Verse</a></li>
     <li><a class="dropdown-item" @click="copyText3"><i class="bi bi-clipboard-check text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166);"></i>Copy Verse</a></li>
     <li><a class="dropdown-item" @click="captureScreenshot3"><i class="bi bi-camera text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166);"></i>Screenshot Verse</a></li>
     <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#translationInfo"><i class="bi bi-info-circle text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Surah info" style="color: rgba(0, 191, 166);"></i>Surah Info</a></li>
     <li><a class="dropdown-item" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#bugTranslation"><i class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Report a bug" style="color: rgba(0, 191, 166);"></i>Report a bug</a></li>
    </ul>
   </div>
  </div>
 </div>

 <div ref="targetElement" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
  <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
  <div class="container">
   <h5 class="mr-2 container">
    <p class="container">{{ information.ayah.surah.name_en }} {{ information.ayah.surah_id }}: {{ information.ayah.ayah_id }}</p>
   </h5>
  </div>

  <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
   <div class="btn">
    <h5 class="text-right ayah-translation" name="ayah_text" style="line-height: 1.6em">{{ information.ayah.ayah_text }}</h5>
   </div>
   <h5 class="text-left ayah-translation" ref="heading3" style="line-height: 1.6em">
    {{ expanded ? information.translation : truncatedText(information.translation) }}
    <template v-if="showMoreLink">
     <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
    </template>
   </h5>
   <h6 class="text-left mt-3"><strong>Translation: </strong>Ahmed Ali</h6>

   <!-- Alerts -->
   <div v-if="showAlertText" class="alert alert-success alert-dismissible fade show mt-2" role="alert">Text copied successfully!</div>
   <div v-if="showAlert" class="alert alert-success mt-2" role="alert">Bookmark created successfully!</div>
   <div v-if="showErrorAlert" class="alert alert-danger" role="alert">Login to your account to be able to bookmark verses.</div>
   <div v-if="showAlertTextNote" class="alert alert-danger" role="alert">Please log in to write a note.</div>
  </div>
 </div>
</div>
</template>

<script>
import html2canvas from 'html2canvas';

export default {
 props: {
  information: {
   type: Object,
   required: true
  },
 },
 data() {
  return {
   expanded: false,
   isFullScreen: false,
   showAlertText: false,
   showAlert: false,
   showErrorAlert: false,
   showAlertTextNote: false,
   touchStartX: 0,
   touchEndX: 0,
  };
 },
 methods: {
  toggleFullScreen() {
   this.isFullScreen = !this.isFullScreen;
  },
  shareTextViaWhatsApp3() {
   const text3 = this.$refs.targetElement.innerText;
   const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(text3)}`;
   window.open(url);
  },
  shareHeadingOnTwitter3() {
   try {
    const headingText3 = this.$refs.targetElement.textContent.trim();
    const encodedHeading = encodeURIComponent(headingText3);
    const twitterUrl = `https://twitter.com/intent/tweet?text=${encodedHeading}`;
    window.open(twitterUrl, "_blank") || console.error("Failed to open Twitter sharing dialog.");
   } catch (error) {
    console.error("Error:", error);
   }
  },
  createCorrection() {
   Swal.fire({
    title: "Are you sure?",
    text: "You want to submit message!",
    showCancelButton: true,
    confirmButtonColor: "green",
    cancelButtonColor: "#d33",
    confirmButtonText: "Submit!",
   }).then((result) => {
    if (result.isConfirmed) {
     axios
      .post("/api/submit-correction", this.form)
      .then((res) => {
       if (!res.data.success) {
        Swal.fire({
         position: "top-end",
         icon: "success",
         title: "Message submitted succesfully",
         showConfirmButton: false,
         timer: 1500,
        });
        // Close the modal after successful submission
        this.resetForm();
        $('#exampleModal').modal('hide');
        this.form.name = "";
        this.form.email = "";
        this.form.mistake_type = "";
        this.form.added_notes = "";
        this.form.ayah_num = "";
        this.showModal = false;
       } else if (res.data.success) {
        Swal.fire(
         "Error!",
         "Unable to create correction.",
         "error"
        );
        // Ensure any modal overlay is removed
        document.body.classList.remove('modal-open');
        const modals = document.querySelectorAll('.modal-backdrop');
        modals.forEach(modal => modal.remove());
       }
       this.resetForm();
       $('#exampleModal').modal('hide');
       this.form.name = "";
       this.form.email = "";
       this.form.mistake_type = "";
       this.form.added_notes = "";
       this.form.ayah_num = "";
       // Ensure any modal overlay is removed
       document.body.classList.remove('modal-open');
       const modals = document.querySelectorAll('.modal-backdrop');
       modals.forEach(modal => modal.remove());
      })
     this.resetForm();
     $('#exampleModal').modal('hide');
    }
   }).catch((err) => {
    console.error(err);
    Swal.fire("Error!", "Failed to submit. Fill in all the fields", "error");
   });
  },
  handleTouchStart(event) {
   this.touchStartX = event.changedTouches[0].screenX;
   this.touchStartY = event.changedTouches[0].screenY;
   this.touchStartTime = Date.now();
  },
  handleTouchMove(event) {
   this.touchEndX = event.changedTouches[0].screenX;
   this.touchEndY = event.changedTouches[0].screenY;
  },
  handleTouchEnd() {
   const touchEndTime = Date.now();
   const timeDiff = touchEndTime - this.touchStartTime;
   const deltaX = this.touchEndX - this.touchStartX;
   const deltaY = this.touchEndY - this.touchStartY;

   const minSwipeDistance = 50; // Minimum distance in pixels to be considered a swipe
   const maxTapDistance = 10; // Maximum distance in pixels to be considered a tap
   const maxSwipeDuration = 500; // Maximum duration in ms to be considered a swipe
   const maxTapDuration = 200; // Maximum duration in ms to be considered a tap

   // Check if it's a tap
   if (Math.abs(deltaX) < maxTapDistance && Math.abs(deltaY) < maxTapDistance && timeDiff < maxTapDuration) {
    this.onTap();
   }
   // Check if it's a swipe
   else if (
    Math.abs(deltaX) > minSwipeDistance &&
    timeDiff < maxSwipeDuration &&
    Math.abs(deltaX) > Math.abs(deltaY) // Ensure it's a horizontal swipe
   ) {
    if (deltaX > 0) {
     this.onSwipeRight();
    } else {
     this.onSwipeLeft();
    }
   }
  },
  createNote() {
   const formData = {
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.information.translation,
    ayah_notes: this.form1.ayah_notes // Add ayah_notes to formData
   };

   Swal.fire({
    title: "Are you sure?",
    text: "You want to submit note!",
    showCancelButton: true,
    confirmButtonColor: "green",
    cancelButtonColor: "#d33",
    confirmButtonText: "Submit!"
   }).then((result) => {
    if (result.isConfirmed) {
     axios
      .post("/api/submit-note", formData)
      .then((res) => {
       if (res.data.success) {
        Swal.fire({
         icon: "success",
         title: "Success!",
         text: "Your note has been submitted.",
         timer: 1500,
         showConfirmButton: false
        }).then(() => {
         // Close the modal
         $('#exampleModal1').modal('hide');
         // Reset the form inputs
         this.form1.surah_name = "";
         this.form1.ayah_num = "";
         this.form1.ayah_text = "";
         this.form1.ayah_notes = "";
         // Ensure any modal overlay is removed
         document.body.classList.remove('modal-open');
         const modals = document.querySelectorAll('.modal-backdrop');
         modals.forEach(modal => modal.remove());
        });
       } else {
        Swal.fire({
         icon: "success",
         title: "Success!",
         text: "Your note has been submitted.",
         timer: 1500,
         showConfirmButton: false
        }).then(() => {
         // Close the modal
         $('#exampleModal1').modal('hide');
         // Reset the form inputs
         this.form1.surah_name = "";
         this.form1.ayah_num = "";
         this.form1.ayah_text = "";
         this.form1.ayah_notes = "";
         // Ensure any modal overlay is removed
         document.body.classList.remove('modal-open');
         const modals = document.querySelectorAll('.modal-backdrop');
         modals.forEach(modal => modal.remove());
        });
       }
      })
      .catch((err) => {
       console.error(err);
       Swal.fire("Error!", "Failed to submit note. Login or create an account to be able to write a note", "error");
      });
    }
   });
  },
  resetNoteForm() {
   this.form1.ayah_notes = '';
  },
  hideNoteModal() {
   this.$refs.noteModal.hide();
  },
  closeModal(modalId) {
   const modalElement = document.getElementById(modalId);
   const modalInstance = new bootstrap.Modal(modalElement);

   modalInstance.hide();

   // Remove any existing modal backdrops
   const modalBackdrops = document.querySelectorAll('.modal-backdrop');
   modalBackdrops.forEach(backdrop => {
    backdrop.parentNode.removeChild(backdrop);
   });

   // Ensure modal-open class is removed from body
   document.body.classList.remove('modal-open');
  },
  resetForm() {
   this.form1.surah_name = "";
   this.form1.ayah_num = "";
   this.form1.ayah_text = "";
   this.form1.ayah_notes = "";
  },

  closeModal(modalId) {
   const modalElement = document.getElementById(modalId);
   const modalInstance = new bootstrap.Modal(modalElement);

   modalInstance.hide();

   // Ensure modal backdrop is properly removed
   const modalBackdrops = document.querySelectorAll('.modal-backdrop');
   modalBackdrops.forEach(backdrop => {
    backdrop.parentNode.removeChild(backdrop);
   });

   // Reset body class to remove modal-open if necessary
   document.body.classList.remove('modal-open');
  },
  resetForm() {
   this.form.reset();
   this.form1.reset();
   const exampleModal2 = bootstrap.Modal.getInstance(this.$refs.exampleModal2);
   if (exampleModal2) {
    exampleModal2.hide();
   }
  },
  copyText3() {
   const range = document.createRange();
   range.selectNode(this.$refs.heading3);
   const selection = window.getSelection();
   selection.removeAllRanges();
   selection.addRange(range);
   document.execCommand('copy');
   selection.removeAllRanges();
   this.showAlertText = true;
   setTimeout(() => {
    this.showAlertText = false;
   }, 2000);
  },
  captureScreenshot3() {
   html2canvas(this.$refs.targetElement).then(canvas => {
    const link = document.createElement('a');
    link.href = canvas.toDataURL('image/png');
    link.download = 'screenshot.png';
    link.click();
   });
  },
  truncatedText(text) {
   if (!text) return '';
   return text.length > this.maxLength ?
    text.substring(0, this.maxLength) + '...' :
    text;
  },
  toggleExpand() {
   this.expanded = !this.expanded;
  },
  hideAlertAfterDelay() {
   setTimeout(() => {
    this.showAlert = false;
    this.showAlertText = false;
    this.showErrorAlert = false;
   }, 3000); // Adjust the duration (in milliseconds) as needed
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
