<template>
<div id="app">
  <!---->
  <h2 class="pt-3 text-center"><strong>The Holy Quran</strong></h2>

  <div class="container-fluid text-center pt-3">

    <!-- multiple input sections -->
    <div class="row  text-center">
      <div class="col-md-12 text-center" style="padding-top:10px; box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;">
        <div class="row">

          <div class="col-md-6 mb-2" style="display:flex;text-align:center">
            <!--
              <label class="pt-2 pl-3 pr-2">Juz:</label>
              <form class="col-md-5">
                <select class="form-control" v-model="juz" >
                  <option value="0">Select Juz</option>
                  <option v-for='data in juzs' :key="data.id" :value='data.id'>{{ data.juz_number }}</option>
                </select>
              </form>
            -->

            <label class="pt-2 pl-3 pr-2" style="display:flex">Surah:</label>
            <form class="col-md-5">
              <select class="form-control" v-model='surah' @change='getAyahs()'>
                <option value="0"><span>Select Surah</span></option>
                <option v-for='data in surahs' :key="data.id" :value='data.id'>{{ data.name_en }}, {{ data.name_ar }}</option>
              </select>
            </form>
            <label class="pt-2 pl-3 pr-2">Ayah:</label>
            <form class="col-md-8 ">
              <select class='form-control' v-model='ayah' @change='getInformations()'>
                <option value="0">Select Ayah</option>
                <option v-for='data in ayahs' :key="data.id" :value='data.id'>{{ data.ayah_id }}, {{ data.ayah_text }}</option>
              </select>
            </form>

            <form class="ml-3 col-md-8 ">
              <input class="form-control input is-primary" type="text" placeholder="Search keyword" />
            </form>
          </div>
        </div>
      </div>
      <Highlighter class="my-highlight" :style="{ color: 'yellow' }" highlightClassName="highlight" :searchWords="keywords" :autoEscape="true" :textToHighlight="text" />

    </div>
  </div>

  <div class="container-fluid mt-4">
    <div class="row">

    </div>
  </div>


  <!-- accordion headers-->
  <div class="row container-fluid">

    <div class="col-md-8">
      <!-- Nav tabs -->
      <div class="card " style="display:flex;border:1px solid lightgrey;padding:10px; border-radius:10px">
        <div class="card-header ">
          <ul class="nav nav-tabs text-left justify-content-center" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                <i class="now-ui-icons objects_umbrella-13"></i> Translation
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                <i class="now-ui-icons shopping_cart-simple"></i> Tafseer
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                <i class="now-ui-icons shopping_shop"></i> Transliteration
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#videos" role="tab">
                <i class="now-ui-icons shopping_shop"></i> Overview
              </a>
            </li>

          </ul>
          <div data-bs-toggle="modal" style="cursor:pointer; float:right" data-bs-target="#staticBackdrop" class="fas fa-fw fa-info-circle fa-lg mt-3 mr-1"></div>
          <div data-bs-toggle="modal" style="cursor:pointer; float:right" data-bs-target="#staticBackdropbug" class="fas fa-fw fa-bug mt-3 fa-lg mt-2 "></div>
          <div class="mt-2 font-weight-bold" v-for="data in informations" :key="data.id" :value='data.id'>Ayah: {{data.ayah_id}}</div>
        </div>

        <!-- instructions -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content ">
              <div class="modal-header">
                <h4 class="modal-title fs-5 text-dark" id="staticBackdropLabel">Information</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <ul class="list-group ">
                  <li class="list-group-item list-group-item mb-2" style="border:2px solid #c3e6cb;">
                    <b>1) Select from the Juz dropdown:</b><br>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                    <img class="mt-2" style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;" src="/images/1.png" width="50%" />
                  </li>
                  <li class="list-group-item list-group-item mb-2" style="border:2px solid #c3e6cb;">
                    <b>2) Select from the Surah dropdown:</b><br>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                    <img class="mt-2" style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;" src="/images/2.png" width="60%" />
                  </li>
                  <li class="list-group-item list-group-item mb-2" style="border:2px solid #c3e6cb;"><b>3) Select from the Ayah dropdown:</b><br>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                    <img class="mt-2" style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;" src="/images/3.png" width="60%" />
                  </li>
                  <li class="list-group-item list-group-item mb-2" style="border:2px solid #c3e6cb;"><b>4) Select from different Masahif:</b><br>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                    <img class="mt-2" style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;" src="/images/5.png" width="60%" />
                  </li>
                  <li class="list-group-item list-group-item mb-2" style="border:2px solid #c3e6cb;"><b>5) Switch between tabs below:</b><br>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                    <img class="mt-2" style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;" src="/images/4.png" width="70%" />
                  </li>

                </ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- report a bug -->
        <div class="modal fade" id="staticBackdropbug" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content ">
              <div class="modal-header">
                <h4 class="modal-title fs-5 text-dark" id="staticBackdropLabel">Report an Error</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form @reset="reset" >
                  <h6 class="modal-title ml-2" id="exampleModalLabel"><b>Type of correction:</b></h6><br>

                  <div class=" ml-2 row">
                    <div class="col-3">
                      <div class="form-check">
                        <input class="form-check-input" name="spelling_mistakes"  type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Spelling mistakes
                        </label>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-check">
                        <input class="form-check-input" name="incomplete_text"  type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Incomplete text
                        </label>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-check">
                        <input class="form-check-input" name="translation_error"  type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Error in translation
                        </label>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-check">
                        <input class="form-check-input" name="reference_error" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Error in tafseer
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3 mb-3">
                    <div class="col-3 ml-3">
                      <div class="form-check">
                        <input class="form-check-input" name="narrator"  type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Error in transliteration
                        </label>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-check">
                        <input class="form-check-input" name="hadith_english"  type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Error in overview
                        </label>
                      </div>
                    </div>

                  </div>
                  <div class="row ml-2 pt-3 pb-5">
                    <label for="exampleFormControlTextarea1" name="added_notes mt-3" class="form-label">Additional comments:</label>
                    <textarea class="form-control col-md-10 ml-2"  id="exampleFormControlTextarea1" rows="5"></textarea>
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

        <div class="card-body">
          <!-- Tab panes -->
          <div class="tab-content text-center">

            <!-- translation -->
            <div class="tab-pane active" id="home" role="tabpanel">
              <div class="row">
                <div class="col-12">
                  <img src="/images/2_19.png" class="pl-3" style="width:100%;">
                  <hr class="container">
                  <div v-for="data in informations" :key="data.id" :value='data.id'>
                    <h3 class="container text-left">"{{ data.translation }}"</h3>
                  </div>
                </div>
              </div>
            </div>

            <!-- tafseer -->
            <div class="tab-pane" id="profile" role="tabpanel">
              <img src="/images/2_19.png" class="pl-3" style="width:100%;">
              <hr class="container">
              <div v-for="data in informations" :key="data.id" :value='data.id'>
                {{ data.tafseer }}
              </div>
            </div>

            <!-- transliteration -->
            <div class="tab-pane" id="messages" role="tabpanel">
              <img src="/images/2_19.png" class="pl-3" style="width:100%;">
              <hr class="container">
              <div v-for="data in informations" :key="data.id" :value='data.id'>
                <h3 class="container text-left">{{ data.transliteration }}</h3>
              </div>
            </div>

            <!-- video -->
            <div class="tab-pane" id="videos" role="tabpanel">
              <div class="row">
                <div class="col-md-12 text-left">
                  <h3 class="mb-2 text-center font-weight-bold">Overview</h3>
                  <p>Surah Al-Fatiha, the opening chapter of the Quran, holds immense spiritual significance in Islam, encapsulating fundamental aspects of faith and worship. It begins with praise and glorification of Allah, acknowledging His mercy and sovereignty over all creation. The chapter then transitions into a supplication for guidance, seeking the straight path of righteousness and truth while recognizing the impending Day of Judgment. Al-Fatiha highlights Allah's attributes and serves as a plea for help in staying on the right path and avoiding deviation. It culminates with a reaffirmation of worship and praise for Allah, solidifying its central role as a comprehensive prayer, recited in every unit of Muslim prayer, reflecting the essence of the entire Quran and guiding believers in their spiritual journey.</p>
                </div>
                <div class="col-md-12 text-center">
                  <iframe width="100%" height="450px" src="https://www.youtube.com/embed/KcJPXUKdKuQ?si=6S30TAR-7Pd346Ed" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- right section -->
    <div class="col-4 row">
      <div class="ml-2 col-md-12 card bg-light row" style="display:flex;border:3px solid #c3e6cb;padding:8px;">
        <form>
          <select class="form-control col-12" style="display:flex">
            <label class="pt-2 pr-2 col-3">Mushaf:</label>
            <option value="0">Select Mushaf</option>
            <option></option>
          </select>
        </form>
      </div>
      <img src="/images/quran_img.png" class="pl-3" style="width:100%;">
    </div>
  </div>
