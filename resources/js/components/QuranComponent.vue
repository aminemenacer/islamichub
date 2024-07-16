<template>
<div id="app">

 <div class="container text-center" v-if="!ayah && dropdownHidden">
  <!-- quran title -->
  <Title />
  <!-- Search bar  -->
  <SearchForm  />
  <!-- custom surah selection -->
  <custom-surah-selection :customSurahs="customSurahs" v-model="surah"></custom-surah-selection>
 </div>

 <!-- accordion headers-->
 <div class="row container-fluid">
  <div class="col-md-4 container">
   <!--  Surah list dropdown from search bar -->
   <ul class="col-md-12 mt-1 scrollable-list " style="list-style-type: none; overflow-y: auto; max-height: 400px; box-shadow: box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
    <li v-for="item in filteredSurah" :key="item.id" @click="selectSurah(item.id)" style="cursor: pointer; padding:5px;box-shadow: box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius:5px; " class="highlight-on-hover">
     <div style="display: flex; align-items: center;">
      <img src="/images/art.png" style="width: 23px" class="mb-1 mr-2" />
      <p style="font-size: 18px;" class="mt-2">{{ item.name_en }} - {{ item.name_ar }}</p>
     </div>
    </li>
   </ul>
   <!-- donation message -->
   <Donation />
   
   <!-- Surah Selection Dropdown (mobile) -->
    <form class="mb-2 right-side-form" style="cursor: pointer; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;">
      <select class="form-control custom-dropdown" aria-placeholder="Select Surah" v-model="surah" @change="getAyahs()" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
        <option value="" aria-placeholder="Select Surah" disabled selected >Select Surah</option>
        <option v-for="data in surahs" :key="data.id" :value="data.id" @click="showCard">
          {{ data.id }} : {{ data.name_en }} - {{ data.name_ar }}
        </option>
      </select>
    </form>

    <!-- Ayah Dropdown (mobile) -->
    <div class="tab-content mb-1" id="nav-tabContent" v-if="ayah == null && !dropdownHidden">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <form @change="handleSelectionChange" style="cursor: pointer; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius:5px; ">
          <!-- Add a class to the select element for easier targeting -->
          <select class="form-control mobile-only hide-on-full-screen hide-on-tablet right-side-form" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" @change="getTafseers(ayahs[$event.target.value].id, $event.target.value)">
          <option value="0">
            <span disabled>Select Ayah</span>
          </option>
          <option v-for="(ayah, index) in ayahs" :key="index" :value="index">{{ ayah.ayah_text }} : {{ayah.ayah_id}}</option>
          </select>
        </form>
      </div>
    </div>
   
   <!-- List of Ayat for Surah (desktop) -->
   <div class="tab-content hide-on-mobile-tablet" id="nav-tabContent" v-if="ayah == null && !dropdownHidden">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" v-if="ayah == null">
     <form class="d-flex pb-2 " role="search" @submit.prevent="scrollToAyah">
      <input class="form-control me-2" type="number" placeholder="Enter Verse Number" v-model="verseNumber" required>
      <button class="btn btn-success mb-1 ml-2" type="submit">Search</button>
     </form>

     <!-- Bootstrap error alert -->
     <div v-if="showError" class="alert alert-danger alert-dismissible fade show" role="alert">
      Please enter a valid ayah number.
      <button type="button" class="btn-close" @click="dismissError" aria-label="Close"></button>
     </div>

     <div class="row container-fluid">
      <hr class="container" style="height: 4px; background: lightgrey;">
      
      <div class="icon-container pb-2">
        <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToFirstAyah" title="First verse"></i>
        <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToPreviousAyah" title="Previous verse"></i>
        <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToNextAyah" title="Next verse"></i>
        <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToLastAyah" title="Last verse"></i>
      </div>
   
      <div class="custom-scrollbar pb-5" style="overflow-y: auto; max-height: 600px; background: white;">
       <ul class="col-md-12 list-group container-fluid root" id="toggle" ref="ayahList" style="list-style-type: none; padding: 10px">
        <li v-for="(ayah, index) in ayahs" :key="index" @click="selectAyah(index)" :class="{ selected: selectedIndexAyah === index, highlighted: verseNumber && parseInt(verseNumber) === ayah.ayah_id }" style="padding: 10px; border-radius:10px">
         <h5 class="text-right" style="display: flex;"> Verse: {{ ayah.ayah_id }} </h5>
         <h5 class="text-right">{{ ayah.ayah_text }}</h5>
        </li>
       </ul>
      </div>
     </div>

    </div>
   </div>
  </div>

  <div class="col-md-8 pt-2 card-hide">

   <div class="card pt-2" style="box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;">

    <div class="container-fluid" v-if="information != null">
     <!-- navigation tabs -->
     <NavTabs />
    </div>

    <div class="card-body" id="alertContainer">
     <div class="tab-content text-center">
      <!-- Intro welcome message -->
      <Welcome :information="information" />

      <!-- Translation Section -->
      <div class="tab-pane active" id="home" role="tabpanel" v-if="information != null">
       <div class="icon-container pb-3">
        <div class="icon-container w-100 hide-on-mobile pb-3">
         <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" data-bs-toggle="modal" data-bs-target="#translationNote" style="color: rgba(0, 191, 166);cursor:pointer"></i>
         <i class="bi bi-whatsapp text-right mr-2 h4" @click="shareTextViaWhatsApp3" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166);cursor:pointer"></i>
         <i style=" color:rgb(0, 191, 166); cursor:pointer" @click="shareHeadingOnTwitter3" class="mr-2 bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X"></i>
         <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
         <i class="bi bi-clipboard-check text-right mr-2 h4" @click="copyText3" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
         <i class="bi bi-camera text-right mr-2 h3" @click="captureScreenshot3" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166); cursor:pointer"></i>
         <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
         <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
         <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#translationInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i>
        </div>
        <!-- Dropdown Features -->
        <div class="dropdown mobile-only">
         <div class=" icon-container">
          <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166);" @click="goToFirstAyah()" title="First verse"></i>
          <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166);" @click="goToPreviousAyah()" title="Previous verse"></i>
          <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166);" @click="goToNextAyah()" title="Next verse"></i>
          <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166);" @click="goToLastAyah()" title="End verse"></i>
          <i class="bi bi-arrows-fullscreen h6" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>

          <i style="color:rgb(0, 191, 166); cursor:pointer" class="bi bi-three-dots-vertical h5 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>
          <ul class="dropdown-menu">
           <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#translationNote"><i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" style="color: rgba(0, 191, 166);"></i>Write a Note</a></li>
           <li><a class="dropdown-item" @click="shareTextViaWhatsApp3"><i class="bi bi-whatsapp text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166);"></i>Share via WhatsApp</a></li>
           <li><a class="dropdown-item" @click="shareHeadingOnTwitter3"><i style=" color:rgb(0, 191, 166); cursor:pointer" class="mr-2 bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X"></i>Share via X</a></li>
           <li><a class="dropdown-item" @click="submitForm"><i class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);"></i>Bookmark Verse</a></li>
           <li><a class="dropdown-item" @click="copyText3"><i class="bi bi-clipboard-check text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166);"></i>Copy Verse</a></li>
           <li><a class="dropdown-item" @click="captureScreenshot3"><i class="bi bi-camera text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166);"></i>Screenshot Verse</a></li>
           <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#translationInfo"><i class="bi bi-info-circle text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Surah info" style="color: rgba(0, 191, 166);"></i>Surah Info</a></li>
           <li><a class="dropdown-item" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Report a bug" style="color: rgba(0, 191, 166);"></i>Report a bug</a></li>
          </ul>

         </div>
        </div>
       </div>

       <!-- Target Element for Screenshot -->
       <div ref="targetElement" class="w-100 my-element "  :class="{'full-screen': isFullScreen}">
        <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
        <AyahInfo :information="information" />
        <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
         <MainAyah :information="information" />
         <div ref="heading3">
          <EnglishTranslation :information="information" />
         </div>
         <Translator translator="Ahmed Ali" />
         <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
        </div>
       </div>
       
        <!-- Surah Info Modal -->
        <div class="modal fade" id="translationInfo" tabindex="-1" aria-labelledby="surahInfoModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
          <div class="modal-content">
           <div class="modal-header">
            <h1 class="modal-title fs-5" id="surahInfoModalLabel"><strong>Information</strong></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
            <form class="container text-left">
             <div class="mb-3 container">
              <label for="formGroupExampleInput" class="form-label">Surah Name (English):</label>
              <p class="mt-2 text-dark text-left">{{ information.ayah.surah.name_en }}</p>
             </div>
             <div class="mb-3 container">
              <label for="formGroupExampleInput" class="form-label text-left">Surah Information:</label>
              <p class="text-left">
               {{ expanded ? information.ayah.surah.text : truncatedText(information.ayah.surah.text) }}
               <template v-if="showMoreLink">
                <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
               </template>
              </p>
             </div>
             
            </form>
           </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
           </div>
          </div>
         </div>
        </div>
        <!-- Notes Modal -->
        <div class="modal fade" id="translationNote" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true" ref="exampleModal1">
         <div class="modal-dialog modal-lg">
          <div class="modal-content">
           <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Write a Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
            <!-- Note Form -->
            <form @submit.prevent="createNote">
             <div class="row container mt-3">
              <h5 class="text-left pb-2 font-weight-bold">Notes & Reflections</h5>
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

      <!-- Tafseer Section -->
      <div class="tab-pane" id="profile" role="tabpanel" v-if="information != null">
       <div class="icon-container pb-3">

        <div class="icon-container w-100 hide-on-mobile pb-3">
         <!-- Camera Icon for Screenshot -->
         <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" data-bs-toggle="modal" data-bs-target="#tafseerNote" style="color: rgba(0, 191, 166);cursor:pointer"></i>
         <i class="bi bi-whatsapp text-right mr-2 h4" @click="shareTextViaWhatsApp1" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166);cursor:pointer"></i>
         <i style=" color:rgb(0, 191, 166); cursor:pointer" @click="shareHeadingOnTwitter1" class="mr-2 bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X"></i>
         <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
         <i class="bi bi-clipboard-check text-right mr-2 h4" @click="copyText1" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
         <i class="bi bi-camera text-right mr-2 h3" @click="captureScreenshot1" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166); cursor:pointer"></i>
         <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
         <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
         <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#tafseerInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i>

        </div>

        <!-- Dropdown Features -->
        <div class="dropdown mobile-only">

         <div class="icon-container">
          <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166);" @click="goToEndAyah()" title="Last verse"></i>
          <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166);" @click="goToPreviousAyah()" title="Previous verse"></i>
          <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166);" @click="goToNextAyah()" title="Next verse"></i>
          <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166);" @click="goToLastAyah()" title="End verse"></i>
          <i class="bi bi-arrows-fullscreen h6" style="color: rgb(0, 191, 166);" @click="toggleFullScreen" title="Full screen"></i>

          <i style="color:rgb(0, 191, 166); cursor:pointer" class="bi bi-three-dots-vertical h5 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>
          <ul class="dropdown-menu">
           <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tafseerNote"><i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" style="color: rgba(0, 191, 166);"></i>Write a Note</a></li>
           <li><a class="dropdown-item" @click="shareTextViaWhatsApp1"><i class="bi bi-whatsapp text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166);"></i>Share via WhatsApp</a></li>
           <li><a class="dropdown-item" @click="shareHeadingOnTwitter1"><i style="color:rgb(0, 191, 166); cursor:pointer" class="mr-2 bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X"></i>Share via X</a></li>
           <li><a class="dropdown-item" @click="submitForm"><i class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);"></i>Bookmark Verse</a></li>
           <li><a class="dropdown-item" @click="copyText1"><i class="bi bi-clipboard-check text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>Copy Verse</a></li>
           <li><a class="dropdown-item" @click="captureScreenshot1"><i class="bi bi-camera text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166);"></i>Screenshot Verse</a></li>
           <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tafseerInfo"><i class="bi bi-info-circle text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Surah info" style="color: rgba(0, 191, 166);"></i>Surah Info</a></li>
           <li><a class="dropdown-item" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Report a bug" style="color: rgba(0, 191, 166);"></i>Report a bug</a></li>

          </ul>
         </div>

        </div>
       </div>

       <!-- Main Content to Capture -->
       <div ref="targetElement1" class="w-100 my-element" :class="{'full-screen': isFullScreen}">
        <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>
        <AyahInfo :information="information" />
        <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
         <!-- main stack top -->
         <div class="btn">
          <h5 class="text-right ayah-translation" name="ayah_text" style="line-height: 1.6em">
           {{ information.ayah.ayah_text }}
          </h5>
         </div>
         <!-- main stack below -->
         <h5 class="text-left ayah-translation" ref="heading1" style="line-height: 1.6em">
          {{ expanded ? tafseer : truncatedText(tafseer) }}
          <template v-if="showMoreLink">
           <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
          </template>
         </h5>
         <h6 class="text-left mt-3"><strong>Tafseer: </strong>Ibn Kathir</h6>
         <br>
         <!-- Include the AlertModal component -->
         <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
        </div>
       </div>

       <!-- Features -->
       <div class="text-right pt-2">
        <!-- Surah Info Modal -->
        <div class="modal fade" id="tafseerInfo" tabindex="-1" aria-labelledby="surahInfoModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
          <div class="modal-content">
           <div class="modal-header">
            <h1 class="modal-title fs-5" id="surahInfoModalLabel"><strong>Information</strong></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
            <form class="container text-left">
             <div class="mb-3 container">
              <label for="formGroupExampleInput" class="form-label">Surah Name (English):</label>
              <p class="mt-2 text-dark text-left">{{ information.ayah.surah.name_en }}</p>
             </div>
             <div class="mb-3 container">
              <label for="formGroupExampleInput" class="form-label text-left">Surah Information:</label>
              <p class="text-left">
               {{ expanded ? information.ayah.surah.text : truncatedText(information.ayah.surah.text) }}
               <template v-if="showMoreLink">
                <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
               </template>
              </p>
             </div>
            </form>
           </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
           </div>
          </div>
         </div>
        </div>

        <!-- Notes Modal -->
        <div class="modal fade" id="tafseerNote" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true" ref="exampleModal1">
         <div class="modal-dialog modal-lg">
          <div class="modal-content">
           <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Write a Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
            <!-- Note Form -->
            <form @submit.prevent="createNote">
             <div class="row container mt-3">
              <h5 class="text-left pb-2 font-weight-bold">Notes & Reflections</h5>
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

      </div>

      <!-- Transliteration Section -->
      <div class="tab-pane" id="messages" role="tabpanel" v-if="information != null">
       <div class="">
        <div>
         <!-- Ayah Controls -->
         <div class="icon-container pb-3">

          <div class="icon-container w-100 hide-on-mobile pb-3">
           <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" data-bs-toggle="modal" data-bs-target="#transliterationNote" style="color: rgba(0, 191, 166);cursor:pointer"></i>
           <i class="bi bi-whatsapp text-right mr-2 h4" @click="shareTextViaWhatsApp2" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166);cursor:pointer"></i>
           <i style=" color:rgb(0, 191, 166); cursor:pointer" @click="shareHeadingOnTwitter2" class="mr-2 bi bi-twitter-x text-right h4" aria-expanded="false" data-bs-placement="top" title="Share via X"></i>
           <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
           <i @click="copyText2" class="bi bi-clipboard-check text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
           <i class="bi bi-camera text-right mr-2 h3" @click="captureScreenshot2" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166); cursor:pointer"></i>
           <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
           <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
           <i class="bi bi-info-circle h4" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-target="#transliterationInfo" aria-expanded="false" data-bs-toggle="modal" data-bs-placement="top" title="Surah info"></i>
          </div>

          <!-- Dropdown Features -->
          <div class="dropdown mobile-only">
           <div class="icon-container">
            <i class="bi bi-chevron-bar-left h5" style="color: rgb(0, 191, 166);" @click="goToEndAyah()" title="Last verse"></i>
            <i class="bi bi-arrow-left-circle h5" style="color: rgb(0, 191, 166);" @click="goToPreviousAyah()" title="Previous verse"></i>
            <i class="bi bi-arrow-right-circle h5" style="color: rgb(0, 191, 166);" @click="goToNextAyah()" title="Next verse"></i>
            <i class="bi bi-chevron-bar-right h5" style="color: rgb(0, 191, 166);" @click="goToLastAyah()" title="End verse"></i>
            <i class="bi bi-arrows-fullscreen h6" style="color: rgb(0, 191, 166);" @click="toggleFullScreen" title="Full screen"></i>
            <i style="color:rgb(0, 191, 166); cursor:pointer" class="bi bi-three-dots-vertical h5 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>
            <ul class="dropdown-menu">
             <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#transliterationNote"><i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" style="color: rgba(0, 191, 166);"></i>Write a Note</a></li>
             <li><a class="dropdown-item" @click="shareTextViaWhatsApp2"><i class="bi bi-whatsapp text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Share on Whatsapp" style="color: rgba(0, 191, 166);"></i>Share via WhatsApp</a></li>
             <li><a class="dropdown-item" @click="shareHeadingOnTwitter2"><i style=" color:rgb(0, 191, 166); cursor:pointer" class="bi bi-twitter-x text-right h4 mr-2" aria-expanded="false" data-bs-placement="top" title="Share via X"></i>Share via X</a></li>
             <li><a class="dropdown-item" @click="submitForm"><i class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);"></i>Bookmark Verse</a></li>
             <li><a class="dropdown-item" @click="copyText2"><i class="bi bi-clipboard-check text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Copy verse" style="color: rgba(0, 191, 166);"></i>Copy Verse</a></li>
             <li><a class="dropdown-item" data-bs-toggle="modal" @click="captureScreenshot2"><i class="bi bi-camera text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Screenshot verse" style="color: rgba(0, 191, 166);"></i>Screenshot Verse</a></li>
             <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#transliterationInfo"><i class="bi bi-info-circle text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Surah info" style="color: rgba(0, 191, 166);"></i>Surah Info</a></li>
             <li><a class="dropdown-item" data-bs-placement="top" title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Report a bug" style="color: rgba(0, 191, 166);"></i>Report a bug</a></li>
            </ul>
           </div>
          </div>
         </div>

         <div ref="targetElement2" class="w-100 my-element " :class="{'full-screen': isFullScreen}">
          <button v-if="isFullScreen" @click="toggleFullScreen" class="close-button mb-3 text-left btn btn-secondary">Close</button>

          <h5 class="mr-2">
           {{ information.ayah.surah.name_en }} {{ information.ayah.surah_id }}: {{ information.ayah.ayah_id }}
          </h5>
          <div @touchstart="handleTouchStart" @touchmove="handleTouchMove" @touchend="handleTouchEnd" class="swipeable-div w-100">
           <!-- main stack top -->
           <div class="btn">
            <h5 class="text-right ayah-translation" name="ayah_text" style="line-height: 1.6em">
             {{ information.ayah.ayah_text }}
            </h5>
           </div>

           <!-- main stack below -->
           <h5 class="text-left ayah-translation" ref="heading2" style="line-height: 1.6em">
            {{ expanded ? information.transliteration : truncatedText(information.transliteration) }}
            <template v-if="showMoreLink">
             <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
            </template>
           </h5>
           <h6 class="text-left mt-3"><strong>Transliteration: </strong>Saheeh International</h6>
          </div>
         </div>
         <br>

         <!-- Include the AlertModal component -->
         <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />

         <!-- Notes Modal -->
         <div class="modal fade" id="transliterationNote" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true" ref="exampleModal1">
          <div class="modal-dialog modal-lg">
           <div class="modal-content">
            <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel1">Write a Note</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <!-- Note Form -->
             <form @submit.prevent="createNote">
              <div class="row container mt-3">
               <h5 class="text-left pb-2 font-weight-bold">Notes & Reflections</h5>
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

         <!-- Surah Info Modal -->
         <div class="modal fade" id="transliterationInfo" tabindex="-1" aria-labelledby="surahInfoModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
           <div class="modal-content">
            <div class="modal-header">
             <h1 class="modal-title fs-5" id="surahInfoModalLabel"><strong>Information</strong></h1>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <form class="container text-left">
              <div class="mb-3 container">
               <label for="formGroupExampleInput" class="form-label">Surah Name (English):</label>
               <p class="mt-2 text-dark text-left">{{ information.ayah.surah.name_en }}</p>
              </div>
              <div class="mb-3 container">
               <label for="formGroupExampleInput" class="form-label text-left">Surah Information:</label>
               <p class="text-left">
                {{ expanded ? information.ayah.surah.text : truncatedText(information.ayah.surah.text) }}
                <template v-if="showMoreLink">
                 <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
                </template>
               </p>
              </div>
             </form>
            </div>
            <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
           </div>
          </div>
         </div>

        </div>
       </div>

      </div>

      <BookmarksAndNotes :information="information" />
      <CorrectionModal />

     </div>
    </div>
   </div>
  </div>

 </div>
