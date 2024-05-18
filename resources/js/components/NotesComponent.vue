<template>
<div>
 <h2 class="pt-4 pb-3 text-center"><strong>Notes</strong></h2>
 <a href="/home" style="color:#00BFA6; text-decoration:none" class="h4 text-left pb-3">Back</a>

 <div class="row">
  <div class="col-md-4 mb-4" v-for="note in notes" :key="note.id">
   <div class="card">
    <div class="card-body">
     <div>
      <h5 > <strong >Surah Name:</strong></h5> <b>{{ note.surah_name }}</b>
     </div>
     <div class="mt-2">
      <h5>Note:</h5> {{ note.ayah_notes }}
     </div>
     <hr />
     <i class="bi bi-eye-fill h4" style="color:rgb(0, 191, 166); cursor:pointer" data-bs-toggle="modal" data-bs-target="#viewNotes" @click="viewModal(note)"></i>
     <i class="bi bi-pencil-square ml-3 h4" style="color:rgb(0, 191, 166); cursor:pointer" data-bs-toggle="modal" data-bs-target="#editNotes" @click="editModal(note)"></i>
     <i class="bi bi-trash-fill h4 ml-3" style="color:rgb(0, 191, 166); cursor:pointer" @click="deleteNote(note.id)"></i>
    </div>
   </div>
  </div>
 </div>

 <!-- edit user -->
 <div class="modal fade" id="editNotes" tabindex="-1" aria-labelledby="editNotes" aria-hidden="true">
  <div class="modal-dialog modal-lg">
   <div class="modal-content">
    <div class="modal-header">
     <h5 class="modal-title text-dark" id="addNew">
      Edit Note
     </h5>
     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
     </button>
    </div>
    <div class="modal-body">
     <form @submit.prevent="updateNotes()">
      <div class="form-group mr-3" style="display: flex">
       <label class="mt-2 mr-2 col-sm-3">Surah Name:</label>
       <input v-model="form1.surah_name" type="text" name="surah_name" placeholder="Enter firstname" class="form-control" readonly />
      </div>

      <div class="form-group mr-2" style="display: flex">
       <label class="mt-2 mr-2 col-sm-3">Ayah Verse Arabic:</label>
       <textarea v-model="form1.ayah_verse_ar" type="text" name="ayah_verse_ar" placeholder="Enter lastname" class="form-control" rows="5" readonly></textarea>
      </div>

      <div class="form-group" style="display: flex">
       <label class="mt-2 mr-2 col-sm-3">English Info:</label>
       <textarea v-model="form1.ayah_verse_en" name=" form1.ayah_verse_en" id="email" placeholder="Enter email" class="form-control" rows="5" readonly></textarea>
      </div>

      <div class="form-group mr-2" style="display: flex">
       <label class="mt-2 mr-2 col-sm-3">Notes:</label>
       <textarea v-model="form1.ayah_notes" type="text" name="ayah_notes" placeholder="Enter phone number" class="form-control" rows="5"></textarea>
      </div>

      <div class="modal-footer">
       <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
        Close
       </button>

       <button type="submit" class="btn btn-primary">
        Update
       </button>
      </div>
     </form>
    </div>
   </div>
  </div>
 </div>

 <!-- View Note Modal -->
 <div class="modal fade" id="viewNotes" tabindex="-1" aria-labelledby="viewNotes" aria-hidden="true">
  <div class="modal-dialog modal-lg">
   <div class="modal-content">
    <div class="modal-header">
     <h5 class="modal-title text-dark" id="viewBookmarkLabel">View Note</h5>
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
import {
 FilterMatchMode
} from "primevue/api";
export default {
 mounted() {
  this.loadNotes();
 },
 data() {
  return {
   filters: {
    global: {
     value: null,
     matchMode: FilterMatchMode.CONTAINS,
    },
   },
   notes: null,
   columns: [{
     field: "id",
     header: "ID",
     sortable: true,
    },
    {
     field: "surah_name",
     header: "Surah name",
     sortable: true,
    },
    // {
    //   field: "ayah_num",
    //   header: "Ayah number",
    //   sortable: true,
    // },
    {
     field: "ayah_verse_ar",
     header: "Arabic verse",
     sortable: true,
    },
    {
     field: "ayah_verse_en",
     header: "English Info",
     sortable: true,
    },
    {
     field: "ayah_notes",
     header: "Notes",
     sortable: true,
    },

   ],
   sortDesc: false,
   form1: new Form({
    id: "",
    surah_name: "",
    ayah_num: "",
    ayah_verse_ar: "",
    ayah_verse_en: "",
    ayah_info: "",
    ayah_notes: "",
   }),
   maxLength: 100, // Set your desired max length
  }
 },
 computed: {
  truncatedText() {
   if (!this.form.ayah_text) return '';
   return this.form.ayah_text.length > this.maxLength ?
    this.form.ayah_text.substring(0, this.maxLength) + '...' // Append ellipsis
    :
    this.form.ayah_text;

   if (!this.form.ayah_notes) return '';
   return this.form.ayah_notes.length > this.maxLength ?
    this.form.ayah_notes.substring(0, this.maxLength) + '...' // Append ellipsis
    :
    this.form.ayah_notes;
  },
 },
 methods: {
  loadNotes() {
   axios.get("api/fetch-notes").then((data) => {
    this.notes = data.data;
   });
  },
  updateNotes() {
   Swal.fire({
     title: "Are you sure you want to update?",
     icon: "warning",
     showCancelButton: true,
     confirmButtonColor: "#3085d6",
     cancelButtonColor: "#d33",
     confirmButtonText: "Yes, update notes!",
    },
    1000
   ).then((result) => {
    if (result.isConfirmed) {
     axios.post(`api/update-notes/${this.form1.id}`, this.form1);
     Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Note updated successfully ",
      showConfirmButton: false,
      timer: 1500,
     });
     $("#editNew").modal("hide");

     this.loadNotes();

     self.close();
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
      .catch(error => {
       console.error(error);
      });
    }
   });
  },
  viewModal(note) {
   this.form1.reset();
   this.form1.fill(note);
   const viewBookmarkModal = new bootstrap.Modal(document.getElementById('viewBookmark'));
   viewBookmarkModal.show();
  },
  //edit user modal
  editModal(notes) {
   this.editmode = true;
   this.form1.reset();
   this.form1.fill(notes);
  },

 },
}
</script>

<style>

</style>