</div>
</template>

<script>
import WordHighlighter from "vue-word-highlighter";
import {
  defineComponent,
  reactive,
  ref,
  computed
} from "vue";

export default ({

  mounted() {
    this.getSurahs();
  },

  data() {
    return {
      data: [],
      juz: 0,
      juzs: [],
      surah: 0,
      surahs: [],
      ayah: 0,
      ayahs: {},
      page: '',
      pages: [],
      information: 0,
      informations: []
    }
  },
  methods: {
    getJuzs: function () {
      axios.get('/get_juzs')
        .then(function (response) {
          this.juzs = response.data;
        }.bind(this));
    },

    getSurahs: function () {
      axios.get('/get_surahs', {
        // params: {
        //   juz_id: this.juz
        // }
      }).then(function (response) {
        this.surahs = response.data;
      }.bind(this));
    },

    getAyahs: function () {
      axios.get('/get_ayahs', {
        params: {
          surah_id: this.surah
        }
      }).then(function (response) {
        this.ayahs = response.data;
      }.bind(this));
    },
    getInformations: function () {
      axios.get('/get_informations', {
        params: {
          ayah_id: this.ayah
        }
      }).then(function (response) {
        this.informations = response.data;
      }.bind(this));
    }

  },
})
</script>

<style>
.navbar {
  position: fixed;

}

