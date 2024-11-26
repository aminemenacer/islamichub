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
            <div class="mb-3">
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
            </div>

            <!-- Donate Button -->
            <button class="container form-control" style="background:#00BFA6; color:white" @click="donate">
              Donate
            </button>
          </div>
        </div>
        <div class="col-md-6 order-2">
          <img src="/images/money1.png" width="100%" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { loadStripe } from "@stripe/stripe-js";
import axios from "axios"; // Assuming axios is imported to handle the API call

export default {
  data() {
    return {
      stripe: null,
      amount: 0,  // Start with 0 so user has to input their own amount
    };
  },
  mounted() {
    // Initialize Stripe with your publishable key
    loadStripe('pk_test_51OhWyICJwy2NXBn1qd6CDCqfzR5BkiaL4OYkl9EUc3nYm2D3paDVZuAyRks7NJBWodYHbQJOcxsxDA9L4umn4Kok00YuLJBbfh').then((stripe) => {
      this.stripe = stripe;
    });
  },
  methods: {
    async donate() {
      if (this.amount <= 0) {
        alert("Please enter a valid donation amount.");
        return;
      }

      try {
        // Send the dynamically selected donation amount to the backend
        const response = await axios.post('/create-checkout-session', {
          amount: this.amount,
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
  font-weight: 400;
  color: #333;
  width: 100%;
  box-sizing: border-box;
  transition: border-color 0.2s ease-in-out;
}

.stripe-input:focus {
  border-color: #00bfa6;
  outline: none;
}

.stripe-input::placeholder {
  color: #ccc;
}

/* Additional button styles */
.donate {
  background-color: #00BFA6;
  border-radius: 8px;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  font-family: "Akzidenz Grotesk BQ Medium", -apple-system, BlinkMacSystemFont, sans-serif;
  font-size: bold;
  font-weight: 400;
  outline: none;
  padding: 10px 25px;
  text-align: center;
  transform: translateY(0);
  transition: transform 150ms, box-shadow 150ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}
</style>