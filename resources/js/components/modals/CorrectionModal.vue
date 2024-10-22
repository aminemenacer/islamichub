<template>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel"><b>Rate your experience</b></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
   <div class="modal-body">
    <form @submit.prevent="createCorrection" id="reportForm">
     <!-- Rating -->
     <label for="rating" class="form-label text-left">Your Rating</label>
     <div class="text-center">
      <div class="row star-rating">
       <div class="col container-fluid text-left">
        <span v-for="star in 5" :key="star" @click="setRating(star)" :class="{ 'active': star <= form.rating }">
         &#9733;
        </span>
       </div>
      </div>
     </div>
     <!-- Notes -->
     
     <div class="mb-3 mt-3 text-left">
      <label for="added_notes" class="form-label text-left">What could we improve on ?</label>
      <!-- <textarea v-model="form.added_notes" class="form-control h4" name="added_notes" placeholder="Enter you message here..." id="added_comments" rows="5" required></textarea> -->
     </div>

      <div class="container mt-5">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
          </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h3>Home Content</h3>
            <p>This is the content for the Home tab.</p>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <h3>Profile Content</h3>
            <p>This is the content for the Profile tab.</p>
          </div>
        </div>
      </div>
     <!-- Audio Recording Mode -->
     <div>
      <div class="container pt-3 text-center">
       <div class="row">
        <div class="col">
         <!-- Start Button -->
         <button type="button" class="btn btn-success me-2" @click="startRecognition" :disabled="isListening || isPaused">
          <i class="bi bi-play-circle"></i> Start Recording
         </button>
        </div>
        <div class="col">
         <!-- Stop Button -->
         <button type="button" class="btn btn-danger" @click="stopRecognition" :disabled="!isListening && !isPaused">
          <i class="bi bi-stop-circle"></i> Stop Recording
         </button>
        </div>
       </div>
      </div>

      <!-- Status -->
      <div class="mt-3">
       <h3 v-if="isListening" class="text-success"><b class="pt-3">Listening...</b></h3>
       <h3 v-if="isPaused" class="text-warning"><b class="pt-3">Paused...</b></h3>
      </div>

      <textarea v-model="form.ayah_notes" class="form-control pb-2" rows="5" placeholder="Your speech will appear here..." :readonly="isListening || isPaused"></textarea>
     </div>
     
    </form>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" form="reportForm" class="btn btn-success">Submit</button>
   </div>
  </div>
 </div>
</div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
 name: 'CorrectionModal',

 data() {
  return {
    isListening: false,
    isPaused: false,
    recognition: null,
   form: {
    mistake_type: '',
    added_notes: '',
    ayah_num: '',
    rating: 0,
   },
  };
 },
 mounted() {
  this.initRecognition();
 },
 methods: {
  // Start recording
    startRecognition() {
      if (!this.recognition) {
        this.initRecognition();  // Initialize if not already initialized
      }
      if (!this.isListening) {
        this.form.ayah_notes = '';  // Clear previous transcript on fresh start
        this.isListening = true;
        this.recognition.start();   // Start speech recognition
      }
    },

    // Stop the recording completely
    stopRecognition() {
      if (this.recognition && this.isListening) {
        this.recognition.abort();   // Completely abort the session
        this.isListening = false;
      }
    },


  // Initialize speech recognition
  initRecognition() {
    this.recognition = new webkitSpeechRecognition();
    this.recognition.continuous = true;  // Allow continuous recognition without time limit
    this.recognition.interimResults = true;  // Show partial results during speech
    this.recognition.lang = 'en-US';

    // Handling recognition results
    this.recognition.onresult = (event) => {
      const transcript = Array.from(event.results)
        .map(result => result[0].transcript)
        .join('');
      this.form.ayah_notes = transcript;  // Update form with transcript
    };

    // Handle recognition end (when manually stopped)
    this.recognition.onend = () => {
      this.isListening = false;
    };

    // Handle errors
    this.recognition.onerror = (event) => {
      console.error('Speech Recognition Error:', event.error);
      this.isListening = false;
    };
  },

  setInactivityTimeout() {
    this.clearInactivityTimeout();  // Clear any existing timer
    this.timeoutID = setTimeout(() => {
      if (this.isListening) {
        console.log("Stopping due to inactivity");
        this.stopRecognition();  // Stop recognition after 3 seconds of inactivity
      }
    }, 3000);  // 3 seconds of inactivity
  },

  // Clear the inactivity timer
  clearInactivityTimeout() {
    if (this.timeoutID) {
      clearTimeout(this.timeoutID);
      this.timeoutID = null;
    }
  },
  setRating(star) {
   this.form.rating = star;
  },
  hideAlertAfterDelay() {
   setTimeout(() => {
    this.showAlert = false;
    this.showAlertText = false;
    this.showErrorAlert = false;
   }, 3000); // Adjust the duration (in milliseconds) as needed
  },
  createCorrection() {
   Swal.fire({
    title: "Are you sure?",
    text: "You want to submit the message!",
    showCancelButton: true,
    confirmButtonColor: "green",
    cancelButtonColor: "#d33",
    confirmButtonText: "Submit!",
   }).then((result) => {
    if (result.isConfirmed) {
     axios.post("/submit-correction", this.form)
      .then((res) => {
       if (res.data.success) {
        Swal.fire({
         position: "top-end",
         icon: "success",
         title: "Message submitted successfully",
         showConfirmButton: false,
         timer: 1500,
        });
        this.resetForm();
        this.hideModal();
       } else {
        Swal.fire({
         position: "top-end",
         icon: "success",
         title: "Message submitted successfully",
         showConfirmButton: false,
         timer: 1500,
        });
       }
      })
      .catch((err) => {
       console.error(err);
       Swal.fire("Error!", "Failed to submit. Fill in all the fields", "error");
      });
    }
   });
  },
  resetForm() {
   this.form.mistake_type = '';
   this.form.added_notes = '';
   this.form.ayah_num = '';
   this.form.rating = 0;
  },
  hideModal() {
   const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
   modal.hide();
  }
 }
};
</script>

<style scoped>
.star-rating {
 font-size: 38px;
 color: #ddd;
}

.star-rating span {
 cursor: pointer;
}

.star-rating span.active {
 color: gold;
}
</style>
