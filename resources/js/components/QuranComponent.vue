<template>
<div id="app">
 <div class="container-fluid text-center ">
  <div class="row text-center">
   <div class="col-md-12 text-center">
    <div class="row">
     <div class="col-md-3"></div>
     <div class="col-md-6" style="display: flex; text-align: center">
      <div class="card-header">
       <h1 class="card-text text-center mt-2 mb-2" style="font-family:serif">
        The Holy Quran
       </h1>

       <h5 class="card-text container lead text-muted mb-0 pb-3" style="line-height: 1.7em;font-family:serif;">
        The Quran, considered the holy scripture of Islam, is a sacred and comprehensive compilation of revelations.
       </h5>
      </div>

     </div>
     <div class="col-md-3"></div>
    </div>
   </div>
  </div>
 </div>

 <div class="container-fluid mt-2">
  <div class="row"></div>
 </div>

 <!-- accordion headers-->
 <div class="row container-fluid">
  <div class="col-md-8">
   <!-- Nav tabs -->
   <div class="card" style="
                        display: flex;
                        border: 5px solid #c3e6cb;
                        padding: 10px;
                        border-radius: 10px;
                    ">
    <div v-if="information != null">

     <ul class="nav nav-tabs text-left justify-content-center" role="tablist">
      <li class="nav-item">
       <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
        Translation
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
        Tafseer
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
        Transliteration
       </a>
      </li>
     </ul>

     <div class="mt-2" v-if="information != null">
      <div class="row">
       <div class="col-md-7">
        <ul class="ul-main">
         <img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" />
         <li class="li-main mr-3">
          <span class="span-main">{{ information.ayah.surah_id }};
           {{information.ayah.ayah_id}}</span>
         </li>

        </ul>
       </div>
       <div class="col-md-5"></div>
      </div>
     </div>
    </div>

    <div class="card-body">
     <!-- Tab panes -->
     <div class="tab-content text-center">
      <div class="tab-pane active" id="home" role="tabpanel" v-if="information == null">
       <div class="row">
        <div class="col-md-6">
         <img src="/images/calligraphy.png" class="pl-3" style="width: 70%" />
        </div>
        <div class="col-md-6 pt-">
         <span class="container text-left mb-4 lead text-muted mb-0 " style="line-height: 1.5em;font-family:serif">The Quran, considered the holy
          The Quran, also spelled as Qur'an, is the holy book of Islam and is considered by Muslims to be the literal word of God as revealed to the Prophet Muhammad (peace be upon him) through the Angel Gabriel.
         </span>
        </div>
       </div>
      </div>

      <!-- translation -->
      <div class="tab-pane active" id="home" role="tabpanel" v-if="information != null">
       <div class="row">
        <div class="col-12">
         <div class="btn">
          <h3 class="container text-right" style="line-height: 2em">
           {{ information.ayah.ayah_text }}
           ({{ information.ayah.ayah_id }})
          </h3>
         </div>

         <hr class="container" />
         <div class="btn">
          <h4 class="container text-left" style="line-height: 1.6em;font-family:serif">
           {{ information.translation }}"
          </h4>
         </div>
        </div>
       </div>
      </div>

      <!-- tafseer -->
      <div class="tab-pane" id="profile" role="tabpanel" v-if="information != null">
       <div class="btn">
        <h3 class="container text-right" style="line-height: 2em;">
         {{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})
        </h3>
       </div>
       <hr class="container" />
       <div class="btn">
        <h4 class="container text-left" style="line-height: 1.6em;font-family:serif">
         {{ tafseer }}
        </h4>
       </div>
      </div>

      <!-- transliteration -->
      <div class="tab-pane" id="messages" role="tabpanel" v-if="information != null">
       <div class="btn">
        <h3 class="container text-right" style="line-height: 2em">
         {{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})
        </h3>
       </div>
       <hr class="container" />
       <div class="btn">
        <h4 class="container text-left" style="line-height: 1.6em;font-family:serif">
         {{ information.transliteration }}
        </h4>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>

  <!-- right side chapter list -->
  <div class="col-md-4 sticky-top container">

   <form class="mb-2 " style="border: 4px solid #c3e6cb;border-radius: 8px;">
    <select class="form-control " v-model="surah" @change="getAyahs()">
     <option value="0">
      <span style="font-family:serif">Select Surah</span>
     </option>
     <option v-for="data in surahs" :key="data.id" :value="data.id">
      {{ data.name_en }} -
      {{ data.name_ar }}
     </option>
    </select>
   </form>
   <div class="tab-content" id="nav-tabContent" v-if="ayah == null">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" v-if="ayah == null">
     <div class="row container-fluid">
      <div class="custom-scrollbar" style="
                                    box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px,
                                        rgba(0, 0, 0, 0.24) 0px 1px 2px;
                                    background: transparent;
                                    border: 5px solid #c3e6cb;
                                ">
       <ul class="col-md-4 list-group container-fluid root" style="min-width: 100%; cursor: pointer" v-for="(ayah, index) in ayahs" :key="index" @click="getTafseers(ayah.id, index)" :class="{ 'selected': selectedIndexAyah === index }">
        <li class="list-group-item container-fluid" id="toggle" style="cursor: pointer; background: transparent; padding: 20px">
         <h5 style="display: flex; font-family: serif">Verse: {{ ayah.ayah_id }}</h5>
         <h5 style="font-family: serif">{{ ayah.ayah_text }}</h5>
        </li>
       </ul>

      </div>
     </div>
    </div>

   </div>

   <div class="container-fluid mr-5" style=""></div>
  </div>
 </div>
