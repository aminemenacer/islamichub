<template>
<div>
  <h2 class="pt-3 text-center"><strong>Bookmark Management</strong></h2>

  <!-- view new Modal -->
  <div class="modal fade" id="editNewBookmark" tabindex="-1" aria-labelledby="editNew" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="addNew">
            View message
          </h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Id:</label>
              <p class="mt-2 text-dark">
                {{ form.id }}
              </p>
            </div>

            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Ayah verse:</label>
              <p class="mt-2 text-dark">
                {{ form.test_field }}
              </p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <DataTable class="pt-5" v-model:filters="filters" showGridlines stripedRows sortable filterDisplay="row" :value="bookmarks" paginator :rows="7" :rowsPerPageOptions="[5, 10, 20, 50]" removableSort width="100%" tableStyle="max-width:100%">
    <template #header>
      <div class="flex justify-content-start" style="display: flex;">

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
          <Button data-bs-toggle="modal" data-bs-target="#editNewBookmark" type="button" class="btn user-btn text-white text-center mr-2 action btn1" style="background-color: #1e88e5; display:flex;display:inline-block" @click="editModal(slotProps.data)">
            <i class="bi bi-eye-fill mr-2"></i>
            View Verse
          </Button>
          <button class="btn text-white user-btn" style="background-color: #b71c1c" @click="deleteBookmark(slotProps.data.id)">
              <i class="bi bi-trash-fill"></i>
              Delete Verse
            </button>
        </div>
      </template>
    </Column>

    <template class="text-center" #footer> In total there are {{ bookmarks ? bookmarks.length : 0 }} Bookmarks. </template>

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
    this.loadBookmark();
  },
  data() {
    return {
      filters: {
        global: {
          value: null,
          matchMode: FilterMatchMode.CONTAINS,
        },
      },
      bookmarks: [],
      columns: [{
          field: "id",
          header: "ID",
          sortable: true,
        }, 
        {
          field: "test_field",
          header: "Ayah text",
          sortable: true,
        },
        {
          field:"",
          header:"Actions",
          sortable:true
        }
        
      ],
      sortDesc: false,
      form: new Form({
        id: "",
        test_field: "",
        created_at: "",
      }),
    }
  },
  methods: {
    loadBookmark() {
      axios.get("api/fetch-bookmarks").then((data) => {
        this.bookmarks = data.data;
      });
    },
    deleteBookmark(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete bookmark!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete("api/delete-bookmarks/" + id);
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Bookmark deleted successfully ",
            showConfirmButton: false,
            timer: 1500,
          });
          this.loadBookmark();
          self.close();
        }
      });
    },
    viewModal(bookmarks) {
      this.form.reset();
      $("#view").modal("show");
      this.form.fill(bookmarks);
    },
    //edit user modal
    editModal(bookmarks) {
      this.editmode = true;
      this.form.reset();
      this.form.fill(bookmarks);
    },
   
  },
}
</script>

<style>

</style>
