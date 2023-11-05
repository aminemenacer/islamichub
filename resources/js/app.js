// Vue libraries
require("./bootstrap");
import { createApp } from "vue";
import { Form } from "vform";
import $ from "jquery";

window.Vue = require("vue").default;

import PrimeVue from 'primevue/config';
import "primevue/resources/themes/saga-blue/theme.css"; //theme
import "primevue/resources/primevue.min.css"; //core css
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';





import ExampleComponent from "./components/ExampleComponent.vue";
import UsersComponent from "./components/UsersComponent.vue";
import FeedbackComponent from "./components/FeedbackComponent.vue";
import PaymentComponent from "./components/PaymentComponent.vue";
import DonationComponent from "./components/DonationComponent.vue";
import ProfileComponent from "./components/ProfileComponent.vue";

const app = createApp({});
window.Form = Form;
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

app.mount("#app");

