<template>
<div>
  <DataTable v-model:filters="filters" showGridlines stripedRows sortable filterDisplay="row" :value="payments" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" removableSort width="100%" tableStyle="max-width:100%">
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

          <button class="btn text-white user-btn" style="background-color: #b71c1c" >
            <i class="pi pi-trash"></i>
            Delete
          </button>
        </div>
      </template>
    </Column>

    <template class="text-center" #footer> In total there are {{ payments ? payments.length : 0 }} Payments. </template>

  </DataTable>
</div>
</template>

<style scoped>
.action {
  display: flex;
  margin: 0 auto;
  width: auto;
  display: flex;
}

.wrapper {
  float: left;
  width: 100%;
  text-align: center;
}
</style>

<script>
import axios from "axios";
import {
  FilterMatchMode
} from "primevue/api";

export default {
  mounted() {
    this.loadPayments();
    ProductService.getProductsMini().then((data) => (this.payments = data.data));
  },
  data() {
    return {
      filters: {
        global: {
          value: null,
          matchMode: FilterMatchMode.CONTAINS,
        },
      },
      searchValue: "",
      columns: [{
          field: 'id',
          header: 'ID',
          sortable: true
        },
        {
          field: "name",
          header: "Name",
          sortable: true,
        },
        {
          field: "amount",
          header: "Amount",
          sortable: true,
        },
        {
          field: "payment_method",
          header: "Payment Method",
          sortable: true,
        },
        {
          field: "currency",
          header: "Currency",
          sortable: true,
        },
        {
          field: "status",
          header: "Status",
          sortable: true,
        },

      ],
      payments: null,
    }
  },
  methods: {
    exportCSV() {
      this.$refs.dt.exportCSV();
    },
    loadPayments() {
      axios.get("api/fetch-payments").then((data) => {
        this.payments = data.data;
      });
    },
  }
}
</script>
