<template>
  <div class="scrollmenu">
    <a href="#" v-for="data in customSurahs" :key="data.id" @click.prevent="selectSurah(data.id)">
      <div class="flex justify-content-center mr-1">
        <span class="badge button-33" :class="{ active: surah === data.id }">{{ data.name }}</span>
      </div>
    </a>
  </div>
</template>

<script>
export default {
  props: {
    customSurahs: Array,
    modelValue: Number
  },
  computed: {
    surah() {
      return this.modelValue;
    }
  },
  methods: {
    selectSurah(surahId) {
      this.$emit('update:modelValue', surahId);
    }
  }
};
</script>

<style scoped>
.scrollmenu {
  overflow-x:scroll;
  white-space: nowrap;
}
.scrollmenu a {
  display: inline-block;
  text-align: center;
  text-decoration: none;
}
.scrollmenu a:hover {
  background-color: #ddd;
}
.badge {
  cursor: pointer;
}
.badge.active {
  background-color: #00bfa6;
  color: white;
}

</style>
