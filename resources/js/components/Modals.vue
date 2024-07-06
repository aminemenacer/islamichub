<template>
  <div>
    <!-- Translation Info Modal -->
    <div class="modal fade" id="translationInfo" tabindex="-1" aria-labelledby="translationInfoLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="translationInfoLabel">Translation Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Content for Translation Info -->
            <p>{{ information.ayah.surah.name_en }} - {{ information.ayah.surah_id }}</p>
            <p>{{ information.ayah.surah.introduction }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Translation Note Modal -->
    <div class="modal fade" id="translationNote" tabindex="-1" aria-labelledby="translationNoteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="translationNoteLabel">Write a Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <textarea v-model="note" class="form-control" rows="5" placeholder="Write your note here..."></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="saveNote">Save Note</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bugs Translation Modal -->
    <div class="modal fade" id="bugTranslation" tabindex="-1" aria-labelledby="bugTranslationLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="bugTranslationLabel">Report a Bug</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <textarea v-model="bugReport" class="form-control" rows="5" placeholder="Describe the bug..."></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="reportBug">Submit Report</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    information: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      note: '',
      bugReport: ''
    };
  },
  methods: {
    saveNote() {
      if (localStorage.getItem('userId')) {
        const userId = localStorage.getItem('userId');
        const notes = JSON.parse(localStorage.getItem('notes')) || [];
        notes.push({ userId, note: this.note });
        localStorage.setItem('notes', JSON.stringify(notes));
        this.note = '';
        this.$refs.translationNoteModal.hide();
      } else {
        alert('Please log in to write a note.');
      }
    },
    reportBug() {
      const bugReports = JSON.parse(localStorage.getItem('bugReports')) || [];
      bugReports.push(this.bugReport);
      localStorage.setItem('bugReports', JSON.stringify(bugReports));
      this.bugReport = '';
      this.$refs.bugTranslationModal.hide();
    }
  }
};
</script>

<style scoped>
.modal-content {
  padding: 20px;
}
.modal-body textarea {
  width: 100%;
}
</style>
