<template>
<div class="id pt-3">
  <section class="ftco-section">
    <h2 class="text-center"><strong>Contact Us</strong></h2>
    <p class="text-center container text-left pt-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here,</p>

 

   

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="wrapper">
            <div class="row no-gutters">
              <div class="col-lg-8 col-md-7 order-md-last d-flex align-items-stretch bg-white">
                <div class="contact-wrap w-100 p-md-5 p-4">
                  <div id="form-message-warning" class="mb-4"></div>

                  <form @reset="reset" @submit.prevent="sendMessage()" id="contactForm" name="contactForm" class="contactForm pb-5">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label" for="name">Firstname:</label>
                          <input v-model="form.firstname" type="text" name="firstname" placeholder="Enter firstname" class="form-control" />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label" for="email">Lastname:</label>
                          <input v-model="form.lastname" type="text" name="lastname" placeholder="Enter lastname" class="form-control" />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label" for="email">Email Address:</label>
                          <input v-model="form.email" name="email" id="email" placeholder="Enter email" class="form-control" />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label" for="email">Phone:</label>
                          <input v-model="form.mobile" type="text" name="mobile" placeholder="Enter mobile number" class="form-control" />
                        </div>
                      </div>

                      <div class="col-md-10">
                        <div class="form-group">
                          <label class="label" for="subject">Subject:</label>
                          <input v-model="form.subject" type="text" name="subject" placeholder="Enter subject" class="form-control" />
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="form-group">
                          <label class="label" for="#">Message:</label>
                          <textarea v-model="form.message" rows="4" type="text" name="message" placeholder="Enter message" class="form-control" />
                          </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="submit" value="Send Message" class="btn text-white" style="background:rgba(34,179,127,255)">
                          <div class="submitting"></div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-lg-4 col-md-5 d-flex align-items-stretch" style="background:rgba(34,179,127,255)">
                <div class="info-wrap w-100 p-md-5 p-4 text-white">
                  <h2><strong>Let's get in touch</strong></h2>
                  <p class="mb-4">We're open for any suggestion or just to have a chat</p>
                  <div class="dbox w-100 d-flex align-items-start">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-map-marker"></span>
                    </div>
                    <div class="text pl-3">
                      <p class="text-white"><span>Address:</span> Bilborough Nottingham, United Kingdom</p>
                    </div>
                  </div>
                  <div class="dbox w-100 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-phone"></span>
                    </div>
                    <div class="text pl-3">
                      <p class="text-white"><span>Phone:</span>(+44) 7871594836</p>
                    </div>
                  </div>
                  <div class="dbox w-100 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-paper-plane"></span>
                    </div>
                    <div class="text pl-3">
                      <p class="text-white"><span>Email:</span>menacer72@gmail.com</p>
                    </div>
                  </div>
                  <div class="dbox w-100 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-globe"></span>
                    </div>
                    <div class="text pl-3">
                      <p class="text-white"><span>Website</span>Islamichub.com</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>
</template>

<script>
export default {
  mounted() {
    this.countDownTimer();
  },
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
      form1: new Form({
        name: "",
        lastname: "",
        phone: "",
        email: "",
      })

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
