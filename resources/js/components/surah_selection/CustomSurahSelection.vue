<template>
<div class="scrollmenu">
 <a href="#" v-for="data in customSurat" :key="data.id" @click.prevent="selectSurah(data.id)">
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
 data() {
  return {
   customSurat: [{
     id: 1,
     name: 'Al Fatiha'
    },
    {
     id: 114,
     name: 'An-Nas'
    },
    {
     id: 113,
     name: 'Al-Falak'
    },
    {
     id: 67,
     name: 'Al-Mulk'
    },
    {
     id: 18,
     name: 'Al-Kahf'
    },
    {
     id: 55,
     name: 'Al-Rahman'
    },
    {
     id: 36,
     name: 'Ya Seen'
    },
    {
     id: 87,
     name: 'Al-A\'la'
    },
    {
     id: 88,
     name: 'Al Ghashiya'
    }
   ],
  }
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
 overflow-x: scroll;
 white-space: nowrap;
}

.scrollmenu a {
 display: inline-block;
 text-align: center;
 text-decoration: none;
}

.badge {
 background-color: white;
 color: black;
 border: 1px solid grey;
 border-radius: 10px;
 cursor: pointer;
}

.badge.active {
 background-color: white;
 color: black;
 border: 1px solid grey;
 border-radius: 10px;
 cursor: pointer;
}
</style>