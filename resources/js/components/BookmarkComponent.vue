<template>
<div id="app">
 <h2 class="pt-4 pb-2 text-center"><strong>Bookmarks</strong></h2>

 <div class="container text-center">

  <div class="row pb-2  text-center">

   <div class="col">
    <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#3D8F67;background:#d1f4d0"><a href="/notes" style="text-decoration:none;color:#3D8F67;background:#d1f4d0">Notes</a></span>
   </div>
   <div class="col">
    <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#B70D52;background:#ead1dc"><a href="/bookmarks" style="text-decoration:none;color:#B70D52;background:#ead1dc">Bookmarks</a></span>
   </div>
   <div class="col">
    <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#0263FF;background:#c2d8fb"><a href="/home" style="text-decoration:none;color:#0263FF;background:#c2d8fb">Home</a></span>
   </div>

  </div>
 </div>


<div class="container">
 <div class="row">
  <div class="col-md-4 mb-4" v-for="bookmark in bookmarks" :key="bookmark.id">
   <div class="card">
    <div class="card-body">
     <div>
      <h5> <strong>Surah Name:</strong></h5> {{ bookmark.surah_name }}
     </div>
     <div class="mt-2">
      <h5><strong> Number:</strong></h5> {{ bookmark.id }}
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
</div>
</template>

<script>
import axios from "axios";
import {
 FilterMatchMode
} from "primevue/api";
export default {
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
     this.fetchBookmarks(this.userId);
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
   
   bookmarks: [],
   
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
  async fetchBookmarks(userId) {
   try {
    const response = await fetch(`/api/fetch-bookmarks/${userId}`);
    if (!response.ok) {
     throw new Error('Network response was not ok');
    }
    this.bookmarks = await response.json();
   } catch (error) {
    console.error('There was a problem with the fetch operation:', error);
   }
  },
  viewModal(bookmark) {
   this.form1 = {
    ...bookmark
   }; // Make sure form1 is populated
   const viewBookmarksModal = new bootstrap.Modal(document.getElementById('viewBookmarks'));
   viewBookmarksModal.show();
  },
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
     axios.delete(`/api/delete-bookmarks/${id}`);
     Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Bookmark deleted successfully ",
      showConfirmButton: false,
      timer: 1500,
     });
     this.fetchBookmarks(this.userId);
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
