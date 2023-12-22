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
            <label class="pt-2 pl-3 pr-2">Juz:</label>
            <form class="col-md-5">
              <select class="form-control" v-model="juz" @change='getSurahs()'>
                <option value="0">Select Juz</option>
                <option v-for='data in juzs' :key="data.id" :value='data.id'>{{ data.juz_number }}</option>
              </select>
            </form>
            <label class="pt-2 pl-3 pr-2" style="display:flex">Surah:</label>
            <form class="col-md-7">
              <select class="form-control" v-model='surah' @change='getAyahs()'>
                <option value="0"><span>Select Surah</span></option>
                <option v-for='data in surahs' :key="data.id" :value='data.id'>{{ data.name_en }}, {{ data.name_ar }}</option>
              </select>
            </form>
            <label class="pt-2 pl-3 pr-2">Ayah:</label>
            <form class="col-md-8">
              <select class='form-control' v-model='ayah' @change='getInformations()'>
                <option value="0">Select Ayah</option>
                <option v-for='data in ayahs' :key="data.id" :value='data.id'>{{ data.ayah_id }}, {{ data.ayah_text }}</option>
              </select>
            </form>

          </div>

        </div>
      </div>
      <!--
        <div class="ml-3 col-md-3 card bg-light row" style="display:flex;border:3px solid #c3e6cb;padding:8px">
          <form role="search" class="row">
            <label class="col-md-3 pt-2" style="display:flex">Search:</label>
            <input class="form-control col-md-8 pr-2" type="search" placeholder="Search Keyword" aria-label="Search">
          </form>
        </div>
      -->

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
            
            <div data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="fas fa-fw fa-info-circle fa-lg mt-2 ml-5"></div>
            
          </ul>
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

        <div class="card-body">
          <!-- Tab panes -->
          <div class="tab-content text-center">
            <div class="tab-pane active " id="home" role="tabpanel">

              <!-- audio player 
                <div class="row container-fluid" style="display:flex; border-radius:10px">
                  <div class="col-md-6 " style="display:flex">
                    <label class="pt-2 pr-2">Reciter:</label>
                    <form class="col-md-8">
                      <select class="form-control col-12" v-model="ayah">
                        <option value="0">Select Reciter</option>
                        <option v-for="ayah in ayahs" :key="ayah.id" :value="ayah.id">{{ ayah.ayah_id }}</option>
                      </select>
                    </form>
                  </div>
                  <div class="col-md-6" style="display:flex">
                    <audio controls>
                      <source src="horse.ogg" type="audio/ogg">
                      <source src="horse.mp3" type="audio/mpeg">
                      Your browser does not support the audio element.
                    </audio>
                  </div>
                </div>
              -->

              <hr class="container">
              <div v-for="data in informations" :key="data.id" :value='data.id'>
                <img src="/images/1_5.png" width="100px" />
                {{ data.translation }}
              </div>
            </div>

            <div class="tab-pane" id="profile" role="tabpanel">
              <div>
                <img src="/images/1_5.png" width="100%" />
              </div>
              <hr class="container">
              <div v-for="data in informations" :key="data.id" :value='data.id'>
                {{ data.tafseer }}
              </div>
            </div>
            <div class="tab-pane" id="messages" role="tabpanel">
              <div>
                <img src="/images/1_5.png" width="100%" />
              </div>
              <hr class="container">
              <div v-for="data in informations" :key="data.id" :value='data.id'>
                {{ data.transliteration }}
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
          <select class="form-control col-12" style="display:flex" v-model="ayah">
            <label class="pt-2 pr-2 col-3">Mushaf:</label>
            <option value="0">Select Mushaf</option>
            <option>{{ ayah.ayah_id }}</option>
          </select>
        </form>

      </div>
      <img src="/images/quran_img.png" class="pl-3" style="width:100%;">
    </div>
  </div>
</div>
</template>

<script>
export default {
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
        .then(function (response) {}.bind(this));
    },

    getSurahs: function () {
      axios.get('/get_surahs', {
        params: {
          juz_id: this.juz
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
}
</script>

<style>
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
