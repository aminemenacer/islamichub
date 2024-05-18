<template>

<div>
 <h2 class="pt-4 pb-2 text-center"><strong>Bookmarks</strong></h2>

  <div class="text-center">
    <div class="row">
      <div class="col">
        <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#B70D52;background:#ead1dc"><a href="/notes" style="text-decoration:none;color:#B70D52;background:#ead1dc">Notes</a></span>
      </div>
      <div class="col">
        <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#3D8F67;background:#d1f4d0"><a href="/profile" style="text-decoration:none;color:#3D8F67;background:#d1f4d0">Profile</a></span>
      </div>
      <div class="col">
        <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#0263FF;background:#c2d8fb"><a href="/home" style="text-decoration:none;color:#0263FF;background:#c2d8fb">Home</a></span>
      </div> 
    </div>
  </div>

 <div class="row">
  <div class="col-md-4 mb-4" v-for="bookmark in bookmarks" :key="bookmark.id">
   <div class="card">
    <div class="card-body">
     <div>
      <h5> <strong>Surah Name:</strong></h5> <b>{{ bookmark.surah_name }}</b>
     </div>
     <div class="mt-2">
      <h5>Ayah Number:</h5> {{ bookmark.id }}
     </div>
     <hr />
     <i class="bi bi-eye-fill h4 " style="color:rgb(0, 191, 166); cursor:pointer" data-bs-toggle="modal" data-bs-target="#viewBookmark" @click="viewModal(bookmark)">
     </i>
     <i class="bi bi-trash-fill h4 ml-3" style="color:rgb(0, 191, 166); cursor:pointer" @click="deleteBookmark(bookmark.id)">
     </i>
    </div>
   </div>

  </div>
 </div>

 

 <!-- View Bookmark Modal -->
 <div class="modal fade" id="viewBookmark" tabindex="-1" aria-labelledby="viewBookmarkLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
   <div class="modal-content">
    <div class="modal-header">
     <h5 class="modal-title" id="viewBookmarkLabel">View Bookmark</h5>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
     <form>
      <div class="mr-2 text-left" style="display: flex">
       <label class="mt-2 mr-2 col-sm-3">ID:</label>
       <p class="mt-2 text-dark text-left">
        {{ form.id }}
       </p>
      </div>
      <div class="mr-2 " style="display: flex">
       <label class="mt-2 mr-2 col-sm-3">Surah Name:</label>
       <p class="mt-2 text-dark text-right">
        {{ form.surah_name }}
       </p>
      </div>
      <div class="mr-2" style="display: flex">
       <label class="mt-2 mr-2 col-sm-3">Arabic Verse:</label>
       <p class="mt-2 text-dark text-right">
        {{ form.ayah_verse_ar }}
       </p>
      </div>
      <div class="mr-2" style="display: flex">
       <label class="mt-2 mr-2 col-sm-3">English Info:</label>
       <p class="mt-2 text-dark">
        {{ form.ayah_verse_en }}
       </p>
      </div>
     </form>
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
import {
 FilterMatchMode
} from "primevue/api";
export default {
 mounted() {
  this.loadBookmark();

 },
 data() {
  return {
   filters: {
    global: {
     value: null,
     matchMode: FilterMatchMode.CONTAINS,
    },
   },
   bookmarks: [],
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

   ],
   sortDesc: false,
   form: new Form({
    id: "",
    ayah_num: "",
    ayah_text: "",
    created_at: "",
    surah_name: "",
    ayah_num: "",
    ayah_verse_ar: "",
    ayah_verse_en: "",
    ayah_notes: "",
   }),
   maxLength: 70, // Set your desired max length
  }
 },
 computed: {
  truncatedText() {
   if (!this.form.ayah_text) return '';
   return this.form.ayah_text.length > this.maxLength ?
    this.form.ayah_text.substring(0, this.maxLength) + '...' // Append ellipsis
    :
    this.form.ayah_text;
  },
 },
 methods: {

  loadBookmark() {
   axios.get("api/fetch-bookmarks").then((data) => {
    this.bookmarks = data.data;
   });
  },
  deleteBookmark(id) {
   Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete bookmark!",
   }).then((result) => {
    if (result.isConfirmed) {
     axios.delete("api/delete-bookmarks/" + id);
     Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Bookmark deleted successfully ",
      showConfirmButton: false,
      timer: 1500,
     });
     this.loadBookmark();
     self.close();
    }
   });
  },
  viewModal(bookmarks) {
   this.form.reset();
   $("#view").modal("show");
   this.form.fill(bookmarks);
  },
  //edit user modal
  editModal(bookmarks) {
   this.editmode = true;
   this.form.reset();
   this.form.fill(bookmarks);
  },

 },
}
</script>

<style>
.truncate {
 white-space: nowrap;
 overflow: hidden;
 text-overflow: ellipsis;
}

.card {
 padding-bottom: 5px;
 border: 1px solid #00BFA6;
}
</style>
