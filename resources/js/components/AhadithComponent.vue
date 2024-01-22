<template>
<div id="app">
  <!-- multiple input sections -->

  <div class="row text-center pt-3 container-fluid">
    <div class="col-md-12 pt-3 text-center" style="
                    box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px,
                        rgba(0, 0, 0, 0.24) 0px 1px 2px;
                    border-radius: 10px;
                    background: transparent;
                    border: 3px solid #c3e6cb;
                ">
      <div class="row">
        <div class="col-md-12 container" style="display: flex; text-align: center">
          <label class="pt-2 pl-3 pr-2" style="display: flex">Imam:</label>
          <form class="col-md-3">
            <select class="form-control" v-model="imam" @change="getChapters()">
              <option value="0">
                <span>Select Imam</span>
              </option>
              <option v-for="data in imams" :key="data.id" :value="data.id">
                {{ data.imam_name }}
              </option>
            </select>
          </form>

          <label class="pt-2 pl-3 pr-3">Chapter:</label>
          <form class="col-md-3">
            <select class="form-control" v-model="chapter_id" @change="getAhadiths()">
              <option value="0">
                <span>Select Chapter</span>
              </option>
              <option v-for="data in chapters" :key="data.id" :value="data.id">
                {{ data.chapter_text }}
              </option>
            </select>
          </form>

          <form class="mb-4 col-md-4" style="display: flex" @submit.prevent="search()">
            <input style="padding: 12px" class="form-control mr-2 icon col-lg-12" type="search" id="search" name="search" @keyup="search" v-model="searchFilters.hadith_en" placeholder="Search for Keyword" aria-label="Search" />
          </form>
          <hr />
        </div>
      </div>
    </div>
  </div>

  <!-- <div v-if="ahadith == null" class="card container bg-white mt-3" style=" box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px,rgba(0, 0, 0, 0.24) 0px 1px 2px;border-radius: 10px;background: transparent;border: 5px solid #c3e6cb;">
   
   <div class="card-header" >
      <h2 class="card-text text-center mt-2 mb-2">
        <b>Hadith Collection</b>
      </h2>
    
      <h6 class="card-text container" style="line-height: 1.7em; font-weight-bold">
        Hadiths are the recorded sayings, actions, and approvals of
        Prophet Muhammad (peace be upon him) in Islam. They serve as
        an essential source of guidance for Muslims, providing
        insights into the Prophet's teachings and practices. The
        collection of Hadiths is a vital component of Islamic
        tradition, alongside the Quran.
      </h6>
      <h6 class="card-text container" style="line-height: 1.7em; font-weight-bold">
        The process of collecting and preserving Hadiths began
        shortly after the death of Prophet Muhammad. Scholars
        recognized the importance of preserving his words and
        actions to maintain the authenticity of Islamic teachings.
        The collection of Hadiths underwent a meticulous and
        rigorous process to ensure accuracy and reliability.
      </h6>   
    </div>
    
    
    <div class="container row" >
      <div style="padding:10px" class="container col-md-12 pt-4">
        <input class="container button-33 mr-2" type="button" v-for="data in imams" :key="data.id" :value="data.imam_name" @click="getChapters()" />
      </div>
    </div>

    <div class="container mt-2" v-if="ahadith == null">
      <div class="row container">
        <ul class="col-md-2 list-group mb-3" style="display:flex"  v-for="data in imams" :key="data.id" :value="data.imam_name" @click="getChapters()">
          <li class="list-group-item list-group-item-success text-center" id="demo" style="cursor:pointer" onclick="document.getElementById('demo').style['text-decoration']='underline'" >{{ data.imam_name }}</li>
        </ul>
      </div>
    </div>

  
    </div>
    -->

  
  <div class="">
    <div class="row">
      <div class="col-md-8">
        <!-- left side ahadith list -->
        <div class="row" v-if="ahadith == null">
          <div class="container-fluid mt-3 col-md-12" style="display: flex; border-radius: 10px" v-for="data in ahadiths" :key="data.id" :value="data.id">
            <div class="card-body" style="background: white; border-radius:10px;box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;">
              <div class="row">
                <div class="col-md-11">
                  <h3 style="display: flex">
                    <img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" />{{ data.chapter.chapter_text }}
                  </h3>
                </div>
                <div class="col-md-1" style="display:flex">
                  <h2 class="text-center" style="color:grey">{{ data.imam_id }}</h2>
                </div>
              </div>
              <hr />
              <div class="container-fluid">
                <h6 style="line-height:1.6em" class="text-right">{{ data.hadith_ar }}</h6>
                <br />
                <h6 style="line-height:1.6em">{{ data.hadith_en }}</h6>
              </div>
              <hr />
              <div class="" style="background: lighgrey">
                <h6 style="background: lighgrey"><b class="pr-2">Reference:</b> Book {{ data.chapter_id }}</h6>
                <h6 style="background: lighgrey"><b class="pr-2">Hadith Num:</b> {{ data.imam_id }}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- right side chapter list -->
      <div class="col-md-4 sticky-top">
      <form v-if="ahadith == null" class="mb-4 sticky-top" style="display: flex" @submit.prevent="search()">
        <input style="padding: 12px" class="form-control mr-2 mt-2 icon col-lg-12" type="search" id="search" name="search" @keyup="search" v-model="searchFilters.hadith_en" placeholder="Search for Chapter" aria-label="Search" />
      </form>
        <div class="container-fluid mt-2 mr-5 custom-scrollbar" v-if="ahadith == null">

          <div class="row container-fluid " style="flex-direction:column">
            
            <ul class="col-md-4 list-group container-fluid scrollbar" style="max-width:100%" v-for="data in chapters" :key="data.id" :value="data.chapter_text" @click="getAhadiths()">
              <li class="list-group-item " style="cursor:pointer; border:2px solid #c3e6cb"><b>{{ data.chapter_id }}) - </b> {{ data.chapter_text }}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</template>

