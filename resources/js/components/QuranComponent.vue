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
       <h5 class="card-text container-fluid mb-0 pb-3">
        <span>The Quran, considered the holy scripture of Islam, is a sacred and comprehensive compilation of revelations.</span>
       </h5>
      </div>
      <li v-for="(audio, index) in audioFiles" :key="index">
       <audio controls>
        <source :src="audio.url" type="audio/mpeg">
        Your browser does not support the audio element.
       </audio>
      </li>

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
 <div class="row container-fluid" >
  <div class="col-md-8 " >
   <!-- Nav tabs -->
   <div class="card " style="padding">
    <h5 class="container font-weight-bold pl-3 pt-3" style="font-family:inter; ">Featured Reading:</h5>

    <div class="scrollmenu ">
     <a href="#home">
      <div class="col container ">
       <div class="flex justify-content-center ">
        <Button class="button-33 " label="Al-Fatiha - الفاتحة" severity="success" raised outlined @click="selectSurah(1)" :class="{ 'active': surah === 1 }" />
       </div>
      </div>
     </a>
     <a href="#news">
      <div class="col container ">
       <div class="flex justify-content-center ">
        <Button class="button-33 " label="Al-Fatiha - الفاتحة" severity="success" raised outlined @click="selectSurah(1)" :class="{ 'active': surah === 1 }" />
       </div>
      </div>
     </a>
     <a href="#contact">
      <div class="col container ">
       <div class="flex justify-content-center ">
        <Button class="button-33 " label="Al-Fatiha - الفاتحة" severity="success" raised outlined @click="selectSurah(1)" :class="{ 'active': surah === 1 }" />
       </div>
      </div>
     </a>
     <a href="#about">
      <div class="col container ">
       <div class="flex justify-content-center ">
        <Button class="button-33 " label="Al-Fatiha - الفاتحة" severity="success" raised outlined @click="selectSurah(1)" :class="{ 'active': surah === 1 }" />
       </div>
      </div>
     </a>
     <a href="#support">
      <div class="col container ">
       <div class="flex justify-content-center ">
        <Button class="button-33 " label="Al-Fatiha - الفاتحة" severity="success" raised outlined @click="selectSurah(1)" :class="{ 'active': surah === 1 }" />
       </div>
      </div>
     </a>
     <a href="">
      <div class="col container ">
       <div class="flex justify-content-center ">
        <Button class="button-33 " label="Al-Fatiha - الفاتحة" severity="success" raised outlined @click="selectSurah(1)" :class="{ 'active': surah === 1 }" />
       </div>
      </div>
     </a>
     <a href="#tools">
      <div class="col container ">
       <div class="flex justify-content-center ">
        <Button class="button-33 " label="Al-Fatiha - الفاتحة" severity="success" raised outlined @click="selectSurah(1)" :class="{ 'active': surah === 1 }" />
       </div>
      </div>
     </a>
     <a href="#base">
      <div class="col container ">
       <div class="flex justify-content-center ">
        <Button class="button-33 " label="Al-Fatiha - الفاتحة" severity="success" raised outlined @click="selectSurah(1)" :class="{ 'active': surah === 1 }" />
       </div>
      </div>
     </a>

    </div>

    <!-- HTML !-->

    <div class="container-fluid" v-if="information != null">

     <ul class="nav nav-tabs text-left justify-content-center pt-3" role="tablist">

      <li class="nav-item text-right">
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

    </div>

    <div class="card-body" id="alertContainer">
     <!-- Tab panes -->
     <div class=" tab-content text-center">

      <div class="tab-pane active" id="home" role="tabpanel" v-if="information == null">
       <div class="row">
        <div class="col-md-6">
         <img src="/images/calligraphy.png" class="pl-3" style="width: 70%" />
        </div>

        <div class="col-md-6 mt-4">
         <h5 style="line-height:1.6em">The Quran, considered the holy
          The Quran, also spelled as Qur'an, is the holy book of Islam and is considered by Muslims to be the literal word of God as revealed to the Prophet Muhammad (peace be upon him) through the Angel Gabriel.
         </h5>
        </div>

       </div>
      </div>

      <!-- translation -->
      <div class="tab-pane active" id="home" role="tabpanel" v-if="information != null">
       <div class="row">
        <!-- left side stack of icon features -->
        <div class="col-md-1">
         <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action"  aria-current="true"><i data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" class="bi-bug-fill" style="font-size: 1.1rem; color: black;"></i></a>
          <a href="#" class="list-group-item list-group-item-action"><i class="bi-bookmark-fill" style="font-size: 1.1rem; color: black;"></i></a>
          <a href="#" class="list-group-item list-group-item-action"  @click="copyText"><i class="bi bi-collection-fill" style="font-size: 1.1rem; color: black;"></i></a>
          <a href="#" class="list-group-item list-group-item-action"><i class="bi-share-fill" style="font-size: 1.1rem; color: black;"></i></a>
          <a class="list-group-item list-group-item-action disabled" aria-disabled="true"><i class="bi-camera-fill" style="font-size: 1.1rem; color: black;"></i></a>
         </div>
        </div>
        <div class="col-11">
        <ul class="ul-main">
         <img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" />
         <li class="li-main mr-3">
          <span class="span-main" style="font-style:bold">{{ information.ayah.surah_id }} : {{ information.ayah.ayah_id }}</span>
         </li>
        </ul>
         <div class="btn">
         <div class="span-main text:left" style="font-style:bolder; color:black"></div>
          <h3 ref="heading" @click="copyText" class="container text-right" style="line-height: 2em">
           {{ information.ayah.ayah_text }}
           ({{ information.ayah.ayah_id }})
          </h3>

         </div>

         <hr class="container" style="border:2px dotted black" />
         <div class="btn">
          <h4 ref="heading" class="container text-left" style="line-height: 1.6em;">
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
        <h4 class="container text-left" style="line-height: 1.6em;">
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
        <h4 class="container text-left" style="line-height: 1.6em;">
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

   <form class="mb-2 right-side-form">
    <select class="form-control " v-model="surah" @change="getAyahs()">
     <option value="0">
      <span>Select Surah</span>
     </option>
     <option v-for="data in surahs" :key="data.id" :value="data.id">
      {{ data.name_en }} - {{ data.name_ar }}
     </option>
    </select>
   </form>
   <div class="tab-content" id="nav-tabContent" v-if="ayah == null">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" v-if="ayah == null">
     <div class="row container-fluid">
      <div class="custom-scrollbar">
       <ul class="col-md-4 list-group container-fluid root" v-for="(ayah, index) in ayahs" :key="index" @click="getTafseers(ayah.id, index)" :class="{ 'selected': selectedIndexAyah === index }">
        <li class="list-group-item container-fluid" id="toggle">
         <h5 style="display: flex;">Verse: {{ ayah.ayah_id }}</h5>
         <h5>{{ ayah.ayah_text }}</h5>
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

