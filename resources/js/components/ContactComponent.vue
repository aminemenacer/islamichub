<template>
<div class="id pt-3">

<div class="newsletter-subscribe mt-5 container">
 <div class="container">
  <div class="intro">
   <h1 class="text-center newsletter font-weight-bold" style="font-family:inter;">Subscribe to our Mailing List</h1>
   <div> <img src="/images/mail1.png" style="width: 100%;" />
   </div>

   <p class="text-center" style="font-family:inter;line-height: 1.7em;">Stay up-to-date with the latest news and updates by joining our mailing list! Be the first to know about new releases, product updates, and important announcements straight to your inbox. Joining our mailing list is the easiest way to stay connected and informed about everything happening in our community. Don't miss out on the latest developments – sign up now!</p>
  </div>

  <form class="form-inline" >
   <div class="form-group"><input class="form-control"  type="text" name="name" placeholder="Your Name"></div>
   <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Your Email Address"></div><br>
   <div class="form-group"><button class="btn btn-primary" type="submit">Subscribe </button></div>
  </form>
 </div>
</div>



 <div class="container py-3">
  <div class="row container">
   <div class="mr-2 ">
    <h1 class="display-4 text-center" style="font-family:serif">Get In Touch</h1>
    <p class="lead text-muted mb-0" style="font-family:serif">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here,</p><br>
   </div>
  </div>
  <div class="row">
   <div class="col-lg-6 mx-auto">
    <li v-for="(audio, index) in audioFiles" :key="index">
     <audio controls>
      <source :src="audio.url" type="audio/mpeg">
      Your browser does not support the audio element.
     </audio>
    </li>

    <div class="card mt-5" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px; border-radius:20px;padding:15px">
     <div class="card-body">

      <form @reset="reset" @submit.prevent="sendMessage()" id="contactForm" name="contactForm" class="contactForm ">
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

        <div class="col-md-12">
         <div class="form-group">
          <p class="lead mb-0" style="color:black">Subject:</p>
          <input v-model="form.subject" type="text" name="subject" placeholder="Enter subject" class="form-control" />
         </div>
        </div>
        <div class="col-md-12">
         <div class="form-group">
          <p class="lead mb-0" style="color:black">Message:</p>
          <textarea v-model="form.message" rows="4" type="text" name="message" placeholder="Enter message" class="form-control" />
          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-success text-white btn-lg">
                          </div>
                        </div>
                    </div>
                  </form>
                </div>
            </div>

          
        </div>
        <div class="col-lg-6 mt-5 d-none d-lg-block"><img src="/images/message.png" alt="" class="img-fluid"></div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

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

 }
 }
</script>

<style scoped>
.newsletter-subscribe {
 color: #313437;
 background-color: #ffffff;
 padding: 55px 74px;
 box-shadow: rgba(161, 159, 159, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;

}

.newsletter-subscribe p {
 color: #7d8285;
 line-height: 1.5;
}

.newsletter-subscribe h2 {
 font-size: 24px;
 font-weight: bold;
 margin-bottom: 25px;
 line-height: 1.5;
 padding-top: 0;
 margin-top: 0;
 color: inherit;
}

.newsletter-subscribe .intro {
 font-size: 16px;
 max-width: 500px;
 margin: 0 auto 25px;
}

.newsletter-subscribe .intro p {
 margin-bottom: 35px;
}

.newsletter-subscribe form {
 justify-content: center;
}

.newsletter-subscribe form .form-control {
 background: #eff1f4;
 border: none;
 border-radius: 3px;
 box-shadow: none;
 outline: none;
 color: inherit;
 text-indent: 9px;
 height: 45px;
 margin-right: 10px;
 min-width: 250px;
}

.newsletter-subscribe form .btn {
 padding: 16px 32px;
 border: none;
 background: none;
 box-shadow: none;
 text-shadow: none;
 opacity: 0.9;
 text-transform: uppercase;
 font-weight: bold;
 font-size: 13px;
 letter-spacing: 0.4px;
 line-height: 1;
}

.newsletter-subscribe form .btn:hover {
 opacity: 1;
}

.newsletter-subscribe form .btn:active {
 transform: translateY(1px);
}

.newsletter-subscribe form .btn-primary {
 background-color: green !important;
 color: #fff;
 outline: none !important;
}

body {
 background: #eee;
}

.newsletter {
 color: green !important;
}
</style>
