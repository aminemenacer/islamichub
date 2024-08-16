<template>
<div id="app">
 <div class="pt-3 text-center">
  <Title v-if="information == null && dropdownHidden" />
  <search-form :surat="surat" @update-results="handleUpdateResults" @clear-results="handleClearResults" @select-surah="handleSelectSurah" />
  <custom-surah-selection :customSurat="customSuratList" v-model="selectedSurah"></custom-surah-selection>
 </div>

 <!-- accordion headers -->
 <div class="row container-fluid">
  <div class="col-md-4 container">
   <FilteredSurahList :filteredSurah="filteredSurah" @select-surah="selectSurahFromResults" />
   <Donation />

   <SurahDropdown :selectedSurah="selectedSurah" :filteredSurah="filteredSurah" :surat="surat" @update:selectedSurah="updateSelectedSurah" @change="getAyat" />
   <AyahDropdown class="desktop-hidden" :selectedSurahId="selectedSurahId" :dropdownHidden="dropdownHidden" @update-information="updateInformation" @update-tafseer="updateTafseer" v-if="ayah == null && !dropdownHidden" />

   <!-- List of Ayat for Surah (desktop) -->
   <div class="tab-content hide-on-mobile-tablet" id="nav-tabContent" v-if="ayah == null && !dropdownHidden">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" v-if="ayah == null">

     <form class="d-flex pb-2 " role="search" @submit.prevent="scrollToAyah">
      <input class="form-control me-2" type="number" placeholder="Enter Verse Number" v-model="verseNumber" required>
      <button class="btn btn-success mb-1 ml-2" type="submit">Search</button>
     </form>

     <!-- Error alert -->
     <ErrorAlert :showError="showError" @dismiss-error="dismissError" />

     <div class="row container-fluid">
      <hr class="container" style="height: 4px; background: lightgrey;">

      <div class="icon-container pb-2">
       <i class="bi bi-chevron-bar-left h4" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToFirstAyah" title="First verse"></i>
       <i class="bi bi-arrow-left-circle h4" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToPreviousAyah" title="Previous verse"></i>
       <i class="bi bi-arrow-right-circle h4" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToNextAyah" title="Next verse"></i>
       <i class="bi bi-chevron-bar-right h4" style="color: rgb(0, 191, 166); cursor: pointer;" @click="goToLastAyah" title="Last verse"></i>
       <!--
       <i class="bi bi-palette-fill h4" style="color: rgb(0, 191, 166); cursor: pointer;" data-bs-toggle="modal" data-bs-target="#themeModal"></i>
       -->
       <i v-if="information != null" class="bi bi-info-circle-fill h4 mr-2 pl-2" style="color: rgb(0, 191, 166);cursor:pointer" data-bs-toggle="modal" data-bs-target="#translationInfo" aria-expanded="false" data-bs-placement="top" title="Surah info"></i>
      </div>

      <div :style="{containerStyle, color: selectedStyle.textColor, computedStyle, backgroundColor: selectedStyle.backgroundColor}" class="custom-scrollbar pb-5" style="overflow-y: auto; max-height: 600px; background: white;border-radius:10px">
       <ul class="col-md-12 list-group container-fluid root" id="toggle" ref="ayahList" style="list-style-type: none; padding: 10px">
        <li v-for="(ayah, index) in ayat" :key="index" @click="selectAyah(index)" :class="{ selected: selectedIndexAyah === index, highlighted: verseNumber && parseInt(verseNumber) === ayah.ayah_id }" style="padding: 10px; border-radius:10px">
         <h5 class="text-right" style="display: flex;"> Verse: {{ ayah.ayah_id }} </h5>
         <h5 class="text-right">{{ ayah.ayah_text }}</h5>
        </li>
       </ul>
      </div>
     </div>

    </div>
   </div>
  </div>

  <div class="col-md-8 card-hide">
   <div class="card content" :style="containerStyle">
    <div class="content" :style="shadowStyle">
     <div class="container-fluid content" v-if="information != null">
      <NavTabs />

      <!-- Surah info Modal -->
      <div class="modal fade" id="translationInfo" tabindex="-1" aria-labelledby="surahInfoModalLabel" aria-hidden="true" @click.self="closeModal">
       <div class="modal-dialog modal-lg">
        <div class="modal-content">
         <div class="modal-header">
          <h1 class="modal-title fs-5" id="surahInfoModalLabel"><strong>Information</strong></h1>
          <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
          <form class="container text-left">
           <div class="mb-3 container" v-if="information.ayah && information.ayah.surah">
            <label for="formGroupExampleInput" class="form-label">Surah Name (English):</label>
            <p class="mt-2 text-dark text-left">{{ information.ayah.surah.name_en }}</p>
           </div>
           <div class="mb-3 container" v-if="information.ayah && information.ayah.surah">
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
          <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
         </div>
        </div>
       </div>
      </div>
     </div>

     <div class="card-body content" id="alertContainer">
      <div class="tab-content text-center">
       <Welcome :information="information" />

       <!-- Translation Section -->
       <div class="tab-pane active content" id="home" role="tabpanel" v-if="information != null">

        <div class="icon-container">
         <!-- Main features desktop -->
         <div class="icon-container w-100 hide-on-mobile pb-3">
          <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="openModal('translationNote')" style="color: rgba(0, 191, 166);cursor:pointer"></i>
          <TranslationNote ref="translationNote" :information="information.translation" />
          <WhatsAppShareTranslation :translationToShare="information.translation" />
          <TwitterShareTranslation :targetElementRef="'targetElement'" :translationText="information.translation" />
          <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
          <CopyTranslationText :textToCopy="information.translation" />
          <!--
          <ScreenTranslationCapture :targetTranslationRef="'targetTranslationElement'" />
          -->
          <PdfDownload :targetTranslationRef="'targetTranslationElement'" />
          <i class="bi bi-paint-bucket h2" style="color: rgb(0, 191, 166); cursor: pointer;" @click="showModal"></i>
          <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
          <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
         </div>
        </div>

        <!-- mobile top Features  ---->
         <div class="dropdown mobile-only pb-2">
          <div class="icon-container">
           <i class="bi bi-chevron-bar-left h4" style="color: rgb(0, 191, 166);" @click="goToFirstAyah()" title="Last verse"></i>
           <i class="bi bi-arrow-left-circle h4" style="color: rgb(0, 191, 166);" @click="goToPreviousAyah()" title="Previous verse"></i>
           <i class="bi bi-arrow-right-circle h4" style="color: rgb(0, 191, 166);" @click="goToNextAyah()" title="Next verse"></i>
           <i class="bi bi-chevron-bar-right h4" style="color: rgb(0, 191, 166);" @click="goToLastAyah()" title="End verse"></i>
           <i class="bi bi-paint-bucket h2" style="color: rgb(0, 191, 166); cursor: pointer;" @click="showModal"></i>
           <i class="bi bi-arrows-fullscreen h6" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
          </div>
         </div>
         <!-- end mobile top Features ---->

        <!-- dropdown mobile content -->
        <div class="pt-2" ref="targetTranslationElement">
         <TranslationSection :information="information" :isFullScreen="isFullScreen" :expanded="expanded" :showMoreLink="showMoreLink" :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @toggle-full-screen="toggleFullScreen" @handle-touch-start="handleTouchStart" @handle-touch-move="handleTouchMove" @handle-touch-end="handleTouchEnd" @toggle-expand="toggleExpand" @close-alert-text="closeAlertText" />
        </div>
        
        <div class="container-fluid text-center mobile-only">
          <div class="row">
            <div class="col">
            </div>
            <div class="col">
              <button @click="toggleContent" class="button-63 text-center mobile-only">
                {{ isOpen ? 'Close Toolbar' : 'Open Toolbar' }}
              </button>
            </div>
            <div class="col">
            </div>
          </div>
        </div>
        
        

        <!-- toolbar mobile -->
        <div v-if="isOpen" class="collapse-content mobile-only" style="background:background-color: rgba(0, 191, 166, 0.452);">
          <div class="card text-bg-light card-body" >
            <!-- Your content here -->
            <TranslationActions class="" :targetTranslationRef="'targetTranslationElement'" :translation="translation" @open-modal="openModal" @submit-form="submitForm" />
            <PdfDownload class="pl-1 pb-2 mt-2 text-left" :targetTranslationRef="'targetTranslationElement'" />
            
          </div>
        </div>
        <!-- end toolbar mobile -->

       </div>

       

       <!-- Tafseer Section -->
       <div class="tab-pane content" id="profile" role="tabpanel" v-if="information != null">
        <div class="icon-container ">

         <div class="icon-container w-100 hide-on-mobile pb-2">
          <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="openModal('tafseerNote')" style="color: rgba(0, 191, 166);cursor:pointer">
          </i>
          <TafseerNote ref="tafseerNote" :information="tafseer" />
          <WhatsAppShareTafseer :tafseerToShare="tafseer" />
          <TwitterShareTafseer :targetElementRef="'targetElement'" :tafseerText="tafseer" />
          <i @click="submitForm" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
          <CopyTafseerText :textToCopy="tafseer" />
          <PdfDownload class="pl-1 pb-2 mt-2 text-left" :targetTranslationRef="'targetTafseerElement'" />
          <i class="bi bi-paint-bucket h2" style="color: rgb(0, 191, 166); cursor: pointer;" @click="showModal"></i>
          <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h3" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
          <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
         </div>

         <!-- mobile top Features  ---->
         <div class="dropdown mobile-only">
          <div class="icon-container pb-2">
           <i class="bi bi-chevron-bar-left h4" style="color: rgb(0, 191, 166);" @click="goToFirstAyah()" title="Last verse"></i>
           <i class="bi bi-arrow-left-circle h4" style="color: rgb(0, 191, 166);" @click="goToPreviousAyah()" title="Previous verse"></i>
           <i class="bi bi-arrow-right-circle h4" style="color: rgb(0, 191, 166);" @click="goToNextAyah()" title="Next verse"></i>
           <i class="bi bi-chevron-bar-right h4" style="color: rgb(0, 191, 166);" @click="goToLastAyah()" title="End verse"></i>
           <i class="bi bi-paint-bucket h2" style="color: rgb(0, 191, 166); cursor: pointer;" @click="showModal"></i>
           <i class="bi bi-arrows-fullscreen h6" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
          </div>
         </div>
         <!-- end mobile top Features ---->
        </div>

        <!-- Main content  -->
        <div class="pt-2" ref="targetTafseerElement">
         <TafseerSection :information="information" :isFullScreen="isFullScreen" :expanded="expanded" :showMoreLink="showMoreLink" :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @toggle-full-screen="toggleFullScreen" @handle-touch-start="handleTouchStart" @handle-touch-move="handleTouchMove" @handle-touch-end="handleTouchEnd" @toggle-expand="toggleExpand" @close-alert-text="closeAlertText" />
        
        
        </div>
        <!-- end main content -->

        <div class="container-fluid text-center mobile-only">
          <div class="row">
            <div class="col">
            </div>
            <div class="col">
              <button @click="toggleContent" class="button-63 text-center mobile-only">
                {{ isOpen ? 'Close Toolbar' : 'Open Toolbar' }}
              </button>
            </div>
            <div class="col">
            </div>
          </div>
        </div>

        <!-- toolbar mobile -->
        <div v-if="isOpen" class="collapse-content mobile-only">
          <div class="card text-bg-light card-body" >
            <!-- Your content here -->
            <TafseerActions :targetTafseerRef="'targetTafseerElement'" :tafseer="tafseer" @open-modal="openModal" @submit-form="submitForm" />
            <PdfDownload class="pl-1 pb-2 mt-2 text-left" :targetTranslationRef="'targetTafseerElement'" />
            
          </div>
        </div>
        <!-- end toolbar mobile -->


        <SurahInfoModal :information="information" />
       </div>

       <!-- Transliteration Section -->
       <div class="tab-pane content" id="messages" role="tabpanel" v-if="information != null">
        <div class="">
         <div>
          <!-- Ayah Controls -->
          <div class="icon-container pb-3">

           <div class="icon-container w-100 hide-on-mobile">
            <i class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="openModal('transliterationNote')" style="color: rgba(0, 191, 166);cursor:pointer">
            </i>
            <TransliterationNote ref="transliterationNote" :information="information.transliteration" />
            <WhatsAppShareTransliteration :transliterationToShare="information.transliteration" />
            <TwitterShareTransliteration :targetElementRef="'targetElement'" :transliterationText="information.transliteration" />
            <i @click="submitForm2" class="bi bi-bookmark text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Bookmark verse" style="color: rgba(0, 191, 166);cursor:pointer"></i>
            <CopyTransliterationText :textToCopy="information.transliteration" />
            <!--
            <ScreenTransliterationCapture :targetTransliterationRef="'targetTransliterationElement'" />
            -->
            <PdfDownload :targetTranslationRef="'targetTransliterationElement'" />
            <i class="bi bi-paint-bucket h2" style="color: rgb(0, 191, 166); cursor: pointer;" @click="showModal"></i>
            <i title="Report a bug" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" style="color: rgba(0, 191, 166); cursor: pointer;"></i>
            <i class="bi bi-arrows-fullscreen h4" style="color: rgb(0, 191, 166);cursor:pointer" @click="toggleFullScreen" title="Full screen"></i>
           </div>

           <!-- Dropdown Features -->
           <div class="dropdown mobile-only">
            <div class="icon-container">
             <i class="bi bi-chevron-bar-left h4" style="color: rgb(0, 191, 166);" @click="goToFirstAyah()" title="Last verse"></i>
             <i class="bi bi-arrow-left-circle h4" style="color: rgb(0, 191, 166);" @click="goToPreviousAyah()" title="Previous verse"></i>
             <i class="bi bi-arrow-right-circle h4" style="color: rgb(0, 191, 166);" @click="goToNextAyah()" title="Next verse"></i>
             <i class="bi bi-chevron-bar-right h4" style="color: rgb(0, 191, 166);" @click="goToLastAyah()" title="End verse"></i>
             <i class="bi bi-paint-bucket h2" style="color: rgb(0, 191, 166); cursor: pointer;" @click="showModal"></i>
             <i class="bi bi-arrows-fullscreen h6" style="color: rgb(0, 191, 166);" @click="toggleFullScreen" title="Full screen"></i>
            </div>
           </div>
          </div>

          <div ref="targetTransliterationElement">
           <TransliterationSection :information="information" :isFullScreen="isFullScreen" :expanded="expanded" :showMoreLink="showMoreLink" :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @toggle-full-screen="toggleFullScreen" @handle-touch-start="handleTouchStart" @handle-touch-move="handleTouchMove" @handle-touch-end="handleTouchEnd" @toggle-expand="toggleExpand" @close-alert-text="closeAlertText" />
          </div>

          <div class="container-fluid text-center mobile-only">
            <div class="row">
              <div class="col">
              </div>
              <div class="col">
                <button @click="toggleContent" class="button-63 text-center mobile-only">
                  {{ isOpen ? 'Close Toolbar' : 'Open Toolbar' }}
                </button>
              </div>
              <div class="col">
              </div>
            </div>
          </div>
            

            <!-- toolbar mobile -->
            <div v-if="isOpen" class="collapse-content mobile-only">
              <div class="card text-bg-light card-body">
                <!-- Your content here -->
                <TransliterationActions :targetTransliterationRef="'targetTransliterationElement'" :transliteration="transliteration" @open-modal="openModal" @submit-form="submitForm" />
                <PdfDownload class="pl-2 pb-2 mt-2 text-left" :targetTransliterationRef="'targetTransliterationElement'" />
              </div>
            </div>
            <!-- end toolbar mobile -->

          
          <AlertModal :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @close-alert-text="closeAlertText" />
          <SurahInfoModal :information="information" />

         </div>
        </div>

       </div>

      </div>

     </div>
     <BookmarksAndNotes :information="information" />
     <CorrectionModal />
     <!-- Modals -->
     <TranslationNote ref="translationNote" :information="modalInformation" />
     <TafseerNote ref="tafseerNote" :information="modalInformation" />
     <TransliterationNote ref="transliterationNote" :information="modalInformation" />

    </div>

   </div>
   <!-- Bootstrap Modal for Theme Selection -->
   <div class="modal fade" id="themeModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
     <div class="modal-content">
      <div class="modal-header">
       <h5 class="modal-title" id="themeModalLabel">Select a Theme</h5>
       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <!-- Theme Selection Dropdown -->
       <select v-model="selectedStyle" @change="applyTheme" class="form-select">
        <option disabled value="">Select a theme</option>
        <option v-for="style in styles" :key="style.name" :value="style">
         {{ style.name }}
        </option>
       </select>
       <!-- Confirmation Message -->
       <div v-if="showMessage" class="mt-3 alert alert-success">
        {{ message }}
       </div>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
     </div>
    </div>
   </div>

   <!-- Bootstrap Modal -->
   <div class="modal fade" id="styleModal" tabindex="-1" aria-labelledby="styleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
     <div class="modal-content">
      <div class="modal-header">
       <h5 class="modal-title" id="styleModalLabel">Customize Your Layout</h5>
       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-left">
       <form>
        <div class="mb-3">
         <label for="bgColor" class="form-label">Background Color</label>
         <input type="color" id="bgColor" v-model="bgColor" class="form-control">
        </div>
        <div class="mb-3">
         <label for="textColor" class="form-label">Text Color</label>
         <input type="color" id="textColor" v-model="textColor" class="form-control">
        </div>
        <div class="mb-3">
         <label for="fontFamily" class="form-label">Font Family</label>
         <select id="fontFamily" v-model="fontFamily" class="form-control">
          <option v-for="font in fontFamilies" :key="font" :value="font">
           {{ font }}
          </option>
         </select>
        </div>
        <div class="mb-3">
          <label for="fontFamily" class="form-label">Shadow Style</label>
          <select v-model="selectedShadow" id="shadow-dropdown" class="form-control">
            <option v-for="shadow in shadows" :key="shadow.name" :value="shadow.style">
              {{ shadow.name }}
            </option>
          </select>
        </div>
        <div class="mb-3">
         <label for="fontSize" class="form-label">Font Size (px)</label>
         <input type="number" id="fontSize" v-model.number="fontSize" class="form-control">
        </div>
        <div class="mb-3">
         <label for="fontSpacing" class="form-label">Font Spacing (px)</label>
         <input type="number" id="fontSpacing" v-model.number="fontSpacing" class="form-control col-md-8">
        </div>
       </form>
       <!-- Success message -->
       <div v-if="showSuccessMessage" class="alert alert-success" role="alert">
        Styles have been successfully applied!
       </div>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       <button type="button" class="btn btn-success" @click="applyCustomStyles">Apply Styles</button>
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
import CustomSurahSelection from './surah_selection/CustomSurahSelection.vue';
import SearchForm from './search/SearchForm.vue';
import SurahList from './search/SurahList.vue';
import SurahDropdown from './search/SurahDropdown.vue';
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
import SwipeGestures from './swipe_gestures/SwipeGestures.vue';
import AyahSearchVerseNum from './search/AyahSearchVerseNum.vue';
import ErrorAlert from './search/ErrorAlert.vue';
import AyahDropdown from './search/AyahDropdown.vue';
import CopyTranslationText from './translation/features/copy_text/CopyTranslationText.vue';
import CopyTafseerText from './translation/features/copy_text/CopyTranslationText.vue';
import CopyTransliterationText from './translation/features/copy_text/CopyTransliterationText.vue';
import ScreenTranslationCapture from './translation/features/screen_capture/ScreenTranslationCapture.vue';
import ScreenTafseerCapture from './translation/features/screen_capture/ScreenTafseerCapture.vue';
import ScreenTransliterationCapture from './translation/features/screen_capture/ScreenTransliterationCapture.vue';
import SurahInfoModal from './modals/SurahInfoModal.vue';
import TwitterShareTranslation from './translation/features/twitter/TwitterShareTranslation.vue';
import TwitterShareTafseer from './translation/features/twitter/TwitterShareTafseer.vue';
import TwitterShareTransliteration from './translation/features/twitter/TwitterShareTransliteration.vue';
import WhatsAppShareTranslation from './translation/features/whatsapp/WhatsAppShareTranslation.vue';
import WhatsAppShareTafseer from './translation/features/whatsapp/WhatsAppShareTafseer.vue';
import WhatsAppShareTransliteration from './translation/features/whatsapp/WhatsAppShareTransliteration.vue';
import TranslationNote from './translation/features/notes/TranslationNote.vue';
import TafseerNote from './translation/features/notes/TafseerNote.vue';
import TransliterationNote from './translation/features/notes/TransliterationNote.vue';
import BookmarkTranslation from './translation/features/bookmarking/BookmarkTranslation.vue';
import FilteredSurahList from './search/FilteredSurahList.vue'
import TafseerSection from './TafseerSection.vue'
import TranslationSection from './TranslationSection.vue'
import TransliterationSection from './TransliterationSection'
import TranslationActions from './TranslationActions.vue'
import TafseerActions from './TafseerActions.vue'
import TransliterationActions from './TransliterationActions.vue'
import SpeechRecognition from './translation/features/speech_recognition/SpeechRecognition.vue';
import ColorPicker from './color_picker/ColorPicker.vue';
import FontStyleSelector from './FontStyleSelector.vue'
import SpeechToText from './SpeechToText.vue';
import PdfDownload from './pdf/PdfDownload.vue'

