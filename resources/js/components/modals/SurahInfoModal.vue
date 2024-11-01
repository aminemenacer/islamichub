<template>
  <div class="modal fade" :id="sectionType + 'Info'" tabindex="-1" :aria-labelledby="sectionType + 'InfoLabel'" aria-hidden="true" @click.self="closeModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" :id="sectionType + 'InfoLabel'"><strong>{{ sectionType }} Information</strong></h1>
          <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p v-if="sectionType === 'Translation'">{{ translationContent }}</p>
          <p v-if="sectionType === 'Tafseer'">{{ tafseerContent }}</p>
          <p v-if="sectionType === 'Transliteration'">{{ transliterationContent }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    sectionType: {
      type: String,
      required: true
    }
  },
  mounted() {
    const modalElement = document.getElementById(this.sectionType + 'Info');
    if (modalElement) {
      this.modalInstance = new bootstrap.Modal(modalElement);
    }
  },
  methods: {
    closeModal() {
      if (this.modalInstance) {
        this.modalInstance.hide();
      }
    }
  }
};
</script>

<style scoped>
.modal-content {
  background-color: #f8f9fa; /* Light grey background */
}

.modal-backdrop.show {
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black backdrop */
}
</style>
