<template>
  <div class="modal fade" id="translationNote" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true" ref="modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1"><b>Write a Note</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="createNote">
            <div class="row container mt-3">
              <h5 class="text-left pb-2 font-weight-bold">Notes & Reflections</h5>
              <div class="col">
                <h1>Speech to Text</h1>
                <button type="button" @click="startRecognition">Start Recognition</button>
                <button type="button" @click="stopRecognition">Stop Recognition</button>
                <p v-if="isListening">Listening...</p>
                <textarea v-model="form.ayah_notes" placeholder="Your speech will appear here..."></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { Modal } from 'bootstrap';

export default {
  data() {
    return {
      recognition: null,
      isListening: false,
      form: {
        ayah_notes: ""
      }
    };
  },
  mounted() {
    this.initRecognition();
  },
  methods: {
    initRecognition() {
      const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

      if (!SpeechRecognition) {
        alert('Your browser does not support Speech Recognition.');
        return;
      }

      this.recognition = new SpeechRecognition();
      this.recognition.lang = 'en-US';
      this.recognition.interimResults = false;
      this.recognition.maxAlternatives = 1;

      this.recognition.onresult = (event) => {
        const result = event.results[0][0].transcript;
        this.form.ayah_notes += result + '\n';
      };

      this.recognition.onerror = (event) => {
        console.error('Speech Recognition Error:', event.error);
      };

      this.recognition.onend = () => {
        this.isListening = false;
      };
    },
    startRecognition() {
      if (!this.recognition) {
        this.initRecognition();
      }
      this.form.ayah_notes = ''; // Clear previous transcript
      this.recognition.start();
      this.isListening = true;
    },
    stopRecognition() {
      if (this.recognition && this.isListening) {
        this.recognition.stop();
        this.isListening = false;
      }
    },
    createNote() {
      const formData = {
        ayah_notes: this.form.ayah_notes,
        // Add any other required fields here
      };

      Swal.fire({
        title: "Are you sure?",
        text: "You want to submit this note!",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "#d33",
        confirmButtonText: "Submit!"
      }).then(result => {
        if (result.isConfirmed) {
          axios.post("api/submit-note", formData)
            .then(res => {
              if (res.data.success) {
                Swal.fire({
                  icon: "success",
                  title: "Success!",
                  text: "Your note has been submitted.",
                  timer: 1500,
                  showConfirmButton: false
                }).then(() => {
                  this.resetNoteForm();
                  this.closeModal();
                });
              } else {
                Swal.fire("Error", "Submission failed", "error");
              }
            })
            .catch(err => {
              console.error(err);
              Swal.fire("Error", "There was an error submitting your note.", "error");
            });
        }
      });
    },
    resetNoteForm() {
      this.form.ayah_notes = '';
    },
    showModal() {
      const modalElement = this.$refs.modal;
      const modalInstance = Modal.getInstance(modalElement) || new Modal(modalElement);
      modalInstance.show();
    },
    closeModal() {
      const modalElement = this.$refs.modal;
      const modalInstance = Modal.getInstance(modalElement) || new Modal(modalElement);
      modalInstance.hide();
      
      // Clean up any backdrops
      const modalBackdrops = document.querySelectorAll('.modal-backdrop');
      modalBackdrops.forEach(backdrop => {
        backdrop.parentNode.removeChild(backdrop);
      });
      
      document.body.classList.remove('modal-open');
    }
  }
};
</script>

<style scoped>
button {
  margin: 10px;
}
</style>