<style>

.custom-scrollbar {
  background-color: #fdfdfd;
  height: 1000px;
  width: 100%;
  border-radius: 6px;
  box-shadow: 0 4px 28px rgba(123,151,158,.25);
  border: 1px solid #d6dee1;
  padding: 1rem;
  overflow: scroll;
  border-radius: 6px;
  box-shadow: 0 4px 28px rgba(123,151,158,.25);
  border: 1px solid #d6dee1;
  padding: 1rem;
  background-color: transparent;
  outline: 1px solid #c3e6cb;
  box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);

}


</style>

<script>
import axios from "axios";

export default {
  mounted() {
    this.getImams();
    // this.getAhadiths();
  },

  data() {
    return {
      data: [],
      imams: [],
      chapters: [],
      ahadiths: [],
      imam: null,
      chapter: null,
      chapter_id: 0,
      imam: 0,
      ahadith: null,

      searchFilters: new Form({
        id: "",
        hadith_en: "",
      }),
    };
  },
  methods: {
    search() {
      var filteredHadiths = [];
      axios
        .post("/search", this.searchFilters)
        .then((data) => {
          filteredHadiths = data.data;
        })
        .catch(function (err) {
          console.log(err);
        })
        .finally((data) => {
          this.ahadiths = filteredHadiths;
        });
    },

    getImams: function () {
      axios
        .get("/get_imams", {
          params: {
            id: this.imam,
          },
        })
        .then(
          function (response) {
            this.imams = response.data;
          }.bind(this)
        );
    },

    getChapters: function () {
      axios
        .get("/get_chapters", {
          params: {
            imam_id: this.imam,
          },
        })
        .then(
          function (response) {
            this.chapters = response.data;
          }.bind(this)
        );
    },

    getAhadiths: function () {
      axios.get(`/ahadith/${this.chapter_id}/fetch`).then(
        function (response) {
          this.ahadiths = response.data;
        }.bind(this)
      );

    },
  },
};
</script>

<style>

</style>
