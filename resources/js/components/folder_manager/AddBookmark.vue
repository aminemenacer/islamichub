<template>
  <!-- Folder Selection Modal -->
<div
  class="modal fade"
  id="folderModal"
  tabindex="-1"
  aria-labelledby="folderModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="folderModalLabel">Select a Folder</h5>
        <button
          style="background-color: rgba(0, 191, 166, 0.452); cursor:pointer"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div v-if="folders.length > 0">
          <p>Select a folder to store the bookmark:</p>
          <ul>
            <div v-for="folder in folders" :key="folder.id">
              <button class="btn btn-info" style="text-decoration:none" @click="selectFolder(folder.id)">
                {{ folder.name }}
              </button>
            </div>
          </ul>
        </div>
        <div v-else>
          <p>No folders available. Please create a folder first.</p>
        </div>
      </div>
    </div>
  </div>
</div>

</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      folders: [],
      bookmarks: [],
    };
  },
  methods: {
    selectFolder(folderId) {
    this.selectedFolderId = folderId;
    this.closeFolderModal();
    this.submitForm2(); // Automatically submit the form after selecting the folder
  },
    async openFolderModal() {
      await this.fetchFolders();
      const modal = new bootstrap.Modal(document.getElementById('folderModal'));
      modal.show();
    },
    async fetchFolders() {
      try {
        const response = await axios.get('/folders'); // Adjusted for API route
        this.folders = response.data.folders;
      } catch (error) {
        console.error('Error fetching folders:', error);
      }
    },
    async fetchBookmarks(folderId) {
      try {
        const response = await axios.get(`/folders/${folderId}/bookmarks`); // Adjusted for API route
        this.bookmarks = response.data.bookmarks;
        this.closeFolderModal();
        this.openBookmarkModal();
      } catch (error) {
        console.error('Error fetching bookmarks:', error);
      }
    },
    closeFolderModal() {
      const folderModal = bootstrap.Modal.getInstance(document.getElementById('folderModal'));
      if (folderModal) {
        folderModal.hide();
      }
    },
    openBookmarkModal() {
      const bookmarkModal = new bootstrap.Modal(document.getElementById('bookmarkModal'));
      bookmarkModal.show();
    },
  },
};
</script>
