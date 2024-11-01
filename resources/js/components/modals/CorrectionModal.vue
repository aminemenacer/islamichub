<template>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"><b>Rate your experience</b></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="createCorrection" id="reportForm">
            <!-- Rating -->
            <h6 class="text-left"><b>Your Rating:</b></h6>
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
              <h6><b>What could we improve on?</b></h6>
            </div>

            <!-- Audio Recording Mode -->
            <div>
              <div class="container text-center">
                <div class="row">
                  <div class="col">
                    <button type="button" class="btn btn-success me-2" @click="startRecognition" :disabled="isListening">
                      <i class="bi bi-play-circle text-white"></i> Start Recording
                    </button>
                  </div>
                  <div class="col">
                    <button type="button" class="btn btn-danger" @click="stopRecognition" :disabled="!isListening">
                      <i class="bi bi-stop-circle text-white"></i> Stop Recording
                    </button>
                  </div>
                </div>
              </div>
            

              <!-- Status -->
              <div class="mt-3">
                <h3 v-if="isListening" class="text-success"><b class="pt-3">Listening...</b></h3>
              </div>

              <!-- Transcript Text Area -->
              <textarea v-model="form.added_notes" class="form-control pb-2" rows="5" placeholder="Your speech will appear here..." :readonly="isListening"></textarea>
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
      recognition: null,
      form: {
        added_notes: '',
        rating: 0,
      },
    };
  },

  mounted() {
    this.initRecognition();
  },

  methods: {
    // Initialize speech recognition
    initRecognition() {
      this.recognition = new webkitSpeechRecognition();
      this.recognition.continuous = true;
      this.recognition.interimResults = true;
      this.recognition.lang = 'en-US';

      this.recognition.onresult = (event) => {
        const transcript = Array.from(event.results)
          .map(result => result[0].transcript)
          .join('');
        this.form.added_notes = transcript;
      };

      this.recognition.onend = () => {
        this.isListening = false;
      };

      this.recognition.onerror = (event) => {
        console.error('Speech Recognition Error:', event.error);
        this.isListening = false;
      };
    },

    // Start speech recognition
    startRecognition() {
      if (!this.isListening) {
        this.form.added_notes = '';
        this.isListening = true;
        this.recognition.start();
      }
    },

    // Stop speech recognition
    stopRecognition() {
      if (this.isListening) {
        this.recognition.stop();
        this.isListening = false;
      }
    },

    // Set star rating
    setRating(star) {
      this.form.rating = star;
    },

    // Create the correction form submission
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
                this.resetForm();  // Reset form fields after submission
                this.closeModal();  // Close modal after submission
              } else {
                Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "Message submitted successfully",
                  showConfirmButton: false,
                  timer: 1500,
                });
                this.resetForm();  // Reset form fields after submission
                this.closeModal();  // Close modal after submission
              }
            })
            .catch((err) => {
              console.error(err);
              Swal.fire("Error!", "Failed to submit. Fill in all the fields", "error");
            });
        }
      });
    },

    // Reset form fields
    resetForm() {
      this.form.added_notes = '';
      this.form.rating = 0;
    },

    // Close modal and reset form
    closeModal() {
      this.resetForm();  // Reset form when modal closes

      const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
      modal.hide();  // Hide modal programmatically
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
