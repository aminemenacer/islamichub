<template>
<div id="app">
  <h2 class="pt-3 pb-3 text-center"><strong>Surah Information</strong></h2>
  <p class="container text-center">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>


      <!-- view new Modal -->
      <div class="modal fade" id="editNewCard" tabindex="-1" aria-labelledby="editNew" aria-hidden="true">
        <div class="modal-dialog modal-xl">
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
                  <label class="mt-2 mr-2 col-sm-3">Surah:</label>
                  <p class="mt-2 text-dark">
                    {{ form.surah }}
                  </p>
                </div>

                <div class="mr-2" style="display: flex">
                  <label class="mt-2 mr-2 col-sm-3">Her verses:</label>
                  <p class="mt-2 text-dark">
                    {{ form.ayaatiha }}
                  </p>
                </div>

                <div class="mr-2" style="display: flex">
                  <label class="mt-2 mr-2 col-sm-3">Meanings of their names:</label>
                  <p class="mt-2 text-dark">
                    {{ form.maeni_asamuha }}
                  </p>
                </div>

                <div class="mr-2" style="display: flex">
                  <label class="mt-2 mr-2 col-sm-3">The reason for its name:</label>
                  <p class="mt-2 text-dark">
                    {{ form.sabab_tasmiatiha }}
                  </p>
                </div>

                <div class="mr-2" style="display: flex">
                  <label class="mt-2 mr-2 col-sm-3">Their names:</label>
                  <p class="mt-2 text-dark">
                    {{ form.asmawuha }}
                  </p>
                </div>
                
                <div class="mr-2" style="display: flex">
                  <label class="mt-2 mr-2 col-sm-3">Its general purpose:</label>
                  <p class="mt-2 text-dark">
                    {{ form.maqsiduha_aleamu }}
                  </p>
                </div>

                <div class="mr-2" style="display: flex">
                  <label class="mt-2 mr-2 col-sm-3">The reason for its descent:</label>
                  <p class="mt-2 text-dark">
                    {{ form.sabab_nuzuliha }}
                  </p>
                </div>
                
                <div class="mr-2" style="display: flex">
                  <label class="mt-2 mr-2 col-sm-3">Her grace:</label>
                  <p class="mt-2 text-dark">
                    {{ form.fadluha }}
                  </p>
                </div>

                <div class="mr-2" style="display: flex">
                  <label class="mt-2 mr-2 col-sm-3">Its occasions:</label>
                  <p class="mt-2 text-dark">
                    {{ form.munasabatiha }}
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
      
      <DataTable v-model:filters="filters" showGridlines stripedRows sortable filterDisplay="row" :value="cards" ref="dt" class="text-center " width="100%" paginator :rows="7" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
        <template #header>

          <div class="flex justify-content-start" style="display:flex">

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
                <Button data-bs-toggle="modal" data-bs-target="#editNewCard" type="button" class="btn user-btn text-white text-center mr-2 action btn1" style="background-color: #1e88e5; display:flex;display:inline-block" @click="editModal(slotProps.data)">
                  <i class="pi pi-eye mr-2"></i>
                  More info
                </Button>
                <Button  type="submit" class="btn btn-danger user-btn text-white text-center mr-2 action btn1" style=" display:flex;display:inline-block"  @submit.prevent="submitLike()" >
                  <i class="pi pi-eye mr-2"></i>
                  Like
                </Button>

              </div>
            </div>
          </template>
        </Column>

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
    this.loadCards();
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
          field: "surah",
          header: "Name",
          sortable: true,
        },
        // {
        //   field: "ayaatiha",
        //   header: "Her verses",
        //   sortable: true,
        // },
        {
          field: "asmawuha",
          header: "Their names",
          sortable: true,
        },
        {
          field: "sabab_tasmiatiha",
          header: "The reason for its name",
          sortable: true,
        },
        {
          field: "maqsiduha_aleamu",
          header: "Its general purpose",
          sortable: true,
        },
        {
          field: "sabab_nuzuliha",
          header: "The reason for its descent",
          sortable: true,
        },
        // {
        //   field: "fadluha",
        //   header: "Her grace",
        //   sortable: true,
        // },
        // {
        //   field: "munasabatiha",
        //   header: "Its occasions",
        //   sortable: true,
        // },
        // {
        //   field: "munasabatiha",
        //   header: "Meanings of their names",
        //   sortable: true,
        // },

      ],
      cards: null,

      form: new Form({
        id: "",
        surah: "",
        ayaatiha: "",
        maeni_asamuha: "",
        asmawuha: "",
        maqsiduha_aleamu: "",
        sabab_nuzuliha: "",
        sabab_tasmiatiha: "",
        fadluha: "",
        munasabatiha: "",
        audio: "",
        image: "",
        munasabatiha: ""
      }),
    }
  },
  methods: {
    loadCards() {
      axios.get("api/fetch-cards").then((data) => {
        this.cards = data.data;
      });
    },
    submitLike() {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to save item !",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "#d33",
        confirmButtonText: "Save item!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .post("/api/create-likes", this.form)
            .then((res) => {
              if (!res.data.success) {
                Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "Item save successfully ",
                  showConfirmButton: false,
                  timer: 1500,
                });
                $("#addNew").hide();
                self.close();
              } else if (res.data.success) {
                Swal.fire(
                  "Error!",
                  "Unable to save item.",
                  "error"
                );
                self.close();
              }
            })
            .catch(function (err) {});
        }
      });
    },

    //edit donation modal
    editModal(card) {
      this.editmode = true;
      this.form.fill(card);
    },
    viewModal(card) {
      $("#view").modal("show");
      this.form.fill(card);
    },
  }
}
</script>
