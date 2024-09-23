<template>
<div>
 <!-- Search Input Group -->
 <div class="container input-group">
  <input type="text" v-model="searchTerm" placeholder="Type any word to search for ayah translation..." class="form-control" />
  <button class="btn btn-success" @click="searchWord">Search</button>
 </div>

 <!-- Offcanvas for Search Results -->
 <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasResults">
   <div class="offcanvas-header">
     <h5 class="offcanvas-title">Search Results</h5>
     <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
   </div>
   <div class="offcanvas-body text-left custom-offcanvas">
     <div v-if="filteredResults.length">
       <div v-for="result in filteredResults" :key="result.id" class="result-item">
         <b><h6>{{ result.ayah.surah_id }} : {{ result.ayah.ayah_id }} - {{ result.ayah.surah.name_ar }}</h6></b>
         <p v-html="highlightSearch(result.translation)"></p>
         <hr>
       </div>
     </div>
     <div v-else>
       <p>No results found.</p>
     </div>
   </div>
 </div>

</div>
</template>

<style scoped>
.custom-offcanvas {
  background-color: #10584f;
  color: white;
}

.custom-offcanvas .result-item {
  margin-bottom: 10px;
}

</style>

<script>
export default {
 data() {
  return {
   searchTerm: '',
   filteredResults: []
  };
 },
 methods: {
  searchWord() {
   if (this.searchTerm.length > 0) {
    axios
     .get("/search-translations", {
      params: {
       query: this.searchTerm
      }
     })
     .then(response => {
      this.filteredResults = response.data;
      this.showOffcanvas();
     })
     .catch(error => {
      console.error(error);
     });
   } else {
    this.filteredResults = [];
   }
  },
  highlightSearch(translation) {
   if (!translation) {
    console.warn("The translation is undefined or null for this result:", translation);
    return '';
   }
   const regex = new RegExp(`(${this.searchTerm})`, 'gi');
   return translation.replace(regex, "<span class='highlight'>$1</span>");
  },
  showOffcanvas() {
   const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasResults'));
   offcanvas.show();
  },
  onInputChange() {
   this.searchWord(); // Automatically search as you type
  }
 }
};
</script>
