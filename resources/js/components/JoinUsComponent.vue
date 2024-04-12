<template>
<div class="newsletter-subscribe mt-5 container">
 <div class="container">
  <div class="intro">
   <h1 class="text-center newsletter font-weight-bold" style="font-family:inter;">Subscribe to our Mailing List</h1>
   <div> <img src="/images/mail2.png" style="width: 100%;" />
   </div>

   <p class="text-center" style="font-family:inter;line-height: 1.7em;">Stay up-to-date with the latest news and updates by joining our mailing list! Be the first to know about new releases, product updates, and important announcements straight to your inbox. Joining our mailing list is the easiest way to stay connected and informed about everything happening in our community. Don't miss out on the latest developments – sign up now!</p>
  </div>

  <form class="form-inline" @reset="reset" @submit.prevent="submitMail()">
   <div class="form-group"><input class="form-control" v-model="form.name" type="text" name="name" placeholder="Your Name"></div>
   <div class="form-group"><input class="form-control" v-model="form.email" type="email" name="email" placeholder="Your Email Address"></div><br>
   <div class="form-group"><button class="btn" style="background:#00BFA6;color:white" type="submit">Subscribe </button></div>
  </form>
 </div>
</div>
</template>

<script>
import axios from 'axios';
export default {

 data() {
  return {
   mailing: {},
   form: new Form({
    name: "",
    email: "",
   })
  }
 },
 methods: {
  submitMail() {
   Swal.fire({
    title: "Are you sure?",
    text: "You want to join the mailing !",
    showCancelButton: true,
    confirmButtonColor: "green",
    cancelButtonColor: "#d33",
    confirmButtonText: "Submit mailing!",
   }).then((result) => {
    if (result.isConfirmed) {
     axios.post("/api/submit-mail", this.form)
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
 color: black !important;
}
</style>
