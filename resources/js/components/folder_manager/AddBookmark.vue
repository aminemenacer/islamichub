<template>
  <div>
    <!-- Button to Trigger Modal -->
    <button
      style="background-color: rgba(0, 191, 166, 0.452); cursor:pointer; font-style:bolder"
      class="bi bi-shuffle h1 button-63"
      data-bs-toggle="modal"
      data-bs-target="#bookmarkModal"
      @click="openModal"
    >
    </button>

    <!-- Modal -->
    <div
      class="modal fade"
      id="bookmarkModal"
      tabindex="-1"
      aria-labelledby="bookmarkModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="bookmarkModalLabel">Save Bookmark</h5>
            <button
              style="background-color: rgba(0, 191, 166, 0.452); cursor:pointer"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="closeModal"
            ></button>
          </div>
          <div class="modal-body">
            <div v-if="folders.length > 0">
              <p>Select a folder to save the bookmark:</p>
              <ul>
                <li v-for="folder in folders" :key="folder.id">
                  <button @click="saveBookmark(folder.id)">
                    {{ folder.name }}
                  </button>
                </li>
              </ul>
            </div>
            <div v-else>
              <p>No folders available. Please create a folder first.</p>
            </div>
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
    };
  },
  methods: {
    async openModal() {
      // Fetch folders when the modal is opened
      await this.fetchFolders();
      // Open the modal
      const modal = new bootstrap.Modal(document.getElementById('bookmarkModal'));
      modal.show();
    },
    async fetchFolders() {
      try {
        const response = await axios.get('/folders');
        this.folders = response.data.folders;
      } catch (error) {
        console.error('Error fetching folders:', error);
      }
    },
    async saveBookmark(folderId) {
      try {
        const bookmarkData = {
          folder_id: folderId,
          // Add other bookmark data here
        };
        await axios.post('/bookmarks', bookmarkData);
        alert('Bookmark saved successfully!');
        this.closeModal();
      } catch (error) {
        console.error('Error saving bookmark:', error);
      }
    },
    closeModal() {
      const modal = bootstrap.Modal.getInstance(document.getElementById('bookmarkModal'));
      if (modal) {
        modal.hide();
      }
    },
  },
};
</script>
