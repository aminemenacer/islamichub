require('./bootstrap');

import { createApp } from "vue";

// Require Vue
window.Vue = require('vue').default;

import ExampleComponent from "./components/ExampleComponent.vue";
import UsersComponent from "./components/UsersComponent.vue";
import FeedbackComponent from "./components/FeedbackComponent.vue";
import PaymentComponent from "./components/PaymentComponent.vue";
import DonationsComponent from "./components/DonationsComponent.vue";

const app = createApp({});

app.component("example-component", ExampleComponent);
app.component("users-component", UsersComponent);
app.component("feedback-component", FeedbackComponent);
app.component("payment-component", PaymentComponent);
app.component("donations-component", DonationsComponent);

app.mount("#app");


// Initialize Vue
// const app = new Vue({
//     el: '#app',
// });