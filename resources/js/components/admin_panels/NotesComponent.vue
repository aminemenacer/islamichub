<template>
  <div>
    <h2 class="pt-4 pb-3 text-center"><strong>Notes</strong></h2>

    <!-- Container visible only on mobile screens -->
    <div class="container text-center mt-3 d-md-none">
      <div class="row pb-2 text-center">
        <div class="col">
          <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#B70D52;background:#ead1dc">
            <a href="/bookmarks" style="text-decoration:none;color:#B70D52;background:#ead1dc">Bookmarks</a>
          </span>
        </div>
        <div class="col">
          <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#0263FF;background:#c2d8fb">
            <a href="/home" style="text-decoration:none;color:#0263FF;background:#c2d8fb">Home</a>
          </span>
        </div>
      </div>
    </div>

    <!-- Notes Container -->
    <div class="container mt-3">
      <div class="row">
        <div class="col-md-4 mb-4" v-for="note in notes" :key="note.id">
          <!-- Note Card -->
          <div class="card" style="border-radius:8px;padding:10px; border: 2px solid rgba(0, 191, 166);">
            <div class="card-body">
              <!-- Note details -->
              <div>
                <h5><strong>Surah Name:</strong></h5>
                <p>{{note.surah_name}}</p>
              </div>
              <div class="mt-2">
                <h5><strong>Note:</strong></h5>
                <div v-html="note.ayah_notes"></div>
              </div>
              <hr />
             
              <i class="bi bi-eye-fill h4" style="color:rgb(0, 191, 166); cursor:pointer" @click="viewModal(note)"></i>
              <i class="bi bi-pencil-square ml-3 h4" style="color:rgb(0, 191, 166); cursor:pointer" @click="editModal(note)"></i>
              <i class="bi bi-trash-fill h4 ml-3" style="color:rgb(0, 191, 166); cursor:pointer" @click="deleteNote(note.id)"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Note Modal -->
    <div class="modal fade" id="editNotes" tabindex="-1" aria-labelledby="editNotesLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="editNotesLabel"><strong>Edit Note</strong></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateNotes">
              <div class="form-group mr-2" style="display: flex">
                <!-- Editor Component -->
                <Editor editorStyle="height: 320px" v-model="form.ayah_notes" name="ayah_notes"></Editor>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- View Note Modal -->
    <div class="modal fade" id="viewNotes" tabindex="-1" aria-labelledby="viewNotesLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="viewNotesLabel">View Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label"><strong>Surah Name:</strong></label>
                <p class="mt-2 text-dark text-left">
                  {{ form.surah_name }}
                </p>
              </div>
              <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label"><strong>Ayah Verse Arabic:</strong></label>
                <p class="mt-2 text-dark text-left">
                  {{ form.ayah_verse_ar }}
                </p>
              </div>
              <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label"><strong>English Info:</strong></label>
                <p class="mt-2 text-dark text-left">
                  {{ form.ayah_verse_en }}
                </p>
              </div>
              <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label"><strong>Notes:</strong></label>
                <div class="mt-2 text-dark text-left" v-html="form.ayah_notes"></div>
              </div>
              <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label"><strong>Date Created:</strong></label>
                <p class="mt-2 text-dark text-left">
                  {{ extractDate(form.created_at) }}
                </p>
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
import axios from "axios";
import Swal from "sweetalert2";
import { FilterMatchMode } from "primevue/api";
import { Editor } from 'primevue/editor';


export default {
  components: {
    Editor
  },
  mounted() {
    fetch('/api/userId')
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to fetch user ID');
        }
        return response.json();
      })
      .then(data => {
        const userId = data.userId; // Assuming the API returns the user ID in a field called userId
        console.log('UserId:', userId);

        if (userId) {
          this.userId = userId;
          this.fetchNotes(this.userId);
        } else {
          console.error('User ID not found');
        }
      })
      .catch(error => {
        console.error('Error fetching user ID:', error);
      });
  },

  data() {
    return {
      notes: [],
      userId: null,
      form: {
        id: "",
        surah_name: "",
        ayah_verse_ar: "",
        ayah_verse_en: "",
        ayah_notes: "",
        created_at: ""
      },
      maxLength: 100
    };
  },

  methods: {
    extractDate(dateTimeString) {
      return dateTimeString.split('T')[0];
    },
    async fetchNotes(userId) {
      try {
        const response = await fetch(`/api/fetch-notes/${userId}`);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        this.notes = await response.json();
      } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
      }
    },
    viewModal(note) {
      this.form = {
        ...note
      }; // Make sure form is populated
      $('#viewNotes').modal('show');
    },
    
    truncatedText(text) {
      const maxLength = 50; // Define your desired max length here
      if (text.length > maxLength) {
        return text.substring(0, maxLength) + '...';
      } else {
        return text;
      }
    },
    updateNotes() {
      Swal.fire({
        title: "Are you sure you want to update?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, update notes!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post(`api/update-notes/${this.form.id}`, this.form)
            .then(() => {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Note updated successfully",
                showConfirmButton: false,
                timer: 1500,
              });
              this.fetchNotes(this.userId);
              const editNotesModal = bootstrap.Modal.getInstance(document.getElementById('editNotes'));
              if (editNotesModal) {
                editNotesModal.hide();
              }
              // Ensure any modal overlay is removed
              document.body.classList.remove('modal-open');
              const modals = document.querySelectorAll('.modal-backdrop');
              modals.forEach(modal => modal.remove());
            })
            .catch((error) => {
              console.error(error);
            });
        }
      });
    },
    deleteNote(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then(result => {
        if (result.isConfirmed) {
          axios.delete(`/api/delete-notes/${id}`)
            .then(() => {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Note deleted successfully",
                showConfirmButton: false,
                timer: 1500,
              });
              this.fetchNotes(this.userId);
            })
            .catch((error) => {
              console.error(error);
            });
        }
      });
    },
    openEditModal(note) {
      this.selectedNote = note;
      this.form.ayah_notes = note.content; // Assume the note content is stored in note.content
      const editModal = new bootstrap.Modal(document.getElementById('editNotes'));
      editModal.show();
    },
    editModal(note) {
      this.form = {
        ...note
      }; // Make sure form is populated
      $('#editNotes').modal('show');
    },
  },
};
</script>
