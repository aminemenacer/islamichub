<template>
<div class="id">
  <div class="row container-fluid">
    <form class="col-md-12 text-center" style="border-radius:30px" id="contact" action="" method="post">
			<img src="/images/muslim.png" width="30px" class="text-center"/>
      <h2 class="text-center"><strong>IslamicHub</strong></h2>
      <p class="text-center mb-3">Contact us for any feedback, questions or bugs</p>
      <fieldset>
        <input placeholder="Your Firstname" type="text" tabindex="1" required autofocus>
      </fieldset>
			<fieldset>
        <input placeholder="Your Lastname" type="text" tabindex="1" required autofocus>
      </fieldset>
      <fieldset>
        <input placeholder="Your Email Address" type="email" tabindex="2" required>
      </fieldset>
      <fieldset>
        <input placeholder="Your Phone Number" type="tel" tabindex="3" required>
      </fieldset>
      <fieldset>
        <input placeholder="Your subject" type="url" tabindex="4" required>
      </fieldset>
      <fieldset>
        <textarea placeholder="Type your message here...." tabindex="5" required></textarea>
      </fieldset>
      <fieldset>
        <button width="50%" name="submit" type="submit" id="contact-submit" data-submit="...Sending" style="background:rgba(34,179,127,255)">Submit</button>
      </fieldset>
    </form>
	
  </div>
</div>
</template>

<script>
export default {

}
</script>

<style scoped>
.container {
  max-width: 300px;
  width: 100%;
  margin: 0 auto;
  position: relative;
}


#contact {
  background: #F9F9F9;
  padding: 25px;
  margin: 100px 0;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}

#contact h3 {
  display: block;
  font-size: 30px;
  font-weight: 400;
  margin-bottom: 10px;
}

#contact h4 {
  margin: 5px 0 15px;
  display: block;
  font-size: 13px;
  font-weight: 400;
}

fieldset {
  border: medium none !important;
  margin: 0 0 10px;
  min-width: 100%;
  padding: 0;
  width: 100%;
}

#contact input[type="text"],
#contact input[type="email"],
#contact input[type="tel"],
#contact input[type="url"],
#contact textarea {
  width: 100%;
  border: 1px solid #ccc;
  background: #FFF;
  margin: 0 0 5px;
  padding: 10px;
}

#contact input[type="text"]:hover,
#contact input[type="email"]:hover,
#contact input[type="tel"]:hover,
#contact input[type="url"]:hover,
#contact textarea:hover {
  -webkit-transition: border-color 0.3s ease-in-out;
  -moz-transition: border-color 0.3s ease-in-out;
  transition: border-color 0.3s ease-in-out;
  border: 1px solid #aaa;
}

#contact textarea {
  height: 100px;
  max-width: 100%;
  resize: none;
}

#contact button[type="submit"] {
  cursor: pointer;
  width: 50%;
  border: none;
  background: #4CAF50;
  color: #FFF;
  margin: 0 0 5px;
  padding: 10px;
  font-size: 15px;
}

#contact button[type="submit"]:hover {
  background: #43A047;
  -webkit-transition: background 0.3s ease-in-out;
  -moz-transition: background 0.3s ease-in-out;
  transition: background-color 0.3s ease-in-out;
}

#contact button[type="submit"]:active {
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
}

.copyright {
  text-align: center;
}

#contact input:focus,
#contact textarea:focus {
  outline: 0;
  border: 1px solid #aaa;
}

::-webkit-input-placeholder {
  color: #888;
}

:-moz-placeholder {
  color: #888;
}

::-moz-placeholder {
  color: #888;
}

:-ms-input-placeholder {
  color: #888;
}
</style>
