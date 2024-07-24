<template>
  <div>
    <!-- Surah list dropdown from search bar -->
    <ul class="col-md-12 mt-1 scrollable-list" style="list-style-type: none; overflow-y: auto; max-height: 400px; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
      <li v-for="item in filteredSurah" :key="item.id" @click="handleSelectSurah(item)" style="cursor: pointer; padding: 5px; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;" class="highlight-on-hover">
        <div style="display: flex; align-items: center;">
          <img src="/images/art.png" style="width: 23px" class="mb-1 mr-2" />
          <p style="font-size: 18px;" class="mt-2">{{ item.name_en }} - {{ item.name_ar }}</p>
        </div>
      </li>
    </ul>
  </div>
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
    handleSelectSurah(item) {
      this.$emit('selectSurah', item.id);
      this.updateInformation(item);
      this.updateTafseer(item);
    },
    updateInformation(item) {
      // Update information based on the selected Surah
      const newInformation = {
        ayah: {
          ayah_text: item.ayah_text,
        },
        translation: item.translation,
        transliteration: item.transliteration,
      };
      this.$emit('updateInformation', newInformation);
    },
    updateTafseer(item) {
      // Update tafseer based on the selected Surah
      const newTafseer = item.tafseer; // Replace with actual tafseer logic
      this.$emit('updateTafseer', newTafseer);
    }
  }
};
</script>

<style scoped>
/* Add any specific styles if necessary */
</style>


<style scoped>
.mb-2 {
  margin-bottom: 1rem;
}
.right-side-form {
  cursor: pointer;
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  border-radius: 5px;
}
.custom-dropdown {
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}
.mt-2 {
  margin-top: 0.5rem;
}
</style>