</div>
</template>

<!-- multiple input sections 
  <label class="pt-2 pl-3 pr-2" style="display:flex">Surah:</label>
  <form class="col-md-5">
    <select class="form-control" v-model='surah' @change='getAyahs()'>
      <option value="0"><span>Select Surah</span></option>
      <option v-for='data in surahs' :key="data.id" :value='data.id'>{{ data.name_en }}, {{ data.name_ar }}</option>
    </select>
  </form>
  <label class="pt-2 pl-3 pr-2">Ayah:</label>

  <form class="col-md-8 ">
    <select class='form-control' v-model='ayah_id' @change='getTafseers(data.ayah_id)'>
      <option value="0">Select Ayah</option>
      <option v-for='data in ayahs' :key="data.id" :value='data.id'>{{ data.ayah_id }}, {{ data.ayah_text }}</option>
    </select>
  </form>

  <form class="ml-3 col-md-4 ">
    <input class="form-control input is-primary" type="text" placeholder="Search keyword" />
  </form>
-->

<script>
export default {
 mounted() {
  this.getSurahs();
 },
 data() {
  return {
   selectedIndexAyah: null,
   ayahId: null,
   data: [],
   surahs: [],
   ayahs: [],
   informations: [],
   tafseers: [],
   surah: null,
   ayah: null,
   tafseer: null,
   information: null,
   ayah_id: null,
   id: null,
   surah: 0,
  };
 },
 methods: {
  getTafseers: function (id, index) {
   this.selectedIndexAyah = index;

   axios.get(`/tafseer/${id}/fetch`).then(
    function (response) {
     console.log(response);
     this.selectedAyah = id;
     this.tafseer = response.data;
    }.bind(this)
   );

   axios.get("/get_informations", {
    params: {
     id: id,
    },
   }).then(
    function (response) {
     this.selectedAyah = id;
     this.information = response.data;
    }.bind(this)
   );
  },

  getAyahs: function (id) {
   this.selectedIndexAyah = id;
   axios.get("/get_ayahs", {
    params: {
     surah_id: this.surah,
    },
   }).then(
    function (response) {
     this.ayahs = response.data;
    }.bind(this)
   );
  },

  getSurahs: function () {
   axios
    .get("/get_surahs", {
     params: {
      id: this.surah,
     },
    })
    .then(
     function (response) {
      this.surahs = response.data;
     }.bind(this)
    );
  },

 },
};
</script>

<style scoped>
.selected {
 background-color: #c3e6cb;
}

.custom-scrollbar {
 background-color: transparent;
 height: 800px;
 width: 100%;
 border-radius: 6px;
 box-shadow: 0 4px 28px rgba(123, 151, 158, 0.25);
 border: 1px solid #d6dee1;
 padding: 1rem;
 border-radius: 6px;
 border: 1px solid #d6dee1;
 padding: 1rem;
 background-color: transparent;
 outline: 1px solid #c3e6cb;
 overflow: scroll;
}

.custom-scrollbar-chapters {
 background-color: transparent;
 height: 600px;
 width: 100%;
 border-radius: 6px;
 box-shadow: 0 4px 28px rgba(123, 151, 158, 0.25);
 border: 1px solid #d6dee1;
 padding: 1rem;
 border-radius: 6px;
 border: 1px solid #d6dee1;
 padding: 1rem;
 background-color: transparent;
 outline: 1px solid #c3e6cb;
 overflow: scroll;
}

.myButton {
 background-color: #c3e6cb;
 border-radius: 8px;
 display: inline-block;
 cursor: pointer;
 color: #000;
 font-family: Arial;
 font-size: 18px;
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
 transition: transform 0.5s ease;
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
 color: #ffffff;
}

.nav-tabs>.nav-item>.nav-link i.now-ui-icons {
 font-size: 14px;
 position: relative;
 top: 1px;
 margin-right: 3px;
}

.nav-tabs.nav-tabs-neutral>.nav-item>.nav-link {
 color: #ffffff;
}

.nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active {
 background-color: rgba(255, 255, 255, 0.2);
 color: #ffffff;
}
</style>
