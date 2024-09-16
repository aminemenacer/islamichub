<template>
<div v-if="information !== null">
 <div class="row " style="padding:10px">

  <div class="text-center">
   <hr>
   <div :style="iconStyle" class="row ">
    <div class="col"><a  href="/bookmarks" class=" h4"><i  class="bi bi-bookmark  h4"></i></a></div>
    <div class="col"><a  href="/notes" class=" h4 "><i  class="bi bi-file-earmark-text  h4 " href="/notes"></i></a></div>
    <div class="col"><a  href="/collection" class=" h4"><i  class="bi bi-collection  h4 " href="/collection"></i></a></div>
    <div class="col"><a  href="/profile" class=" h2"><i  class="bi bi-person h2  " href="/profile"></i></a></div>
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
  },
  iconColor: {
   type: String,
   default: 'rgba(0, 191, 166)'
  }
 },

};
</script>

<style>

</style>
