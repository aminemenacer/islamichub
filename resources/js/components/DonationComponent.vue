<template>
<div>
  <DataTable v-model:filters="filters" showGridlines stripedRows sortable filterDisplay="row" :value="donations" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" removableSort width="100%" tableStyle="max-width:100%">
    <template #header>
      <div class="flex justify-content-start" style="display: flex;">
        <Button type="button" style="border-radius:8%" class="flex flex-column md:flex-row md:justify-content-between row-gap-3 mr-3" severity="help" label="Export" @click="exportCSV($event)" />

        <p style="display: flex" class=" ml-auto mr-3 mt-2 text-black">
          Search:
        </p>
        <span>
          <InputText v-model="filters['global'].value" style="float: left" placeholder="Keyword Search" />
        </span>
      </div>
    </template>

    <Column v-for="col of columns" :key="col.field" :field="col.field" :header="col.header" sortable class="text-left" style="align-items:center" width>
    </Column>

    <Column :exportable="true" style="min-width: 8rem">
      <template #body="slotProps">
        <div class="wrapper text-center" style="display:flex">
          <Button data-bs-toggle="modal" data-bs-target="#editNew1" type="button" class="btn user-btn text-white text-center mr-2 " style="background-color: #1e88e5; display:flex" @click="editModal(slotProps.data)">
            <i class="pi pi-eye mr-2"></i>
            View
          </Button>
        </div>
      </template>
    </Column>

    <template class="text-center" #footer> In total there are {{ donations ? donations.length : 0 }} donations. </template>

  </DataTable>
</div>
</template>

<script>
import axios from "axios";
import {
  FilterMatchMode
} from "primevue/api";

export default {
  mounted() {
    this.loadDonations();
    ProductService.getProductsMini().then((data) => (this.donations = data));
  },
  data(){
    return{
      filters: {
        global: {
          value: null,
          matchMode: FilterMatchMode.CONTAINS,
        },
      },
      searchValue: "",
      columns: [{
          field: "id",
          header: "ID",
          sortable: true,
        },
        {
          field: "firstname",
          header: "Firstname",
          sortable: true,
        },
        {
          field: "lastname",
          header: "Lastname",
          sortable: true,
        },
        {
          field: "amount",
          header: "Amount",
          sortable: true,
        },
        {
          field: "currency",
          header: "Currency",
          sortable: true,
        },
        {
          field: "payment_status",
          header: "Payment Status",
          sortable: true,
        }
      ],

      users: [],
      sortDesc: false,
    }
  },
  methods: {
    exportCSV() {
      this.$refs.dt.exportCSV();
    },
    loadDonations() {
      axios.get("api/fetch-donations").then((data) => {
        this.donations = data.data;
      });
    },
  },
}
</script>

<style>

</style>
