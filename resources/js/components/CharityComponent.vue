<template>
<div id="app" class="pt-3">

  <div class="container py-3">
  <!--
    <div class="row">
      <div class="col-lg-6 text-left">
      <h1 class="display-4">Donations</h1>
        <p class="lead text-muted mb-0">In Islam, the act of giving and charitable donations hold profound significance, emphasized through the pillar of Zakat. Zakat is a mandatory form of almsgiving, representing a fundamental aspect of Islamic financial and social responsibility. The term itself means "purification," signifying the purification of one's wealth through the act of giving to those in need.</p><br>
        <p class="lead text-muted mb-0">The call for donations in Islam is rooted in compassion and empathy for the less fortunate. It is a way for individuals to fulfill their duty towards their fellow human beings, fostering a sense of community and solidarity. </p>
      </div>
      <div class="col-lg-6 mx-auto">
        <div class="card mt-5" style="border-radius:8px">
          <div class="card-header" style="border-radius:8px">

            -- Credit card form content --
            <div class="tab-content">
              -- credit card info--
              <div id="credit-card" class="tab-pane fade show active pt-3">
                <form role="form" onsubmit="event.preventDefault()">
                  <div class="form-group"> <label for="username">
                      <h6>Card Owner</h6>
                    </label> <input type="text" name="username" placeholder="Card Owner Name" required class="form-control "> </div>
                  <div class="form-group"> <label for="cardNumber">
                      <h6>Card number</h6>
                    </label>
                    <div class="input-group"> <input type="text" name="card_number" placeholder="Valid card number" class="form-control " required>
                      <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-8">
                      <div class="form-group"> <label><span class="hidden-xs">
                            <h6>Expiration Date</h6>
                          </span></label>
                        <div class="input-group"> <input type="number" placeholder="MM" name="" class="form-control" required> <input type="number" placeholder="YY" name="" class="form-control" required> </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group mb-4"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                          <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                        </label> <input type="text" required class="form-control"> </div>
                    </div>
                  </div>
                  <div class="card-footer"> 
                    <button type="button" class="subscribe btn btn-secondary btn-block shadow-sm" @click="handleSubmit">Pay Now</button>
                  </div>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>


    <form id="payment-form">
        <div id="payment-element">
            -- Stripe will create form elements here --
        </div>
        <button type="submit" @click="handleSubmit">Pay via Stripe</button>
    </form>
  -->

  <div>
    <label for="amount">Amount:</label>
    <input v-model="amount" type="number" min="1" step="0.01">
    
    <label for="currency">Currency:</label>
    <select v-model="selectedCurrency">
      <option value="usd">USD</option>
      <option value="eur">EUR</option>
      <!-- Add more currency options as needed -->
    </select>
    
    <button @click="initiatePayment">Initiate Payment</button>
  </div>

  </div>
  
</div>
</template>

<script>
export default {
  data() {
    return {
      amount: 1, // Default amount
      selectedCurrency: 'usd', // Default currency
    };
  },
  async mounted() {
    const stripe = await this.$stripe;
    const elements = stripe.elements();

    // Create an instance of the card Element.
    const cardElement = elements.create('card');

    // Mount the card element to the DOM.
    cardElement.mount('#card-element');
  },
  methods: {
    async initiatePayment() {
      try {
        const stripe = await this.$stripe; // Access Stripe instance from the Vue app
        const response = await axios.post('/payment/initiate', {
          amount: this.amount,
          currency: 'usd', // Adjust currency as needed
        });

        const { error } = await stripe.confirmCardPayment(response.data.client_secret, {
          payment_method: {
            card: elements.getElement('card-element'), // Use the card element created earlier
            billing_details: {
              // Include any additional billing details if needed
            },
          },
        });

        cardElement.mount('#card-element');

        if (error) {
          console.error(error);
        } else {
          console.log('Payment successful!');
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>



<style>
body {
  background: #f5f5f5
}

.rounded {
  border-radius: 1rem
}

.nav-pills .nav-link {
  color: #555
}

.nav-pills .nav-link.active {
  color: white
}

input[type="radio"] {
  margin-right: 5px
}

.bold {
  font-weight: bold
}
</style>
