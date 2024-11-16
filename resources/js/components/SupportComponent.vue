<template>
  <div>
    <div class="container pt-3">
      <div class="row gx-4 align-items-center justify-content-between">
        <div class="col-md-6 order-2 order-md-1 pb-3">
          <div class="mt-3 mt-md-0">
            <h2 class="display-5 fw-bold pb-3">Support Us</h2>
            <p class="lead">
              Support Islamic Connect: Build a Bridge to Islamic Knowledge.
              Your generous donations help us expand and provide free access to educational Islamic resources.
            </p>
            <p class="lead">
              By donating, you're helping us spread the message of Islam. Join us in making Islamic knowledge more accessible.
            </p>

            <!-- Stripe-themed Donation Amount Input -->
            <!-- <div class="mb-3">
              <label for="donationAmount" class="form-label">Enter Donation Amount</label>
              <input 
                type="number" 
                id="donationAmount" 
                v-model="amount" 
                class="form-control stripe-input" 
                placeholder="Enter amount"
                min="1"
                step="1"
                required
              />
            </div> -->

            <!-- Donate Button -->
            <a 
              :href="gofundmeUrl" 
              target="_blank" 
              class="container form-control" 
              style="background:#00BFA6; color:white; text-align: center; text-decoration: none;">
              Donate
            </a>
          </div>
        </div>
        <div class="col-md-6 order-2">
          <img src="/images/money1.png" width="100%" loading="lazy"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script defer>
import { loadStripe } from "@stripe/stripe-js";
import axios from "axios";

export default {
  data() {
    return {
      gofundmeUrl: "https://www.gofundme.com/f/empowerment-through-quran-support-islamic-connects-mission",
      stripe: null,
      amount: 0,
    };
  },
  mounted() {
    loadStripe('pk_live_51QIJkjIol4Q5wn4Og4nYBjG25zNBFSnvTIfivJvDdHt6u0CD364TMcQHvGmrh6TOBNPDi9xwRDz7Zoirdl6NSDoB00JEFToo7F').then((stripe) => {
      this.stripe = stripe;
    }).catch(error => {
      console.error("Error loading Stripe:", error);
    });
  },
  methods: {
    async donate() {
      if (this.amount <= 0 || isNaN(this.amount)) {
        alert("Please enter a valid donation amount.");
        return;
      }

      if (!this.stripe) {
        console.error("Stripe not loaded yet.");
        alert("Stripe is not available. Please try again later.");
        return;
      }

      try {
        // Send amount to the backend and get session ID
        const response = await axios.post('/create-checkout-session', {
          amount: this.amount,
        });

        // Check if the sessionId is available
        const { sessionId } = response.data;
        if (!sessionId) {
          console.error("No session ID returned from the server.");
          alert("Failed to initiate checkout session. Please try again.");
          return;
        }

        // Debugging log to confirm sessionId is available
        console.log("Received sessionId:", sessionId);

        // Redirect to Stripe Checkout page with sessionId
        const { error } = await this.stripe.redirectToCheckout({
          sessionId: sessionId,
        });

        if (error) {
          console.error('Error redirecting to checkout:', error.message);
        }
      } catch (error) {
        console.error('Error creating checkout session:', error.message);
        alert("Failed to initiate checkout. Please check your network connection and try again.");
      }
    },
  },
};
</script>

<style>
/* Stripe-like theme for the input */
.stripe-input {
  background-color: #f7f7f8;
  border: 1px solid #ccd0d5;
  border-radius: 4px;
  padding: 12px;
  font-size: 16px;
  color: #333;
  width: 100%;
}

.stripe-input:focus {
  border-color: #00bfa6;
  outline: none;
}

.stripe-input::placeholder {
  color: #ccc;
}
</style>
