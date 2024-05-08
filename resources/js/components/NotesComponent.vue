<template>
<div>
  <h2 class="pt-3 text-center"><strong>Notes Management</strong></h2>

  <!-- view new Modal -->
  <div class="modal fade" id="editNewCorrection" tabindex="-1" aria-labelledby="editNew" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="addNew">
            View notes data 
          </h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form1>
            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">ID:</label>
              <p class="mt-2 text-dark">
                {{ form1.id }}
              </p>
            </div>
            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Surah name:</label>
              <p class="mt-2 text-dark">
                {{ form1.surah_name }}
              </p>
            </div>

            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Ayah number:</label>
              <p class="mt-2 text-dark">
                {{ form1.ayah_num }}
              </p>
            </div>

            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Ayah verse:</label>
              <p class="mt-2 text-dark">
                {{ form1.ayah_text }}
              </p>
            </div>

            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Notes:</label>
              <p class="mt-2 text-dark">
                {{ form1.ayah_notes }}
              </p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
              </button>
            </div>
          </form1>
        </div>
      </div>
    </div>
  </div>

  <DataTable class="pt-5" v-model:filters="filters" showGridlines stripedRows sortable filterDisplay="row" :value="notes" paginator :rows="7" :rowsPerPageOptions="[5, 10, 20, 50]" removableSort width="100%" tableStyle="max-width:100%">
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

    <Column v-for="col of columns" :key="col.field" :field="col.field" :header="col.header" sortable class="text-left truncate" style="align-items:center" width>
    </Column>

    <Column :exportable="true" style="min-width: 8rem">
      <template #body="slotProps">
        <div class="wrapper text-center" style="display:flex">
          <Button data-bs-toggle="modal" data-bs-target="#editNewCorrection" type="button" class="btn user-btn text-white text-center mr-2 action btn1" style="background-color: #1e88e5; display:flex;display:inline-block" @click="editModal(slotProps.data)">
            <i class="pi pi-eye mr-2"></i>
            View
          </Button>
          <button class="btn text-white user-btn" style="background-color: #b71c1c" @click="deleteNote(slotProps.data.id)">
            <i class="pi pi-trash"></i>
            Delete
          </button>
        </div>
      </template>
    </Column>

    <template class="text-center" #footer> In total there are {{ notes ? notes.length : 0 }} notes. </template>

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
    this.loadNotes();
  },
  data() {
    return {
      filters: {
        global: {
          value: null,
          matchMode: FilterMatchMode.CONTAINS,
        },
      },
      notes: null,
      columns: [{
          field: "id",
          header: "ID",
          sortable: true,
        }, {
          field: "surah_name",
          header: "Surah name",
          sortable: true,
        },
        {
          field: "ayah_num",
          header: "Ayah number",
          sortable: true,
        },
        {
          field: "ayah_text",
          header: "Verse",
          sortable: true,
        },
        {
          field: "ayah_notes",
          header: "Notes",
          sortable: true,
        },
       
      ],
      sortDesc: false,
      form1: new Form({
        id: "",
        surah_name: "",
        ayah_num: "",
        ayah_text: "",
        ayah_notes: "",
      }),
      maxLength: 70, // Set your desired max length
    }
  },
  computed: {
    truncatedText() {
      if (!this.form.ayah_text) return '';
      return this.form.ayah_text.length > this.maxLength
        ? this.form.ayah_text.substring(0, this.maxLength) + '...' // Append ellipsis
        : this.form.ayah_text;

        if (!this.form.ayah_notes) return '';
      return this.form.ayah_notes.length > this.maxLength
        ? this.form.ayah_notes.substring(0, this.maxLength) + '...' // Append ellipsis
        : this.form.ayah_notes;
    },
  },
  methods: {
    loadNotes() {
      axios.get("api/fetch-notes").then((data) => {
        this.notes = data.data;
      });
    },
    deleteNote(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete note!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete("api/delete-notes/" + id);
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Note deleted successfully ",
            showConfirmButton: false,
            timer: 1500,
          });
          this.loadNotes();
          self.close();
        }
      });
    },
    viewModal(notes) {
      this.form1.reset();
      $("#view").modal("show");
      this.form1.fill(notes);
    },
    //edit user modal
    editModal(notes) {
      this.editmode = true;
      this.form1.reset();
      this.form1.fill(notes);
    },

  },
}
</script>

<style>

</style>