</div>
</template>

<script>
import html2canvas from 'html2canvas';
import CustomSurahSelection from './surah_selection/CustomSurahSelection.vue'; // Ensure the path is correct
import SearchForm from './search/SearchForm.vue';
import SurahList from './search/SurahList.vue';
import SurahDropdown from './search/SurahDropdown.vue';
import ArrowControls from './arrowControls/ArrowControls.vue';
import BookmarksAndNotes from './bookmark_and_notes_links/BookmarksAndNotes.vue';
import AlertModal from './modals/AlertModal.vue';
import Welcome from './intro/Welcome.vue';
import Title from './intro/Title.vue';
import CorrectionModal from './modals/CorrectionModal.vue';
import Donation from './intro/Donation.vue'
import NavTabs from './tabs/NavTabs.vue';
import AyahInfo from './translation/AyahInfo.vue';
import MainAyah from './translation/MainAyah.vue';
import EnglishTranslation from './translation/EnglishTranslation.vue';
import Translator from './translation/Translator.vue';

export default {

 name: 'QuranComponent',
 props: {},
 components: {
  CustomSurahSelection,
  SurahList,
  ArrowControls,
  BookmarksAndNotes,
  AlertModal,
  Welcome,
  CorrectionModal,
  Donation,
  NavTabs,
  Title,
  SearchForm,
  AyahInfo,
  MainAyah,
  EnglishTranslation,
  Translator,
 },
 mounted() {
  this.getSurahs(); // Ensure data dependencies are handled correctly
  this.fetchAyahs(); // Ensure data dependencies are handled correctly
 },
 data() {
  return {
   // ayah controls
   surah: 0, 
   selectedIndexAyah: 0,
   // define & initialize
   data: [],
   surahs: [],
   ayahs: [],
   tafseers: [],
   surah: [],
   information: null,
   surah: null,
   ayah_id: null, 
   //expand text 
   expanded: false,
   //full screen toggle
   isFullScreen: false,
   //swipe gestures
   touchStartX: 0,
   touchEndX: 0,
   touchStartY: 0,
   touchEndY: 0,
   touchStartTime: 0,
   threshold: 50,
   // auth login
   isLoggedIn: false,
   // main search
   showClearButton: false,
   searchTerm: '', 
   filteredSurah: [],
   // main card visibility
   isCardVisible: false,
   // select ayah dropdown
   selectedIndexAyah: -1,
   selectedIndexAyah: null,
   selectedAyah: null,
   dropdownHidden: true,
   verseNumber: null,
   //alerts
   showError: false,
   showAlertText: false,
   showAlert: false,
   showErrorAlert: false,
   showAlertTextNote: false,
   maxLength: 400,

   // notes modal
   form1: new Form({
    id: "",
    surah_name: "",
    ayah_num: "",
    ayah_verse_ar: "",
    ayah_verse_en: "",
    ayah_notes: "",
   }),

   // correction modal
   form: new Form({
    id: "",
    name: "",
    email: "",
    mistake_type: "",
    added_notes: "",
    ayah_num: "",
   }),

   // search
   searchFilters: new Form({
    name_en: "",
    name_ar: ""
   }),
  };
 },
 methods: {
   getSelectedSurahAyahs() {
      if (this.surahs[this.surah]) {
        return this.surahs[this.surah].ayahs;
      }
      return [];
    },
    updateAyah(newIndex) {
      this.selectedIndexAyah = newIndex;
      console.log(`Selected Ayah: ${newIndex}`);
      // Add any additional logic for updating the ayah
    },
  
  getSelectedSurahAyahs() {
    const surahData = this.surahs.find(surah => surah.id === parseInt(this.surah));
    return surahData ? surahData.ayahs : [];
  },
  toggleExpand() {
   this.expanded = !this.expanded;
  },
  closeAlertText() {
   this.showAlertText = false;
  },
  triggerBookmarkSuccess() {
   this.showAlert = true;
   setTimeout(() => {
    this.showAlert = false;
   }, 3000);
  },
  triggerLoginError() {
   this.showErrorAlert = true;
  },
  triggerNoteLoginError() {
   this.showAlertTextNote = true;
  },
  toggleFullScreen() {
   this.isFullScreen = !this.isFullScreen;
  },
  async fetchSurahs() {
   try {
    const response = await axios.get('http://localhost:3000/api/surahs');
    this.surahs = response.data;
    console.log('Fetched surahs:', this.surahs);
   } catch (error) {
    console.error('Error fetching surahs:', error);
   }
  },
  handleTouchStart(event) {
   this.touchStartX = event.changedTouches[0].screenX;
   this.touchStartY = event.changedTouches[0].screenY;
   this.touchStartTime = Date.now();
  },
  handleTouchMove(event) {
   this.touchEndX = event.changedTouches[0].screenX;
   this.touchEndY = event.changedTouches[0].screenY;
  },
  handleTouchEnd() {
   const touchEndTime = Date.now();
   const timeDiff = touchEndTime - this.touchStartTime;
   const deltaX = this.touchEndX - this.touchStartX;
   const deltaY = this.touchEndY - this.touchStartY;

   const minSwipeDistance = 50; // Minimum distance in pixels to be considered a swipe
   const maxTapDistance = 10; // Maximum distance in pixels to be considered a tap
   const maxSwipeDuration = 500; // Maximum duration in ms to be considered a swipe
   const maxTapDuration = 200; // Maximum duration in ms to be considered a tap

   // Check if it's a tap
   if (Math.abs(deltaX) < maxTapDistance && Math.abs(deltaY) < maxTapDistance && timeDiff < maxTapDuration) {
    this.onTap();
   }
   // Check if it's a swipe
   else if (
    Math.abs(deltaX) > minSwipeDistance &&
    timeDiff < maxSwipeDuration &&
    Math.abs(deltaX) > Math.abs(deltaY) // Ensure it's a horizontal swipe
   ) {
    if (deltaX > 0) {
     this.onSwipeRight();
    } else {
     this.onSwipeLeft();
    }
   }
  },
  onSwipeLeft() {
   this.goToPreviousAyah();
   console.log('Swiped left');
   // Add your logic for swiping left here
  },
  onSwipeRight() {
   this.goToNextAyah();
   console.log('Swiped right');
   // Add your logic for swiping right here
  },
  goToFirstAyah() {
   this.selectAyah(0);
  },
  goToPreviousAyah() {
   if (this.selectedIndexAyah > 0) {
    this.selectAyah(this.selectedIndexAyah - 1);
   } else {
    this.selectAyah(this.ayahs.length - 1);
   }
  },
  goToNextAyah() {
   if (this.selectedIndexAyah < this.ayahs.length - 1) {
    this.selectAyah(this.selectedIndexAyah + 1);
   } else {
    this.selectAyah(0);
   }
  },
  goToLastAyah() {
   this.selectAyah(this.ayahs.length - 1);
  },
  truncatedText(text) {
   if (!text) return '';
   return text.length > this.maxLength ? text.substring(0, this.maxLength) + '...' : text;
  },
  detectSwipe() {
   const swipeDistance = this.touchStartX - this.touchEndX;
   console.log('Swipe distance:', swipeDistance);
   if (swipeDistance > 50) {
    console.log('Swipe left detected');
    alert('Swipe left detected');
   } else if (swipeDistance < -50) {
    console.log('Swipe right detected');
    alert('Swipe right detected');
   }
  },
  handleNoteClick() {
   if (this.isLoggedIn) {
    this.showAlertTextNote = false;
    this.openNoteModal();
   } else {
    this.showAlertTextNote = true;
   }
  },
  openNoteModal() {
   $('#exampleModal1').modal('show');
  },
  submitCat() {
   const formData = {
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.information.translation,
    category_id: this.selectedCategory
   };
   axios.post('/submit_category', formData);
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
    this.showError = true;
    setTimeout(() => {
     this.dismissError();
    }, 5000);
   }
  },
  dismissError() {
   this.showError = false;
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
     //  Swal.fire({
     //   title: "Error!",
     //   text: "You need to be logged in to create a bookmark.",
     //   icon: "error",
     //   confirmButtonText: "OK"
     //  });
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
     //  Swal.fire({
     //   title: "Error!",
     //   text: "You need to be logged in to create a bookmark.",
     //   icon: "error",
     //   confirmButtonText: "OK"
     //  });
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
     //  Swal.fire({
     //   title: "Error!",
     //   text: "You need to be logged in to create a bookmark.",
     //   icon: "error",
     //   confirmButtonText: "OK"
     //  });
     this.hideAlertAfterDelay(); // Start timer to hide alert
    });
  },
  hideAlertAfterDelay() {
   setTimeout(() => {
    this.showAlert = false;
    this.showAlertText = false;
    this.showErrorAlert = false;
   }, 3000);
  },
  
  async getAyahs() {
   if (this.surah > 0) {
    try {
     console.log(`Fetching ayahs for surah ${this.surah}`);
     const response = await axios.get(`/api/ayahs/${this.surah}`);
     this.ayahs = response.data;
     if (this.ayahs.length > 0) {
      this.selectedAyah = this.ayahs[0].id;
      this.selectedIndexAyah = 0;
     }
    } catch (error) {
     console.error('Error fetching ayahs:', error);
    }
   } else {
    this.ayahs = [];
    this.selectedAyah = null;
    this.selectedIndexAyah = null;
   }
  },
  
  showCard() {
   this.isCardVisible = true; // Show the card when button is clicked
  },
  selectAyah(index) {
   this.selectedIndexAyah = index;
   this.scrollToSelectedAyah();
   this.getTafseers(this.ayahs[index].id, index);
  },
  dismissError() {
   this.showError = false; // Dismiss the error alert by setting showError to false
  },

  scrollToSelectedAyah() {
   this.$nextTick(() => {
    const selectedAyah = this.$refs.ayahList.querySelector('.selected');
    if (selectedAyah) {
     selectedAyah.scrollIntoView({
      behavior: 'smooth'
     });
    } else {
     // Display error alert if no ayah is selected
     this.showError = true;

     // Automatically dismiss the alert after 5 seconds
     setTimeout(() => {
      this.dismissError();
     }, 1000);
    }
   });
  },
  determineNextAyah() {
   const currentIndex = this.ayahs.findIndex(ayah => ayah.id === this.selectedAyah.id);
   if (currentIndex !== -1 && currentIndex < this.ayahs.length - 1) {
    return this.ayahs[currentIndex + 1];
   }
   return null;
  },
  determinePreviousAyah() {
   const currentIndex = this.ayahs.findIndex(ayah => ayah.id === this.selectedAyah.id);
   if (currentIndex > 0) {
    return this.ayahs[currentIndex - 1];
   }
   return null;
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
    const headingText3 = this.$refs.targetElement.textContent.trim();
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
   const text3 = this.$refs.targetElement.innerText;
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
   const targetElement = this.$refs.targetElement;

   // Capture screenshot for targetElement after 5 seconds
   setTimeout(() => {
    html2canvas(targetElement).then(canvas => {
     const dataUrl = canvas.toDataURL('image/png');
     this.downloadUrl = dataUrl;

     // Simulate click on download link after 2 seconds
     setTimeout(() => {
      const downloadLink = document.createElement('a');
      downloadLink.href = dataUrl;
      downloadLink.download = 'screenshot.png';
      downloadLink.click();
     }, 4); // 2000 milliseconds = 2 seconds
    });
   }, 4); // 5000 milliseconds = 5 seconds
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
     }, 4); // 2000 milliseconds = 2 seconds
    });
   }, 4); // 5000 milliseconds = 5 seconds
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
     }, 4); // 2000 milliseconds = 2 seconds
    });
   }, 4); // 5000 milliseconds = 5 seconds
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

  selectSurah() {
   // Example: Fetch ayahs data for the selected surah (replace with actual logic)
   // Simulate fetching ayahs data for the selected surah
   this.ayahs = this.fetchAyahsForSurah(this.surah); // Replace with actual logic
   // Always select the first ayah when a surah is selected
   this.selectedAyah = this.ayahs.length > 0 ? '0' : '0'; // Select the first ayah
  },
  selectSurah(surahId) {
   this.surah = surahId;
   this.searchTerm = ''; // Clear the search term
   this.filteredSurah = []; // Clear the filtered results
   this.showClearButton = false; // Hide the clear button after clearing results
   this.getAyahs(); // Call the getAyahs method with the selected Surah ID

  },
  createNote() {
   const formData = {
    surah_name: this.information.ayah.surah.name_en,
    ayah_num: this.information.ayah_id,
    ayah_verse_ar: this.information.ayah.ayah_text,
    ayah_verse_en: this.information.translation,
    ayah_notes: this.form1.ayah_notes
   };

   Swal.fire({
    title: "Are you sure?",
    text: "You want to submit note!",
    showCancelButton: true,
    confirmButtonColor: "green",
    cancelButtonColor: "#d33",
    confirmButtonText: "Submit!"
   }).then(result => {
    if (result.isConfirmed) {
     axios.post("/api/submit-note", formData)
      .then(res => {
       if (res.data.success) {
        Swal.fire({
         icon: "success",
         title: "Success!",
         text: "Your note has been submitted.",
         timer: 1500,
         showConfirmButton: false
        }).then(() => {
         $('#exampleModal1').modal('hide');
         this.resetNoteForm();
         document.body.classList.remove('modal-open');
         document.querySelectorAll('.modal-backdrop').forEach(modal => modal.remove());
        });
       } else {
        Swal.fire({
         icon: "success",
         title: "Success!",
         text: "Your note has been submitted.",
         timer: 1500,
         showConfirmButton: false
        }).then(() => {
         $('#exampleModal1').modal('hide');
         this.resetNoteForm();
         document.body.classList.remove('modal-open');
         document.querySelectorAll('.modal-backdrop').forEach(modal => modal.remove());
        });
       }
      })
      .catch(err => {
       console.error(err);
       Swal.fire("Error!", "Failed to submit note. Please try again.", "error");
      });
    }
   });
  },
  resetNoteForm() {
   this.form1.ayah_notes = '';
  },
  hideNoteModal() {
   this.$refs.noteModal.hide();
  },
  closeModal(modalId) {
   const modalElement = document.getElementById(modalId);
   const modalInstance = new bootstrap.Modal(modalElement);

   modalInstance.hide();

   // Remove any existing modal backdrops
   const modalBackdrops = document.querySelectorAll('.modal-backdrop');
   modalBackdrops.forEach(backdrop => {
    backdrop.parentNode.removeChild(backdrop);
   });

   // Ensure modal-open class is removed from body
   document.body.classList.remove('modal-open');
  },
  resetForm() {
   this.form1.surah_name = "";
   this.form1.ayah_num = "";
   this.form1.ayah_text = "";
   this.form1.ayah_notes = "";
  },

  resetForm() {
   this.form.reset();
   this.form1.reset();
   const exampleModal2 = bootstrap.Modal.getInstance(this.$refs.exampleModal2);
   if (exampleModal2) {
    exampleModal2.hide();
   }
  },

  copyText3() {
   console.log(this.$refs.heading3);
   var textToCopy3 = this.$refs.heading3.innerText;
   console.log(textToCopy3);
   // Copy the text to the clipboard
   this.copyToClipboard(textToCopy3);
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
  $route(to, from) {
   // Re-fetch translation if route changes (i.e., if ID changes)
   console.log('Route changed, fetching new translation...');
   this.fetchTranslation();
  },
  surah(newSurah) {
   this.getAyahs(newSurah);
  },
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
.full-screen[data-v-2b3c2c26] {
 position: fixed;
 top: 0;
 left: 0;
 width: 100vw;
 height: 100vh;
 z-index: 9999;
 background: #fff;
 padding: 100px;
 overflow: auto;
}

@media (max-width: 767.98px) {

 .hide-on-mobile-tablet {
  display: none !important;
 }

 .show-on-desktop {
  display: flex !important;
 }

 .show-on-desktop {
  display: block;
 }

 .custom-form {
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  border-radius: 5px;
  overflow-x: hidden;
  /* Hide horizontal scrollbar */
 }

 .tab-content {
  overflow-x: hidden;
  /* Hide horizontal scrollbar */
 }

 .icon-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
 }

 .icon-container i {
  flex: 1;
  text-align: center;
 }

 .dropdown {
  flex: 1;
  text-align: center;
 }
}

