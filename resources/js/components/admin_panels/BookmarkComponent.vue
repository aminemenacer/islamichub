<template>
<div id="app">
 <h2 class="pt-4 pb-3 text-center"><strong>Bookmarks</strong></h2>

 <!-- Container visible only on mobile screens -->
 <div class="container text-center mt-3 d-md-none">
  <div class="row pb-2  text-center">
   <div class="col">
    <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#3D8F67;background:#d1f4d0">
     <a href="/notes" style="text-decoration:none;color:#3D8F67;background:#d1f4d0">Notes</a>
    </span>
   </div>
   
   <div class="col">
    <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#0263FF;background:#c2d8fb">
     <a href="/home" style="text-decoration:none;color:#0263FF;background:#c2d8fb">Home</a>
    </span>
   </div>
  </div>
 </div>


 <!-- Bookmarks Container -->
 <div class="container ">
  <h3 class="pb-3 text-center">
    <strong>You have:</strong> <b style="color:rgb(0, 191, 166)">{{ bookmarks.length }}</b> <strong>bookmarks</strong>
  </h3>
  <div class="row">
   <div class="col-md-4 mb-4" v-for="bookmark in bookmarks" :key="bookmark.id">
    <!-- Bookmark Card -->
    <div class="card" style="border-radius:8px;padding:10px; border: 2px solid rgba(0, 191, 166);">
     <div class="card-body">
      <!-- Bookmark details -->
      <!-- Truncated text example -->
      <div class="truncate">
       <h5> <strong>Surah Name:</strong></h5>
       {{ truncatedText (bookmark.surah_name) }}
      </div>
      <!-- End of truncated text -->
      <div class="mt-2">
       <h5><strong>Information:</strong></h5>
       {{ truncatedText (bookmark.ayah_verse_en) }}
      </div>
      <hr />
      <!-- Icons for actions -->
      <i class="bi bi-eye-fill h4 " style="color:rgb(0, 191, 166); cursor:pointer" data-bs-toggle="modal" data-bs-target="#viewBookmark" @click="viewModal(bookmark)">
      </i>
      <i class="bi bi-trash-fill h4 ml-3" style="color:rgb(0, 191, 166); cursor:pointer" @click="deleteBookmark(bookmark.id)">
      </i>
     </div>
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
     <form class="container">
      <div class="mb-3 container">
        <label for="formGroupExampleInput" class="form-label"><strong>Surah Name:</strong></label>
        <p class="mt-2 text-dark text-left">
        {{ form.surah_name }}
       </p>
      </div>
      <div class="mb-3 container">
        <label for="formGroupExampleInput" class="form-label"><strong>Arabic Verse:</strong></label>
        <p class="mt-2 text-dark text-left">
        {{ form.ayah_verse_ar }}
       </p>
      </div>
      <div class="mb-3 container">
        <label for="formGroupExampleInput" class="form-label"><strong>English Info:</strong></label>
        <p class="mt-2 text-dark text-left">
        {{ form.ayah_verse_en }}
       </p>
      </div>
      <div class="mb-3 container">
        <label for="formGroupExampleInput" class="form-label"><strong>Date Created:</strong></label>
        <p class="mt-2 text-dark text-left">
          {{ extractDate(form.created_at) }}
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
  fetch("/api/userId")
   .then((response) => {
    if (!response.ok) {
     throw new Error("Failed to fetch user ID");
    }
    return response.json();
   })
   .then((data) => {
    const userId = data.userId; // Assuming the API returns the user ID in a field called userId
    console.log("UserId:", userId);

    if (userId) {
     this.userId = userId;
     this.fetchBookmarks(this.userId);
    } else {
     console.error("User ID not found");
    }
   })
   .catch((error) => {
    console.error("Error fetching user ID:", error);
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
    created_at: ""
   }),
   maxLength: 70, // Set your desired max length
  };
 },
 
 methods: {
   extractDate(dateTimeString) {
      return dateTimeString.split('T')[0];
    },
  async fetchBookmarks(userId) {
   try {
    const response = await fetch(`/api/fetch-bookmarks/${userId}`);
    if (!response.ok) {
     throw new Error("Network response was not ok");
    }
    this.bookmarks = await response.json();
   } catch (error) {
    console.error(
     "There was a problem with the fetch operation:",
     error
    );
   }
  },
  truncatedText(text) {
    if (!text) return '';
    return text.length > this.maxLength
      ? text.substring(0, this.maxLength) + '...'
      : text;
  },
  viewModal(bookmark) {
   this.form1 = {
    ...bookmark
   }; // Make sure form1 is populated
   const viewBookmarksModal = new bootstrap.Modal(
    document.getElementById("viewBookmarks")
   );
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
};
</script>

<!-- <style scoped>
.truncate {
 white-space: nowrap;
 overflow: hidden;
 text-overflow: ellipsis;
}

.card {
 padding-bottom: 5px;
 border: 1px solid #00BFA6;
}
</style> -->