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
                <Editor v-model="form.ayah_notes" editorStyle="height: 400px" name="ayah_notes" placeholder="Save your notes and personal reflections privately."></Editor>
                
                <button @click="toggleSpeechRecognition" type="button" class="btn btn-primary mt-2">
                  {{ isListening ? 'Stop Listening' : 'Start Speech to Text' }}
                </button>
                
                <p v-if="isListening" class="text-success mt-2">Listening...</p>
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
import Editor from 'primevue/editor';
import { Modal } from 'bootstrap';

export default {
  props: {
    information: {
      type: Object,
      default: () => ({
        ayah: {
          surah: { name_en: '', ayah_text:'', },
          ayah_text: '', surah_name: ''
        },
        ayah_id: null,
        translation: ''
      })
    }
  },
  components: {
    Editor
  },
  data() {
    return {
      isListening: false,
      recognition: null,
      form: {
        ayah_notes: "",
        surah_name: "",
        ayah_num: "",
        ayah_verse_ar: "",
        ayah_verse_en: "",
        ayah_info: "",
        is_speech_to_text: false
      }
    };
  },
  mounted() {
    this.initializeSpeechRecognition();
  },
  methods: {
    initializeSpeechRecognition() {
      if ('webkitSpeechRecognition' in window) {
        this.recognition = new webkitSpeechRecognition();
        this.recognition.continuous = true;
        this.recognition.interimResults = true;
        
        this.recognition.onresult = (event) => {
          let interimTranscript = '';
          for (let i = event.resultIndex; i < event.results.length; ++i) {
            if (event.results[i].isFinal) {
              this.form.ayah_notes += event.results[i][0].transcript + ' ';
            } else {
              interimTranscript += event.results[i][0].transcript;
            }
          }
        };
        
        this.recognition.onerror = (event) => {
          console.error('Speech recognition error:', event.error);
          this.isListening = false;
        };
        
        this.recognition.onend = () => {
          this.isListening = false;
        };
      } else {
        console.error('Speech recognition not supported');
      }
    },
    
    toggleSpeechRecognition() {
      if (this.isListening) {
        this.recognition.stop();
      } else {
        this.recognition.start();
        this.form.is_speech_to_text = true;
      }
      this.isListening = !this.isListening;
    },
    
    createNote() {
      const { ayah } = this.information;
      if (!ayah || !ayah.surah) {
        Swal.fire("Error!", "Information data is missing.", "error");
        return;
      }

      this.form.surah_name = ayah.surah.name_en;
      this.form.ayah_num = this.information.ayah_id;
      this.form.ayah_verse_ar = ayah.ayah_text;
      this.form.ayah_verse_en = this.information.translation;
      this.form.ayah_info = `${ayah.surah.name_en} - Ayah ${this.information.ayah_id}`;

      axios.post("api/submit-note", this.form)
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
              this.closeModal('translationNote');
            });
          } else {
            Swal.fire("Error!", "Failed to submit note.", "error");
          }
        })
        .catch(err => {
          console.error(err);
          Swal.fire("Error!", "An error occurred while submitting the note.", "error");
        });
    },
    
    resetNoteForm() {
      this.form = {
        ayah_notes: "",
        surah_name: "",
        ayah_num: "",
        ayah_verse_ar: "",
        ayah_verse_en: "",
        ayah_info: "",
        is_speech_to_text: false
      };
    },
    
    closeModal() {
      const modalElement = this.$refs.modal;
      const modalInstance = Modal.getInstance(modalElement);
      if (modalInstance) {
        modalInstance.hide();
      }
    }
  }
};
</script>