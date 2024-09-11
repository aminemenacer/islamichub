<template>
  <div>
    <!-- Modal structure -->
    <div class="modal fade" ref="themeModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="themeModalLabel">Customize Your Theme</h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Form for customizing the theme -->
            <form @submit.prevent="saveTheme">
              <div class="mb-3">
                <label for="backgroundColor" class="form-label">Background Color</label>
                <input type="color" v-model="theme.backgroundColor" id="backgroundColor" class="form-control">
              </div>
              <div class="mb-3">
                <label for="textColor" class="form-label">Text Color</label>
                <input type="color" v-model="theme.textColor" id="textColor" class="form-control">
              </div>
              <div class="mb-3">
                <label for="shadowStyle" class="form-label">Shadow Style</label>
                <input type="text" v-model="theme.shadowStyle" id="shadowStyle" class="form-control" placeholder="e.g. 2px 2px 5px grey">
              </div>
              <div class="mb-3">
                <label for="fontStyle" class="form-label">Font Style</label>
                <select v-model="theme.fontStyle" id="fontStyle" class="form-select">
                  <option value="normal">Normal</option>
                  <option value="italic">Italic</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="textTransform" class="form-label">Text Transformation</label>
                <select v-model="theme.textTransform" id="textTransform" class="form-select">
                  <option value="none">None</option>
                  <option value="uppercase">Uppercase</option>
                  <option value="lowercase">Lowercase</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="fontSize" class="form-label">Font Size (px)</label>
                <input type="number" v-model="theme.fontSize" id="fontSize" class="form-control">
              </div>
              <div class="mb-3">
                <label for="fontSpacing" class="form-label">Font Spacing (px)</label>
                <input type="number" v-model="theme.fontSpacing" id="fontSpacing" class="form-control">
              </div>
              <div class="mb-3">
                <label for="fontFamily" class="form-label">Font Family</label>
                <input type="text" v-model="theme.fontFamily" id="fontFamily" class="form-control" placeholder="e.g. Arial, sans-serif">
              </div>
              <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Success message for applying theme -->
    <div v-if="showSuccessMessage" class="alert alert-success mt-3" role="alert">
      Theme changes have been successfully applied!
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      theme: {
        backgroundColor: '#ffffff',
        textColor: '#000000',
        shadowStyle: 'none',
        fontStyle: 'normal',
        textTransform: 'none',
        fontSize: 16,
        fontSpacing: 0,
        fontFamily: 'Arial, sans-serif'
      },
      showSuccessMessage: false
    };
  },
  mounted() {
    // Load theme from localStorage if it exists
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      this.theme = JSON.parse(savedTheme);
      this.applyTheme();
    }
  },
  methods: {
    openModal() {
      const modalElement = this.$refs.themeModal;
      if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
      } else {
        console.error('Modal reference not found.');
      }
    },
    closeModal() {
      const modalElement = this.$refs.themeModal;
      if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
          modal.hide();
        }
      } else {
        console.error('Modal reference not found.');
      }
    },
    saveTheme() {
      // Save the theme to localStorage and apply it
      localStorage.setItem('theme', JSON.stringify(this.theme));
      this.applyTheme();
      this.showSuccessMessage = true;
      setTimeout(() => {
        this.showSuccessMessage = false;
        this.closeModal();
      }, 2000);
    },
    applyTheme() {
      // Apply theme to the body or a specific section
      document.body.style.backgroundColor = this.theme.backgroundColor;
      document.body.style.color = this.theme.textColor;
      document.body.style.boxShadow = this.theme.shadowStyle;
      document.body.style.fontStyle = this.theme.fontStyle;
      document.body.style.textTransform = this.theme.textTransform;
      document.body.style.fontSize = `${this.theme.fontSize}px`;
      document.body.style.letterSpacing = `${this.theme.fontSpacing}px`;
      document.body.style.fontFamily = this.theme.fontFamily;
    }
  }
};
</script>

<style scoped>
.card.content {
  margin: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>
