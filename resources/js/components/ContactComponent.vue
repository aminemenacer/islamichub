<template>
<div class="id pt-3">

  <div class="container-fluid py-3">
    <div class="row container-fluid">
      <div class="col-lg-5 mr-2 container">
        <h1 class="display-4 text-center">Get In Touch</h1>
        <p class="lead text-muted mb-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here,</p><br>
      </div>
      <div class="col-lg-6 mx-auto">
        <div class="card mt-5" style="border-radius:8px">
          <div class="card-header" style="border-radius:8px">

            <div class="tab-content">
              <div class="tab-pane fade show active pt-3">
                <form @reset="reset" @submit.prevent="sendMessage()" id="contactForm" name="contactForm" class="contactForm pb-5">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <p class="lead mb-0" style="color:black">Firstname:</p>
                        <input v-model="form.firstname" type="text" name="firstname" placeholder="Enter firstname" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <p class="lead mb-0" style="color:black">Lastname:</p>
                        <input v-model="form.lastname" type="text" name="lastname" placeholder="Enter lastname" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <p class="lead mb-0" style="color:black">Email Address:</p>
                        <input v-model="form.email" name="email" id="email" placeholder="Enter email" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <p class="lead mb-0" style="color:black">Phone:</p>
                        <input v-model="form.mobile" type="text" name="mobile" placeholder="Enter mobile number" class="form-control" />
                      </div>
                    </div>

                    <div class="col-md-10">
                      <div class="form-group">
                        <p class="lead mb-0" style="color:black">Subject:</p>
                        <input v-model="form.subject" type="text" name="subject" placeholder="Enter subject" class="form-control" />
                      </div>
                    </div>
                    <div class="col-md-10">
                      <div class="form-group">
                        <p class="lead mb-0" style="color:black">Message:</p>
                        <textarea v-model="form.message" rows="4" type="text" name="message" placeholder="Enter message" class="form-control" />
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="submit" value="Send Message" class="btn text-white" style="background:rgba(34,179,127,255)">
                        </div>
                      </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
export default {
  
  data() {
    return {
      feedback: {},
      form: new Form({
        firstname: "",
        lastname: "",
        email: "",
        subject: "",
        mobile: "",
        message: ""
      }),
     
    }
  },
  methods: {

    sendMessage() {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to send the message !",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "#d33",
        confirmButtonText: "Send message!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .post("/api/send-message", this.form)
            .then((res) => {
              if (!res.data.success) {
                Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "Message sent successfully ",
                  showConfirmButton: false,
                  timer: 1500,
                });
                this.form.reset();
                $("#addNew").hide();

              } else if (res.data.success) {
                Swal.fire(
                  "Error!",
                  "Unable to send message.",
                  "error"
                );
                this.form.reset();
                self.close();
              }
            })
            .catch(function (err) {});
        }
      });
    },

  },
}
</script>

<style scoped>

</style>
