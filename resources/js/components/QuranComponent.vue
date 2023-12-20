<template>
<div id="app">
  <!---->
  <h2 class="pt-3 text-center"><strong>The Holy Quran</strong></h2>

  <div class="container-fluid text-center pt-3">

    <!-- main section search
        <div class=" text-center col-md-12 pt-3" style="padding:15px; box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;">
          <div class="row ">
            <div class="col-5">
              <form class="d-flex" role="search">
                <label class="pr-2 pt-2">Search:</label>
                <input class="form-control me-2" type="search" placeholder="Search Keyword" aria-label="Search">
              </form>
            </div>
            <div class="col-7">
              <form style="display:flex">
                <label class="pt-2 pr-3">Results:</label>
                <select class="form-control">
                  <option>Select</option>
                  <option>Car</option>
                  <option>Bike</option>
                  <option>Scooter</option>
                  <option>Cycle</option>
                  <option>Horse</option>
                </select>
              </form>
            </div>
          </div>
        </div>
        <hr style="color:black">
    -->

    <!-- multiple input sections -->
    <div class="row  text-center">
      <div class="col-md-8 text-center" style="padding-top:10px; box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px; border-radius:10px; background:transparent;border:3px solid #c3e6cb;">
        <div class="row">

          <div class="card-body">
            <div class="form-group">
              <label>Select surah:</label>
              <select class='form-control' v-model='surah' @change='getAyahs()'>
                <option value='0'>Select surah</option>
                <option v-for='data in surahs' :key="data.id" :value='data.id'>{{ data.name_en }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>Select ayah:</label>
              <select class='form-control' v-model='ayah' @change='getInformations()'>
                <option value='0'>Select ayah</option>
                <option v-for='data in ayahs' :key="data.id" :value='data.id'>{{ data.ayah_id }}, {{ data.ayah_text }}</option>
              </select>
            </div>
          </div>

          <!--
              <div class="col-md-6 " style="display:flex;text-align:center">
                <label class="pt-2 pl-3 pr-2" style="display:flex">Surah:</label>
                <form class="col-md-6">
                  <select class="form-control" v-model="surah">
                    <option value="0"><span>Select Surah</span></option>
                    <option v-for="surah in surahs" :key="surah.id" :value="surah.id">{{ surah.name_en }}</option>
                  </select>
                </form>
                <label class="pt-2 pl-3 pr-2">Ayah:</label>
                <form class="col-md-6">
                  <select class="form-control " v-model="ayah">
                    <option value="0">Select Ayah</option>
                    <option v-for="ayah in ayahs" :key="ayah.id" :value="ayah.id">{{ ayah.ayah_id }}</option>
                  </select>
                </form>

                <label class="pt-2 pl-3 pr-2">Juz:</label>
                <form class="col-md-6">
                  <select class="form-control" v-model="ayah">
                    <option value="0">Select Juz</option>
                    <option v-for="ayah in ayahs" :key="ayah.id" :value="ayah.id">{{ ayah.ayah_id }}</option>
                  </select>
                </form>
              </div>
            -->

        </div>
      </div>

      <div class="ml-3 col-md-3 card bg-light row" style="display:flex;border:3px solid #c3e6cb;padding:8px">

        <form role="search" class="row">
          <label class="col-md-3 pt-2" style="display:flex">Search:</label>
          <input class="form-control col-md-8 pr-2" type="search" placeholder="Search Keyword" aria-label="Search">
        </form>

      </div>
      <!--
          <div class="col" style="display:flex">
            <label class="pt-2 pl-2 pr-2">Mushaf:</label>
            <form class="col-md-8">
              <select class="form-control col-12" v-model="surah" @change="getAyahs()">
                <option value="0">Select Mushaf</option>
                <option v-for="surah in surahs" :key="surah.id" :value="surah.id">{{ surah.name_en }}</option>
              </select>
            </form>
          </div>
          <div class="col" style="display:flex">
            <label class="pt-2 pr-2">Reciter:</label>
            <form class="col-md-8">
              <select class="form-control col-12" v-model="ayah">
                <option value="0">Select Reciter</option>
                <option v-for="ayah in ayahs" :key="ayah.id" :value="ayah.id">{{ ayah.ayah_id }}</option>
              </select>
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
      <div class="card " style="display:flex;border:3px solid lightgrey;padding:10px; border-radius:10px">
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
              <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
                <i class="now-ui-icons ui-2_settings-90"></i> Information
              </a>
            </li>

          </ul>
        </div>
        <div class="card-body">
          <!-- Tab panes -->
          <div class="tab-content text-center">
            <div class="tab-pane active" id="home" role="tabpanel">
              <div v-for='data in ayahs' :key="data.id" :value='data.id'>
                {{ data.ayah_text }}
              </div>
              <hr class="container">
              <div v-for="data in informations" :key="data.id" :value='data.id'>
                {{ data.translation }}
              </div>
            </div>

            <div class="tab-pane" id="profile" role="tabpanel">

              <hr class="container">
              <div v-for="data in informations" :key="data.id" :value='data.id'>
                {{ data.tafseer }}
              </div>
            </div>
            <div class="tab-pane" id="messages" role="tabpanel">
              
              <hr class="container">
              <div v-for="data in informations" :key="data.id" :value='data.id'>
                {{ data.transliteration }}
              </div>
            </div>
            <div class="tab-pane" id="settings" role="tabpanel">
              
            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- right section -->

    <div class="col-4 container-fluid">
      <img src="/images/quran_img.png" style="width:100%; border:4px solid lightgrey;border-radius:10px">
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

    getSurahs: function () {
      axios.get('/get_surahs')
        .then(function (response) {
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
