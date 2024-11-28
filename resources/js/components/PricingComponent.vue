<template>
<div id="app" class="container-fluid pt-3">
  <!-- <section class="py-3">
    <div class="container">
      <div class="row justify-content-center text-center mb-2 mb-lg-4">
        <div class="col-12 col-lg-8 col-xxl-7 text-center mx-auto">
          <h2 class="display-5 fw-bold">Our Pricings</h2>
          <p class="lead">We offer flexible pricing plans tailored to meet your goals. Whether you're just starting out or need advanced features, select the plan that works best for you and get started today.</p>
        </div>
      </div>
      <div v-for="(plan, key) in plans" :key="key" style="border-radius:12%" class="card border-0 mb-3">
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
              <button class="btn btn-lg" style="background:rgba(0, 191, 166);color:white" @click="initiateCheckout(key)">
                Get Started
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->

  <section class="py-3">
    <div class="price-sec-wrap">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-8 col-xxl-7 text-center mx-auto">
            <h2 class="display-4 fw-bold">Our Pricings</h2>
            <p class="lead">We offer flexible pricing plans tailored to meet your goals. Whether you're just starting out or need advanced features, select the plan that works best for you and get started today.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4">
            <div class="price-box">
              <div class="">
                <div class="price-label basic">Basic Plan</div>
                <div class="price">£ 0</div>
                <div class="price-info">Per Month</div>
              </div>
              <div class="info">
                <ul>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Voice search with instant Quranic results.</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Speech-to-text audio recording for user feedback.</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Toggle between basic and advanced modes.</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Multiple translations and audio recitations (in progress).</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Unlimited bookmarks and basic notes storage.</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Basic surah information.</li>
                </ul>
                <!-- <a href="#" class="plan-btn">Join Basic Plan</a> -->
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="price-box">
              <div class="">
                <div class="price-label value">Value Plan</div>
                <div class="price">£ 1.99</div>
                <div class="price-info">Per Month</div>
              </div>
              <div class="info">
                <ul>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Audio Sync with Word-by-Word Highlighting.</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Search Blogs, Articles, Podcasts, and More</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Generate up to 20 text summaries daily.</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Advanced and Customizable Editor</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Speech-to-Text for English Translations and Tafsir</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Text-to-Speech for Note Recordings (Up to 10 Daily).</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Download Screen Captures (Up to 10 Daily).</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Export Quranic Verses to CSV, Word, or PDF.</li>
                </ul>
                <a href="#" class="plan-btn">Join Value Plan</a>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="price-box">
              <div class="">
                <div class="price-label premium">Premium Plan</div>
                <div class="price">£ 2.99</div>
                <div class="price-info">Per Month</div>
              </div>
              <div class="info">
                <ul>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Download blogs and articles for offline reading.</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Generate unlimited text summaries with PDF export.</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Speech-to-text settings for an enhanced audio experience.</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Utilize text-to-speech for unlimited note recordings.</li>
                  <li><img src="images/check.png" width="20px" class="mr-2"/>Capture and download unlimited screen recordings.</li>
                </ul>
                <a href="#" class="plan-btn">Join Premium Plan</a>
              </div>
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
import {
  loadStripe
} from "@stripe/stripe-js";

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
          name: "Premium Pro",
          price: "$6",
          features: ["Unlimited screenshots", "Unlimited notes", "Unlimited folders"],
          extras: ["Custom styling", "TinyMce Editor", "Unlimited speech-to-text"],
        },
      },
    };
  },
  methods: {
    async initiateCheckout(plan) {

      const response = await axios.post("/create-checkout-session", {
        plan
      });

      if (response.data.sessionId) {
        const stripe = await loadStripe("pk_test_51QIJkjIol4Q5wn4OOOwjUCTuVO7k49YHuLHsnMGjcOAiKesa3CbihaIRvdsXmXrKCUOxbslT1kWyHhbxFEW4TVzf00Kpk3PNUf");

        const {
          error
        } = await stripe.redirectToCheckout({
          sessionId: response.data.sessionId,
        });

        if (error) {
          console.error("Error redirecting to checkout:", error.message);
        }
      } else {
        console.error("No sessionId returned from backend");
      }
    }
  },
};
</script>

<style scoped>
.price-sec-wrap {
  width: 100%;
  float: left;
  font-family: 'Lato', sans-serif;
}

.main-heading {
  text-align: center;
  font-weight: 600;
  padding-bottom: 15px;
  position: relative;
  text-transform: capitalize;
  font-size: 24px;
  margin-bottom: 25px;
}

.price-box {
  box-shadow: 0 0 35px rgba(0, 0, 0, 0.10);
  padding: 20px;
  background: #fff;
  border-radius: 4px;
}

.price-box ul {
  padding: 10px 0px 30px;
  margin: 17px 0 0 0;
  list-style: none;
  border-top: solid 1px #e9e9e9;
}

.price-box ul li {
  padding: 7px 0;
  font-size: 14px;
  color: #808080;
}

.price-box ul li .fas {
  color: #68AE4A;
  margin-right: 7px;
  font-size: 12px;
}

.price-label {
  font-size: 16px;
  font-weight: 600;
  line-height: 1.34;
  margin-bottom: 0;
  padding: 6px 15px;
  display: inline-block;
  border-radius: 3px;
}

.price-label.basic {
  background: #E8EAF6;
  color: #3F51B5;
}

.price-label.value {
  background: #E8F5E9;
  color: #4CAF50;
}

.price-label.premium {
  background: #FBE9E7;
  color: #FF5722;
}

.price {
  font-size: 44px;
  line-height: 44px;
  margin: 15px 0 6px;
  font-weight: 900;
}

.price-info {
  font-size: 14px;
  font-weight: 400;
  line-height: 1.67;
  color: inherit;
  width: 100%;
  margin: 0;
  color: #989898;
}

.plan-btn {
  text-transform: uppercase;
  font-weight: 600;
  display: block;
  padding: 11px 30px;
  border: 2px solid #b3b3b3;
  color: #000;
  margin-top: 5px;
  overflow: hidden;
  position: relative;
  z-index: 1;
  margin: 0;
  border-radius: 5px;
  text-decoration: none;
  width: 100%;
  text-align: center;
  font-size: 14px;
}

.plan-btn::after {
  position: absolute;
  left: -100%;
  top: 0;
  content: "";
  height: 100%;
  width: 100%;
  background: #000;
  z-index: -1;
  transition: all 0.35s ease-in-out;
}

.plan-btn:hover::after {
  left: 0;
}

.plan-btn:hover,
.plan-btn:focus {
  text-decoration: none;
  color: #fff;
  border: 2px solid #000;
}

@media (max-width: 991px) {
  .price-box {
    margin-bottom: 20px;
  }
}

@media (max-width: 575px) {
  .main-heading {
    font-size: 21px;
  }

  .price-box {
    margin-bottom: 20px;
  }
}

/* .card{
  box-shadow: 24px 24px 80px rgba(0,0,0,0.1);
  box-sizing: border-box;
  border-radius: 12px;
  margin: 20px;
  display: flex;
  flex-direction: column;
  border: 2px double rgba(0, 191, 166);

}

.subscription-buttons button {
  margin: 10px;
  padding: 10px;
  cursor: pointer;
} */
</style>
