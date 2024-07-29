<template>
  <div class="custom-scrollbar pb-5" style="overflow-y: auto; max-height: 600px; background: white;" ref="scrollContainer">
    <ul class="col-md-12 list-group container-fluid root" style="list-style-type: none; padding: 10px">
      <li 
        v-for="(ayah, index) in ayat" 
        :key="index" 
        @click="$emit('select-ayah', index)" 
        :class="{ 
          selected: selectedIndexAyah === index, 
          highlighted: verseNumber && parseInt(verseNumber) === ayah.ayah_id 
        }" 
        :ref="'ayah-' + index"
        style="padding: 10px; border-radius:10px"
      >
        <h5 class="text-right" style="display: flex;"> Verse: {{ ayah.ayah_id }} </h5>
        <h5 class="text-right">{{ ayah.ayah_text }}</h5>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'AyahList',
  props: {
    ayat: Array,
    selectedIndexAyah: Number,
    verseNumber: String
  },
  watch: {
    selectedIndexAyah(newIndex) {
      this.scrollToAyah(newIndex);
    }
  },
  methods: {
    scrollToAyah(index) {
      this.$nextTick(() => {
        const element = this.$refs['ayah-' + index][0];
        if (element) {
          element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      });
    }
  }
};
</script>

<style scoped>
.selected {
  background-color: rgba(5, 223, 194, 0.726); /* Add your preferred color */
}


</style>
