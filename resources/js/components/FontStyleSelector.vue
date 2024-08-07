<template>
  <div>
    <label for="font-select">Choose a font style:</label>
    <select id="font-select" v-model="selectedFont" @change="updateFont">
      <option value="Arial">Arial</option>
      <option value="Courier New">Courier New</option>
      <option value="Georgia">Georgia</option>
      <option value="Times New Roman">Times New Roman</option>
      <option value="Verdana">Verdana</option>
    </select>
    <div :style="{ fontFamily: selectedFont }">
      <p>This is a sample text with the selected font style.</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedFont: 'Arial'
    };
  },
  created() {
    const savedFont = localStorage.getItem('selectedFont');
    if (savedFont) {
      this.selectedFont = savedFont;
    }
  },
  methods: {
    updateFont() {
      localStorage.setItem('selectedFont', this.selectedFont);
    }
  }
};
</script>

<style scoped>
#font-select {
  margin-bottom: 10px;
}
</style>
