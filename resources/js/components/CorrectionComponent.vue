<template>
<div>
  <h2 class="pt-3 text-center"><strong>Correction Management</strong></h2>

  <!-- view new Modal -->
  <div class="modal fade" id="editNewCorrection" tabindex="-1" aria-labelledby="editNew" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="addNew">
            View correction data 
          </h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">ID:</label>
              <p class="mt-2 text-dark">
                {{ form.id }}
              </p>
            </div>
            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Spelling mistakes:</label>
              <p class="mt-2 text-dark">
                {{ form.spelling_mistakes }}
              </p>
            </div>

            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Incomplete Text:</label>
              <p class="mt-2 text-dark">
                {{ form.incomplete_text }}
              </p>
            </div>

            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Translation Error:</label>
              <p class="mt-2 text-dark">
                {{ form.translation_error }}
              </p>
            </div>

            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Reference Error:</label>
              <p class="mt-2 text-dark">
                {{ form.reference_error }}
              </p>
            </div>

            <div class="mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Added Notes:</label>
              <p class="mt-2 text-dark">
                {{ form.added_notes }}
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

  <DataTable class="pt-5" v-model:filters="filters" showGridlines stripedRows sortable filterDisplay="row" :value="corrections" paginator :rows="7" :rowsPerPageOptions="[5, 10, 20, 50]" removableSort width="100%" tableStyle="max-width:100%">
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
          <Button data-bs-toggle="modal" data-bs-target="#editNewCorrection" type="button" class="btn user-btn text-white text-center mr-2 action btn1" style="background-color: #1e88e5; display:flex;display:inline-block" @click="editModal(slotProps.data)">
            <i class="pi pi-eye mr-2"></i>
            View
          </Button>
        </div>
      </template>
    </Column>

    <template class="text-center" #footer> In total there are {{ corrections ? corrections.length : 0 }} corrections. </template>

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
    this.loadCorrections();
  },
  data() {
    return {
      filters: {
        global: {
          value: null,
          matchMode: FilterMatchMode.CONTAINS,
        },
      },
      corrections: null,
      columns: [{
          field: "id",
          header: "ID",
          sortable: true,
        }, {
          field: "spelling_mistakes",
          header: "Spelling mistakes",
          sortable: true,
        },
        {
          field: "incomplete_text",
          header: "Incomplete text",
          sortable: true,
        },
        {
          field: "translation_error",
          header: "Translation error",
          sortable: true,
        },
        {
          field: "reference_error",
          header: "Reference Error",
          sortable: true,
        },
        // {
        //   field: "added_notes",
        //   header: "Added notes",
        //   sortable: true,
        // },

      ],
      sortDesc: false,
      form: new Form({
        id: "",
        spelling_mistakes: "",
        incomplete_text: "",
        translation_error: "",
        reference_error: "",
        added_notes: "",
      }),
    }
  },
  methods: {
    loadCorrections() {
      axios.get("api/fetch-corrections").then((data) => {
        this.corrections = data.data;
      });
    },
    viewModal(corrections) {
      this.form.reset();
      $("#view").modal("show");
      this.form.fill(corrections);
    },
    //edit user modal
    editModal(corrections) {
      this.editmode = true;
      this.form.reset();
      this.form.fill(corrections);
    },

  },
}
</script>

<style>

</style>
