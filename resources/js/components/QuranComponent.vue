<template>
<div id="app">
 <div class="container-fluid text-center">
  <div class="row text-center">
   <div class="col-md-12 text-center">
    <div class="row">
     <div class="col-md-3"></div>
     <div class="col-md-6" style="display: flex; text-align: center">
      <div class="card-header">
       <!-- quran title -->
       <h1 class="card-text text-center mt-2 mb-2" style="font-family: serif">
        The Holy Quran
       </h1>
       <!-- quran description -->
       <h5 class="card-text container-fluid mb-0 pb-3">
        <span>The Quran, considered the holy
         scripture of Islam, is a sacred and
         comprehensive compilation of
         revelations.</span>
       </h5>
      </div>

     </div>
     <div class="col-md-3"></div>
    </div>
   </div>
  </div>
 </div>

 <!-- correction modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
   <div class="modal-content form">
    <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLabel">
      <b>Report a Mistake</b>
     </h5>
    </div>
    <div class="modal-body">
     <form @submit.prevent="createCorrection()">
      <div class="row container">
       <div class="col">
        <input v-model="form.name" type="text" class="form-control" name="name" placeholder="First name (Optional)" aria-label="First name" />
       </div>
       <div class="col">
        <input v-model="form.email" type="text" class="form-control" name="email" placeholder="Email Address (Optional)" aria-label="Email Address" />
       </div>
      </div>
      <div class="row mt-3 container">
       <div class="col">
        <input v-model="form.hadith_num" type="text" class="form-control" name="hadith_num" placeholder="Hadith number" aria-label="Hadith number" />
       </div>

       <div class="col">
        <select class="form-control" name="mistake_type" v-model="form.mistake_type">
         <option value="" disabled>
          Select Type
         </option>
         <option value="Spelling mistakes">
          Spelling mistakes
         </option>
         <option value="Translation error">
          Translation error
         </option>
         <option value="Reference mismatch">
          Reference mismatch
         </option>
        </select>
       </div>
      </div>
      <div class="row container mt-3">
       <textarea v-model="form.added_notes" class="form-control container mb-3" name="added_notes" placeholder="Explain to us exactly what the problem is" id="added_comments" rows="5"></textarea>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        Close
       </button>
       <button type="submit" class="btn btn-success">
        Save changes
       </button>
      </div>
     </form>
    </div>
   </div>
  </div>
 </div>

 <!-- accordion headers-->
 <div class="row container-fluid">
  <div class="col-md-8">
   <!-- Nav tabs -->
   <div class="card" style="padding; display:flex">
    <!-- title of featured reading -->
    <h5 class="container font-weight-bold pl-3 pt-3" style="font-family: inter">
     Featured Reading:
    </h5>
    <!-- list of featured reading -->
    <div class="scrollmenu">
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Ya Seen 36 - يس ٣٦ " severity="success" raised outlined @click="selectSurah(36)" :class="{ active: surah === 36 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="An-Nas 114 - الناس ١١٤" severity="success" raised outlined @click="selectSurah(114)" :class="{ active: surah === 114 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Al-Falak 113 - الفلق ١١٣" severity="success" raised outlined @click="selectSurah(113)" :class="{ active: surah === 133 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Al-Kafiroon 109 - الكافيرون ١٠٩" severity="success" raised outlined @click="selectSurah(109)" :class="{ active: surah === 109 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Al-Mulk 67 - الملك ٦٧" severity="success" raised outlined @click="selectSurah(67)" :class="{ active: surah === 67 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Al-Rahman 55 - الرمان ٥٥" severity="success" raised outlined @click="selectSurah(55)" :class="{ active: surah === 55 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Al-Kahf 18 -	الكهف ١٨" severity="success" raised outlined @click="selectSurah(18)" :class="{ active: surah === 18 }" />
       </div>
      </div>
     </a>
    </div>

    <!-- tabs for Translation, Tafseer & Transliteration -->
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
     <!-- Intro -->
     <div class="tab-content text-center">

      <div class="tab-pane active" id="home" role="tabpanel" v-if="information == null">
       <div class="row">
        <!-- Intro image -->
        <div class="col-md-6">
         <img src="/images/calligraphy.png" class="pl-3" style="width: 70%" />
        </div>
        <!-- Intro desc -->
        <div class="col-md-6 mt-4">
         <h5 style="line-height: 1.6em">
          The Holy Quran is the central religious text of Islam, believed by Muslims to be a revelation from God. It is written in Arabic and is considered the literal word of God as conveyed to Prophet Muhammad (peace be upon him) through the Angel Gabriel over a period of approximately 23 years. The Quran is divided into chapters called surahs, which vary in length, and contains guidance on matters of faith, morality, law, and spirituality.
         </h5>
        </div>
       </div>
      </div>

      <!-- translation section -->
      <div class="tab-pane active" id="home" role="tabpanel" v-if="information != null">
       <div class="row">
        <!-- left side stack of icon features -->
        <div class="col-md-1">
         <div class="list-group styling">
          <a href="#" class="list-group-item list-group-item-action" aria-current="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Play audio"><i class="bi-play-circle-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action dropdown-toggle dropend" data-bs-toggle="dropdown" aria-expanded="false" data-bs-placement="top" title="Share verse"><i class="bi bi-share-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy verse" @click="copyText"><i class="bi bi-collection-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Screenshot verse" @click="captureScreenshot"><i class="bi bi-camera-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" aria-current="true" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi-bug-fill test" style="font-size: 1.2rem"></i></a>

          <ul class="dropdown-menu">
           <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Share verse with whatsapp" @click="shareTextViaWhatsApp"><i class="bi bi-whatsapp test" style="font-size: 1.2rem">Whatsapp</i></a>
           <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Share verse with mail" @click="shareViaEmail($refs.targetElement.innerText)"><i class="bi bi-envelope-at-fill test" style="font-size: 1.2rem">Email</i></a>
           <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Share verse with twitter" @click="shareHeadingOnTwitter()"><i class="bi bi-twitter-x test" style="font-size: 1.2rem">Twitter</i></a>
          </ul>

         </div>
        </div>

        <div class="col-11" ref="targetElement">
         <!-- surah/ayah detail -->

         <ul class="ul-main row mb-3">
          <h5 class="col-md-3 font-weight-bold">
           <img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" />{{ information.ayah.surah.name_en }}
          </h5>
          <div class="col-md-6">
           <li class="li-main mr-3">
            <span class="span-main" style="font-style: bold">{{ information.ayah.surah_id }}: {{ information.ayah.ayah_id }}</span>
           </li>
          </div>
          <h5 class="col-md-3 ">{{ information.ayah.surah.name_ar }} <img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" /></h5>
         </ul>
         <hr style="border: 1px dotted grey">
         <a :href="downloadUrl" class="button-33 mb-2 mt-2" download="screenshot.png" v-if="downloadUrl">Download Screenshot</a>

         <!-- Display audio for the selected ayah -->
         <div class="row">
          <div class="col-md-4"> <button class="btn button-33" @click="goToPreviousSurah">Previous Surah</button>
          </div>
          <div class="col-md-4"> <audio ref="audioPlayer" :src="selectedAyah ? selectedAyah.audio_link : ''" controls></audio>
          </div>
          <div class="col-md-4"><button class="btn button-33" @click="goToNextSurah()">Next Surah</button></div>
         </div>

         <div class="btn">
          <div class="span-main text:left" style="font-style: bolder;color: black;"></div>
          <h3 class="container text-right" style="line-height: 2em">
           {{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})
          </h3>
          <div v-for="(ayah, index) in filteredAyahs" :key="index">
           <p>{{ ayah.ayah_text }}</p>
          </div>
          <hr />
          <!-- main stack below -->
          <div class="btn">
           <h4 ref="heading" class="container text-left" style="line-height: 1.6em">
            <h3 name="text">
             {{ information.translation }}
            </h3>
           </h4>
          </div>
         </div>
        </div>

       </div>
      </div>

      <!-- tafseer section -->
      <div class="tab-pane" id="profile" role="tabpanel" v-if="information != null">
       <div class="row">

        <!-- left side stack of icon features -->
        <div class="col-md-1">
         <div class="list-group styling">
          <a href="#" class="list-group-item list-group-item-action" aria-current="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Play audio"><i class="bi-play-circle-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action dropdown-toggle dropend" data-bs-toggle="dropdown" aria-expanded="false" data-bs-placement="top" title="Share verse"><i class="bi bi-share-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy verse" @click="copyText1"><i class="bi bi-collection-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Screenshot verse" @click="captureScreenshot1"><i class="bi bi-camera-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" aria-current="true" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi-bug-fill test" style="font-size: 1.2rem"></i></a>

          <ul class="dropdown-menu">
           <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Share verse with whatsapp" @click="shareTextViaWhatsApp1"><i class="bi bi-whatsapp test" style="font-size: 1.2rem">Whatsapp</i></a>
           <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Share verse with mail" @click="shareViaEmail1( $refs.targetElement1.innerText)"><i class="bi bi-envelope-at-fill test" style="font-size: 1.2rem">Email</i></a>
           <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Share verse with twitter" @click="shareHeadingOnTwitter1()"><i class="bi bi-twitter-x test" style="font-size: 1.2rem">Twitter</i></a>
          </ul>

         </div>
        </div>

        <div class="col-11" ref="targetElement1">
         <!-- surah/ayah detail -->
         <ul class="ul-main row mb-3">
          <h5 class="col-md-3 font-weight-bold"><img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" />{{information.ayah.surah.name_en}}</h5>
          <div class="col-md-6">
           <li class="li-main mr-3">
            <span class="span-main" style="font-style: bold">{{information.ayah.surah_id}}: {{ information.ayah.ayah_id }}
            </span>
           </li>
          </div>
          <h5 class="col-md-3 ">{{information.ayah.surah.name_ar}} <img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" /></h5>
         </ul>

         <hr style="border: 1px dotted grey">
         <a :href="downloadUrl" class="button-33 mb-2 mt-2" download="screenshot.png" v-if="downloadUrl">Download Screenshot</a>

         <!-- Display audio for the selected ayah -->
         <div class="row">
          <div class="col-md-4"> <button class="btn button-33" @click="goToPreviousSurah">Previous Surah</button>
          </div>
          <div class="col-md-4"> <audio ref="audioPlayer" :src="selectedAyah ? selectedAyah.audio_link : ''" controls></audio>
          </div>
          <div class="col-md-4"><button class="btn button-33" @click="goToNextSurah()">Next Surah</button></div>
         </div>

         <!-- main stack top -->
         <div class="btn">
          <h3 class="container text-right" style="line-height: 2em">
           {{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})
          </h3>
         </div>
         <hr />
         <!-- main stack below -->
         <div class="btn">
          <h4 class="container text-left" ref="heading1" style="line-height: 1.6em">
           {{ tafseer }}
          </h4>
         </div>
        </div>
       </div>
      </div>

      <!-- transliteration section -->
      <div class="tab-pane" id="messages" role="tabpanel" v-if="information != null">
       <div class="row">

        <!-- left side stack of icon features -->
        <div class="col-md-1">
         <div class="list-group styling">
          <a href="#" class="list-group-item list-group-item-action" aria-current="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Play audio"><i class="bi-play-circle-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action dropdown-toggle dropend" data-bs-toggle="dropdown" aria-expanded="false" data-bs-placement="top" title="Share verse"><i class="bi bi-share-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy verse" @click="copyText2"><i class="bi bi-collection-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Screenshot verse" @click="captureScreenshot2"><i class="bi bi-camera-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" aria-current="true" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi-bug-fill test" style="font-size: 1.2rem"></i></a>

          <ul class="dropdown-menu">
           <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Share verse with whatsapp" @click="shareTextViaWhatsApp2"><i class="bi bi-whatsapp test" style="font-size: 1.2rem">Whatsapp</i></a>
           <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Share verse with mail" @click="shareViaEmail2($refs.targetElement2.innerText)"><i class="bi bi-envelope-at-fill test" style="font-size: 1.2rem">Email</i></a>
           <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Share verse with mail" @click="shareHeadingOnTwitter2()"><i class="bi bi-twitter-x test" style="font-size: 1.2rem">Twitter</i></a>
          </ul>
         </div>
        </div>

        <div class="col-11" ref="targetElement2">
         <!-- surah/ayah detail -->
         <ul class="ul-main row ">
          <h5 class="col-md-3 font-weight-bold"><img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" />{{information.ayah.surah.name_en}}</h5>
          <div class="col-md-6">
           <li class="li-main mr-3">
            <span class="span-main" style="font-style: bold">{{information.ayah.surah_id}}: {{ information.ayah.ayah_id }}
            </span>
           </li>
          </div>
          <h5 class="col-md-3 ">{{information.ayah.surah.name_ar}} <img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" /></h5>
         </ul>
         <hr style="border: 1px dotted grey">
         <a :href="downloadUrl" class="button-33 mb-2 mt-2" download="screenshot.png" v-if="downloadUrl">Download Screenshot</a>

         <!-- Display audio for the selected ayah -->
         <div class="row">
          <div class="col-md-4"> <button class="btn button-33" @click="goToPreviousSurah">Previous Surah</button>
          </div>
          <div class="col-md-4"> <audio ref="audioPlayer" :src="selectedAyah ? selectedAyah.audio_link : ''" controls></audio>
          </div>
          <div class="col-md-4"><button class="btn button-33" @click="goToNextSurah()">Next Surah</button></div>
         </div>

         <!-- main stack top -->
         <div class="btn">
          <h3 class="container text-right" style="line-height: 2em">
           {{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})
          </h3>
         </div>
         <hr />
         <!-- main stack below -->
         <div class="btn">
          <h4 class="container text-left" ref="heading2" style="line-height: 1.6em">
           {{ information.transliteration }}
          </h4>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>

  <!-- right side chapter list -->
  <div class="col-md-4 sticky-top container">
   <form class="mb-2 right-side-form">
    <select class="form-control" v-model="surah" @change="getAyahs()">
     <option value="0">
      <span>Select Surah</span>
     </option>
     <option v-for="data in surahs" :key="data.id" :value="data.id">
      {{ data.name_en }} - {{ data.name_ar }}
     </option>
    </select>
   </form>
   <!-- list search for surat -->
   <div class="tab-content" id="nav-tabContent" v-if="ayah == null && !dropdownHidden">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" v-if="ayah == null">
     <div class="row container-fluid">
      <!-- controls -->
      <div class="row mb-3">
       <div class="col-md-6">
        <button class="btn button-33" style="width:100%" @click="goToPreviousAyah()">Previous Ayah</button>
       </div>
       <div class="col-md-6">
        <button class="btn button-33" style="width:100%" @click="goToNextAyah()">Next Ayah</button>
       </div>
      </div>
      <div class="custom-scrollbar" style="overflow-y:auto; max-height:600px">
       <ul class="col-md-4 list-group container-fluid root" v-for="(ayah, index) in ayahs" :key="index" @click="getTafseers(ayah.id, index)" :class="{selected: selectedIndexAyah === index,}">
        <li class="list-group-item container-fluid" id="toggle" ref="selectedAyah">
         <h5 style="display: flex"> Verse: {{ ayah.ayah_id }} </h5>
         <h5>{{ ayah.ayah_text }}</h5>
        </li>
       </ul>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>
</template>

<script>
import html2canvas from 'html2canvas';

export default {
 mounted() {
  this.getSurahs();
  this.fetchAyahs();
 },

 data() {
  return {
   selectedIndexAyah: -1,
   selectedAyah: null,
   downloadUrl: null,
   ayahs: [], // Your list of ayahs
   dropdownHidden: true,
   selectedSurah: "",
   audioFiles: [],
   totalAudios: 6236,
   audioUrl: "",
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
   isPlaying: false,

   form: new Form({
    id: "",
    name: "",
    email: "",
    mistake_type: "",
    added_notes: "",
    hadith_num: "",
   }),
  };
 },
 computed: {
  filteredAyahs() {
   // Filter ayahs based on selected surah
   if (!this.surah) return [];
   return this.ayahs.filter(ayah => ayah.surah_id === this.surah);
  }
 },
 async getAyahs() {
  try {
   const response = await axios.get(`http://localhost:8000/api/ayahs?surah=${this.surah}`);
   this.ayahs = response.data;
  } catch (error) {
   console.error('Error fetching ayahs:', error);
  }
 },
 methods: {

  goToNextAyah() {
   if (this.selectedIndexAyah < this.ayahs.length - 1) {
    this.selectedIndexAyah++;
    this.getTafseers(this.ayahs[this.selectedIndexAyah].id, this.selectedIndexAyah);
   } else {
    this.selectedIndexAyah = 0;
    this.getTafseers(this.ayahs[this.selectedIndexAyah].id, this.selectedIndexAyah);
   }
  },
  goToPreviousAyah() {
   if (this.selectedIndexAyah > 0) {
    this.selectedIndexAyah--;
   } else {
    // If already at the beginning, loop to the end
    this.selectedIndexAyah = this.ayahs.length - 1;
   }
   this.getTafseers(this.ayahs[this.selectedIndexAyah].id, this.selectedIndexAyah);
  },

  getAyahs: function () {
   this.dropdownHidden = false;
   axios
    .get("/get_ayahs", {
     params: {
      surah_id: this.surah,
     },
    })
    .then(
     function (response) {
      this.ayahs = response.data;
      // Reset selectedIndexAyah to 0 when fetching ayahs for a new surah
      this.selectedIndexAyah = 0;
      // Ensure that the first verse is highlighted
      this.scrollSelectedAyahIntoView();
     }.bind(this)
    )
    .catch(function (error) {
     console.error("Error fetching ayahs:", error);
    });
  },
  goToNextSurah() {
   // Check if the current selected surah is not the last one
   if (this.surah < this.surahs.length - 1) {
    this.surah++;
   } else {
    // If already at the last surah, loop back to the first surah
    this.surah = 0;
   }
   this.selectedIndexAyah = 0; // Reset the selected ayah index to the first verse of the next surah
   // Fetch ayahs for the next surah
   this.getAyahs(this.surah);
  },
  goToPreviousSurah() {
   // Check if the current selected surah is not the first one
   if (this.surah > 1) {
    // Decrement the surah index to move to the previous surah
    this.surah--;
   } else {
    // If already at the first surah, loop to the last surah
    this.surah = this.surahs.length;
   }
   this.selectedIndexAyah = 0; // Reset the selected ayah index to the first verse of the previous surah
   // Fetch ayahs for the previous surah
   this.getAyahs(this.surah);
  },
  getSurahs() {
   axios
    .get("/get_surahs")
    .then(response => {
     this.surahs = response.data;
    })
    .catch(error => {
     console.error('Error fetching surahs:', error);
    });
  },

  shareHeadingOnTwitter() {
   try {
    const headingText = this.$refs.targetElement.textContent.trim();
    const encodedHeading = encodeURIComponent(headingText);
    const twitterUrl = `https://twitter.com/intent/tweet?text=${encodedHeading}`;
    window.open(twitterUrl, "_blank") || console.error("Failed to open Twitter sharing dialog.");
   } catch (error) {
    console.error("Error:", error);
   }
  },

  shareHeadingOnTwitter1() {
   try {
    const headingText1 = this.$refs.targetElement1.textContent.trim();
    const encodedHeading = encodeURIComponent(headingText1);
    const twitterUrl = `https://twitter.com/intent/tweet?text=${encodedHeading}`;
    window.open(twitterUrl, "_blank") || console.error("Failed to open Twitter sharing dialog.");
   } catch (error) {
    console.error("Error:", error);
   }
  },

  shareHeadingOnTwitter2() {
   try {
    const headingText2 = this.$refs.targetElement2.textContent.trim();
    const encodedHeading = encodeURIComponent(headingText2);
    const twitterUrl = `https://twitter.com/intent/tweet?text=${encodedHeading}`;
    window.open(twitterUrl, "_blank") || console.error("Failed to open Twitter sharing dialog.");
   } catch (error) {
    console.error("Error:", error);
   }
  },

  shareViaEmail(body) {
   const url = `mailto:?body=${encodeURIComponent(body)}`;
   window.location.href = url;
  },
  shareViaEmail1(body1) {
   const url = `mailto:?body=${encodeURIComponent(body1)}`;
   window.location.href = url;
  },
  shareViaEmail2(body2) {
   const url = `mailto:?body=${encodeURIComponent(body2)}`;
   window.location.href = url;
  },

  shareTextViaWhatsApp() {
   const text = this.$refs.targetElement.innerText;
   const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
   window.open(url, '_blank');
  },
  shareTextViaWhatsApp1() {
   const text1 = this.$refs.targetElement1.innerText;
   const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(text1)}`;
   window.open(url, '_blank');
  },
  shareTextViaWhatsApp2() {
   const text2 = this.$refs.targetElement2.innerText;
   const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(text2)}`;
   window.open(url, '_blank');
  },

  captureScreenshot() {
   const targetElement = this.$refs.targetElement;

   // Show the button initially
   this.showScreenshotButton = true;

   // Capture screenshot for targetElement after 5 seconds
   setTimeout(() => {
    html2canvas(targetElement).then(canvas => {
     const dataUrl = canvas.toDataURL('image/png');
     this.downloadUrl = dataUrl;

     // Hide the button after another 5 seconds
     setTimeout(() => {
      this.showScreenshotButton = false;
     }, 5000); // 5000 milliseconds = 5 seconds
    });
   }, 5000); // 5000 milliseconds = 5 seconds
  },

  captureScreenshot1() {
   const targetElement1 = this.$refs.targetElement1;
   setTimeout(() => {
    // Capture screenshot for targetElement
    html2canvas(targetElement1).then(canvas => {
     const dataUrl = canvas.toDataURL('image/png');
     this.downloadUrl = dataUrl;

     // Extract text content for targetElement
     const textContent = targetElement1.innerText;
     console.log("Text content for targetElement:", textContent);
    });
   }, 5000); // 5000 milliseconds = 5 seconds
  },
  captureScreenshot2() {
   const targetElement2 = this.$refs.targetElement2;
   setTimeout(() => {
    // Capture screenshot for targetElement
    html2canvas(targetElement2).then(canvas => {
     const dataUrl = canvas.toDataURL('image/png');
     this.downloadUrl = dataUrl;

     // Extract text content for targetElement
     const textContent = targetElement2.innerText;
     console.log("Text content for targetElement:", textContent);
    });
   }, 5000); // 5000 milliseconds = 5 seconds
  },
  // 5000 milliseconds = 5 seconds,
  fetchAyahs() {
   fetch('/api/ayahs')
    .then(response => response.json())
    .then(data => {
     this.ayahs = data;
    })
    .catch(error => {
     console.error('Error fetching ayahs:', error);
    });
  },
  playAudio() {
   this.$refs.audioPlayer.play();
   this.isPlaying = true;
  },
  pauseAudio() {
   this.$refs.audioPlayer.pause();
   this.isPlaying = false;
  },
  async getAyahs() {
    try {
     const response = await axios.get(`http://localhost:8000/api/ayahs?surah=${this.surah}`);
     this.ayahs = response.data;
     console.log('Ayahs:', this.ayahs); // Check the fetched ayahs data
     // Ensure that the selectedAyah object is populated with valid data
     if (this.ayahs.length > 0) {
      this.selectedAyah = this.ayahs[0]; // Assuming you want to select the first ayah by default
      console.log('Selected Ayah:', this.selectedAyah); // Check the selected ayah data
      // Assuming you have an <audio> element with id="ayahAudio", update its source with the selected ayah's audio_link
      document.getElementById('ayahAudio').src = this.selectedAyah.audio_link;
     }
    } catch (error) {
     console.error('Error fetching ayahs:', error);
    }
   }

   ,
  selectSurah(surahId) {
   this.surah = surahId;
   this.getAyahs(); // Call the getAyahs method with the selected Surah ID
   // You can perform further actions, such as fetching data related to the selected Surah
  },

  createCorrection() {
   Swal.fire({
    title: "Are you sure?",
    text: "You want to create a new Correction !",
    showCancelButton: true,
    confirmButtonColor: "green",
    cancelButtonColor: "#d33",
    confirmButtonText: "Create correction!",
   }).then((result) => {
    if (result.isConfirmed) {
     axios
      .post("/api/submit-correction", this.form)
      .then((res) => {
       if (!res.data.success) {
        Swal.fire({
         position: "top-end",
         icon: "success",
         title: "Correction created successfully ",
         showConfirmButton: false,
         timer: 1500,
        });
        $("#exampleModal").modal("hide");
       } else if (res.data.success) {
        Swal.fire(
         "Error!",
         "Unable to create correction.",
         "error"
        );
       }
      })
      .catch(function (err) {});
    }
   });
  },

  copyText() {
   var textToCopy = this.$refs.heading.innerText;
   var textarea = document.createElement("textarea");

   textarea.value = textToCopy;
   document.body.appendChild(textarea);
   textarea.select();
   document.execCommand("copy");
   document.body.removeChild(textarea);

   var alertElement = document.createElement("div");
   alertElement.classList.add("alert", "alert-success");
   alertElement.textContent = "Copied text to clipboard";

   document.getElementById("alertContainer").appendChild(alertElement);

   setTimeout(function () {
    alertElement.remove();
   }, 3000);

  },

  copyText1() {
   var textToCopy1 = this.$refs.heading1.innerText;
   var textarea = document.createElement("textarea");

   textarea.value = textToCopy1;
   document.body.appendChild(textarea);
   textarea.select();
   document.execCommand("copy");
   document.body.removeChild(textarea);

   var alertElement = document.createElement("div");
   alertElement.classList.add("alert", "alert-success");
   alertElement.textContent = "Copied text to clipboard";

   document.getElementById("alertContainer").appendChild(alertElement);

   setTimeout(function () {
    alertElement.remove();
   }, 3000);

  },

  copyText2() {
   var textToCopy1 = this.$refs.heading2.innerText;
   var textarea = document.createElement("textarea");

   textarea.value = textToCopy1;
   document.body.appendChild(textarea);
   textarea.select();
   document.execCommand("copy");
   document.body.removeChild(textarea);

   var alertElement = document.createElement("div");
   alertElement.classList.add("alert", "alert-success");
   alertElement.textContent = "Copied text to clipboard";

   document.getElementById("alertContainer").appendChild(alertElement);

   setTimeout(function () {
    alertElement.remove();
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

   axios
    .get("/get_informations", {
     params: {
      id: id,
     },
    })
    .then(
     function (response) {
      this.selectedAyah = id;
      this.information = response.data;
     }.bind(this)
    );
  },

  getAyahs: function (id) {
   this.dropdownHidden = false;
   this.selectedIndexAyah = id;
   axios
    .get("/get_ayahs", {
     params: {
      surah_id: this.surah,
     },
    })
    .then(
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

 watch: {
  'information.ayah.surah.name_ar': 'updateFileName'
 }

};
</script>

<style scoped>
.list-group-item-action:hover {
 background-color: #c3e6cb;
}

.styling {
 box-shadow: rgba(154, 167, 159, 0.2) 0 -25px 18px -14px inset,
  rgba(44, 187, 99, 0.15) 0 1px 2px, rgba(44, 187, 99, 0.15) 0 2px 4px,
  rgba(44, 187, 99, 0.15) 0 4px 8px, rgba(44, 187, 99, 0.15) 0 8px 16px,
  rgba(44, 187, 99, 0.15) 0 16px 32px;
 transition: all 250ms;
 cursor: pointer;
 touch-action: manipulation;
 border: 1px solid lightgrey;
}

.list-group-item {
 border: none;
}

.button-33 {
 background-color: #c2fbd7;
 border-radius: 10px;
 box-shadow: rgba(154, 167, 159, 0.2) 0 -25px 18px -14px inset,
  rgba(44, 187, 99, 0.15) 0 1px 2px, rgba(44, 187, 99, 0.15) 0 2px 4px,
  rgba(44, 187, 99, 0.15) 0 4px 8px, rgba(44, 187, 99, 0.15) 0 8px 16px,
  rgba(44, 187, 99, 0.15) 0 16px 32px;
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
 overflow-x: inherit;
 /* Hide horizontal scrollbar */
 white-space: nowrap;
}

.scrollmenu a {
 display: inline-block;
 vertical-align: top;
 margin-right: 20px;
}

.button-33:hover {
 box-shadow: rgba(44, 187, 99, 0.35) 0 -25px 18px -14px inset,
  rgba(44, 187, 99, 0.25) 0 1px 2px, rgba(44, 187, 99, 0.25) 0 2px 4px,
  rgba(44, 187, 99, 0.25) 0 4px 8px, rgba(44, 187, 99, 0.25) 0 8px 16px,
  rgba(44, 187, 99, 0.25) 0 16px 32px;
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
