<template>
  <div class="btn">
    <h5 class="text-right ayah-translation" name="ayah_text" :style="styleObject">{{ information.ayah.ayah_text }}</h5>
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
  font-size: 1.3rem;
  color: #333;
}

</style>