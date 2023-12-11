<template>
<div id="app">
<!--
  <h2 class="pt-3 text-center"><strong>The Holy Quran</strong></h2>
-->
  <div class="container-fluid text-center">

    <!-- main section search-->
    <div class="row pt-3">
      <div class="col-7">
        <form class="d-flex" role="search">
          <label class="pr-2 pt-2">Search:</label>
          <input class="form-control me-2" type="search" placeholder="Search Keyword" aria-label="Search">
        </form>
      </div>
      <div class="col-5">
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
    <hr style="color:black">


    

    <!-- multiple input sections -->
    <div class="container-fluid text-center">
      <div class="row">
        <div class="col-md-6" style="display:flex">

          <label class="pt-2 pl-2 pr-2">Surah:</label>

          <form class="col-md-5">
            <select class="form-control" v-model="surah" @change="getAyahs()">
              <option value="0">Select Surah</option>
              <option v-for="surah in surahs" :key="surah.id" :value="surah.id">{{ surah.name_en }}</option>
            </select>
          </form>

          <label class="pt-2 pr-2">Ayah:</label>

          <form class="col-md-5">
            <select class="form-control" v-model="ayah">
              <option value="0">Select Ayah</option>
              <option v-for="ayah in ayahs" :key="ayah.id" :value="ayah.id">{{ ayah.ayah_id }}</option>
            </select>
          </form>
          <!--
            <label class="pt-2 pl-4 pr-3">Page:</label>
            <form class="col-md-3">
              <select class="form-control " v-model="information">
                <option value="0">Select Page</option>
                <option v-for="information in informations" :key="information.id" :value="information.id">{{ information.tafseer }}</option>
              </select>
            </form>
          -->

        </div>

        <div class="col-md-6 pl-5" style="display:flex">
          <label class="pt-2 pl-5 pr-3">Mushaf:</label>
          <form class="col-md-4">
            <select class="form-control ">
              <option>Standard</option>
            </select>
          </form>

          <label class="pt-2 pl-2 pr-3">Reciter:</label>
          <form class="col-md-4">
            <select class="form-control">
              <option>Yacein</option>
            </select>
          </form>
        </div>
      </div>
    </div>
  </div>
  <hr>

  <div class="container-fluid mt-4">
      <div class="row">
        

      </div>
    </div>

  <!-- accordion headers-->
  <div class="row container-fluid">
    <!--
      <div class="col-8 ">
        <Accordion style="border:2px solid lightgrey" :multiple="true" :activeIndex="[0,1,2]">
          <AccordionTab :scrollable="true" style="color:black" header="Translation">
            <p class="text-left  m-0">
              1
            </p>
          </AccordionTab>
          <AccordionTab style="color:black" header="Tafseer">
            <p class="text-left m-0">
              2
            </p>
          </AccordionTab>
          <AccordionTab style="color:black" header="Transliteration">
            <p class="text-left m-0">
              3
            </p>
          </AccordionTab>
        </Accordion>
      </div>
    -->
    <div class="col-md-8">
          <!-- Nav tabs -->
          <div class="card" style="padding:10px; ">
            <div class="card-header">
              <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                    <i class="now-ui-icons objects_umbrella-13"></i> Translation
                  </a>
                </li>
                <li class="nav-item">
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
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#audio" role="tab">
                    <i class="now-ui-icons ui-2_settings-90"></i> Audio
                  </a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <!-- Tab panes -->
              <div class="tab-content text-center">
                <div class="tab-pane active" id="home" role="tabpanel">
                  <p>I think that’s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at. So when you get something that has the name Kanye West on it, it’s supposed to be pushing the furthest possibilities. I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus.</p>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel">
                  <p> I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus. I think that’s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at. I think that’s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at. </p>
                </div>
                <div class="tab-pane" id="messages" role="tabpanel">
                  <p>I think that’s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at. So when you get something that has the name Kanye West on it, it’s supposed to be pushing the furthest possibilities. I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus.</p>
                </div>
                <div class="tab-pane" id="settings" role="tabpanel">
                  <p>
                    "I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus. I think that’s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at."
                  </p>
                </div>
                <div class="tab-pane" id="audio" role="tabpanel">
                  <p>
                  quran audio
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
    <!-- right section -->
    <div class="col-4 container-fluid">
      <!--
            <div class="row">
              <div class="col-3"></div>
              <div class="col-6">
                <div class="m-0 mr-3 fas fa-fw fa-play text-right"></div>
                <div class="m-0 mr-3 fas fa-fw fa-pause text-right"></div>
                <div class="m-0 fas fa-fw fa-stop text-right"></div>
              </div>
              <div class="col-3"></div>
            </div>
          
            <div class="row mt-3 text-center">
              <div class="col-3">
                <div><b>Surah 1</b></div>
              </div>
              <div class="col-6 text-center">
                <div class="m-0 fas fa-fw mt-1 fa-arrow-left"></div>
                472
                <div class="m-0 fas fa-fw mt-1 fa-arrow-right text-right"></div>
              </div>
              <div class="col-3">
                <div><b>Surah 2</b></div>
              </div>
            </div>
          -->

          <audio controls  autoplay muted class="container-fluid" style="background:grey">
            <source src="" type="audio/ogg">
            <source src="" type="audio/mpeg">
            Your browser does not support the audio element.
          </audio>
      <img src="/images/quran_img.png" style="width:100%; border:4px solid lightgrey">
    </div>
  </div>
</div>
</template>

<script>
export default {
  mounted() {
    this.getInformations();
  },
  data() {
    return {
      information: [],
      surah: 0,
      surahs: [],
      ayah: 0,
      ayahs: [],
      page: 0,
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
          surah_num: this.surah
        }
      }).then(function (response) {
        this.ayahs = response.data;
      }.bind(this));
    },

    getInformations: function () {
      axios.get('/get_informations', {

      }).then(function (response) {
        this.informations = response.data;
      }.bind(this));
    },
  },
}
</script>

<style>
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