<script>
export default {

 mounted() {
  this.getSurahs();
 },

 data() {

  return {
   surah: 0,
   selectedSurah: '',
   audioFiles: [],
   totalAudios: 6236,
   audioUrl: '',
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
   name_en: null,
   id: null,
   surah: 0,
   selectedSurah: null, // Initialize selectedSurah as null initially

  };
 },
 methods: {
  selectSurah(surahId) {
   this.surah = surahId;
   this.getAyahs(surahId); // Call the getAyahs method with the selected Surah ID
   // You can perform further actions, such as fetching data related to the selected Surah
  },

  async fetchAllAudios() {
   const audioUrl = 'https://cdn.islamic.network/quran/audio/128/ar.alafasy/29.mp3';
   const corsProxyUrl = 'https://cors-proxy.htmldriven.com/';

   // Construct the proxied URL
   const proxiedUrl = corsProxyUrl + audioUrl;

   // Make a request to the proxied URL
   const response = await axios.get(proxiedUrl);
   try {
    const batchSize = 0; // Adjust the batch size as needed
    const totalAudios = 6236; // Total number of audio files
    const numBatches = Math.ceil(totalAudios / batchSize);

    for (let batchIndex = 0; batchIndex < numBatches; batchIndex++) {
     const startId = batchIndex * batchSize + 1;
     const endId = Math.min(startId + batchSize - 1, totalAudios);

     const batchAudioIds = Array.from({
      length: endId - startId + 1
     }, (_, i) => startId + i);

     const batchResponses = await Promise.all(batchAudioIds.map(id => axios.get(`https://cdn.islamic.network/quran/audio/128/ar.alafasy/${id}.mp3`)));

     for (let response of batchResponses) {
      this.audioFiles.push({
       url: response.request.responseURL
      });
     }
    }
   } catch (error) {
    console.error('Error fetching audio files:', error);
   }
  },

  copyText() {
    // Get the text content of the h3 element
    var textToCopy = this.$refs.heading.innerText;

    // Create a temporary textarea element
    var textarea = document.createElement("textarea");

    // Set its value to the text content
    textarea.value = textToCopy;

    // Append the textarea to the document body
    document.body.appendChild(textarea);

    // Select its text
    textarea.select();

    // Copy the selected text to the clipboard
    document.execCommand("copy");

    // Remove the temporary textarea
    document.body.removeChild(textarea);

    // Create a Bootstrap alert element
    var alertElement = document.createElement("div");
    alertElement.classList.add("alert", "alert-success");
    alertElement.textContent = "Copied text to clipboard";
    
    // Append the alert element to a container in your HTML
    document.getElementById("alertContainer").appendChild(alertElement);

    // Optionally, you can hide or remove the alert after a certain duration
    setTimeout(function() {
      alertElement.remove(); // Remove the alert element after 3 seconds
    }, 3000);
  },


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

.list-group-item {
  border: none;
}
/* CSS */
.button-33 {
 background-color: #c2fbd7;
 border-radius: 10px;
 box-shadow: rgba(44, 187, 99, .2) 0 -25px 18px -14px inset, rgba(44, 187, 99, .15) 0 1px 2px, rgba(44, 187, 99, .15) 0 2px 4px, rgba(44, 187, 99, .15) 0 4px 8px, rgba(44, 187, 99, .15) 0 8px 16px, rgba(44, 187, 99, .15) 0 16px 32px;
 color: green;
 cursor: pointer;
 display: inline-block;
 font-family: CerebriSans-Regular, -apple-system, system-ui, Roboto, sans-serif;
 padding: 7px 20px;
 text-align: center;
 text-decoration: none;
 transition: all 250ms;
 border: 0;
 font-size: 16px;
 user-select: none;
 -webkit-user-select: none;
 touch-action: manipulation;
}

.scrollmenu {
 padding-bottom: 10px;
 padding-top: 10px;
 overflow-y: hidden;
 /* Enable horizontal scrolling */
 white-space: nowrap;
 /* Prevent line breaks */
}

.scrollmenu a {
 display: inline-block;
 vertical-align: top;
 /* Align icons to the top */
 margin-right: 20px;
 /* Adjust spacing between icons */
}

.button-33:hover {
 box-shadow: rgba(44, 187, 99, .35) 0 -25px 18px -14px inset, rgba(44, 187, 99, .25) 0 1px 2px, rgba(44, 187, 99, .25) 0 2px 4px, rgba(44, 187, 99, .25) 0 4px 8px, rgba(44, 187, 99, .25) 0 8px 16px, rgba(44, 187, 99, .25) 0 16px 32px;
 transform: scale(1.05) rotate(-1deg);
}

.list-group-item {
 cursor: pointer;
 background: transparent;
 padding: 20px;
}

.list-group {
 min-width: 100%;
 cursor: pointer;
}

.right-side-form {
 border: 4px solid #c3e6cb;
 border-radius: 8px;
}

.card {
 display: flex;
 border: 5px solid #c3e6cb;
 padding: 10px;
 border-radius: 10px;
}

.card-text {
 line-height: 1.7em;

}

.selected {
 background-color: #c3e6cb;
}

.horizontal-scroll-wrapper {
 overflow-x: scroll;
 overflow-y: hidden;
 white-space: nowrap;
 width: 600px;
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
 box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
 background: transparent;
 border: 5px solid #c3e6cb;
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
