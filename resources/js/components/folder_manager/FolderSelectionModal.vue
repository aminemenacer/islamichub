<template>
  <div>
    <!-- Folder Selection Modal -->
    <div
      class="modal fade"
      id="folderSelectionModal"
      tabindex="-1"
      aria-labelledby="folderSelectionModalLabel"
      aria-hidden="true"
      ref="folderSelectionModal"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="folderSelectionModalLabel">
              Select Folder
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <!-- List of folders -->
            <ul class="list-group">
              <li
                v-for="folder in folders"
                :key="folder.id"
                class="list-group-item d-flex justify-content-between align-items-center"
              >
                <span @click="selectFolder(folder.id)" style="cursor: pointer;">
                  {{ folder.name }}
                </span>
                <button 
                  type="button"
                  class="btn btn-danger btn-sm"
                  @click="confirmDeleteFolder(folder.id)"
                >
                  Delete
                </button>
              </li>
            </ul>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Cancel
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="confirmSelection"
            >
              Confirm
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
      class="modal fade"
      id="deleteConfirmationModal"
      tabindex="-1"
      aria-labelledby="deleteConfirmationModalLabel"
      aria-hidden="true"
      ref="deleteConfirmationModal"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteConfirmationModalLabel">
              Confirm Delete
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this folder?
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Cancel
            </button>
            <button
              type="button"
              class="btn btn-danger"
              @click="deleteFolder"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'FolderSelectionModal',
  data() {
    return {
      folders: [],
      selectedFolderId: null,
      folderIdToDelete: null, // To store the folder ID to be deleted
    };
  },
  mounted() {
    this.fetchFolders();
  },
  methods: {
    async fetchFolders() {
      try {
        const response = await axios.get('/folders');
        this.folders = response.data.folders;
      } catch (error) {
        console.error('Error fetching folders:', error);
      }
    },
    selectFolder(folderId) {
      this.selectedFolderId = folderId;
    },
    async confirmSelection() {
      if (!this.selectedFolderId) {
        alert('Please select a folder.');
        return;
      }

      const formData = { folder_id: this.selectedFolderId };

      try {
        const response = await axios.post('/bookmarks', formData);
        this.$emit('folder-selected', response.data.bookmark);
        this.selectedFolderId = null;
        this.closeFolderSelectionModal();
      } catch (error) {
        console.error('Error saving bookmark:', error.response?.data?.message || error.message);
        alert('Failed to add bookmark! Please try again.');
      }
    },
    openFolderSelectionModal() {
      const modal = new bootstrap.Modal(this.$refs.folderSelectionModal);
      modal.show();
    },
    closeFolderSelectionModal() {
      const modal = bootstrap.Modal.getInstance(this.$refs.folderSelectionModal);
      if (modal) modal.hide();
    },
    confirmDeleteFolder(folderId) {
      this.folderIdToDelete = folderId;
      const modal = new bootstrap.Modal(this.$refs.deleteConfirmationModal);
      modal.show();
    },
    async deleteFolder() {
      if (!this.folderIdToDelete) return;

      try {
        await axios.delete(`/folders/${this.folderIdToDelete}`);
        this.folders = this.folders.filter(folder => folder.id !== this.folderIdToDelete);
        this.folderIdToDelete = null;
        const modal = bootstrap.Modal.getInstance(this.$refs.deleteConfirmationModal);
        if (modal) modal.hide();
      } catch (error) {
        console.error('Error deleting folder:', error.response?.data?.message || error.message);
        alert('Failed to delete folder! Please try again.');
      }
    },
  },
};
</script>

<style scoped>
/* Add any custom styles for the modal here */
</style>
