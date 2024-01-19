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
                " v-if="ahadith == null">
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
            <input style="padding: 12px" class="form-control mr-2 icon col-lg-12" type="search" id="search" name="search" @keyup="search" v-model="searchFilters.chapter_text" placeholder="Search for Keyword" aria-label="Search" />
          </form>
          <hr />
        </div>
      </div>
    </div>
  </div>

  <!--
    <div class="card container bg-white mt-3" style="
                  box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px,
                      rgba(0, 0, 0, 0.24) 0px 1px 2px;
                  border-radius: 10px;
                  background: transparent;
                  border: 5px solid #c3e6cb;
              " v-if="ahadith == null">
      <div class="card-header">
        <h2 class="card-text text-center mt-2 mb-2">
          <b>Hadith Collection</b>
        </h2>
      </div>
      <div class="card-body container">
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
      <div>

      </div>

    </div>
  -->

  <!-- main section -->
  <div class="row">
    <div class="container mt-3 col-md-6" style="display: flex; border-radius: 10px" v-for="data in ahadiths" :key="data.id" :value="data.id">
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
          <h5 style="line-height:1.6em">{{ data.hadith_ar }}</h5>
          <br />
          <h5 style="line-height:1.6em">{{ data.hadith_en }}</h5>
        </div>
        <hr />
        <div class="" style="background: lighgrey">
          <h5 style="background: lighgrey"><b class="pr-2">Reference:</b>  Book {{ data.chapter_id }}</h5>
          <h5 style="background: lighgrey"><b class="pr-2">Hadith Num:</b> {{ data.imam_id }}</h5>
        </div>
      </div>
    </div>
  </div>

  <div style="display:flex" class="pr-2 pt-3">
  <input class="button-46"  type="button" v-for="data in imams" :key="data.id" :value="data.imam_name" @click="getChapters()" />
  </div>

  <div >
  <input type="button" class="button-14" v-for="data in chapters" :key="data.id" :value="data.chapter_text" @click="getAhadiths()"/>
  </div>

</div>
</template>

<style>

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
      chapter:null,
      chapter_id: 0,
      imam:0,
      ahadith: null,

      searchFilters: new Form({
        id: "",
        hadith_en: "",
        chapter_text:""
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

/* CSS */
.button-14 {
  background-image: linear-gradient(#f7f8fa ,#e7e9ec);
  border-color: #adb1b8 #a2a6ac #8d9096;
  border-style: solid;
  border-width: 1px;
  border-radius: 3px;
  box-shadow: rgba(255,255,255,.6) 0 1px 0 inset;
  box-sizing: border-box;
  color: #0f1111;
  cursor: pointer;
  display: inline-block;
  font-family: "Amazon Ember",Arial,sans-serif;
  font-size: 14px;
  height: 29px;
  font-size: 13px;
  outline: 0;
  overflow: hidden;
  padding: 0 11px;
  text-align: center;
  text-decoration: none;
  text-overflow: ellipsis;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  white-space: nowrap;
}

.button-14:active {
  border-bottom-color: #a2a6ac;
}

.button-14:active:hover {
  border-bottom-color: #a2a6ac;
}

.button-14:hover {
  border-color: #a2a6ac #979aa1 #82858a;
}

.button-14:focus {
  border-color: #e77600;
  box-shadow: rgba(228, 121, 17, .5) 0 0 3px 2px;
  outline: 0;
}


/* CSS */
.button-46 {
  align-items: center;
  background-color: rgba(240, 240, 240, 0.26);
  border: 1px solid #DFDFDF;
  border-radius: 16px;
  box-sizing: border-box;
  color: #000000;
  cursor: pointer;
  display: flex;
  font-family: Inter, sans-serif;
  font-size: 18px;
  justify-content: center;
  line-height: 28px;
  max-width: 100%;
  padding: 14px 22px;
  text-decoration: none;
  transition: all .2s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  width: 100%;
}

.button-46:active,
.button-46:hover {
  outline: 0;
}

.button-46:hover {
  background-color: #FFFFFF;
  border-color: rgba(0, 0, 0, 0.19);
}

@media (min-width: 768px) {
  .button-46 {
    font-size: 20px;
    min-width: 200px;
    padding: 14px 16px;
  }
}

</style>