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
   <div class="card" style="padding">
    <!-- title of featured reading -->
    <h5 class="container font-weight-bold pl-3 pt-3" style="font-family: inter">
     Featured Reading:
    </h5>
    <!-- list of featured reading -->
    <div class="scrollmenu">
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Ya Seen - يس" severity="success" raised outlined @click="selectSurah(36)" :class="{ active: surah === 36 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="An-Nas - 	الناس" severity="success" raised outlined @click="selectSurah(114)" :class="{ active: surah === 114 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Al-Falak - 	الفلق" severity="success" raised outlined @click="selectSurah(113)" :class="{ active: surah === 133 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Al-Kafiroon -	الكافرون" severity="success" raised outlined @click="selectSurah(109)" :class="{ active: surah === 109 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Al-Mulk - الملك" severity="success" raised outlined @click="selectSurah(67)" :class="{ active: surah === 67 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Al-Rahman - الرحمن" severity="success" raised outlined @click="selectSurah(55)" :class="{ active: surah === 55 }" />
       </div>
      </div>
     </a>
     <a href="#">
      <div class="col container">
       <div class="flex justify-content-center">
        <Button class="button-33" label="Al-Kahf -	الكهف" severity="success" raised outlined @click="selectSurah(18)" :class="{ active: surah === 18 }" />
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
          The Quran, considered the holy The
          Quran, also spelled as Qur'an, is
          the holy book of Islam and is
          considered by Muslims to be the
          literal word of God as revealed to
          the Prophet Muhammad (peace be upon
          him) through the Angel Gabriel.
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
          <a  href="#" class="list-group-item list-group-item-action" aria-current="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Play audio"><i class="bi-play-circle-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" aria-current="true" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi-bug-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy verse" @click="copyText"><i class="bi bi-collection-fill test" style="font-size: 1.2rem"></i></a>
          <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tooltip" data-bs-placement="top" title="Screenshot verse" @click="captureScreenshot"><i class="bi bi-camera-fill test" style="font-size: 1.2rem"></i></a>
         </div>
        </div>

        <div class="col-11">

        

         <!-- surah/ayah detail -->
         <ul class="ul-main row">
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
         <a :href="downloadUrl" class="button-33 mb-2 mt-2" download="fileName" v-if="downloadUrl">Download Screenshot</a>

         <!-- main stack top           
          <div v-for="(ayah, index) in ayahs" :key="index">
                  <p>{{ ayah.ayah_text }}</p>
                  <audio ref="audioPlayer" :src="ayah.audio_links" controls></audio>

              </div>
          -->
    
         <div ref="targetElement" class="btn">
          <div class="span-main text:left" style="font-style: bolder;color: black;"></div>
          <h3   class="container text-right" style="line-height: 2em">
           {{ information.ayah.ayah_text }}
           ({{ information.ayah.ayah_id }})
          </h3>
          <div v-for="(ayah, index) in filteredAyahs" :key="index">
          <p>{{ ayah.ayah_text }}</p>


         </div>
         <hr />
         <!-- main stack below -->
         <div class="btn">
          <h4 ref="heading" class="container text-left" style="line-height: 1.6em">
           <h3  name="text">
           {{ information.translation }}"
           </h3>
          </h4>
         </div>
        </div>
       </div>
      </div>
      </div>

      <!-- tafseer section -->
      <div class="tab-pane" id="profile" role="tabpanel" v-if="information != null">

       <!-- surah/ayah detail -->
       <ul class="ul-main row col-md-10">
        <h5 class="col-md-3 font-weight-bold"><img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" />{{information.ayah.surah.name_en}}</h5>
        <div class="col-md-6">
         <li class="li-main mr-3">
          <span class="span-main" style="font-style: bold">{{information.ayah.surah_id}}: {{ information.ayah.ayah_id }}
          </span>
         </li>
        </div>
        <h5 class="col-md-3 ">{{information.ayah.surah.name_ar}} <img src="/images/art1.png" style="width: 27px" class="mb-1 mr-2" /></h5>
       </ul>
       <hr>
       <!-- main stack top -->
       <div class="btn">
        <h3 class="container text-right" style="line-height: 2em">
         {{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})
        </h3>
       </div>
       <hr />
       <!-- main stack below -->
       <div class="btn">
        <h4 class="container text-left" style="line-height: 1.6em">
         {{ tafseer }}
        </h4>
       </div>
      </div>

      <!-- transliteration section -->
      <div class="tab-pane" id="messages" role="tabpanel" v-if="information != null">

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
       <hr>
       <!-- main stack top -->
       <div class="btn">
        <h3 class="container text-right" style="line-height: 2em">
         {{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})
        </h3>
       </div>
       <hr />
       <!-- main stack below -->
       <div class="btn">
        <h4 class="container text-left" style="line-height: 1.6em">
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
      <div class="custom-scrollbar">
       <ul class="col-md-4 list-group container-fluid root" v-for="(ayah, index) in ayahs" :key="index" @click="getTafseers(ayah.id, index)" :class="{selected: selectedIndexAyah === index,}">
        <li class="list-group-item container-fluid" id="toggle">
         <h5 style="display: flex">
          Verse: {{ ayah.ayah_id }}
         </h5>
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
import html2canvas from 'html2canvas';

export default {
 mounted() {
  this.getSurahs();
  this.fetchAyahs();
 },

 data() {
  return {
    fileName: 'screenshot.png',
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
 methods: {
   updateFileName() {
    if (this.information && this.information.ayah && this.information.ayah.surah && this.information.ayah.surah.name_ar) {
      this.fileName = this.information.ayah.surah.name_ar + '.png';
    }
   },
   captureScreenshot() {
      const targetElement = this.$refs.targetElement;

      // Use html2canvas to capture the target element
      html2canvas(targetElement).then(canvas => {
        // Convert canvas to data URL
        const dataUrl = canvas.toDataURL('image/png');
        
        // Set download URL
        this.downloadUrl = dataUrl;
      });
    },
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
 selectSurah(surahId) {
  this.surah = surahId;
  this.getAyahs(surahId); // Call the getAyahs method with the selected Surah ID
  // You can perform further actions, such as fetching data related to the selected Surah
 },

 async getAyahs() {
        try {
            // Make an HTTP request to fetch ayahs based on selected surah
            const response = await axios.get(`http://localhost:8000/api/ayahs?surah=${this.surah}`);
            // Assuming the response data contains ayahs
            this.ayahs = response.data;
        } catch (error) {
            console.error('Error fetching ayahs:', error);
        }
    },

  playAudio(audioSrc) {
        // Create an audio element dynamically
        const audio = new Audio(audioSrc);
        // Play the audio
        audio.play()
            .then(() => console.log('Audio is playing'))
            .catch(error => console.error('Error playing audio:', error));
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
