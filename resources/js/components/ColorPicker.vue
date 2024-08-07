<!-- src/components/ColorPicker.vue -->
<template>
  <div>
    <input type="color" v-model="color" @input="updateColor" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      color: localStorage.getItem('bgColor') || '#ffffff',
    };
  },
  methods: {
    updateColor() {
      this.$emit('color-change', this.color);
      localStorage.setItem('bgColor', this.color);
    },
  },
  mounted() {
    this.updateColor();
  },
};
</script>

<style scoped>
input {
  margin: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
</style>
