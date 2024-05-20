<template>
<div id="app">
 <div class="container-fluid text-center">
  <div class="row text-center">
   <!-- quran title -->
   <h1 class="card-text text-center mt-2 mb-2" style="font-family: inter">
    The Holy Quran
   </h1>

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
     <form @submit.prevent="createCorrection" id="reportForm">
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
        <input v-model="form.hadith_num" type="text" class="form-control" name="hadith_num" placeholder="Ayah number" aria-label="Ayah number" />
       </div>
       <div class="col">
        <select class="form-control" name="mistake_type" v-model="form.mistake_type">
         <option value="" disabled>Select Type</option>
         <option value="Spelling mistakes">Spelling mistakes</option>
         <option value="Translation error">Translation error</option>
         <option value="Reference mismatch">Reference mismatch</option>
        </select>
       </div>
      </div>
      <div class="row container mt-3">
       <textarea v-model="form.added_notes" class="form-control container mb-3" name="added_notes" placeholder="Explain to us exactly what the problem is" id="added_comments" rows="5"></textarea>
      </div>
     </form>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
     <button type="submit" form="reportForm" class="btn btn-success">Save changes</button>
    </div>
   </div>
  </div>
 </div>

 <!-- accordion headers-->
 <div class="row container-fluid">
  <!-- left side chapter list -->

  <div class="col-md-4  container">

   <form class="d-flex pb-1" @submit.prevent="search" >
    <input style="box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;" class="form-control me-2" type="search" id="search" name="search" v-model="searchTerm" placeholder="Search for Surah name" autocomplete="off" @keyup="search">
    <button v-if="showClearButton" class="btn btn-outline-secondary text-center width:100%" @click="clearResults">Clear</button>
   </form>

   <!-- Surah list -->
   <ul class="col-md-12 mt-1 scrollable-list " style="list-style-type: none; overflow-y: auto; max-height: 350px;">
    <li v-for="item in filteredSurah" :key="item.id" @click="selectSurah(item.id)" style="cursor: pointer; padding:5px;" class="highlight-on-hover">
     <div style="display: flex; align-items: center;">
      <img src="/images/art.png" style="width: 23px" class="mb-1 mr-2" />
      <p style="font-size: 18px;" class="mt-2">{{ item.name_en }} - {{ item.name_ar }}</p>
     </div>
    </li>
   </ul>

   <!-- list of ayat for surat -->
   <div class="tab-content hide-on-mobile" id="nav-tabContent" v-if="ayah == null && !dropdownHidden">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" v-if="ayah == null">
     <div class="row container-fluid">

      <!-- controls 
        <div class="row "> 
          <div class="col-md-4">
            <button class="btn button-33" @click="goToPreviousSurah">Previous Surah</button>
          </div>
          <div class="col-md-4">
            <button class="btn button-33" @click="goToNextSurah()">Next Surah</button>
          </div>
        </div>
      -->

      <form class="d-flex" @submit.prevent="scrollToAyah">
       <input class="form-control mb-2" type="number" placeholder="Enter Ayah Number" aria-label="Search" v-model="verseNumber" required>
       <button class="btn btn-success mb-2 ml-2" type="submit">Search</button>
      </form>

      <div class="custom-scrollbar" style="overflow-y: auto; max-height: 700px; background: white;">
       <ul class="col-md-4 list-group container-fluid root" id="toggle" ref="ayahList" style="list-style-type: none; padding: 10px">
        <li v-for="(ayah, index) in ayahs" :key="index" @click="getTafseers(ayah.id, index)" :class="{ selected: selectedIndexAyah === index, 'highlighted': verseNumber && parseInt(verseNumber) === ayah.ayah_id }" style="padding: 10px;border-radius:10px">
         <h5 style="display: flex;"> Verse: {{ ayah.ayah_id }} </h5>
         <h5>{{ ayah.ayah_text }}</h5>
        </li>
       </ul>
      </div>

     </div>
    </div>
   </div>

   <!-- list of ayah dropdown -->
   <div class="tab-content mb-2" id="nav-tabContent" v-if="ayah == null && !dropdownHidden">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" v-if="ayah == null">
     <form @change="handleSelectionChange" class="row container-fluid">
      <!-- Add a class to the select element for easier targeting -->
      <select class="form-control mobile-only hide-on-full-screen hide-on-tablet right-side-form" @change="getTafseers(ayahs[$event.target.value].id, $event.target.value)">
       <option value="0">
        <span>Select Ayah</span>
       </option>
       <option v-for="(ayah, index) in ayahs" :key="index" :value="index">{{ ayah.ayah_text }}</option>
      </select>
     </form>
    </div>
   </div>

  </div>

  <div class="col-md-8 card-hide">
   <!-- Nav tabs -->
   <div class="card " style="box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;">
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
        <div class="col-md-6">
         <img src="/images/calligraphy.png" class="pl-3" style="width: 70%" />
        </div>
        <div class="col-md-6 mt-4">
         <h5 style="line-height: 1.6em">
          The Holy Quran is the central religious text of Islam, believed by Muslims to be a revelation from God. It is written in Arabic and is considered the literal word of God as conveyed to Prophet Muhammad (peace be upon him).
         </h5>
        </div>
       </div>
      </div>

      <!-- translation section -->
      <div class="tab-pane active" id="home" role="tabpanel" v-if="information != null">
       <div class="row">

        <div class="col-12">
         <!-- surah/ayah detail -->
         <ul class="ul-main row ">
          <!-- ayah controls -->
          <div>

           <!-- Surah information -->
           <div class="row" ref="targetElement3">
            <h5 class="col-md-6 text-left pl-4 font-weight-bold" name="ayah_num"><img src="/images/art.png" style="width: 27px" class="mb-1 mr-2" />{{information.ayah.surah.name_en}} {{information.ayah.surah_id}}: {{ information.ayah.ayah_id }}</h5>
            <div class="col-md-6">
             <!-- Next surah button -->
             <div class="d-flex gap-2 justify-content-end">
              <button class="btn button-33 mr-2" @click="goToPreviousAyah()"><i class="bi bi-arrow-left-circle-fill"></i></button>
              <button class="btn button-33 " @click="goToNextAyah()"><i class="bi bi-arrow-right-circle-fill "></i></button>
             </div>
            </div>
           </div>

          </div>
         </ul>
         <hr style="border: 1px dotted grey">

         <div ref="targetElement3">
          <!-- main stack top -->
          <div class="btn zoomable">
           <h5 class="container text-right" style="line-height: 2em">{{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})</h5>
          </div>
          <hr />

          <!-- main stack below -->
          <div class="btn zoomable">
           <h5 class="container text-left" name="ayah_text" ref="heading" style="line-height: 1.6em">{{ information.translation }}</h5>
          </div>

          <!-- Bootstrap alert component -->
          <div v-if="showAlertText" class="alert alert-success alert-dismissible fade show" role="alert">
           Text copied successfully!
          </div>

          <!-- bookmark component -->
          <div v-if="showAlert" class="alert alert-success" role="alert">
           Bookmark created successfully!
          </div>
          <div v-if="showErrorAlert" class="alert alert-danger" role="alert">
           Login to your account to be able to bookmark verses.
          </div>

          <div v-if="showAlertTextNote" class="alert alert-danger" role="alert">
           Please log in to write a note.
          </div>

         </div>
         <!-- features -->
         <div class="text-right mt-2">

          <!-- notes modal -->
          <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="exampleModal1">
           <div class="modal-dialog modal-lg">
            <div class="modal-content">
             <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Write a Note</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">

              <!-- Note form -->
              <form @submit.prevent="createNote">

               <div class="row container mt-3">
                <h5 class="text-left pb-2" style="font-weight:bolder">Notes & Reflections</h5>

                <div class="col">
                 <textarea v-model="form1.ayah_notes" class="form-control container mb-3" name="ayah_notes" placeholder="Save your notes and personal reflections privately. Oftentimes your reflections can deeply resonate with your connection to the Quran, and your relationship with Allah ?." rows="8"></textarea>
                </div>
               </div>
               <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Submit</button>
               </div>
              </form>
             </div>
            </div>
           </div>
          </div>

          <!--
          <i class="bi bi-cloud-arrow-down-fill mt-1 h3" style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" title="Download Verse" @click="exportToCSV"></i>
          -->
          <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-file-earmark-text-fill text-right h4" aria-expanded="false" data-bs-placement="top" title="Write a note" data-bs-toggle="modal" data-bs-target="#exampleModal1" @click="openNoteModal"></i>
          <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-whatsapp text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via whatsapp" @click="shareTextViaWhatsApp3()"></i>
          <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X" @click="shareHeadingOnTwitter3()"></i>
          <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-bookmark text-right h4" aria-expanded="false" data-bs-placement="top" title="Save bookmark" @click="submitForm"></i>

          <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-clipboard-check-fill text-right h4" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy verse" @click="copyText"></i>

          <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-camera-fill text-right h4" data-bs-toggle="tooltip" data-bs-placement="top" title="Screenshot verse" @click="captureScreenshot3"></i>
          <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-bug-fill text-right h4" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
         </div>
        </div>
       </div>
      </div>

      <!-- tafseer section -->
      <div class="tab-pane" id="profile" role="tabpanel" v-if="information != null">
       <div class="row">

        <div class="col-12">
         <!-- surah/ayah detail -->
         <ul class="ul-main row ">
          <!-- ayah controls -->
          <div>

           <!-- Surah information -->
           <div class="row" ref="targetElement">
            <h5 class="col-md-6 text-left pl-4 font-weight-bold" name="ayah_num"><img src="/images/art.png" style="width: 27px" class="mb-1 mr-2" />{{information.ayah.surah.name_en}} {{information.ayah.surah_id}}: {{ information.ayah.ayah_id }}</h5>
            <div class="col-md-6">
             <div class="d-flex gap-2 justify-content-end">
              <button class="btn button-33 mr-2" @click="goToPreviousAyah()"><i class="bi bi-arrow-left-circle-fill"></i></button>
              <button class="btn button-33 " @click="goToNextAyah()"><i class="bi bi-arrow-right-circle-fill "></i></button>
             </div>
            </div>
           </div>

          </div>
         </ul>
         <hr style="border: 1px dotted grey">
         <div>
          <div ref="targetElement1">
           <!-- main stack top -->
           <div class="btn zoomable">
            <h5 class="container text-right" style="line-height: 2em">{{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})</h5>
           </div>
           <hr />

           <!-- main stack below -->
           <div class="btn zoomable">
            <h5 class="container text-left" name="ayah_text" ref="heading1" style="line-height: 1.6em">{{ tafseer }}</h5>
           </div>
          </div>

          <!-- Bootstrap alert component -->
          <div v-if="showAlertText" class="alert alert-success alert-dismissible fade show" role="alert">
           Text copied successfully!
          </div>

          <!-- bookmark component -->
          <div v-if="showAlert" class="alert alert-success" role="alert">
           Bookmark created successfully!
          </div>
          <div v-if="showErrorAlert" class="alert alert-danger" role="alert">
           Login to your account to be able to bookmark verses.
          </div>
          <!-- features -->

          <div class="text-right mt-2 mr-3 container">

           <div>
            <!-- Your other components and code -->

            <!-- Notes Modal -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="exampleModal2">
             <div class="modal-dialog modal-lg">
              <div class="modal-content">
               <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Write a Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                <!-- Note form -->
                <form @submit.prevent="createNote">
                 <div class="row container mt-3">
                  <h5 class="text-left pb-2" style="font-weight:bolder">Notes & Reflections</h5>
                  <div class="col">
                   <textarea v-model="form1.ayah_notes" class="form-control container mb-3" name="ayah_notes" placeholder="Save your notes and personal reflections privately. Oftentimes your reflections can deeply resonate with your connection to the Quran, and your relationship with Allah." rows="8"></textarea>
                  </div>
                 </div>
                 <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Submit</button>
                 </div>
                </form>
               </div>
              </div>
             </div>
            </div>
           </div>

           <!--
           <i class="bi bi-cloud-arrow-down-fill mt-1 h3" style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" title="Download Verse" @click="exportToCSV2"></i>
           -->
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-file-earmark-text-fill text-right h4" aria-expanded="false" data-bs-placement="top" title="Write a note" data-bs-toggle="modal" data-bs-target="#exampleModal2" @click="openNoteModal"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-whatsapp text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via whatsapp" @click="shareTextViaWhatsApp1()"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X" @click="shareHeadingOnTwitter1()"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-bookmark text-right h4" aria-expanded="false" data-bs-placement="top" title="Save bookmark" @click="submitForm1"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-clipboard-check-fill text-right h4" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy verse" @click="copyText1"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-camera-fill text-right h4" data-bs-toggle="tooltip" data-bs-placement="top" title="Screenshot verse" @click="captureScreenshot1"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-bug-fill text-right h4" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
          </div>
         </div>
        </div>
       </div>
      </div>

      <!-- transliteration section -->
      <div class="tab-pane" id="messages" role="tabpanel" v-if="information != null">
       <div class="row">

        <div class="col-12">
         <!-- surah/ayah detail -->
         <ul class="ul-main row ">
          <!-- ayah controls -->
          <div>

           <!-- Surah information -->
           <div class="row" ref="targetElement2">
            <h5 class="col-md-6 text-left pl-4 font-weight-bold" name="ayah_num"><img src="/images/art.png" style="width: 27px" class="mb-1 mr-2" />{{information.ayah.surah.name_en}} {{information.ayah.surah_id}}: {{ information.ayah.ayah_id }}</h5>
            <div class="col-md-6">
             <div class="d-flex gap-2 justify-content-end">
              <button class="btn button-33 mr-2" @click="goToPreviousAyah()"><i class="bi bi-arrow-left-circle-fill"></i></button>
              <button class="btn button-33 " @click="goToNextAyah()"><i class="bi bi-arrow-right-circle-fill "></i></button>
             </div>
            </div>
           </div>

          </div>
         </ul>
         <hr style="border: 1px dotted grey">
         <div>
          <div ref="targetElement2">
           <!-- main stack top -->
           <div class="btn zoomable">
            <h5 class="container text-right" style="line-height: 2em">{{ information.ayah.ayah_text }} ({{ information.ayah.ayah_id }})</h5>
           </div>
           <hr />

           <!-- main stack below -->
           <div class="btn zoomable">
            <h5 class="container text-left" name="ayah_text" ref="heading2" style="line-height: 1.6em">{{ information.transliteration }}</h5>
           </div>
          </div>

          <!-- Bootstrap alert component -->
          <div v-if="showAlertText" class="alert alert-success alert-dismissible fade show" role="alert">
           Text copied successfully!
          </div>

          <!-- bookmark component -->
          <div v-if="showAlert" class="alert alert-success" role="alert">
           Bookmark created successfully!
          </div>
          <div v-if="showErrorAlert" class="alert alert-danger" role="alert">
           Login to your account to be able to bookmark verses.
          </div>

          <!-- features -->
          <div class="text-right mt-2">
           <!-- notes modal -->
           <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="exampleModal3">
            <div class="modal-dialog modal-lg">
             <div class="modal-content">
              <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Write a Note</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

               <form @submit.prevent="createNote">

                <div class="row container mt-3">
                 <h5 class="text-left pb-2" style="font-weight:bolder">Notes & Reflections</h5>

                 <div class="col">
                  <textarea v-model="form1.ayah_notes" class="form-control container mb-3" name="ayah_notes" placeholder="Save your notes and personal reflections privately. Oftentimes your reflections can deeply resonate with your connection to the Quran, and your relationship with Allah ?." rows="8"></textarea>
                 </div>
                </div>
                <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-success">Submit</button>
                </div>
               </form>
              </div>
             </div>
            </div>
           </div>
           <!--
           <i class="bi bi-cloud-arrow-down-fill mt-1 h3" style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" title="Download Verse" @click="exportToCSV2"></i>
           -->
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-file-earmark-text-fill text-right h4" aria-expanded="false" data-bs-placement="top" title="Write a note" data-bs-toggle="modal" data-bs-target="#exampleModal3" @click="openNoteModal"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-whatsapp text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via whatsapp" @click="shareTextViaWhatsApp2()"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X" @click="shareHeadingOnTwitter2()"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-bookmark text-right h4" aria-expanded="false" data-bs-placement="top" title="Save bookmark" @click="submitForm2"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-clipboard-check-fill text-right h4" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy verse" @click="copyText2"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-camera-fill text-right h4" data-bs-toggle="tooltip" data-bs-placement="top" title="Screenshot verse" @click="captureScreenshot2"></i>
           <i style="padding:10px; color:rgb(0, 191, 166); cursor:pointer" class="bi bi-bug-fill text-right h4" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
          </div>
         </div>
        </div>

       </div>
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
   isLoggedIn: false,
   bookmarkSubmitted: false,
   bookmarkSubmitted: JSON.parse(localStorage.getItem('bookmarkSubmitted')) || {},
   selectedCategory: '',
   verseNumber: null,
   showClearButton: false,
   searchTerm: '', // Search term entered by the user
   filteredSurah: [], // Array to hold filtered surahs based on search term,
   selectedSurahId: '',
   boxSize: 0, // Initial size of the box
   isExpanded: false,
   isCardVisible: false,
   showModal: false,
   timer: null,
   showScreenshotButton: false,
   selectedIndexAyah: -1,
   selectedAyah: null,
   downloadUrl: null,
   transition: [], // Your list of ayahs
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
   surah: [],
   surah: null,
   ayah: null,
   tafseer: null,
   information: null,
   ayah_id: null,
   name_en: null,
   id: null,
   surah: 0,
   isPlaying: false,
   textContent: "",
   ayah_num: "",
   ayah_text: "",
   showAlert: false,
   showAlertText: false,
   translation: '',
   transliteration: '',
   tafseer: '',

   form1: new Form({
    id: "",
    surah_name: "",
    ayah_num: "",
    ayah_verse_ar: "",
    ayah_verse_en: "",
    ayah_notes: "",
   }),

   form: new Form({
    id: "",
    name: "",
    email: "",
    mistake_type: "",
    added_notes: "",
    hadith_num: "",
   }),

   searchFilters: new Form({
    name_en: "",
    name_ar: ""
   }),
  };
 },
 computed: {
  filteredAyahs() {
   // Filter ayahs based on selected surah
   if (!this.surah) return [];
   return this.ayahs.filter(ayah => ayah.surah_id === this.surah);
  },
  currentSurah() {
   return this.surahs[this.surah];
  },
  currentAyah() {
   return this.ayahs[this.selectedIndexAyah];
  }
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
    // Update the audio source with the selected ayah's audio_link
    this.$refs.audioPlayer.src = this.selectedAyah.audio_link;
   }
  } catch (error) {
   console.error('Error fetching ayahs:', error);
  }
 },

 methods: {
  exportToCSV() {
   // Extract the content from the data object
   const formData = {
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.information.translation,
   };

   // Convert formData to a CSV string
   const csvContent = `Surah Name,Ayah Number,Ayah Verse (AR),Ayah Verse (EN)\n${formData.surah_name},${formData.ayah_num},${formData.ayah_verse_ar},${formData.ayah_verse_en}`;

   // Create and download the CSV file
   this.downloadCSV(csvContent, 'export.csv');
  },

  submitCat() {
   const formData = {
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.information.translation,
    category_id: this.selectedCategory
   };
   // Axios request
  },
  scrollToAyah() {
   const verseNum = parseInt(this.verseNumber);
   if (!isNaN(verseNum) && verseNum >= 1 && verseNum <= this.ayahs.length) {
    const ayahElement = this.$refs.ayahList.querySelectorAll("li")[verseNum - 1];
    if (ayahElement) {
     ayahElement.scrollIntoView({
      behavior: "smooth",
      block: "start"
     });
    }
   } else {
    alert("Please enter a valid ayah number.");
   }
  },
  submitForm() {
   const formData = {
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.information.translation,
   };

   axios.post('/bookmarks', formData)
    .then(response => {
      console.log(response.data.message);
      // Set the submitted status for the selected bookmark
      localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
      // Log the updated bookmarkSubmitted object
      console.log(this.bookmarkSubmitted);
      this.showAlert = true; // Show success alert
      this.showErrorAlert = false; // Hide error alert
      this.hideAlertAfterDelay(); // Start timer to hide alert
    })
    .catch(error => {
      console.error(error);
      this.showAlert = false; // Hide success alert
      this.showErrorAlert = true; // Show error alert
      Swal.fire({
        title: "Error!",
        text: "You need to be logged in to create a bookmark.",
        icon: "error",
        confirmButtonText: "OK"
      });
      this.hideAlertAfterDelay(); // Start timer to hide alert
    });
  },
  submitForm1() {
   const formData = {
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.tafseer,
   };

   axios.post('/bookmarks', formData)
    .then(response => {
      console.log(response.data.message);
      // Set the submitted status for the selected bookmark
      localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
      // Log the updated bookmarkSubmitted object
      console.log(this.bookmarkSubmitted);
      this.showAlert = true; // Show success alert
      this.showErrorAlert = false; // Hide error alert
      this.hideAlertAfterDelay(); // Start timer to hide alert
    })
    .catch(error => {
      console.error(error);
      this.showAlert = false; // Hide success alert
      this.showErrorAlert = true; // Show error alert
      Swal.fire({
        title: "Error!",
        text: "You need to be logged in to create a bookmark.",
        icon: "error",
        confirmButtonText: "OK"
      });
      this.hideAlertAfterDelay(); // Start timer to hide alert
    });
  },
  submitForm2() {
   const formData = {
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.information.transliteration,
   };

   axios.post('/bookmarks', formData)
    .then(response => {
      console.log(response.data.message);
      // Set the submitted status for the selected bookmark
      localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
      // Log the updated bookmarkSubmitted object
      console.log(this.bookmarkSubmitted);
      this.showAlert = true; // Show success alert
      this.showErrorAlert = false; // Hide error alert
      this.hideAlertAfterDelay(); // Start timer to hide alert
    })
    .catch(error => {
      console.error(error);
      this.showAlert = false; // Hide success alert
      this.showErrorAlert = true; // Show error alert
      Swal.fire({
        title: "Error!",
        text: "You need to be logged in to create a bookmark.",
        icon: "error",
        confirmButtonText: "OK"
      });
      this.hideAlertAfterDelay(); // Start timer to hide alert
    });
  },
  hideAlertAfterDelay() {
   setTimeout(() => {
    this.showAlert = false;
    this.showAlertText = false;
    this.showErrorAlert = false;
   }, 3000); // Adjust the duration (in milliseconds) as needed
  },
  clearResults() {
   this.searchTerm = ''; // Clear the search term
   this.filteredSurah = []; // Clear the filtered results
   this.showClearButton = false; // Hide the clear button after clearing results
  },
  getAyahs() {
   if (this.selectedSurahId) {
    axios.post("/getAyahs", {
      surahId: this.selectedSurahId
     })
     .then(response => {
      if (response.data.length > 0) {
       this.surah = response.data; // Update surah array with data from API
      } else {
       console.warn("No ayahs found for the selected surah");
       // Optionally, you can clear the surah array if no ayahs are found
       // this.surah = [];
      }
     })
     .catch(error => {
      console.error("API Error:", error); // Log any errors
     });
   } else {
    console.warn("No surah selected");
    // Optionally, you can clear the surah array if no surah is selected
    // this.surah = [];
   }
  },
  search() {
   // Perform search and update filteredSurah based on search term
   const searchTerm = this.searchTerm.trim().toLowerCase();
   if (searchTerm === '') {
    this.filteredSurah = [];
    this.showClearButton = false;
    return;
   }
   this.filteredSurah = this.surahs.filter(surah => {
    const nameEn = surah.name_en.toLowerCase();
    const nameAr = surah.name_ar.toLowerCase();
    return nameEn.includes(searchTerm) || nameAr.includes(searchTerm);
   });
   this.showClearButton = true; // Show clear button after search
  },
  showCard() {
   this.isCardVisible = true; // Show the card when button is clicked
  },

  goToNextAyah() {
   if (this.selectedIndexAyah < this.ayahs.length - 1) {
    this.selectedIndexAyah++;
   } else {
    this.selectedIndexAyah = 0;
   }
   this.scrollToSelectedAyah();
   this.getTafseers(this.ayahs[this.selectedIndexAyah].id, this.selectedIndexAyah);
  },
  goToPreviousAyah() {
   if (this.selectedIndexAyah > 0) {
    this.selectedIndexAyah--;
   } else {
    this.selectedIndexAyah = this.ayahs.length - 1;
   }
   this.scrollToSelectedAyah();
   this.getTafseers(this.ayahs[this.selectedIndexAyah].id, this.selectedIndexAyah);
  },
  scrollToSelectedAyah() {
   const list = this.$refs.ayahList;
   const selectedAyah = list.querySelector('.selected');

   if (selectedAyah) {
    selectedAyah.scrollIntoView({
     behavior: 'smooth',
     block: 'center',
     inline: 'nearest'
    });
   }
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
   if (this.surah > 0) {
    // Decrement the surah index to move to the previous surah
    this.surah--;
   } else {
    // If already at the first surah, loop to the last surah
    this.surah = this.surahs.length - 1;
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

  shareHeadingOnTwitter3() {
   try {
    const headingText3 = this.$refs.targetElement3.textContent.trim();
    const encodedHeading = encodeURIComponent(headingText3);
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

  shareTextViaWhatsApp3() {
   const text3 = this.$refs.targetElement3.innerText;
   const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(text3)}`;
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

  captureScreenshot3() {
   const targetElement3 = this.$refs.targetElement3;

   // Capture screenshot for targetElement after 5 seconds
   setTimeout(() => {
    html2canvas(targetElement3).then(canvas => {
     const dataUrl = canvas.toDataURL('image/png');
     this.downloadUrl = dataUrl;

     // Simulate click on download link after 2 seconds
     setTimeout(() => {
      const downloadLink = document.createElement('a');
      downloadLink.href = dataUrl;
      downloadLink.download = 'screenshot.png';
      downloadLink.click();
     }, 10); // 2000 milliseconds = 2 seconds
    });
   }, 10); // 5000 milliseconds = 5 seconds
  },

  captureScreenshot1() {
   const targetElement1 = this.$refs.targetElement1;

   // Capture screenshot for targetElement after 5 seconds
   setTimeout(() => {
    html2canvas(targetElement1).then(canvas => {
     const dataUrl = canvas.toDataURL('image/png');
     this.downloadUrl = dataUrl;

     // Simulate click on download link after 2 seconds
     setTimeout(() => {
      const downloadLink = document.createElement('a');
      downloadLink.href = dataUrl;
      downloadLink.download = 'screenshot.png';
      downloadLink.click();
     }, 10); // 2000 milliseconds = 2 seconds
    });
   }, 10); // 5000 milliseconds = 5 seconds
  },

  captureScreenshot2() {
   const targetElement2 = this.$refs.targetElement2;

   // Capture screenshot for targetElement after 5 seconds
   setTimeout(() => {
    html2canvas(targetElement2).then(canvas => {
     const dataUrl = canvas.toDataURL('image/png');
     this.downloadUrl = dataUrl;

     // Simulate click on download link after 2 seconds
     setTimeout(() => {
      const downloadLink = document.createElement('a');
      downloadLink.href = dataUrl;
      downloadLink.download = 'screenshot.png';
      downloadLink.click();
     }, 10); // 2000 milliseconds = 2 seconds
    });
   }, 10); // 5000 milliseconds = 5 seconds
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

  getAyahs() {
   try {
    // Fetch ayahs data
    // ...

    // Assign selectedAyah
    if (this.ayahs.length > 0) {
     this.selectedAyah = this.ayahs[0];
     console.log('Selected Ayah:', this.selectedAyah);
    } else {
     console.warn("No ayahs found in the response data.");
    }
   } catch (error) {
    console.error('Error fetching ayahs:', error);
   }
  },
  selectSurah(surahId) {

   this.surah = surahId;
   this.searchTerm = ''; // Clear the search term
   this.filteredSurah = []; // Clear the filtered results
   this.showClearButton = false; // Hide the clear button after clearing results
   this.getAyahs(); // Call the getAyahs method with the selected Surah ID

  },
  // Function to close the modal
  // Function to open the modal
  openModal() {
   this.showModal = true;
  },
  // Function to close the modal
  closeModal() {
   this.showModal = false;
  },
  createCorrection() {
   Swal.fire({
    title: "Are you sure?",
    text: "You want to submit message!",
    showCancelButton: true,
    confirmButtonColor: "green",
    cancelButtonColor: "#d33",
    confirmButtonText: "Submit!",
   }).then((result) => {
    if (result.isConfirmed) {
     axios
      .post("/api/submit-correction", this.form)
      .then((res) => {
       if (!res.data.success) {
        Swal.fire({
         position: "top-end",
         icon: "success",
         title: "Message submitted succesfully",
         showConfirmButton: false,
         timer: 1500,
        });
        // Close the modal after successful submission
        this.resetForm();
        $('#exampleModal').modal('hide');
       } else if (res.data.success) {
        Swal.fire(
         "Error!",
         "Unable to create correction.",
         "error"
        );
       }
       this.resetForm();
        $('#exampleModal').modal('hide');
      })
      this.resetForm();
      $('#exampleModal').modal('hide');
    }
   });
  },

  createNote() {
    Swal.fire({
      title: "Are you sure?",
      text: "You want to submit the note!",
      showCancelButton: true,
      confirmButtonColor: "green",
      cancelButtonColor: "#d33",
      confirmButtonText: "Submit!",
    }).then((result) => {
      if (result.isConfirmed) {
        axios
          .post("/api/submit-note", this.form1)
          .then((res) => {
            if (res.data.success) {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Note saved successfully",
                showConfirmButton: false,
                timer: 1500,
              });
              // Close the modal after successful submission
              this.resetForm();
              $('#exampleModal1').modal('hide');
            } else {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Note saved successfully",
                showConfirmButton: false,
                timer: 1500,
              });
              this.resetForm();
              $('#exampleModal1').modal('hide');
            }
          })
          .catch((error) => {
            if (error.response && error.response.status === 401) {
              Swal.fire("Error!", "You need to be logged in to create a note.", "error");
              this.resetForm();
              $('#exampleModal1').modal('hide');
            } 
          });
      }
    });
  },

  resetForm() {
   this.form.reset();
   this.form1.reset();
   const exampleModal2 = bootstrap.Modal.getInstance(this.$refs.exampleModal2);
   if (exampleModal2) {
    exampleModal2.hide();
   }
  },

  copyText() {
   console.log(this.$refs.heading);
   var textToCopy = this.$refs.heading.innerText;
   console.log(textToCopy);
   // Copy the text to the clipboard
   this.copyToClipboard(textToCopy);
   this.showAlertText = true; // Show success alert
   this.showErrorAlert = false; // Hide error alert
   this.hideAlertAfterDelay(); // Start timer to hide alert
  },

  copyText1() {
   console.log(this.$refs.heading1);
   var textToCopy1 = this.$refs.heading1.innerText;
   console.log(textToCopy1);
   this.copyToClipboard(textToCopy1);
   this.showAlertText = true; // Show success alert
   this.showErrorAlert = false; // Hide error alert
   this.hideAlertAfterDelay(); // Start timer to hide alert
  },

  copyText2() {
   // Log the reference to ensure it's correct
   console.log(this.$refs.heading2);

   // Access the text content from the reference
   var textToCopy2 = this.$refs.heading2.innerText;

   // Log the text content to ensure it's correct
   console.log(textToCopy2);

   // Copy the text to the clipboard
   this.copyToClipboard(textToCopy2);
   this.showAlertText = true; // Show success alert
   this.showErrorAlert = false; // Hide error alert
   this.hideAlertAfterDelay(); // Start timer to hide alert
  },

  copyToClipboard(text) {
   // Create a textarea element to copy the text
   var textarea = document.createElement("textarea");

   // Set the value of the textarea to the text to be copied
   textarea.value = text;

   // Append the textarea to the document body
   document.body.appendChild(textarea);

   // Select the text within the textarea
   textarea.select();

   // Execute the copy command to copy the selected text
   document.execCommand("copy");

   // Remove the textarea from the document body
   document.body.removeChild(textarea);

   // Log a success message
   console.log("Text copied to clipboard:", text);
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
 created() {
  // Initialize submitted status for each bookmark
  this.ayahs.forEach(ayah => {
   const submitted = localStorage.getItem(`bookmarkSubmitted_${ayah.id}`);
   if (submitted) {
    this.$set(this.bookmarkSubmitted, ayah.id, true);
   }
  });
 },

 watch: {
  'information.ayah.surah.name_ar': 'updateFileName',
  verseNumber(newVal, oldVal) {
   if (newVal !== oldVal && parseInt(newVal)) {
    this.selectedIndexAyah = parseInt(newVal) - 1;
   }
  },

 }
};
</script>

<style scoped>
.selected {
 background-color: yellow;
 /* Change to any desired highlight color */
}

.highlighted {
 background-color: lightblue;
 /* Change to any desired highlight color */
}

.highlight-on-hover:hover {
 background-color: rgba(16, 247, 216, 0.192);
 /* Change to your desired highlight color */
 border-radius: 10px;
 padding: 15px;
}

.zoomable {
 transition: transform 0.4s;
 /* Smooth transition effect */
}

.zoomable:hover {
 transform: scale(1.1);
 /* Zoom in effect */
}

.custom-icon {
 font-size: 1.3rem;
 /* Adjust the font-size as needed */
}

#movingDiv {
 /* Position the div absolutely */
 position: absolute;
 /* Place the div at the top-left corner of the viewport */
 top: 0;
 left: 0;
 /* Add more styling as needed */
 background-color: #ffffff;
 border: 1px solid #000000;
 padding: 10px;
 /* Adjust z-index to ensure it's on top of other content */
 z-index: 9999;
}

/* Hide on full-screen sizes */
@media (min-width: 992px) {
 .hide-on-full-screen {
  display: none;
 }
}

@media (max-width: 991.98px) {
 .hide-on-full-screen {
  display: none;
 }
}

@media (max-width: 575px) {

 /* Hide the content on mobile devices */
 .hide-on-mobile {
  display: none;
 }

 .custom-dropdown {
  max-height: 200px;
  /* Adjust the value as needed */
  overflow-y: auto;
 }
}

@media (max-width: 768px) {

 /* Hide the content on mobile devices */
 .hide-on-mobile {
  display: none;
 }

 .hide-on-tablet {
  display: unset;
 }

 .custom-dropdown {
  max-height: 200px;
  /* Adjust the value as needed */
  overflow-y: auto;
 }

}

/* Define a media query for full-screen devices */
@media screen and (min-width: 1024px) {

 /* Select the element with the class hide-on-full-screen and hide it */
 .hide-on-full-screen {
  display: none;
 }
}

/* Media query for mobile screens */
@media screen and (max-width: 768px) {
 #movingDiv {
  /* Adjust positioning for smaller screens */
  /* For example, center the div horizontally */
  transform: translateX(-50%);
  /* You can adjust other styles as needed for mobile */
 }

 /* Initially visible */
 .targetDiv {
  display: block;
 }

 /* Hide when the corresponding anchor link is targeted */
 .targetDiv:target {
  display: none;
 }

 .scrollable-list {
  overflow-x: auto;
 }
}

.list-group-item-action:hover {
 background-color: rgba(0, 191, 166, 0.452);
}

.list-group-item {
 border: none;
}

.button-33 {
 background-color: rgba(0, 191, 166);
 border-radius: 10px;
 color: white;
 cursor: pointer;
 display: inline-block;
 font-family: inter;
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

.list-group-item {
 cursor: pointer;
 background: transparent;
 padding: 10px;
}

.list-group {
 min-width: 100%;
 cursor: pointer;
}

.right-side-form {
 border: 1px solid rgb(65, 66, 66);
 border-radius: 8px;
}

.card {
 display: flex;
 border: 1px solid #00BFA6;
 padding: 10px;
 border-radius: 10px;
}

.card-text {
 line-height: 1.7em;
}

.selected {
 background-color: rgba(0, 191, 166, 0.452);
}

.horizontal-scroll-wrapper {
 overflow-x: scroll;
 overflow-y: hidden;
 white-space: nowrap;
 width: 600px;
}

.custom-scrollbar {
 background-color: transparent;
 height: 100%;
 width: 100%;
 border-radius: 6px;
 border: 1px solid #d6dee1;
 padding: 1rem;
 border-radius: 6px;
 border: 1px solid #d6dee1;
 padding: 1rem;
 background-color: transparent;
 overflow: scroll;
 background: transparent;
 border: 1px solid #00BFA6;
}

.custom-scrollbar-chapters {
 background-color: transparent;
 height: 600px;
 width: 100%;
 border-radius: 6px;
 border: 1px solid #d6dee1;
 padding: 1rem;
 border-radius: 6px;
 border: 1px solid #d6dee1;
 padding: 1rem;
 color: white;
 background-color: transparent;
 outline: 1px solid #00BFA6;
 overflow: scroll;
}

.myButton {
 background-color: #00BFA6;
 border-radius: 8px;
 display: inline-block;
 cursor: pointer;
 color: #000;
 font-family: inter;
 font-size: 18px;
 padding: 13px 32px;
 text-decoration: none;
}

p.no-after:after {
 content: none;
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
 background-color: #00BFA6;
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
 font-family: inter;
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
