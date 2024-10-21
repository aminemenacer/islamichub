<template>
  <div class="modal fade show" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true" style="display: block;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="videoModalLabel"><b>Sign Language Videos</b></h4>
          <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container text-center">
            <div class="row">
              <div class="container pb-3">
                <h3 class="modal-title pb-2"><b>Sign Language Playlist</b></h3>
                <p>The Sign Language Video Playlist offers videos using sign language.</p>
              </div>
              <div class="col-lg-7">
                <h5 class="fw-bold text-left">Auto Word Completion</h5>
                <p class="text-left">Our Auto Word Completion tool predicts and suggests words...</p>
              </div>
              <div class="col-lg-5">
                <iframe 
                  src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&controls=0&rel=0&loop=1&playlist=dQw4w9WgXcQ&modestbranding=1&start=10"
                  width="100%" height="315" frameborder="0" allowfullscreen>
                </iframe>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    closeModal() {
      this.$emit('close-modal'); // Emit event to close modal
    },
  },
};
</script>


