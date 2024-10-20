<template>
<div>

 <!-- Modal -->
 <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
   <div class="modal-content">
    <div class="modal-header">
     <h4 class="modal-title fs-5" id="videoModalLabel"><b>Sign Language Video's</b></h4>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
     <div class="container text-center">

      <div class="row">
       <div class="container pb-3">
        <h3 class="modal-title pb-2" id="videoModalLabel"><b>Sign Language Playlist</b></h3>
        <p>The Sign Language Video Playlist offers a series of videos that cover the basics of Islam, using sign language to ensure accessibility for the deaf and hard of hearing. The playlist introduces key Islamic teachings, like the Five Pillars and daily practices, in a clear and engaging way.</p>
       </div>
       
       <div class="col-lg-7">
        <h5 class="fw-bold text-left">Auto Word Completion</h5>
        <p class="text-left">Our Auto Word Completion tool predicts and suggests words as users type, streamlining the search for Quranic verses and tafseer. This aids those with limited Arabic skills and boosts user engagement. Contributions will help us develop this essential feature further.</p>
       </div>
       <div class="col-lg-5 16x9">
        <iframe 
         src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&controls=0&rel=0&loop=1&playlist=dQw4w9WgXcQ&modestbranding=1&start=10" >
        </iframe>
       </div>
      </div>
      <hr class="container">
      <div class="row">       
       <div class="col-7">
        <h5 class="fw-bold text-left">Auto Word Completion</h5>
        <p class="text-left">Our Auto Word Completion tool predicts and suggests words as users type, streamlining the search for Quranic verses and tafseer. This aids those with limited Arabic skills and boosts user engagement. Contributions will help us develop this essential feature further.</p>
       </div>
       <div class="col-md-5 21x9">
        <iframe 
         src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&controls=0&rel=0&loop=1&playlist=dQw4w9WgXcQ&modestbranding=1&start=10" 
         title="YouTube video" 
         allow="autoplay; fullscreen"
         allowfullscreen>
        </iframe>
       </div>
      </div>
      

     </div>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
   </div>
  </div>
 </div>

</div>
</template>

<script>
export default {
 methods: {
  saveChanges() {
   this.$emit('save-video-data', 'Video data saved');
  }
 },
}
</script>

<style>

</style>>
