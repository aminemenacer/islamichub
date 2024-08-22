<template>
<div v-if="information !== null">
 <hr class="container text-secondary">
 <div class="row mobile-only" style="padding:10px">
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
  <div class="col-md-4"></div>

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
.link-darkgrey-underline {
 color: rgb(0, 0, 0);
 font-weight: bold;
 text-decoration: none;
 background-color: rgba(0, 191, 166);
 padding: 6px;
 color: #fff;
 /*for background new colour (it worked)*/
 border-radius: 3px;

}

.link-darkgrey-underline:hover {
 color: #231f20;
 /*for text new colour (not worked)*/
 background-color: rgba(0, 191, 166);
 color: #fff;
 /*for background new colour (it worked)*/
 transition: opacity .9s, margin-left .5s, margin-right .5s;
}
</style>
