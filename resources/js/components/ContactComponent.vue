<template>
<div class="newsletter-subscribe">
 <div>
  <div class="intro">
   <h1 class="text-center newsletter-title ">Get In Touch</h1>
  </div>

  <div class="contact3 container-fluid">
   <div class="row no-gutters">
    <div >
     <div class="row container-fluid">
      <div class="col-lg-6">
       <p class="text-left text-secondary " style="line-height: 1.7em; font-family:inter">
        Welcome to Islamic Connect, where we aim to make accessing and understanding the Noble Quran a truly enriching experience for everyone.
       </p>
       <p class="text-left text-secondary " style="line-height: 1.7em; font-family:inter">
        Islamic Connect is more than just a platform its a Sadaqah Jariyah, a continuous charity that benefits individuals and communities for years to come. Our vision is to provide effortless access to the timeless wisdom and guidance found within the Quran, fostering a deeper connection to faith and spirituality for people around the world.
       </p>
       <p class="text-left text-secondary " style="line-height: 1.7em; font-family:inter">
        We recognize that navigating the Quran can be challenging, which is why we have curated a range of tools and resources to make the process easier and more fulfilling. From searchable translations and interpretations to audio recitations and educational articles, we offer everything you need to engage with the Quran on your own terms.
       </p>
      </div>
      <div class="col-lg-6">
       <div class="contact-box ml-3">
        <form @reset="reset" @submit.prevent="sendMessage()">
         <p class="text-left text-secondary " style="line-height: 1.7em; font-family:inter">"Please use the contact form below to reach out. Our team is ready to assist you and will respond promptly."</p>

         <div class="row ">
          <div class="col-md-10 mb-3">
           <input type="text" style="border:1px solid grey; border-radius:10px" class="form-control " v-model="form.firstname" name="firstname" placeholder="Enter firstname">
          </div>
          <div class="col-md-10 mb-3">
           <input type="text" style="border:1px solid grey; border-radius:10px" class="form-control" v-model="form.lastname" name="lastname" placeholder="Enter lastname">
          </div>
         </div>
         <div class="row">
          <div class="col-md-10 mb-3">
           <input type="email" style="border:1px solid grey; border-radius:10px" class="form-control" v-model="form.email" name="email" placeholder="Enter email">
          </div>
          <div class="col-md-10 mb-3">
           <input type="text" style="border:1px solid grey; border-radius:10px" class="form-control" v-model="form.mobile" name="mobile" placeholder="Enter mobile">
          </div>
         </div>
         <div class="row">
          <div class="col-md-10 mb-3">
           <input class="form-control" style="border:1px solid grey; border-radius:10px" v-model="form.subject" type="text" name="subject" placeholder="Enter subject">
          </div>
          <div class="col-md-10 mb-3 ">
           <textarea class="form-control" style="border:1px solid grey; border-radius:10px" v-model="form.message" name="message" placeholder="Enter message" rows="5"></textarea>
          </div>
         </div>
         <div class="row">
          <div class="col-md-12">
           <div class="form-group"><button class="btn text-left" style="background:#00BFA6;color:white" type="submit">Submit</button></div>
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

<style scoped>
.contact3 {
 font-family: "Montserrat", sans-serif;
 color: #8d97ad;
 font-weight: 300;
}

.contact3 h1,
.contact3 h2,
.contact3 h3,
.contact3 h4,
.contact3 h5,
.contact3 h6 {
 color: #3e4555;
}

.contact3 .font-weight-medium {
 font-weight: 500;
}

.contact3 .card-shadow {
 -webkit-box-shadow: 0px 0px 30px rgba(115, 128, 157, 0.1);
 box-shadow: 0px 0px 30px rgba(115, 128, 157, 0.1);
}

.contact3 .btn-danger-gradiant {
 background: #ff4d7e;
 background: -webkit-linear-gradient(legacy-direction(to right), #ff4d7e 0%, #ff6a5b 100%);
 background: -webkit-gradient(linear, left top, right top, from(#ff4d7e), to(#ff6a5b));
 background: -webkit-linear-gradient(left, #ff4d7e 0%, #ff6a5b 100%);
 background: -o-linear-gradient(left, #ff4d7e 0%, #ff6a5b 100%);
 background: linear-gradient(to right, #ff4d7e 0%, #ff6a5b 100%);
}

.contact3 .btn-danger-gradiant:hover {
 background: #ff6a5b;
 background: -webkit-linear-gradient(legacy-direction(to right), #ff6a5b 0%, #ff4d7e 100%);
 background: -webkit-gradient(linear, left top, right top, from(#ff6a5b), to(#ff4d7e));
 background: -webkit-linear-gradient(left, #ff6a5b 0%, #ff4d7e 100%);
 background: -o-linear-gradient(left, #ff6a5b 0%, #ff4d7e 100%);
 background: linear-gradient(to right, #ff6a5b 0%, #ff4d7e 100%);
}

.newsletter-subscribe {
 font-family: inter;
 color: #313437;
 padding: 40px;
}

.newsletter-subscribe p {
 color: #7d8285;
 line-height: 1.5;
 font-family: inter;
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
 color: black !important;
}
</style>

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
