<template>
<div id="app">
  <h2 class="pt-3 text-center"><strong>The Holy Quran</strong></h2>

  <div class="container-fluid text-center">

    <!-- main section search-->
    <div class="row container pt-3">
      <div class="col">
        <form class="d-flex" role="search">
          <label class="pr-2 pt-2">Search:</label>
          <input class="form-control me-2" type="search" placeholder="Search Keyword" aria-label="Search">
        </form>
      </div>
      <div class="col">
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
    <div class="container-fluid text-center pb-5">
      <div class="row container-fluid">
        <div class="col-md-7" style="display:flex">

          <label class="pt-2 pl-2 pr-2">Surah:</label>

          <form class="col-md-4">
            <select class="form-control" v-model="surah" @change="getAyahs()">
              <option value="0">Select Surah</option>
              <option v-for="surah in surahs" :key="surah.id" :value="surah.id">{{ surah.name }}</option>
            </select>

          </form>

          <label class="pt-2 pl-4 pr-2">Ayah:</label>

          <form class="col-md-4">
            <select class="form-control" v-model="ayah" @change="getInformations()">
              <option value="0">Select Ayah</option>
              <option v-for="ayah in ayahs" :key="ayah.id" :value="ayah.id">{{ ayah.name }}</option>
            </select>
          </form>
<!--
          <label class="pt-2 pl-4 pr-3">Page:</label>

          <form class="col-md-3">
            <select class="form-control " v-model="page">
              <option value="0">Select Page</option>
              <option v-for="page in pages" :key="page.id" :value="pages.id">{{ pages.name }}</option>
            </select>
          </form>

           <button class=" btn btn-outline-success" type="submit">Search</button> -->
        </div>

        <div class="col-md-5 pl-5" style="display:flex">
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
      <hr>

      <!-- accordion headers-->
      <div class="row container-fluid">
        <div class="col-8 pt-3">
          <Accordion v-for="information in informations" :key="information.id" :value="information.id"  style="border:2px solid lightgrey" :multiple="true" :activeIndex="[0,1,2]">
            <AccordionTab  style="color:black" header="Translation">
              <div class="m-0 fas fa-fw fa-play text-right"></div>
              <p class="text-left mt-2 m-0">
                {{ information.translation }}
              </p>
            </AccordionTab>
            <AccordionTab style="color:black" header="Tafseer">
              <div class="m-0 fas fa-fw fa-play text-right"></div>
              <p class="text-left mt-2 m-0">
                {{ information.tafseer }}
              </p>
            </AccordionTab>
            <AccordionTab style="color:black" header="Transliteration">
              <div class="m-0 fas fa-fw fa-play text-right"></div>
              <p class="text-left mt-2 m-0">
                {{ information.transliteration }}
              </p>
            </AccordionTab>
          </Accordion>
        </div>
        <div class="col-4">
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

          <img src="/images/quran_img.png" style="width:90%; border:4px solid lightgrey">
        </div>
      </div>
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
      surah: 0,
      surahs: [],
      ayah: 0,
      ayahs: [],
      page: 0,
      pages: [],
      information: 0,
      informations:[]
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
    // getPages: function () {
    //   axios.get('/get_pages', {
    //     params: {
    //       ayah_id: this.ayah
    //     }
    //   }).then(function (response) {
    //     this.pages = response.data;
    //   }.bind(this));
    // },
    getInformations: function () {
      axios.get('/get_informations', {
        params: {
          ayah_id: this.ayah
        }
      }).then(function (response) {
        this.informations = response.data;
      }.bind(this));
    },
  },
}
</script>

<style>

</style>
