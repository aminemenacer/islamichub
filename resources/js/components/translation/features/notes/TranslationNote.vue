<template>
  <div class="modal fade" id="translationNote" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true" ref="modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1"><b>Notes & Reflections</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-secondary">Save your notes and personal reflections privately. Oftentimes your reflections can deeply resonate with your connection to the Quran, and your relationship with Allah.</p>
          <form @submit.prevent="createNote">
            <div class="row">
              <div class="form-check col-md-4">
                <input class="form-check-input" type="radio" name="inputMode" id="basicMode" value="basic" v-model="inputMode">
                <label class="form-check-label" for="basicMode">
                  Basic
                </label>
              </div>
              <div class="form-check col-md-4">
                <input class="form-check-input" type="radio" name="inputMode" id="audioMode" value="audio" v-model="inputMode">
                <label class="form-check-label" for="audioMode">
                  Audio Note Recording
                </label>
              </div>
              <div class="form-check col-md-4">
                <input class="form-check-input" type="radio" name="inputMode" id="editorMode" value="editor" v-model="inputMode">
                <label class="form-check-label" for="editorMode">
                  Editor Keyboard
                </label>
              </div>
            </div>

            <div class="mt-3">
              <!-- Audio Recording Mode -->
              <div v-if="inputMode === 'audio'">
                <button type="button" class="btn btn-success" @click="startRecognition" :disabled="isListening">
                  Start Recording
                </button>
                <button type="button" class="btn btn-secondary" @click="stopRecognition" :disabled="!isListening">
                  Stop Recording
                </button>
                <p v-if="isListening">Listening...</p>
                <textarea v-model="form.ayah_notes" class="form-control pb-2" rows="5" placeholder="Your speech will appear here..." :readonly="isListening"></textarea>
              </div>
              
              <!-- Rich Text Editor Mode -->
              <Editor v-if="inputMode === 'editor'" v-model="form.ayah_notes" editorStyle="height: 400px" name="ayah_notes" placeholder="Save your notes and personal reflections privately. Oftentimes your reflections can deeply resonate with your connection to the Quran, and your relationship with Allah."></Editor>
              
              <!-- Basic Mode -->
              <textarea v-if="inputMode === 'basic'" v-model="form.ayah_notes" class="form-control pb-2" rows="5" placeholder="Save your notes and personal reflections privately. Oftentimes your reflections can deeply resonate with your connection to the Quran, and your relationship with Allah."></textarea>
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
import Editor from 'primevue/editor';
import { Modal } from 'bootstrap';

export default {
  data() {
    return {
      inputMode: 'basic',
      recognition: null,
      isListening: false,
      form: {
        ayah_notes: ""
      }
    };
  },
  components: {
    Editor
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