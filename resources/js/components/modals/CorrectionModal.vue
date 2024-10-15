<template>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"><b>Rate your experience</b></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="createCorrection" id="reportForm">
            <!-- Rating -->
            <label for="rating" class="form-label text-left">Your Rating</label>
            <div class="star-rating">
              <span v-for="star in 5" :key="star" @click="setRating(star)" :class="{ 'active': star <= form.rating }">
                &#9733;
              </span>
            </div>
            <!-- Notes -->
            <div class="mb-3 mt-3 text-left">
              <label for="added_notes" class="form-label text-left">What could we improve on ?</label>
              <textarea v-model="form.added_notes" class="form-control h4" name="added_notes" placeholder="Enter you message here..." id="added_comments" rows="5" required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" form="reportForm" class="btn btn-success">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';


export default {
  name: 'CorrectionModal',

  data() {
    return {
      form: {
        mistake_type: '',
        added_notes: '',
        ayah_num: '',
        rating: 0
      },
      
    };
    
  },
  methods: {
    setRating(star) {
      this.form.rating = star;
    },
    hideAlertAfterDelay() {
     setTimeout(() => {
      this.showAlert = false;
      this.showAlertText = false;
      this.showErrorAlert = false;
     }, 3000); // Adjust the duration (in milliseconds) as needed
    },
    createCorrection() {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to submit the message!",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "#d33",
        confirmButtonText: "Submit!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post("/submit-correction", this.form)
            .then((res) => {
              if (res.data.success) {
                Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "Message submitted successfully",
                  showConfirmButton: false,
                  timer: 1500,
                });
                this.resetForm();
                this.hideModal();
              } else {
                Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "Message submitted successfully",
                  showConfirmButton: false,
                  timer: 1500,
                });
              }
            })
            .catch((err) => {
              console.error(err);
              Swal.fire("Error!", "Failed to submit. Fill in all the fields", "error");
            });
        }
      });
    },
    resetForm() {
      this.form.mistake_type = '';
      this.form.added_notes = '';
      this.form.ayah_num = '';
      this.form.rating = 0;
    },
    hideModal() {
      const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
      modal.hide();
    }
  }
};
</script>

<style scoped>
.star-rating {
  font-size: 24px;
  color: #ddd;
}
.star-rating span {
  cursor: pointer;
}
.star-rating span.active {
  color: gold;
}
</style>
