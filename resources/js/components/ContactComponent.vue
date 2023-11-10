<template>
<div class="id">
  <section class="ftco-section">
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
                  <h1 class="mb-4"><strong>Get in touch</strong></h1>
                  <div id="form-message-warning" class="mb-4"></div>

                  <form method="POST" id="contactForm" name="contactForm" class="contactForm">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label" for="name">Firstname:</label>
                          <input type="text" class="form-control" name="name" id="name" placeholder="firstname">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label" for="email">Lastname:</label>
                          <input type="email" class="form-control" name="email" id="email" placeholder="Lastname">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label" for="email">Email Address:</label>
                          <input type="email" class="form-control" name="email" id="email" placeholder="Email address">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="label" for="subject">Subject:</label>
                          <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="label" for="#">Message:</label>
                          <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Message"></textarea>
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

<style scoped>
form {

  font-family: 'Quicksand', sans-serif;
  color: #212529;
  font-size: 1.1rem;
}

.btn.btn-primary {
  font-family: 'Quicksand', sans-serif;
  font-weight: bold;
  line-height: 2.5rem;
  padding: 0 3rem;
  border: 0;
  border-radius: 3rem;
  background-image: linear-gradient(131deg, #ffd340, #ff923c, #ff923c, #ff923c);
  background-size: 300% 100%;
  transition: all 0.3s ease-in-out;
}

.btn.btn-primary:hover:enabled {
  box-shadow: 0 0.5em 0.5em -0.4em #ff923cba;
  background-size: 100% 100%;
  transform: translateY(-0.15em);
}
</style>