export default {
 name: 'QuranComponent',
 props: {},
 components: {
  CustomSurahSelection,
  SurahList,
  SurahDropdown,
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
  SwipeGestures,
  AyahSearchVerseNum,
  ErrorAlert,
  AyahDropdown,
  CopyTranslationText,
  CopyTafseerText,
  CopyTransliterationText,
  ScreenTranslationCapture,
  ScreenTafseerCapture,
  ScreenTransliterationCapture,
  SurahInfoModal,
  TwitterShareTranslation,
  TwitterShareTransliteration,
  TwitterShareTafseer,
  WhatsAppShareTranslation,
  WhatsAppShareTafseer,
  WhatsAppShareTransliteration,
  TranslationNote,
  TafseerNote,
  TransliterationNote,
  BookmarkTranslation,
  FilteredSurahList,
  TafseerSection,
  TranslationSection,
  TransliterationSection,
  TranslationActions,
  TafseerActions,
  TransliterationActions,
  SpeechRecognition,
  FontStyleSelector,
  SpeechToText,
  PdfDownload
 },

 mounted() {
  this.getSurat(); // Call getSurat to populate the surah list
  this.loadSettings();
  const savedSettings = JSON.parse(localStorage.getItem('userStyles'));
  if (savedSettings) {
   this.bgColor = savedSettings.bgColor || '#ffffff';
   this.textColor = savedSettings.textColor || '#000000';
   this.fontFamily = savedSettings.fontFamily || 'Arial, sans-serif';
   this.fontSize = savedSettings.fontSize || 1;
   this.fontSpacing = savedSettings.fontSpacing || 1;
  }
 },
 data() {
  return {
    isOpen: false,
    
    styles: [{
     name: 'Default',
     backgroundColor: '#ffffff',
     textColor: '#000000'
    },
    {
     name: 'Dyslexia',
     backgroundColor: '#FDFD96',
     textColor: '#000080',
     fontStyle: 'Arial, sans-serif'
    },
    {
     name: 'Dysgraphia',
     backgroundColor: '#FFFDD0',
     textColor: '#00008B',
     fontStyle: "'Arial, sans-serif"
    },
    {
     name: 'Hyperlexia',
     backgroundColor: '#F5F5DC',
     textColor: '#06402B',
     fontStyle: "''Arial, sans-serif"
    },
    {
     name: 'Visual Proccesing disorder',
     backgroundColor: '#fff',
     textColor: 'black',
     fontStyle: 'Arial, sans-serif'
    },
    {
     name: 'ADHD',
     backgroundColor: '#ADD8E6',
     textColor: '#696969',
     fontStyle: "Arial, sans-serif"
    },
   ],
   fontFamilies: [
    'Arial, sans-serif',
    'Courier New, Courier, monospace',
    'Georgia, serif',
    'Times New Roman, Times, serif',
    'Verdana, sans-serif',
    'Trebuchet MS, sans-serif',
    'Tahoma, sans-serif',
    'Impact, sans-serif',
    'Comic Sans MS, cursive, sans-serif',
    'Helvetica, Arial, sans-serif'
   ],
   // List of shadow options
    shadows: [
      { name: 'None', style: 'none' },
      { name: 'Small Shadow', style: '1px 1px 2px rgba(0, 0, 0, 0.5)' },
      { name: 'Medium Shadow', style: '2px 2px 4px rgba(0, 0, 0, 0.5)' },
      { name: 'Large Shadow', style: '4px 4px 8px rgba(0, 0, 0, 0.5)' },
      { name: 'Deep Shadow', style: '6px 6px 12px rgba(0, 0, 0, 0.7)' },
      { name: 'Soft Glow', style: '0px 0px 10px rgba(255, 255, 255, 0.7)' },
      { name: 'Dark Glow', style: '0px 0px 10px rgba(0, 0, 0, 0.9)' },
    ],
   selectedStyle: this.getStoredStyle() || {
    name: 'Default',

   },
   isCollapsed: false,
   showSuccessMessage: false,
   showMessage: false,
   message: 'Theme has been applied successfully!',
   filteredSurah: [],
   selectedShadow: 'none',
   fontSize: 16, // in pixels
   fontSpacing: 0, // in pixels
   fontFamily: 'Arial, sans-serif',
   backgroundColor: '#ffffff',
   textColor: '#000000',
   //twitter/whatsapp
   information: {
    translation: '',
    transliteration: '', // Example translated text
   },
   tafseer: '',
   //custom surah collection
   customSuratList: [],
   selectedSurah: 1,
   // track selected id
   selectedSurahId: 0,
   selectedAyahId: 0,
   // initialize empty arrays
   data: [],
   surat: [],
   ayat: [],
   tafseers: [],
   // storage
   information: null,
   tafseer: null,
   surah: null,
   ayah_id: null,
   // ayah controls
   surat: 0,
   selectedIndexAyah: 0,
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
 computed: {
  containerStyle() {
   return {
    backgroundColor: this.bgColor,
    color: this.textColor,
    fontFamily: this.fontFamily,
    fontSize: `${this.fontSize}px`,
    letterSpacing: `${this.fontSpacing}px`
   };
  },
  shadowStyle() {
    return {
      textShadow: this.selectedShadow,
      fontSize: '16px',
      fontWeight: 'bold',
      color: '#333',
    };
  },
 },
 methods: {
   toggleContent() {
      this.isOpen = !this.isOpen; // Toggle the content's visibility
    },
  toggleCollapse() {
    this.isCollapsed = !this.isCollapsed;
  },
  openModal(modalId) {
   const modalElement = this.$refs[modalId];
   if (modalElement) {
    const modalInstance = Modal.getInstance(modalElement) || new Modal(modalElement);
    modalInstance.show();
   } else {
    console.error(`Modal reference '${modalId}' not found.`);
   }
  },
  showModal() {
   const modal = new bootstrap.Modal(document.getElementById('styleModal'));
   modal.show();
   this.successMessage = ''; // Reset the success message when the modal is opened
  },
  applyCustomStyles() {
   this.saveSettings();
   this.showSuccessMessage = true; // Show the success message
   setTimeout(() => {
    const modal = bootstrap.Modal.getInstance(document.getElementById('styleModal'));
    this.showSuccessMessage = false; // Hide the success message before closing the modal
    modal.hide();
   }, 2000); // Display the success message for 2 seconds before closing the modal
  },
  saveSettings() {
   const settings = {
    bgColor: this.bgColor,
    textColor: this.textColor,
    fontSize: this.fontSize,
    fontFamily: this.fontFamily,
    fontSpacing: this.fontSpacing
   };
   localStorage.setItem('userStyles', JSON.stringify(settings));
  },
  loadSettings() {
   const savedSettings = JSON.parse(localStorage.getItem('userStyles'));
   if (savedSettings) {
    this.bgColor = savedSettings.bgColor || '#ffffff';
    this.textColor = savedSettings.textColor || '#000000';
    this.fontSize = savedSettings.fontSize || 16;
    this.fontSpacing = savedSettings.fontSpacing || 1;
    this.fontFamily = savedSettings.fontFamily || 'Arial, sans-serif';
   }
  },
  applyTheme() {
   this.saveStyle();
   this.showMessage = true;
   setTimeout(() => this.showMessage = false, 3000); // Hide message after 3 seconds
  },
  saveStyle() {
   localStorage.setItem('selectedStyle', JSON.stringify(this.selectedStyle));
  },
  getStoredStyle() {
   const storedStyle = localStorage.getItem('selectedStyle');
   return storedStyle ? JSON.parse(storedStyle) : null;
  },
  toggleVisibility() {
   this.isVisible = !this.isVisible;
  },
  handleTranscript(transcript) {
   this.transcript = transcript;
  },
  openModal(modalRef) {
   const modalComponent = this.$refs[modalRef];
   if (modalComponent && typeof modalComponent.showModal === 'function') {
    modalComponent.showModal();
   } else {
    console.error(`Modal reference '${modalRef}' not found or showModal is not a function.`);
   }
  },
  updateSelectedSurah(surah) {
   this.selectedSurah = surah;
   this.selectedSurahId = surah.id; // Assuming `surah` object has an `id` field
  },
  updateSelectedSurah(newSurah) {
   this.selectedSurah = newSurah;
  },
  updateInformation(newInformation) {
   this.information = newInformation;
  },
  updateTafseer(newTafseer) {
   this.tafseer = newTafseer;
  },
  handleUpdateResults(results) {
   this.filteredSurah = results;
  },
  handleClearResults() {
   this.filteredSurah = [];
  },
  handleSelectSurah(surahId) {
   this.selectedSurah = surahId;
   this.filteredSurah = []; // Hide the search results list
  },
  selectSurahFromResults(surah) {
   this.selectedSurah = surah.id;
   this.filteredSurah = []; // Hide the search results list
  },
  handleScrollToAyah(verseNumber) {
   this.$nextTick(() => {
    const ayahElement = this.$refs.ayahContainer.querySelector(`#ayah-${verseNumber}`);
    if (ayahElement) {
     ayahElement.scrollIntoView({
      behavior: 'smooth'
     });
    } else {
     console.error('Ayah not found:', verseNumber);
    }
   });
  },

  toggleExpand() {
   this.expanded = !this.expanded;
  },
  getSelectedSurahAyat() {
    const surahData = this.surat.find(surah => surah.id === parseInt(this.surah));
   return surahData ? surahData.ayat : [];
   if (this.surat[this.surah]) {
    return this.surat[this.surah].ayat;
   }
   return [];
  },
  updateAyah(newIndex) {
   this.selectedIndexAyah = newIndex;
   console.log(`Selected Ayah: ${newIndex}`);
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
  },
  onSwipeRight() {
   this.goToNextAyah();
   console.log('Swiped right');
  },
  goToFirstAyah() {
   this.selectAyah(0);
  },
  goToPreviousAyah() {
   if (this.selectedIndexAyah > 0) {
    this.selectAyah(this.selectedIndexAyah - 1);
   } else {
    this.selectAyah(this.ayat.length - 1);
   }
  },
  goToNextAyah() {
   if (this.selectedIndexAyah < this.ayat.length - 1) {
    this.selectAyah(this.selectedIndexAyah + 1);
   } else {
    this.selectAyah(0);
   }
  },
  goToLastAyah() {
   this.selectAyah(this.ayat.length - 1);
  },
  truncatedText(text) {
   const maxLength = 300; // Define your desired max length here
   if (text.length > maxLength) {
    return text.substring(0, maxLength) + '...';
   } else {
    return text;
   }
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
    $('#exampleModal1').modal('show');
   } else {
    this.showAlertTextNote = true;
   }
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
   if (!isNaN(verseNum) && verseNum >= 1 && verseNum <= this.ayat.length) {
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
     this.showError = false;
    }, 5000);
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

  async getSurat() {
   try {
    const response = await axios.get('/get_surat'); // Update the URL to match your backend
    this.surat = response.data;
   } catch (error) {
    console.error('Error fetching surahs:', error);
   }
  },
  async getAyat() {

   if (this.selectedSurahId > 0) {
    try {
     const response = await axios.get('/get_ayat', {
      params: {
       surah_id: this.selectedSurahId
      },
     });
     this.ayat = response.data;
     this.dropdownHidden = false; // Show Ayah dropdown after fetching
    } catch (error) {
     console.error('Error fetching ayat:', error);
    }
   } else {
    this.ayat = [];
    this.dropdownHidden = true; // Hide Ayah dropdown if no Surah is selected
   }
  },


  async handleAyahChange() {
   const selectedAyahIndex = parseInt(this.selectedAyahId);
   const selectedAyah = this.ayat[selectedAyahIndex];
   if (selectedAyah) {
    const ayahId = selectedAyah.ayah_id;
    try {
     const tafseerResponse = await axios.get(`/tafseer/${ayahId}/fetch`);
     this.tafseer = tafseerResponse.data;

     const infoResponse = await axios.get('/get_informations', {
      params: {
       id: ayahId
      },
     });
     this.information = infoResponse.data;
    } catch (error) {
     console.error('Error fetching information or tafseer:', error);
    }
   }
  },
  showCard() {
   this.isCardVisible = true; // Show the card when button is clicked
  },
  selectAyah(index) {
   this.selectedIndexAyah = index;
   this.scrollToSelectedAyah();
   this.getTafseers(this.ayat[index].id, index);
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
   const currentIndex = this.ayat.findIndex(ayah => ayah.id === this.selectedAyah.id);
   if (currentIndex !== -1 && currentIndex < this.ayat.length - 1) {
    return this.ayat[currentIndex + 1];
   }
   return null;
  },
  determinePreviousAyah() {
   const currentIndex = this.ayat.findIndex(ayah => ayah.id === this.selectedAyah.id);
   if (currentIndex > 0) {
    return this.ayat[currentIndex - 1];
   }
   return null;
  },
  selectSurah() {
   this.ayat = this.fetchAyatForSurah(this.surah); // Replace with actual logic
   this.selectedAyah = this.ayat.length > 0 ? '0' : '0'; // Select the first ayah
  },
  selectSurah(surahId) {
   this.surah = surahId;
   this.searchTerm = '';
   this.filteredSurah = [];
   this.showClearButton = false;
   this.getAyat();

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
 },

 created() {
  // Initialize submitted status for each bookmark
  this.ayat.forEach(ayah => {
   const submitted = localStorage.getItem(`bookmarkSubmitted_${ayah.id}`);
   if (submitted) {
    this.$set(this.bookmarkSubmitted, ayah.id, true);
   }
  });
 },

 watch: {
  selectedSurah(newSurah) {
   this.selectedSurahId = newSurah;
   this.getAyat();
  },

  'information.ayah.surah.name_ar': 'updateFileName',
  verseNumber(newVal, oldVal) {
   if (newVal !== oldVal && parseInt(newVal)) {
    this.selectedIndexAyah = parseInt(newVal) - 1;
   }
  },
 },
}
</script>

<style scoped src="./css/styles.css">
.button-33 {
  background-color: rgba(0, 191, 166, 0.2);
  color: rgb(5, 32, 29);
  border: 1px solid rgba(0, 191, 166);
}
</style>
