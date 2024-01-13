<template>
<div id="app">
  <!--
    <h2 class="pt-3 text-center"><strong>The Holy Quran</strong></h2>
  -->
  <div class="container-fluid text-center pt-3">

    <!-- multiple input sections -->
    <div class="row  text-center">
      <div class="col-md-12 text-center" style="padding-top:10px; box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;">
        <div class="row">

          <div class="col-md-6 mb-2" style="display:flex;text-align:center">

            <label class="pt-2 pl-3 pr-2" style="display:flex">Surah:</label>
            <form class="col-md-5">
              <select class="form-control" v-model='surah' @change='getAyahs()'>
                <option value="0"><span>Select Surah</span></option>
                <option v-for='data in surahs' :key="data.id" :value='data.id'>{{ data.name_en }}, {{ data.name_ar }}</option>
              </select>
            </form>
            <label class="pt-2 pl-3 pr-2">Ayah:</label>

            <form class="col-md-8 ">
              <select class='form-control' v-model='ayah_id' @change='getTafseers()'>
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
      <div class="card" style="display:flex;border:5px solid #c3e6cb;padding:10px; border-radius:10px;">
        <div class="card-header ">
          <ul class="nav nav-tabs text-left justify-content-center" role="tablist" v-if="information != null">
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

          </ul>
          <!--
            <div data-bs-toggle="modal" style="cursor:pointer; float:right" data-bs-target="#staticBackdrop" v-if="information != null" class="fas fa-fw fa-info-circle fa-lg mt-3 mr-1"></div>
            <div data-bs-toggle="modal" style="cursor:pointer; float:right" data-bs-target="#staticBackdropbug" v-if="information != null" class="fas fa-fw fa-bug mt-3 fa-lg mt-2 "></div>
          -->

          <div class="mt-2" v-if="information != null">
            <ul class="ul-main">
              <img src="/images/art1.png" style="width:27px" class="mb-1 mr-2" />
              <li class="li-main mr-3"><span class="span-main">{{information.ayah.surah_id}} ; {{information.ayah.ayah_id}}</span></li>
            </ul>
          </div>
        </div>

        <!-- instructions 
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content ">
              <div class="modal-header">
                <h4 class="modal-title fs-5 text-dark" id="staticBackdropLabel">Information</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div class="row">
                  <div class="col-md-6">
                    <li class="list-group-item list-group-item mb-2" style="border:2px solid #c3e6cb;">
                      <b>1) Select from the Juz dropdown:</b><br>
                      <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                      <img class="mt-2" style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;" src="/images/1.png" width="70%" />
                    </li>
                  </div>
                  <div class="col-md-6">
                    <li class="list-group-item list-group-item mb-2" style="border:2px solid #c3e6cb;">
                      <b>2) Select from the Surah dropdown:</b><br>
                      <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                      <img class="mt-2" style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;" src="/images/2.png" width="90%" />
                    </li>
                  </div>
                  <div class="col-md-6">
                    <li class="list-group-item list-group-item mb-2" style="border:2px solid #c3e6cb;"><b>3) Select from the Ayah dropdown:</b><br>
                      <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                      <img class="mt-2" style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;" src="/images/3.png" width="90%" />
                    </li>
                  </div>
                  <div class="col-md-6">
                    <li class="list-group-item list-group-item mb-2" style="border:2px solid #c3e6cb;"><b>4) Select from different Masahif:</b><br>
                      <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                      <img class="mt-2" style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;" src="/images/5.png" width="90%" />
                    </li>
                  </div>
                  <div class="col-md-12">
                    <li class="list-group-item list-group-item mb-2" style="border:2px solid #c3e6cb;"><b>5) Switch between tabs below:</b><br>
                      <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                      <img class="mt-2" style="box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;" src="/images/4.png" width="90%" />
                    </li>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
       
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
                <form @reset="reset">
                  <h6 class="modal-title ml-2" id="exampleModalLabel"><b>Type of correction:</b></h6><br>

                  <div class=" ml-2 row">
                    <div class="col-3">
                      <div class="form-check">
                        <input class="form-check-input" name="spelling_mistakes" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Spelling mistakes
                        </label>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-check">
                        <input class="form-check-input" name="incomplete_text" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Incomplete text
                        </label>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-check">
                        <input class="form-check-input" name="translation_error" type="checkbox" value="" id="flexCheckChecked">
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
                        <input class="form-check-input" name="narrator" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Error in transliteration
                        </label>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-check">
                        <input class="form-check-input" name="hadith_english" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Error in overview
                        </label>
                      </div>
                    </div>

                  </div>
                  <div class="row ml-2 pt-3 pb-5">
                    <label for="exampleFormControlTextarea1" name="added_notes mt-3" class="form-label">Additional comments:</label>
                    <textarea class="form-control col-md-10 ml-2" id="exampleFormControlTextarea1" rows="5"></textarea>
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
        -->

        <div class="card-body">
          <!-- Tab panes -->
          <div class="tab-content text-center">

            <div class="tab-pane active" id="home" role="tabpanel" v-if="information == null">
              <div class="row">
                <div class="col-md-6">
                  <img src="/images/calligraphy.png" class="pl-3 " style="width:70%;">
                </div>
                <div class="col-md-6">
                  <h2 class="font-weight-bold mb-3 mt-3 text-center">The Holy Quran</h2>
                  <span class="container text-left mb-4" style="line-height:1.5em">The Quran, considered the holy scripture of Islam, is a sacred and comprehensive compilation of revelations believed by Muslims to have been conveyed to the Prophet Muhammad by the archangel Gabriel from around 610 CE to 632 CE. </span>
                  <!--<br><a href="#" class="myButton mt-3">Get started</a>-->
                </div>
              </div>
            </div>

            <!-- translation -->
            <div class="tab-pane active" id="home" role="tabpanel" v-if="information != null">
              <div class="row">
                <div class="col-12">
                  <div class="btn">
                    <h4 class="container text-right" style="line-height: 2.0em;">{{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})</h4>
                  </div>
                 
                  <hr class="container">
                  <div class="btn">

                    <h4 class="container text-left" style="line-height: 1.6em;">{{ information.translation }}"</h4>
                  </div>
                </div>
              </div>
            </div>

            <!-- tafseer -->
            <div class="tab-pane" id="profile" role="tabpanel" v-if="information != null">
              <div class="btn">
                <h3 class="container text-right" style="line-height: 2.0em;">{{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})</h3>
              </div>
              <hr class="container">
              <div class="btn">
                <h3 class="container text-left" style="line-height: 1.6em;">{{ tafseer }}</h3>
              </div>
            </div>

            <!-- transliteration -->
            <div class="tab-pane" id="messages" role="tabpanel" v-if="information != null">
              <div class="btn">
                <h3 class="container text-right" style="line-height: 2.0em;">{{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})</h3>
              </div>
              <hr class="container">
              <div class="btn">
                <h3 class="container text-left" style="line-height: 1.6em;">{{ information.transliteration }}</h3>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

    <!-- right section change -->

    <div class="col-4 row" style="" v-if="information != null">
      <div class="ml-2 col-md-12 card bg-light row" style="display:flex;border:5px solid #c3e6cb;padding:8px;">
        <form style="display:flex">

          <select class="form-control col-5">
            <label class="pt-2  col-3">Mushaf:</label>
            <option value="0">Select Mushaf</option>
            <option></option>
          </select>
          <div class="col-1"></div>
          <select class="form-control col-6">
            <label class="pt-2 col-3">Reciter:</label>
            <option value="0">Select Reciter</option>
            <option></option>
          </select>

        </form>
      </div>
      <img src="/images/quran_img.png" class="pl-3" style="width:100%;">
    </div>

    <div class="col-4 row" v-if="information == null">
      <div class="ml-2 col-md-12 card bg-light row" style="display:flex;border:5px solid #c3e6cb;padding:8px;">
        <form style="display:flex">

          <div class="col-12 text-center">
            <h4 class="font-weight-bold mt-3 text-center">The Holy Quran</h4>
            <img src="/images/calligraphy.png" class=" pl-3 pb-1" style="width:70%;">
            <!-- <p class="container">The Quran, considered the holy scripture of Islam, is a sacred and comprehensive compilation of revelations believed by Muslims to have been conveyed to the Prophet Muhammad by the archangel Gabriel from around 610 CE to 632 CE. </p> -->
          </div>

        </form>
      </div>
    </div>

  </div>
