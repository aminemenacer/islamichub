<template>
<div >
  <DataTable v-model:filters="filters" showGridlines stripedRows sortable filterDisplay="row" :value="users" ref="dt" class="text-center" width="100%" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
    <template #header >

      <div class="flex justify-content-start" style="display:flex">
        <Button type="button" style="border-radius:8%" class="flex flex-column md:flex-row md:justify-content-between row-gap-3 mr-3" severity="help" label="Export" @click="exportCSV($event)" />
        <Button type="button" class="flex flex-column md:flex-row md:justify-content-between row-gap-3 mr-3" style="background:teal;border-radius:8%" data-bs-toggle="modal"  data-bs-target="#createModal">
          Add New User
        </button>

        <p style="display: flex" class=" ml-auto mr-3 mt-2 text-black">
          Search:
        </p>
        <span>
          <InputText class="flex justify-content-end ml-2" v-model="filters['global'].value" placeholder="Keyword Search" />
        </span>

      </div>

    </template>

    <Column v-for="col of columns" :key="col.field" :field="col.field" :header="col.header" sortable style="text-align:center" width>
    </Column>

    <Column :exportable="true" style="min-width: 8rem">
      <template #body="slotProps">
        <div style="display:flex">

          <div class="text-center">
            <button data-bs-toggle="modal" data-bs-target="#editNew1" type="button" class="btn user-btn text-white text-center mr-2" style="background-color: #1e88e5" @click="editModal(slotProps.data)">
              <i class="pi pi-eye"></i>
              View
            </button>
            <button data-bs-toggle="modal" data-bs-target="#editNew" type="button" class="btn text-white user-btn mr-2" style="background-color: #43a047" @click="editModal(slotProps.data)">
              <i class="pi pi-user-edit"></i>
              Edit
            </button>
            <button class="btn text-white user-btn" style="background-color: #b71c1c" @click="deleteUser(slotProps.data.id)">
              <i class="pi pi-trash"></i>
              Delete
            </button>

          </div>
        </div>
      </template>
    </Column>

    <template #footer> In total there are {{ users ? users.length : 0 }} Users. </template>

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
    this.loadUsers();
    ProductService.getProductsMini().then((data) => (this.users = data));
  },
  data(){
    return{
      filters: {
        global: {
          value: null,
          matchMode: FilterMatchMode.CONTAINS,
        },
      },
      users: [],
      searchValue: "",
      totalUsers: 0,
      columns: [{
          field: "id",
          header: "ID",
          sortable: true,
        },
        
        {
          field: "lastname",
          header: "Lastname",
          sortable: true,
        },
        {
          field: "email",
          header: "Email",
          sortable: true,
        },
        {
          field: "user_type",
          header: "User Type",
          sortable: true,
        }
      ],
      sortDesc: false,
    }
  },
  methods: {
    exportCSV() {
      this.$refs.dt.exportCSV();
    },
    loadUsers() {
      axios.get("api/fetch-users").then((data) => {
        this.users = data;
      });
    },
  }

}
</script>

<style>

</style>
