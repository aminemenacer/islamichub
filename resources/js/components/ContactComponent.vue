<template>
<div class="newsletter-subscribe container">
 <div class="container ">
  <div class="intro">
   <h1 class="text-center newsletter-title ">Get In Touch</h1>
  </div>

  <div class="row mt-5">
  <div class="col-md-6">
    <img src="/images/message.png" style="width: 100%;" />
   </div>
   <div class="col-sm-6 ">
    <p class="text-left text-secondary " style="line-height: 1.7em; font-family:inter">"Connect with Us: Whether you have questions, suggestions, or simply want to say hello, we welcome your input. Please use the contact form below to reach out. Our team is ready to assist you and will respond promptly."</p>
    <form @reset="reset" @submit.prevent="sendMessage()">
     <div class="row ">
      <div class="col-md-10 mb-3">
       <input type="text" class="form-control " v-model="form.firstname" name="firstname" placeholder="Enter firstname">
      </div>
      <div class="col-md-10 mb-3">
       <input type="text" class="form-control" v-model="form.lastname" name="lastname" placeholder="Enter lastname">
      </div>
     </div>
     <div class="row">
      <div class="col-md-10 mb-3">
       <input type="email" class="form-control" v-model="form.email" name="email" placeholder="Enter email">
      </div>
      <div class="col-md-10 mb-3">
       <input type="text" class="form-control" v-model="form.mobile" name="mobile" placeholder="Enter mobile">
      </div>
     </div>
     <div class="row">
      <div class="col-md-10 mb-3">
       <input class="form-control" v-model="form.subject" type="text" name="subject" placeholder="Enter subject">
      </div>
      <div class="col-md-10 mb-3 ">
       <textarea class="form-control" v-model="form.message" name="message" placeholder="Enter message" rows="5"></textarea> 
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
</template>

<script>

</script>

<style >
 .newsletter-subscribe {
  font-family: inter;
  color: #313437;
  background-color: #ffffff;
  padding: 55px 74px;
  box-shadow: rgba(161, 159, 159, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
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