.ayah_img:hover {
  background-color: #c3e6cb;
  border-radius: 10px;
  cursor: pointer;
}

.enlarge .ayah {
  transition: transform 0.50s ease;
  float: right;
}

.enlarge:hover {
  -webkit-transform: scale(1.5);
  /* or some other value */
  transform: scale(1.2);
}

button,
input {
  font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
}

.nav-item .nav-link,
.nav-tabs .nav-link {
  -webkit-transition: all 300ms ease 0s;
  -moz-transition: all 300ms ease 0s;
  -o-transition: all 300ms ease 0s;
  -ms-transition: all 300ms ease 0s;
  transition: all 300ms ease 0s;
}

.nav-tabs>.nav-item>.nav-link {
  color: #888888;
  margin: 0;
  margin-right: 5px;
  background-color: transparent;
  border: 1px solid transparent;
  font-size: 14px;
  padding: 11px 23px;
  line-height: 1.5;
}

.nav-tabs>.nav-item>.nav-link:hover {
  background-color: transparent;
}

.nav-tabs>.nav-item>.nav-link.active {
  background-color: #444;
  color: #FFFFFF;
}

.nav-tabs>.nav-item>.nav-link i.now-ui-icons {
  font-size: 14px;
  position: relative;
  top: 1px;
  margin-right: 3px;
}

.nav-tabs.nav-tabs-neutral>.nav-item>.nav-link {
  color: #FFFFFF;
}

.nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active {
  background-color: rgba(255, 255, 255, 0.2);
  color: #FFFFFF;
}
</style>
