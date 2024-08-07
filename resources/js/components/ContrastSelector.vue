<template>
  <div>
    <label for="contrast">Select Contrast:</label>
    <select id="contrast" v-model="selectedContrast" @change="changeContrast">
      <option value="default">Default</option>
      <option value="high-contrast">High Contrast</option>
      <option value="dark">Dark</option>
    </select>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedContrast: 'default',
    };
  },
  created() {
    // Load the saved contrast from localStorage
    const savedContrast = localStorage.getItem('selectedContrast');
    if (savedContrast) {
      this.selectedContrast = savedContrast;
      this.applyContrast(savedContrast);
    }
  },
  methods: {
    changeContrast() {
      this.applyContrast(this.selectedContrast);
      // Save the selected contrast in localStorage
      localStorage.setItem('selectedContrast', this.selectedContrast);
    },
    applyContrast(contrast) {
      document.documentElement.setAttribute('data-contrast', contrast);
    },
  },
};
</script>