.dropdown-toggle::after {
 display: none !important;
}

.flex-container i {
 color: rgb(0, 191, 166);
}

.icon-container {
 display: flex;
 align-items: center;
 justify-content: space-around;
 flex-wrap: nowrap;
}

.icon-row i {
 color: rgb(0, 191, 166);
 cursor: pointer;
 font-size: 1.5rem;
 /* Adjust the font size to ensure icons fit in one line */
}

.mobile-only {
 display: none;
}


@media (max-width: 576px) {
 .flex-container {
  flex-direction: column;
  align-items: stretch;
 }

 .icon-row {
  display: flex;
  justify-content: space-between;
 }

 .icon-row i {
  flex: 1;
  text-align: center;
 }

}

/* Media query for mobile devices (example: max-width 600px) */
@media (max-width: 600px) {

 .container.text-right,
 .container.text-left {
  font-size: 1em;
  /* Equivalent to h6 font size */
 }
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


/* Define a media query for full-screen devices */
@media screen and (min-width: 1024px) {

 /* Select the element with the class hide-on-full-screen and hide it */
 .hide-on-full-screen {
  display: none;
 }
}

/* Media query for mobile screens */
@media screen and (max-width: 768px) {
 .full-screen[data-v-2b3c2c26] {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  z-index: 9999;
  background: #fff;
  padding: 20px;
  overflow: auto;
 }

 .mobile-only {
  display: block;
 }

 .hide-on-full-screen {
  display: none;
 }

 .hide-on-tablet {
  display: none;
 }


.container.text-right,
.container.text-left {
 font-size: 1.25em;
 /* Equivalent to h5 font size */
}
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
  overflow-y: hidden;
 }

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

}

.button-33 {
 background-color: rgba(0, 191, 166);
 border-radius: 8px;
 color: white;
 cursor: pointer;
 display: inline-block;
 font-family: inter;
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
 overflow-x: scroll;
 /* Hide horizontal scrollbar */
 white-space: nowrap;
}

.scrollmenu a {
 display: inline-block;
 vertical-align: top;
}

.list-group {
 min-width: 100%;
 background: transparent;
 cursor: pointer;
}

.card {
 display: flex;
 border: 1px solid #00BFA6;
 padding: 10px;
 border-radius: 10px;
}

.selected {
 background-color: rgba(0, 191, 166, 0.452);
}

.custom-scrollbar {
 border-radius: 6px;
 padding: 1rem;
 overflow: scroll;
 border: 2px solid #00BFA6;
}
</style>
