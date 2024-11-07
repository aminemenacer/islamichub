<template>
  <div>
    <div class="container pt-3">
      <div class="row gx-4  align-items-center justify-content-between">
        <div class="col-md-6 order-2 order-md-1 pb-3">
          <div class="mt-3 mt-md-0">
            <h2 class="display-5 fw-bold pb-3">Support Us</h2>
            <p class="lead">
              Support Islamic Connect: Build a Bridge to Islamic Knowledge. 
              At Islamic Connect, we are committed to providing free, easy-to-access Islamic resources to people worldwide.
              Your generous donations allow us to maintain and expand our platform, offering AI-powered tools, authentic Quranic content,
              and educational materials to those seeking knowledge, including new Muslims and non-Muslims.
            </p>
            <p class="lead">
              By donating, you are helping us spread the message of Islam to communities who need it most, 
              fostering understanding and peace. Join us in making Islamic knowledge more accessible and impactful. 
              Every donation, big or small, is a step toward a more enlightened world.
            </p>
            <button class="container form-control" style="background:#00BFA6; color:white" type="submit" @click="donate">Donate</button>
          </div>
        </div>
        <div class="col-md-6 order-2 ">
          <img src="/images/money1.png" width="100%">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { loadStripe } from "@stripe/stripe-js";
export default {
 data() {
   return {
      stripe: null,
      amount: 10
   }
 },
 mounted() {
    // Initialize Stripe with your publishable key
    loadStripe('pk_test_51OhWyICJwy2NXBn1qd6CDCqfzR5BkiaL4OYkl9EUc3nYm2D3paDVZuAyRks7NJBWodYHbQJOcxsxDA9L4umn4Kok00YuLJBbfh').then((stripe) => {
      this.stripe = stripe;
    });
  },
  methods: {
    async donate() {
      try {
        // Send a request to your backend to create a Stripe Checkout session
        const response = await axios.post('/create-checkout-session', {
          amount: this.amount,  // Set a default amount or dynamically get this value
        });

        const { id } = response.data;

        // Redirect to Stripe Checkout page
        const { error } = await this.stripe.redirectToCheckout({
          sessionId: id,
        });

        if (error) {
          console.error('Error redirecting to checkout:', error.message);
        }
      } catch (error) {
        console.error('Error creating checkout session:', error.message);
      }
    },

  },
}
</script>

<style>
.donate {
  background-color: #00BFA6;
  border-radius: 8px;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  font-family: "Akzidenz Grotesk BQ Medium", -apple-system, BlinkMacSystemFont, sans-serif;
  font-size:bold;
  font-weight: 400;
  outline: none;
  outline: 0;
  padding: 10px 25px;
  text-align: center;
  transform: translateY(0);
  transition: transform 150ms, box-shadow 150ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-37:hover {
  transform: translateY(-2px);
}

@media (min-width: 768px) {
  .button-37 {
    padding: 10px 30px;
  }
}

</style>
