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
        <div v-for="(plan, key) in plans" :key="key" class="card border-0 mb-3">
          <div class="card-body bg-light text-center py-4">
            <div class="row align-items-center">
              <div class="col-md-3">
                <h5 class="fw-bold mb-0">{{ plan.name }}</h5>
                <div class="display-3 fw-bold mt-1">
                  {{ plan.price }}
                </div>
                <div>Monthly</div>
              </div>
              <div class="col-md-3">
                <ul class="list-unstyled mt-4 mt-md-3">
                  <li v-for="feature in plan.features" :key="feature" class="mb-3">{{ feature }}</li>
                </ul>
              </div>
              <div class="col-md-3">
                <ul class="list-unstyled mt-3">
                  <li v-for="extra in plan.extras" :key="extra" class="mb-3">{{ extra }}</li>
                </ul>
              </div>
              <div class="col-md-3">
                <button
                  class="btn btn-lg"
                  style="background:rgba(0, 191, 166);color:white"
                  @click="initiateCheckout(key)"
                >
                  Get Started
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from "axios";
import { loadStripe } from "@stripe/stripe-js";

export default {
  data() {
    return {
      plans: {
        basic: {
          name: "Basic",
          price: "$2",
          features: [
            "5 free screenshots per week",
            "5 free notes per week",
            "5 pdf downloads per week",
          ],
          extras: ["3 voice notes per week", "Basic features"],
        },
        premium: {
          name: "Premium",
          price: "$4",
          features: [
            "15 free screenshots per week",
            "Unlimited notes per week",
            "5 folders & store up to 10 bookmarks or notes",
          ],
          extras: [
            "15 pdf downloads per week",
            "Custom and Default styling",
            "10 speech-to-text notes",
          ],
        },
        deluxe: {
          name: "Premium Plus",
          price: "$6",
          features: ["Unlimited screenshots", "Unlimited notes", "Unlimited folders"],
          extras: ["Custom styling", "TinyMce Editor", "Unlimited speech-to-text"],
        },
      },
    };
  },
  methods: {
    async initiateCheckout(plan) {
      try {
        const response = await axios.post("/create-checkout-session", { plan });

        if (response.data.sessionId) {
          const stripe = await loadStripe("pk_test_51QIJkjIol4Q5wn4OOOwjUCTuVO7k49YHuLHsnMGjcOAiKesa3CbihaIRvdsXmXrKCUOxbslT1kWyHhbxFEW4TVzf00Kpk3PNUf");

          const { error } = await stripe.redirectToCheckout({
            sessionId: response.data.sessionId,
          });

          if (error) {
            console.error("Error redirecting to checkout:", error.message);
          }
        } else {
          console.error("No sessionId returned from backend");
        }
      } catch (error) {
        console.error("Error creating checkout session:", error.response?.data || error.message);
      }
    },
  },
};
</script>

<style scoped>
.subscription-buttons button {
  margin: 10px;
  padding: 10px;
  cursor: pointer;
}
</style>
