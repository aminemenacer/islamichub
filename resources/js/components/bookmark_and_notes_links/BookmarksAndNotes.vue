<template>
<div v-if="information !== null">
 <div class="row mobile-only" style="padding:10px">

  <div class="text-center">
   <div class="row mobile-only settings container">
   <hr>
    <div class="col"><a style="text-decoration:none;color:grey;cursor:pointer" href="/bookmarks" class="links h4"><i style="cursor:pointer" class="bi bi-bookmark links h4"></i></a></div>
    <div class="col"><a style="text-decoration:none;color:grey;cursor:pointer" href="/notes" class="links h4 "><i style="cursor:pointer" class="bi bi-file-earmark-text  h4 links" href="/notes"></i></a></div>
    <div class="col"><a style="text-decoration:none;color:grey;cursor:pointer" href="/collection" class="links h4"><i style="cursor:pointer" class="bi bi-collection  h4 links" href="/collection"></i></a></div>
    <div class="col"><a style="text-decoration:none;color:grey;cursor:pointer" href="/profile" class="links h2"><i style="cursor:pointer" class="bi bi-person h2 mb-2 links" href="/profile"></i></a></div>
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
 /*for text new colour (not worked)*/
 color: rgba(0, 191, 166);
 transition: opacity .9s, margin-left .5s, margin-right .5s;
}
</style>
