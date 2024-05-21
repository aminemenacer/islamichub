<template>
  <div>
    <h2 class="pt-4 pb-3 text-center"><strong>Notes</strong></h2>

    <div class="text-center">
      <div class="row">
        <div class="col">
          <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#3D8F67;background:#d1f4d0">
            <a href="/profile" style="text-decoration:none;color:#3D8F67;background:#d1f4d0">Profile</a>
          </span>
        </div>
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

     <h1>Notes for User {{ userId }}</h1>
    <ul>
      <li v-for="note in notes" :key="note.id">
        <strong>Surah:</strong> {{ note.surah_name }}<br>
        <strong>Ayah Number:</strong> {{ note.ayah_num }}<br>
        <strong>Ayah Verse (AR):</strong> {{ note.ayah_verse_ar }}<br>
        <strong>Ayah Verse (EN):</strong> {{ note.ayah_verse_en }}<br>
        <strong>Info:</strong> {{ note.ayah_info }}<br>
        <strong>Notes:</strong> {{ note.ayah_notes }}<br>
        <hr>
      </li>
    </ul>

    <div class="row">
      <div class="col-md-4 mb-4" v-for="note in notes" :key="note.id">
        <div class="card">
          <div class="card-body">
            <div>
              <h5><strong>Surah Name:</strong></h5> <b>{{ note.surah_name }}</b>
            </div>
            <div class="mt-2">
              <h5>Note:</h5> {{ note.ayah_notes }}
            </div>
            <hr />
            <i class="bi bi-eye-fill h4" style="color:rgb(0, 191, 166); cursor:pointer" @click="viewModal(note)"></i>
            <i class="bi bi-pencil-square ml-3 h4" style="color:rgb(0, 191, 166); cursor:pointer" @click="editModal(note)"></i>
            <i class="bi bi-trash-fill h4 ml-3" style="color:rgb(0, 191, 166); cursor:pointer" @click="deleteNote(note.id)"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Note Modal -->
    <div class="modal fade" id="editNotes" tabindex="-1" aria-labelledby="editNotesLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="editNotesLabel">Edit Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateNotes">
              <h3 class="mt-2 mr-2 col-sm-3">Notes:</h3>
              <div class="form-group mr-2" style="display: flex">
                <textarea v-model="form1.ayah_notes" type="text" name="ayah_notes" placeholder="Enter notes" class="form-control" rows="5"></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
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
            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">ID:</label>
              <p class="mt-2 text-dark">{{ form1.id }}</p>
            </div>
            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Surah Name:</label>
              <p class="mt-2 text-dark">{{ form1.surah_name }}</p>
            </div>
            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Ayah Verse Arabic:</label>
              <p class="mt-2 text-dark">{{ form1.ayah_verse_ar }}</p>
            </div>
            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">English Info:</label>
              <p class="mt-2 text-dark">{{ form1.ayah_verse_en }}</p>
            </div>
            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Notes:</label>
              <p class="mt-2 text-dark">{{ form1.ayah_notes }}</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
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

export default {
  mounted() {
    try {
      // Dynamically extract userId from the URL path
      const pathSegments = window.location.pathname.split('/');
      const userIdIndex = pathSegments.indexOf('users') + 1;
      const userId = userIdIndex > 0 ? pathSegments[userIdIndex] : null;

      console.log('URL Path:', window.location.pathname);
      console.log('Extracted userId:', userId);

      if (userId) {
        this.userId = userId;
        this.fetchNotes(userId);
      } else {
        console.error('User ID not found in URL path');
      }
    } catch (error) {
      console.error('Error while extracting userId:', error);
    }
  
  },
  data() {
    return {
      filters: {
        global: {
          value: null,
          matchMode: FilterMatchMode.CONTAINS,
        },
      },
      notes: [],
      userId: null,
      columns: [
        { field: "id", header: "ID", sortable: true },
        { field: "surah_name", header: "Surah name", sortable: true },
        { field: "ayah_verse_ar", header: "Arabic verse", sortable: true },
        { field: "ayah_verse_en", header: "English Info", sortable: true },
        { field: "ayah_notes", header: "Notes", sortable: true },
      ],
      form1: {
        id: "",
        surah_name: "",
        ayah_verse_ar: "",
        ayah_verse_en: "",
        ayah_notes: "",
      },
    };
  },
  methods: {
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
      this.form1 = { ...note };  // Make sure form1 is populated
      const viewNotesModal = new bootstrap.Modal(document.getElementById('viewNotes'));
      viewNotesModal.show();
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
          axios.post(`api/update-notes/${this.form1.id}`, this.form1)
            .then(() => {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Note updated successfully",
                showConfirmButton: false,
                timer: 1500,
              });
              this.loadNotes();
              const editNotesModal = bootstrap.Modal.getInstance(document.getElementById('editNotes'));
              editNotesModal.hide();
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
              this.loadNotes();
            })
            .catch((error) => {
              console.error(error);
            });
        }
      });
    },
    editModal(note) {
      this.form1 = { ...note };  // Make sure form1 is populated
      const editNotesModal = new bootstrap.Modal(document.getElementById('editNotes'));
      editNotesModal.show();
    },
  },
};
</script>
