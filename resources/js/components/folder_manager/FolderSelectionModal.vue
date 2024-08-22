<template>
  <div>
    <!-- Button to trigger folder selection modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#folderSelectionModal">
      Select Folder
    </button>

    <!-- Folder Selection Modal -->
    <div class="modal fade" id="folderSelectionModal" tabindex="-1" aria-labelledby="folderSelectionModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="folderSelectionModalLabel">Select Folder</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <button class="btn btn-primary dropdown-toggle" type="button" id="folderDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              Select Folder
            </button>
            <ul class="dropdown-menu" aria-labelledby="folderDropdown">
              <li v-for="folder in folders" :key="folder.id">
                <a class="dropdown-item" href="#" @click="selectFolder(folder.id)">
                  {{ folder.name }}
                </a>
              </li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" @click="confirmSelection" data-bs-dismiss="modal">Confirm</button>
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
  props: {
    information: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      folders: [],
      selectedFolderId: null
    };
  },
  mounted() {
    this.fetchFolders();
    new bootstrap.Dropdown(document.getElementById('folderDropdown'));
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
        console.error('No folder selected');
        alert('Please select a folder.');
        return;
      }

      // Validate bookmark data fields
      if (!this.information.surah_name || !this.information.ayah_num ||
        !this.information.ayah_verse_ar || !this.information.ayah_verse_en) {
        console.error('Bookmark data is incomplete:', this.information);
        alert('Please fill in all bookmark details before saving.');
        return;
      }

      // Prepare the form data
      
      const formData = {
        folder_id: this.selectedFolderId,
        surah_name: this.information.surah_name,
        ayah_num: this.information.ayah_num,
        ayah_verse_ar: this.information.ayah_verse_ar,
        ayah_verse_en: this.information.ayah_verse_en
      };

      try {
        // Make the POST request to save the bookmark
        const response = await axios.post('/bookmarks', formData);
        console.log('Bookmark saved:', response.data.message);
        
        // Emit an event to notify parent component
        this.$emit('folder-selected', response.data.bookmark);

        // Reset form data
        this.$emit('update:information', {
          surah_name: '',
          ayah_num: '',
          ayah_verse_ar: '',
          ayah_verse_en: ''
        });
        this.selectedFolderId = null;

        // Hide the modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('folderSelectionModal'));
        if (modal) {
          modal.hide();
        }
      } catch (error) {
        console.error('Error saving bookmark:', error.response?.data?.message || error.message);
        alert('Failed to add bookmark! Please check the details and try again.');
      }
    }
  }
}
</script>
