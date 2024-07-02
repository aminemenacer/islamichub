<template>
  <!-- Surah list -->
  <ul class="col-md-12 mt-1 scrollable-list">
    <li
      v-for="item in filteredSurah"
      :key="item.id"
      @click="selectSurah(item.id)"
      class="highlight-on-hover surah-item"
    >
      <div class="surah-details">
        <img src="/images/art.png" class="surah-image" />
        <p class="surah-text">{{ item.name_en }} - {{ item.name_ar }}</p>
      </div>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    filteredSurah: {
      type: Array,
      required: true
    }
  },
  methods: {
    selectSurah(surahId) {
      this.$emit('select-surah', surahId);
    }
  }
};
</script>

<style scoped>
.scrollable-list {
  list-style-type: none;
  overflow-y: auto;
  max-height: 400px;
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}

.surah-item {
  cursor: pointer;
  padding: 5px;
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  border-radius: 5px;
}

.surah-details {
  display: flex;
  align-items: center;
}

.surah-image {
  width: 23px;
  margin-bottom: 1px;
  margin-right: 2px;
}

.surah-text {
  font-size: 18px;
  margin-top: 2px;
}

/* Media query for mobile screens */
@media screen and (max-width: 768px) {
  .scrollable-list {
    overflow-x: hidden;
  }
}
</style>
