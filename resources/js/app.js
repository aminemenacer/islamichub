// Vue libraries
require("./bootstrap");
import { createApp } from "vue";
import { Form } from "vform";
import swal from "sweetalert2";
import "sweetalert2/src/sweetalert2.scss";

window.Vue = require("vue");

import PrimeVue from "primevue/config";
import "primevue/resources/themes/saga-blue/theme.css"; //theme
import "primevue/resources/primevue.min.css"; //core css
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import InputText from "primevue/inputtext";

import UsersComponent from "./components/UsersComponent.vue";
import FeedbackComponent from "./components/FeedbackComponent.vue";
import PaymentComponent from "./components/PaymentComponent.vue";
import DonationComponent from "./components/DonationComponent.vue";
import ProfileComponent from "./components/ProfileComponent.vue";
import DashboardComponent from "./components/DashboardComponent.vue";
import ExampleComponent from './components/ExampleComponent.vue';
import JsonComponent from './components/JsonComponent.vue';
import HomepageComponent from './components/HomepageComponent.vue';


window.Vue = require('vue');

const app = createApp({});

window.Form = Form;
window.Swal = swal;

app.use(PrimeVue);

app.component("Column", Column);
app.component("DataTable", DataTable);
app.component("Button", Button);
app.component("InputText", InputText);

app.component("example-component", ExampleComponent);
app.component("users-component", UsersComponent);
app.component("feedback-component", FeedbackComponent);
app.component("payment-component", PaymentComponent);
app.component("donation-component", DonationComponent);
app.component("profile-component", ProfileComponent);
app.component("dashboard-component", DashboardComponent);
app.component("json-component", JsonComponent);
app.component("homepage-component", HomepageComponent);


app.mount('#app');
