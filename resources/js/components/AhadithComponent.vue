<template>
<div id="app">
  <!-- multiple input sections -->
  <div class="row text-center pt-3 container-fluid">
    <div class="col-md-12 text-center" style="
                    padding-top: 10px;
                    box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px,
                        rgba(0, 0, 0, 0.24) 0px 1px 2px;
                    border-radius: 10px;
                    background: transparent;
                    border: 3px solid #c3e6cb;
                " v-if="ahadith != null">
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

          <div></div>
        </div>
      </div>
    </div>
  </div>

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
            <input style="padding: 12px" class="form-control mr-2 icon col-lg-12" type="search" id="search" name="search" @keyup="search" v-model="searchFilters.hadith_en" placeholder="Search for Keyword" aria-label="Search" />
          </form>
          <hr />
        </div>
      </div>
    </div>
  </div>

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

  <!-- main section -->
  <div class="row">
    <div class="container mt-3 col-md-6" style="display: flex; border-radius: 10px" v-for="data in ahadiths" :key="data.id" :value="data.id">
      <div class="card-body" style="background: white; border: 3px solid #c3e6cb">
        <h3 style="display: flex">
          <img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" />{{ data.chapter.chapter_text }}
        </h3>
        <hr />
        <div class="container-fluid">
          <p class="">{{ data.hadith_ar }}</p>
          <br />
          {{ data.hadith_en }}
        </div>
        <hr />
        <div class="" style="background: lighgrey">
          <!-- <b style="background:lighgrey">Reference:</b> <span style="background:lighgrey">{{ ahadith.imam.imam_name }} , {{ ahadith.chapter_id }}</span><br> -->
          <b style="background: lighgrey">In-Book Reference: </b><span style="background: lighgrey">
            Book {{ data.chapter_id }}</span><br />
          <b style="background: lighgrey">Hadith Num: </b>
          <span style="background: lighgrey">{{ data.chapter.imam_id }}</span><br />
        </div>
      </div>
    </div>
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
        this.getAhadiths();

  },
  data() {
    return {
      data: [],
      imams: [],
      chapters: [],
      ahadiths: [],
      imam: null,
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
