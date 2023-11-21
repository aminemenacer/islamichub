<template>
<div id="app">

  <h2 class="pt-3 text-center"><strong>Ahadith Al-Qudsi</strong></h2>
  <p class="container text-center">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
  

  <!-- correction modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="exampleModalLabel"><b>Corrections</b></h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @reset="reset" @submit.prevent="submitCorrection()">
            <h6 class="modal-title " id="exampleModalLabel"><b>Type of correction:</b></h6><br>

            <div class="row">
              <div class="col-3">
                <div class="form-check">
                  <input class="form-check-input" name="spelling_mistakes" v-model="form.spelling_mistakes" type="checkbox" value="" id="flexCheckChecked">
                  <label class="form-check-label" for="flexCheckChecked">
                    Spelling mistakes
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check">
                  <input class="form-check-input" name="incomplete_text" v-model="form.incomplete_text" type="checkbox" value="" id="flexCheckChecked">
                  <label class="form-check-label" for="flexCheckChecked">
                    Incomplete text
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check">
                  <input class="form-check-input" name="translation_error" v-model="form.translation_error" type="checkbox" value="" id="flexCheckChecked">
                  <label class="form-check-label" for="flexCheckChecked">
                    Error in translation
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check">
                  <input class="form-check-input" name="reference_error" v-model="form.reference_error" type="checkbox" value="" id="flexCheckChecked">
                  <label class="form-check-label" for="flexCheckChecked">
                    Reference Error
                  </label>
                </div>
              </div>
            </div>
            <div class="row mt-3 mb-3">
              <div class="col-3">
                <div class="form-check">
                  <input class="form-check-input" name="narrator" v-model="form.narrator" type="checkbox" value="" id="flexCheckChecked">
                  <label class="form-check-label" for="flexCheckChecked">
                    Narrator
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check">
                  <input class="form-check-input" name="hadith_english" v-model="form.hadith_english" type="checkbox" value="" id="flexCheckChecked">
                  <label class="form-check-label" for="flexCheckChecked">
                    Hadith English
                  </label>
                </div>
              </div>
              <div class="col-3 mb-3 ml-3">
                <div class="form-check">
                  <input class="form-check-input" name="hadith_arabic" v-model="form.hadith_arabic" type="checkbox" value="" id="flexCheckChecked">
                  <label class="form-check-label ml-3" for="flexCheckChecked">
                    Hadith Arabic
                  </label>
                </div>
              </div>
              <div class="col-3">
                
              </div>

            </div>
            <div class="row pt-3">
              <label for="exampleFormControlTextarea1" name="added_notes mt-3" class="form-label">Additional comments:</label>
              <textarea class="form-control col-md-10" v-model="form.added_notes" id="exampleFormControlTextarea1" rows="5"></textarea>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Submit changes</button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
  
  <div class="row py-3">
    <div class="col-lg-12 mx-auto">
      <button type="button" class="btn text-white mr-2 " style="background:brown; float:right" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Correction
      </button>
      <div class="container-fluid table-responsive container-fluid" v-for="item in hadith" :key="item.id">
        <table id="example" style="width:100%" class="table table-striped table-responsive table-bordered custom-class"><b class="pb-2">Reference: {{ item.reference }}</b>
          <thead class="table-success">
            <tr class="text-center">

              <th>Hadith (English)</th>
              <th>Hadith (Arabic)</th>
              <th>Narrator</th>

            </tr>
          </thead>
          <tbody style="background:white">
            <tr class="text-center">
              <td>{{ item.text }}</td>
              <td>{{ item.arabic }}</td>
              <td>{{ item.narrator }}</td>
            </tr>
          </tbody>

        </table>

      </div>
    </div>          

  </div>
</div>
</template>

<script>
import hadith from '/Users/amine/Desktop/islamichub/storage/three_main/qudsi_book.json';

export default {
  data() {
    return {
      items: [],
      hadith,
      view: [],
      correction: [],
      form: new Form({
        id: "",
        spelling_mistakes: "",
        incomplete_text: "",
        translation_error: "",
        added_notes: "",
        reference_error: "",
        narrator: "",
        hadith_english: "",
        hadith_arabic: ""

      }),
    }
  },
  methods:{
    submitCorrection() {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to submit your correction !",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "#d33",
        confirmButtonText: "Submit Correction",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .post("/api/submit-correction", this.form)
            .then((res) => {
              if (!res.data.success) {
                Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "Correction has been submitted",
                  showConfirmButton: false,
                  timer: 1500,
                });
                window.location.reload();
                $("#addNew").hide();
                self.close();
              } else if (res.data.success) {
                Swal.fire(
                  "Error!",
                  "Unable to submit your correction.",
                  "error"
                );
                self.close();
              }
            })
            .catch(function (err) {});
        }
      });
    },
  }

}
</script>

<style>

</style>
