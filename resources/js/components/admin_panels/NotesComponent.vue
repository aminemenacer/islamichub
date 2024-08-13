<template>
  <div>
    <h2 class="pt-4 pb-3 text-center"><strong>Notes</strong></h2>

    <div class="container mt-3">
      <div class="row">
        <div class="col-md-4 mb-4" v-for="note in notes" :key="note.id">
          <div class="card" style="border-radius:8px;padding:10px; border: 2px solid rgba(0, 191, 166);">
            <div class="card-body">
              <div>
                <h5><strong>Surah Name:</strong></h5>
                <p>{{note.surah_name}}</p>
              </div>
              <div class="mt-2">
                <h5><strong>Note:</strong></h5>
                <div v-html="truncatedHtml(note.ayah_notes)"></div>
              </div>
              <hr />
              <span v-if="note.is_speech_to_text" class="badge bg-info">Speech to Text</span>
              <i class="bi bi-eye-fill h4" style="color:rgb(0, 191, 166); cursor:pointer" @click="viewModal(note)"></i>
              <i class="bi bi-trash-fill h4 ml-3" style="color:rgb(0, 191, 166); cursor:pointer" @click="deleteNote(note.id)"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- View Note Modal -->
    <div class="modal fade" id="viewNotes" tabindex="-1" aria-labelledby="viewNotesLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="viewNotesLabel"><b>View Note</b></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="mb-3">
                <label class="form-label"><strong>Surah Name:</strong></label>
                <p class="mt-2 text-dark text-left">{{ selectedNote.surah_name }}</p>
              </div>
              <div class="mb-3">
                <label class="form-label"><strong>Ayah Verse Arabic:</strong></label>
                <p class="mt-2 text-dark text-left">{{ selectedNote.ayah_verse_ar }}</p>
              </div>
              <div class="mb-3">
                <label class="form-label"><strong>English Info:</strong></label>
                <p class="mt-2 text-dark text-left">{{ selectedNote.ayah_verse_en }}</p>
              </div>
              <div class="mb-3">
                <label class="form-label"><strong>Notes:</strong></label>
                <div class="mt-2 text-dark text-left" v-html="selectedNote.ayah_notes"></div>
              </div>
              <div class="mb-3">
                <label class="form-label"><strong>Date Created:</strong></label>
                <p class="mt-2 text-dark text-left">{{ extractDate(selectedNote.created_at) }}</p>
              </div>
              <div class="mb-3" v-if="selectedNote.is_speech_to_text">
                <span class="badge bg-info">Created using Speech to Text</span>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
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
      notes: [],
      selectedNote: {},
    };
  },
  mounted() {
    this.fetchNotes();
  },
  methods: {
    fetchNotes() {
      axios.get(`/api/notes/${this.userId}`)
        .then(response => {
          this.notes = response.data;
        })
        .catch(error => {
          console.error('Error fetching notes:', error);
        });
    },
    truncatedHtml(html, maxLength = 150) {
      const div = document.createElement("div");
      div.innerHTML = html;
      const plainText = div.textContent || div.innerText || "";
      if (plainText.length > maxLength) {
        const truncatedText = plainText.substring(0, maxLength) + '...';
        div.innerHTML = truncatedText;
        return div.innerHTML;
      }
      return html;
    },
    viewModal(note) {
      this.selectedNote = note;
      const modal = new Modal(document.getElementById('viewNotes'));
      modal.show();
    },
    deleteNote(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`/api/delete-note/${id}`)
            .then(() => {
              Swal.fire("Deleted!", "Your note has been deleted.", "success");
              this.fetchNotes();
            })
            .catch((error) => {
              console.error('Error deleting note:', error);
              Swal.fire("Error!", "Failed to delete the note.", "error");
            });
        }
      });
    },
    extractDate(dateTimeString) {
      return dateTimeString.split('T')[0];
    }
  } 
};
</script>

<style scoped>
.card {
  transition: all 0.3s ease;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>