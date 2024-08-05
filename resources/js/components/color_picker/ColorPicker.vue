<template>
  <div>
    <input type="color" v-model="selectedColor" @input="changeColor" />
    <div class="content" :style="{ backgroundColor: selectedColor }">
      This is some content whose background color will change based on the selected color.
    </div>
  </div>
</template>

<script>
export default {
  name: 'ColorPicker',
  data() {
    return {
     selectedColor: localStorage.getItem('selectedColor') || '#ffffff'
    };
  },
  methods: {
    changeColor() {
      localStorage.setItem('selectedColor', this.selectedColor);
    }
  },
  mounted() {
    this.changeColor();
  }
};
</script>

<style scoped>
.content {
  padding: 20px;
  border: 1px solid #ccc;
  margin-top: 10px;
}
</style>
