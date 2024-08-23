<template>
<div v-if="information !== null">
 <hr class="container text-secondary">
 <div class="row mobile-only" style="padding:10px">
 <!--
  <div class="col-md-4">
   <p class="text-left ayah-translation text-secondary" style="line-height: 1.6em; cursor: pointer;">
    <a href="/bookmarks" class="link-darkgrey-underline">View bookmarks</a>
   </p>
   <p class="text-left ayah-translation text-secondary" style="line-height: 1.6em; cursor: pointer;">
    <a href="/notes" class="link-darkgrey-underline">View Notes</a>
   </p>
   <p class="text-left ayah-translation text-secondary" style="line-height: 1.6em; cursor: pointer;">
    <a href="/collection" class="link-darkgrey-underline">View Collections</a>
   </p>
  </div>
  -->
  <div class="container pb-4 text-center">
   <div class="row container ">
     <div class="col">
       <i class="bi bi-bookmark pr-2 pt-2 h3 links"></i>
       <a style="text-decoration:none;color:grey" class="links h5" href="/bookmarks">Bookmarks</a>
     </div>
     <div class="col">
      <i class="bi bi-file-earmark-text pr-2 h3 links" ></i>
      <a style="text-decoration:none;color:grey " class="links h5" href="/notes">Notes</a>
     </div>
     <div class="col">
      <i class="bi bi-collection pr-2 h3 links"></i>
      <a style="text-decoration:none;color:grey " class="links h5" href="/collection">Collections</a>
     </div>
   </div>
</div>

 </div>

</div>
</template>

<script>
export default {
 name: 'BookmarksAndNotes',
 props: {
  information: { // Assuming information is passed as a prop
   type: Object,
   default: null
  }
 },

};
</script>

<style>


.links:hover {
 color: #231f20;
 /*for text new colour (not worked)*/
 color: rgba(0, 191, 166);
 transition: opacity .9s, margin-left .5s, margin-right .5s;
}
</style>