</div>
</template>

<script>
export default ({

  mounted() {
    this.getSurahs();
    // this.getAyahs();
  },
  computed: {
    keywords() {
      return this.words.split(' ')
    }
  },

  data() {
    return {
      text: 'The dog is chasing the cat. Or perhaps they\'re just playing?',
      words: 'and or the',
      data: [],
      juz: 0,
      juzs: [],
      surah: 0,
      tafseers: [],
      tafseer: null,
      surahs: [],
      ayah_id: 0,
      ayahs: [],
      page: '',
      pages: [],
      information: null,
      informations: [],

    }
  },
  methods: {

    getSurahs: function () {
      axios.get('/get_surahs', {
        params: {
          id: this.surah
        }
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

    getTafseers: function () {
      axios.get(`/tafseer/${this.ayah_id}/fetch`).then(function (response) {
        this.tafseer = response.data;
      }.bind(this));

      axios.get('/get_informations', {
        params: {
          ayah_id: this.ayah_id
        }
      }).then(function (response) {
        this.information = response.data;
      }.bind(this));
    },

  },
})
</script>

<style scoped>
.myButton {
  background-color: #c3e6cb;
  border-radius: 8px;
  display: inline-block;
  cursor: pointer;
  color: #000;
  font-family: Arial;
  font-size: 18px;
  font-weight: bold;
  padding: 13px 32px;
  text-decoration: none;
}


@media (min-width: 768px) {
  .button-46 {
    font-size: 20px;
    min-width: 200px;
    padding: 14px 16px;
  }
}

p.no-after:after {
  content: none;
}

.btn:hover {
  background-color: #99e0ab81;
  opacity: 2;
}

.ul-main {
  list-style: none;
}

.ul-main .li-main {
  display: inline-block;
  font-size: 12px;
  text-align: center;
}

.ul-main .li-main .span-main {
  font-size: 20px;
  display: block;
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