<template>
<div id="app" class="container-fluid pt-3">
  <section class="py-3">
    <div class="container">
      <div class="row justify-content-center text-center mb-2 mb-lg-4">
        <div class="col-12 col-lg-8 col-xxl-7 text-center mx-auto">
          <h2 class="display-5 fw-bold">Our Pricings</h2>
          <p class="lead">We offer flexible pricing plans tailored to meet your goals. Whether you're just starting out or need advanced features, select the plan that works best for you and get started today.</p>
        </div>
      </div>
      <div class="card border-0 mb-3">
        <div class="card-body bg-light text-center py-4">
          <div class="row align-items-center">
            <div class="col-md-3">
              <h5 class="fw-bold mb-0">Basic</h5>
              <div class="display-3 fw-bold mt-1">
                $2
              </div>
              <div>
                Monthly
              </div>
            </div>
            <div class="col-md-3">
              <ul class="list-unstyled mt-4 mt-md-3">
                <li class="mb-3">5 free screenshots per week</li>
                <li class="mb-3">5 free notes per week</li>
                <li class="mb-3">5 pdf downloads per week</li>
                <li class="mb-3">3 voice notes per week</li>
              </ul>
            </div>
            <div class="col-md-3">
              <ul class="list-unstyled mt-3">
                <li class="mb-3">3 voice notes per week</li>
                <li class="mb-3">5 pdf downloads per week</li>
                <li class="mb-3">3 voice notes per week</li>
              </ul>
            </div>
            <div class="col-md-3">
              <button class="btn btn-lg" style="background:rgba(0, 191, 166);color:white" @click="initiateCheckout('basic')">Get Started</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card border-0 mb-3">
        <div class="card-body bg-light text-center py-4">
          <div class="row align-items-center">
            <div class="col-md-3">
              <h5 class="fw-bold mb-0">Premium</h5>
              <div class="display-3 fw-bold mt-1" style="color:rgba(0, 191, 166)">
                $4
              </div>
              <div>
                Monthly
              </div>
            </div>
            <div class="col-md-3">
              <ul class="list-unstyled mt-4 mt-md-3">
                <li class="mb-3">15 free screenshots per week</li>
                <li class="mb-3">Unlimited notes per week</li>
                <li class="mb-3">5 folders & store up to 10 bookmarks or notes</li>
              </ul>
            </div>
            <div class="col-md-3">
              <ul class="list-unstyled mt-3">
                <li class="mb-3">15 pdf downloads per week</li>
                <li class="mb-3">Custom and Default styling</li>
                <li class="mb-3">10 speech to text notes</li>
              </ul>
            </div>
            <div class="col-md-3">
              <button class="btn btn-lg" style="background:rgba(0, 191, 166);color:white" @click="initiateCheckout('premium')">Get Started</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card border-0 mb-3">
        <div class="card-body bg-light text-center py-4">
          <div class="row align-items-center">
            <div class="col-md-3">
              <h5 class="fw-bold mb-0">Premium Plus</h5>
              <div class="display-3 fw-bold mt-1">
                $6
              </div>
              <div>
                Monthly
              </div>
            </div>
            <div class="col-md-3">
              <ul class="list-unstyled mt-4 mt-md-3">
                <li class="mb-3">Unlimited screenshots</li>
                <li class="mb-3">Unlimited notes</li>
                <li class="mb-3">Unlimited folders & storage</li>
              </ul>
            </div>
            <div class="col-md-3">
              <ul class="list-unstyled mt-3">
                <li class="mb-3">Custom and Default styling</li>
                <li class="mb-3">TinyMce Editor</li>
                <li class="mb-3">Unlimited speech to text notes</li>
              </ul>
            </div>
            <div class="col-md-3">
              <button class="btn btn-lg" style="background:rgba(0, 191, 166);color:white" @click="initiateCheckout('deluxe')">Get Started</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
</template>

<script>
import axios from 'axios';
import {
  loadStripe
} from "@stripe/stripe-js";

export default {
  data() {
    return {
      plans: {
        basic: 10, // Example price
        premium: 20,
        deluxe: 30,
      },
    };
  },
  methods: {
    async initiateCheckout(plan) {
      try {
        // Make a POST request to the backend to create a checkout session
        const response = await axios.post('/create-checkout-session', {
          plan
        });

        // Get the session ID from the backend response
        const sessionId = response.data.sessionId;

        // Load Stripe with your publishable key
        const stripe = await loadStripe('pk_test_51QIJkjIol4Q5wn4OOOwjUCTuVO7k49YHuLHsnMGjcOAiKesa3CbihaIRvdsXmXrKCUOxbslT1kWyHhbxFEW4TVzf00Kpk3PNUf');
        const {
          error
        } = await stripe.redirectToCheckout({
          sessionId
        });

        if (error) {
          console.error('Error redirecting to checkout:', error);
        }
      } catch (error) {
        console.error('Error creating checkout session:', error);
      }
    }
  },

}
</script>

<style scoped>
.subscription-buttons button {
  margin: 10px;
  padding: 10px;
  cursor: pointer;
}
</style>

