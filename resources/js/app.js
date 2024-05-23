// Vue libraries
require("./bootstrap");
import 'bootstrap/dist/css/bootstrap.min.css'; // Optional: If you want to include Bootstrap's CSS
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import { createApp } from "vue";
import { Form } from "vform";
import swal from "sweetalert2";
import "sweetalert2/src/sweetalert2.scss";
import $ from "jquery";

import PrimeVue from "primevue/config";
import "primevue/resources/themes/saga-blue/theme.css"; //theme
import "primevue/resources/primevue.min.css"; //core css
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Card from "primevue/card";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";
import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";
import Listbox from "primevue/listbox";
import Fieldset from "primevue/fieldset";
import Panel from "primevue/panel";
import Dialog from "primevue/dialog";
import Image from "primevue/image";

import UsersComponent from "./components/UsersComponent.vue";
import MailingListComponent from "./components/MailingListComponent.vue";
import FeedbackComponent from "./components/FeedbackComponent.vue";
import PaymentComponent from "./components/PaymentComponent.vue";
import DonationComponent from "./components/DonationComponent.vue";
import ProfileComponent from "./components/ProfileComponent.vue";
import DashboardComponent from "./components/DashboardComponent.vue";
import HomepageComponent from "./components/HomepageComponent.vue";
import PricingComponent from "./components/PricingComponent.vue";
import ContactComponent from "./components/ContactComponent.vue";
import CharityComponent from "./components/CharityComponent.vue";
import VolunteerComponent from "./components/VolunteerComponent.vue";
import AhadithComponent from "./components/AhadithComponent.vue";
import CorrectionComponent from "./components/CorrectionComponent.vue";
import QuranComponent from "./components/QuranComponent.vue";
import AboutComponent from "./components/AboutComponent.vue";
import BookmarkComponent from "./components/BookmarkComponent.vue";
import UpdatesComponent from "./components/UpdatesComponent.vue";
import JoinUsComponent from "./components/JoinUsComponent.vue";
import NotesComponent from "./components/NotesComponent.vue";

const app = createApp({});

window.Form = Form;
window.Swal = swal;
window.$ = window.jQuery = $;

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
app.component("ListBox", Listbox);
app.component("Fieldset", Fieldset);
app.component("Panel", Panel);
app.component("Dialog", Dialog);
app.component("Image", Image);

app.component("users-component", UsersComponent);
app.component("mailing_list-component", MailingListComponent);
app.component("feedback-component", FeedbackComponent);
app.component("payment-component", PaymentComponent);
app.component("donation-component", DonationComponent);
app.component("profile-component", ProfileComponent);
app.component("dashboard-component", DashboardComponent);
app.component("homepage-component", HomepageComponent);
app.component("pricing-component", PricingComponent);
app.component("contact-component", ContactComponent);
app.component("charity-component", CharityComponent);
app.component("volunteer-component", VolunteerComponent);
app.component("ahadith-component", AhadithComponent);
app.component("correction-component", CorrectionComponent);
app.component("quran-component", QuranComponent);
app.component("about-component", AboutComponent);
app.component("bookmark-component", BookmarkComponent);
app.component("updates-component", UpdatesComponent);
app.component("join_us-component", JoinUsComponent);
app.component("notes-component", NotesComponent);

// Ensure Bootstrap dropdowns are initialized correctly
document.addEventListener('DOMContentLoaded', function () {
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });
});

app.mount("#app");
