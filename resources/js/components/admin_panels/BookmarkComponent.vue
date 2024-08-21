<template>
  <div id="app">
    <h2 class="pt-4 pb-3 text-center"><strong>Bookmarks</strong></h2>

    <!-- Create Folder Modal -->
    <div class="modal fade" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createFolderModalLabel">Create New Folder</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createFolder">
              <div class="mb-3">
                <label for="folderName" class="form-label">Folder Name</label>
                <input type="text" id="folderName" v-model="newFolderName" class="form-control" required />
              </div>
              <button type="submit" class="btn btn-primary">Create Folder</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Folder Selection -->
    <button class="btn btn-success" @click="openCreateFolderModal">Create New Collection</button>

    <div class="mt-3">
      <h3>Select a Folder</h3>
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="folder in folders" :key="folder.id">
          <button class="btn btn-link" @click="selectFolder(folder.id)">
            {{ folder.name }}
          </button>
          <button class="btn btn-danger btn-sm" @click="confirmDeleteFolder(folder.id)">
            Delete
          </button>
        </li>
      </ul>
    </div>

    <!-- Display Bookmarks -->
    <div v-if="selectedFolderId">
      <h3 class="pt-3">Bookmarks in Selected Folder</h3>
      <div class="row">
        <div class="col-md-4 mb-4" v-for="bookmark in bookmarks" :key="bookmark.id">
          <div class="card" style="border-radius:8px;padding:10px; border: 2px solid rgba(0, 191, 166);">
            <div class="card-body">
              <div class="truncate">
                <h5><strong>Surah Name:</strong></h5>
                {{ truncatedText(bookmark.surah_name) }}
              </div>
              <div class="mt-2">
                <h5><strong>Information:</strong></h5>
                {{ truncatedText(bookmark.ayah_verse_en) }}
              </div>
              <hr />
              <i class="bi bi-eye-fill h4" style="color:rgb(0, 191, 166); cursor:pointer" @click="viewModal(bookmark)"></i>
              <i class="bi bi-trash-fill h4 ml-3" style="color:rgb(0, 191, 166); cursor:pointer" @click="deleteBookmark(bookmark.id)"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewBookmarkModal" tabindex="-1" aria-labelledby="viewBookmarkModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewBookmarkModalLabel">Bookmark Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="card" style="border-radius:8px;padding:10px; border: 2px solid rgba(0, 191, 166);">
              <div class="card-body">
                <div class="truncate">
                  <h5><strong>Surah Name:</strong></h5>
                  {{ selectedBookmark.surah_name }}
                </div>
                <div class="mt-2">
                  <h5><strong>Ayah Number:</strong></h5>
                  {{ selectedBookmark.ayah_num }}
                </div>
                <div class="mt-2">
                  <h5><strong>Arabic Verse:</strong></h5>
                  {{ selectedBookmark.ayah_verse_ar }}
                </div>
                <div class="mt-2">
                  <h5><strong>English Translation:</strong></h5>
                  {{ selectedBookmark.ayah_verse_en }}
                </div>
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

export default {
  data() {
    return {
      folders: [],
      bookmarks: [],
      selectedFolderId: null,
      newFolderName: "",
      selectedBookmark: {}, // Holds the selected bookmark details for the modal
    };
  },

  mounted() {
    this.fetchFolders();
  },

  methods: {
    async fetchFolders() {
      try {
        const response = await axios.get("/folders");
        this.folders = response.data.folders;
      } catch (error) {
        console.error("Error fetching folders:", error);
      }
    },

    async createFolder() {
      try {
        const response = await axios.post("/folders", {
          name: this.newFolderName,
        });
        this.folders.push(response.data.folder);
        this.newFolderName = "";
        const modal = bootstrap.Modal.getInstance(
          document.getElementById("createFolderModal")
        );
        if (modal) {
          modal.hide();
        }
      } catch (error) {
        console.error("Error creating folder:", error);
      }
    },

    async selectFolder(folderId) {
      this.selectedFolderId = folderId;
      this.fetchBookmarksByFolder(folderId);
    },

    async fetchBookmarksByFolder(folderId) {
      try {
        const response = await axios.get(`/folders/${folderId}/bookmarks`);
        console.log('Fetched bookmarks response:', response); // Log for debugging
        this.bookmarks = response.data.bookmarks;
      } catch (error) {
        console.error('Error fetching bookmarks by folder:', error);
      }
    },

    async confirmDeleteFolder(folderId) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      });

      if (result.isConfirmed) {
        this.deleteFolder(folderId);
      }
    },

    async deleteFolder(folderId) {
      try {
        await axios.delete(`/folders/${folderId}`);
        this.folders = this.folders.filter((folder) => folder.id !== folderId);
        if (this.selectedFolderId === folderId) {
          this.selectedFolderId = null;
          this.bookmarks = [];
        }
        Swal.fire("Deleted!", "The folder has been deleted.", "success");
      } catch (error) {
        console.error("Error deleting folder:", error);
        Swal.fire("Error!", "There was an issue deleting the folder.", "error");
      }
    },

    openCreateFolderModal() {
      const modal = new bootstrap.Modal(
        document.getElementById("createFolderModal")
      );
      modal.show();
    },

    truncatedText(text) {
      const maxLength = 70;
      return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
    },

    viewModal(bookmark) {
      this.selectedBookmark = bookmark; // Set the selected bookmark for the modal
      const viewBookmarksModal = new bootstrap.Modal(
        document.getElementById("viewBookmarkModal")
      );
      viewBookmarksModal.show();
    },

    async deleteBookmark(id) {
      try {
        await axios.delete(`/api/delete-bookmarks/${id}`);
        this.fetchBookmarksByFolder(this.selectedFolderId); // Refresh bookmarks
      } catch (error) {
        console.error("Error deleting bookmark:", error);
      }
    },
  },
};
</script>
