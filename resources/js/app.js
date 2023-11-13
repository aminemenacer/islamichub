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
import Card from 'primevue/card';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';

import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';



import UsersComponent from "./components/UsersComponent.vue";
import FeedbackComponent from "./components/FeedbackComponent.vue";
import PaymentComponent from "./components/PaymentComponent.vue";
import DonationComponent from "./components/DonationComponent.vue";
import ProfileComponent from "./components/ProfileComponent.vue";
import DashboardComponent from "./components/DashboardComponent.vue";
import ExampleComponent from './components/ExampleComponent.vue';
import JsonComponent from './components/JsonComponent.vue';
import HomepageComponent from './components/HomepageComponent.vue';
import PricingComponent from './components/PricingComponent.vue';
import ContactComponent from './components/ContactComponent.vue';
import ReminderComponent from './components/ReminderComponent.vue';
import CharityComponent from './components/CharityComponent.vue';
import VolunteerComponent from './components/VolunteerComponent.vue';
import CardsComponent from './components/CardsComponent.vue';
import HadithComponent from './components/HadithComponent.vue';


window.Vue = require('vue');

const app = createApp({});

window.Form = Form;
window.Swal = swal;

app.use(PrimeVue);

app.component("Column", Column);
app.component("DataTable", DataTable);
app.component("Button", Button);
app.component("InputText", InputText);
app.component("AccordionTab", AccordionTab);
app.component("Accordion", Accordion);
app.component("Card", Card);
app.component("TabView", TabView);
app.component("TabPanel", TabPanel);

app.component("example-component", ExampleComponent);
app.component("users-component", UsersComponent);
app.component("feedback-component", FeedbackComponent);
app.component("payment-component", PaymentComponent);
app.component("donation-component", DonationComponent);
app.component("profile-component", ProfileComponent);
app.component("dashboard-component", DashboardComponent);
app.component("json-component", JsonComponent);
app.component("homepage-component", HomepageComponent);
app.component("pricing-component", PricingComponent);
app.component("contact-component", ContactComponent);
app.component("reminder-component", ReminderComponent);
app.component("charity-component", CharityComponent);
app.component("volunteer-component", VolunteerComponent);
app.component("cards-component", CardsComponent);
app.component("hadith-component", HadithComponent);


app.mount('#app');
