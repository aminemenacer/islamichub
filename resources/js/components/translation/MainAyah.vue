<template>
  <div class="btn">
    <div class="text-right ayah-translation" name="ayah_text" :style="styleObject">{{ information.ayah.ayah_text }}</div>
  </div>
</template>

<script>
export default {
  name: 'AyahTranslation',
  props: {
    information: {
      type: Object,
      required: true
    }
  },
  computed: {
    styleObject() {
      return {
        lineHeight: '1.6em'
      };
    }
  }
};
</script>

<style scoped>
.btn {
  padding: 10px;
}
.text-right {
  text-align: right;
}
.ayah-translation {
  font-size: 1.8rem;
  color: #333;
}

</style>