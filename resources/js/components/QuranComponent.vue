<template>
<div id="app">
 <div class="pt-3 text-center">
  <Title />
   <div style="display:flex" class="container align-items-center">
    <search-form  :surat="surat" @update-results="handleUpdateResults" @clear-results="handleClearResults" @select-surah="handleSelectSurah" />
    <!-- Toggle Button for Advanced Search -->
    <i @click="toggleAdvancedSearch" :class="isAdvancedSearchVisible ? 'bi bi-dash-circle' : 'bi bi-arrow-down-circle-fill'" class="toggle-icon h3"></i>
  </div>
  <AdvancedSearch v-if="isAdvancedSearchVisible" @input-change="handleInputChange" />
   
  <custom-surah-selection :customSurat="customSuratList" v-model="selectedSurah"></custom-surah-selection>
 </div> 
    

 <!-- accordion headers -->
 <div class="row container-fluid">
  <div class="col-md-4 container">
   <FilteredSurahList :filteredSurah="filteredSurah" @select-surah="selectSurahFromResults" />
   <Donation />
   <div style="display:flex" class="row">
    <SurahDropdown class="col-md-12" :selectedSurah="selectedSurah" :filteredSurah="filteredSurah" :surat="surat" @update:selectedSurah="updateSelectedSurah" @change="getAyat" />
    
    <AddBookmark />
    
   </div>
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

      <div :style="iconStyle" class="icon-container pb-2">
       <i class="bi bi-chevron-bar-left h4" style="color:#00BFA6" @click="goToFirstAyah" title="First verse"></i>
       <i class="bi bi-arrow-left-circle h4" style="color:#00BFA6" @click="goToPreviousAyah" title="Previous verse"></i>
       <i class="bi bi-arrow-right-circle h4" style="color:#00BFA6" @click="goToNextAyah" title="Next verse"></i>
       <i class="bi bi-chevron-bar-right h4" style="color:#00BFA6" @click="goToLastAyah" title="Last verse"></i>
       <i v-if="information != null" class="bi bi-info-circle-fill h4 mr-2 pl-2" style="color:#00BFA6" data-bs-toggle="modal" data-bs-target="#translationInfo" aria-expanded="false" data-bs-placement="top" title="Surah info"></i>
      </div>

      <div class="custom-scrollbar pb-5" style="overflow-y: auto; max-height: 600px; background: white;border-radius:10px">
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
  <div class="card content" >
    <div class="content" >
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
             {{ information.ayah.surah.text }}
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
  
        <!-- desktop top features -->
        <div :style="iconStyle">
          <div class="col pb-2 ">
            <i  :class="isOpen ? 'bi bi-x-circle-fill' : 'bi bi-plus-circle-fill'" class="top-toolbar-btn text-left hide-on-mobile h4" @click="toggleContent"></i>
          </div>
          <div v-if="isOpen" class=" hide-on-mobile ">
            <div class="text-center">
              <div  class="row pt-2">
                <div class="col"><i  class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="openModal('translationNote')" ></i></div>
                <div class="col"><WhatsAppShareTranslation :translationToShare="information.translation" /></div>
                <div class="col"><TwitterShareTranslation  :targetElementRef="'targetElement'" :translationText="information.translation" /></div>
                <div class="col"><i 
                  @click="submitForm" 
                  class="bi bi-bookmark text-right mr-2 h4" 
                  aria-expanded="false" 
                  title="Bookmark verse"
                ></i>
                </div>
                <div class="col"><CopyTranslationText  :textToCopy="information.translation" /></div>
                <div class="col"><ScreenTranslationCapture  :targetTranslationRef="'targetTranslationElement'" /></div>
                <div class="col"><PdfDownload  :targetTranslationRef="'targetTranslationElement'" /></div>
                <div class="col"><i class="bi bi-paint-bucket h2"  @click="showModal"></i></div>
                <div class="col"><i title="Report a bug"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" ></i></div>
                <div class="col"><i class="bi bi-arrows-fullscreen h4" @click="toggleFullScreen" title="Full screen"></i></div>
              </div>
            </div>
            <hr style="border: 2px solid #333;"> 
                   
          </div>                      
        </div>
          
         <!-- mobile navigation  ---->
        <div class="dropdown mobile-only pb-2">
          <div :style="iconStyle" class="icon-container">
            <i class="bi bi-chevron-bar-left h4" @click="goToFirstAyah()" title="Last verse"></i>
            <i class="bi bi-arrow-left-circle h4" @click="goToPreviousAyah()" title="Previous verse"></i>
            <i class="bi bi-arrow-right-circle h4" @click="goToNextAyah()" title="Next verse"></i>
            <i class="bi bi-chevron-bar-right h4" @click="goToLastAyah()" title="End verse"></i>
            <i class="bi bi-paint-bucket h2" @click="showModal"></i>
            <i class="bi bi-arrows-fullscreen h6" @click="toggleFullScreen" title="Full screen"></i>
          </div>
        </div>

        <!-- dropdown mobile content -->
        <div>
          <div class="pt-2" ref="targetTranslationElement" >
            <TranslationSection  
              :information="information" 
              :isFullScreen="isFullScreen" 
              :expanded="expanded" 
              :showMoreLink="showMoreLink" 
              :showAlertText="showAlertText" 
              :showAlert="showAlert" 
              :showErrorAlert="showErrorAlert" 
              :showAlertTextNote="showAlertTextNote" 
              @toggle-full-screen="toggleFullScreen" 
              @handle-touch-start="handleTouchStart" 
              @handle-touch-move="handleTouchMove" 
              @handle-touch-end="handleTouchEnd" 
              @toggle-expand="toggleExpand" 
              @close-alert-text="closeAlertText" 
            />          
          </div>
          
          <!-- open toolbar -->
          <div class="container-fluid text-center mobile-only">
            <div class="row">
              <div class="col">
                <i :class="isOpen ? 'bi bi-x-circle' : 'bi bi-plus-circle-fill'" class="text-center mobile-only h3 pt-3" @click="toggleContent"></i>
              </div>
            </div>
          </div>
          <!-- toolbar mobile -->
          <div v-if="isOpen" class="collapse-content mobile-only">
            <div class="card text-bg-light card-body">
              <TranslationActions :targetTranslationRef="'targetTranslationElement'" :translation="translation" @open-modal="openModal" @submit-form="submitForm" />
            </div>
          </div>
        </div>

       </div>

       <!-- Tafseer Section -->
      <div class="tab-pane content" id="profile" role="tabpanel" v-if="information != null">
        <div >
     
         <!-- desktop top features -->
          <div :style="iconStyle">
            <div class="col pb-2">
              <i  :class="isOpen ? 'bi bi-x-circle-fill' : 'bi bi-plus-circle-fill'" class="top-toolbar-btn text-left hide-on-mobile h4" @click="toggleContent"></i>
            </div>
            <div v-if="isOpen" class="icon-container-fluid hide-on-mobile ">
              <div class=" text-center">
                <div  class="row pt-2">
                  <div class="col">
                  <i  class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="openModal('tafseerNote')" ></i></div>
                  <div class="col">
                    <WhatsAppShareTranslation 
                      :targetElementRef="'targetElement'" 
                      :translationToShare="information.translation" 
                    />
                  </div>
                  <div class="col">
                    <TwitterShareTranslation  
                      :targetElementRef="'targetElement'" 
                      :translationText="information.translation" 
                    />
                  </div>
                              
                  <div class="col"><i 
                    @click="submitFormTafseer()" 
                    class="bi bi-bookmark text-right mr-2 h4" 
                    aria-expanded="false" 
                    data-bs-placement="top" 
                    title="Bookmark verse"
                  ></i>
                  </div>   
                  <div class="col"><CopyTafseerText  :textToCopy="information.tafseer" /></div>
                  <div class="col"><ScreenTafseerCapture  :targetTafseerRef="'targetTafseerElement'" /></div>
                  <div class="col"><PdfDownloadTafsser  :targetTafseerRef="'targetTafseerElement'" class="h3"/></div>
                  <div class="col"><i class="bi bi-paint-bucket h2"  @click="showModal"></i></div>
                  <div class="col"><i title="Report a bug"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" ></i></div>
                  <div class="col"><i class="bi bi-arrows-fullscreen h4" @click="toggleFullScreen" title="Full screen"></i></div>
                </div>
              </div>
              <hr style="border: 2px solid #333;">               
            </div>                      
          </div>

         <!-- mobile navigation  ---->
         <div class="dropdown mobile-only">
          <div :style="iconStyle" class="icon-container pb-2">
           <i class="bi bi-chevron-bar-left h4"  @click="goToFirstAyah()" title="Last verse"></i>
           <i class="bi bi-arrow-left-circle h4"  @click="goToPreviousAyah()" title="Previous verse"></i>
           <i class="bi bi-arrow-right-circle h4"  @click="goToNextAyah()" title="Next verse"></i>
           <i class="bi bi-chevron-bar-right h4"  @click="goToLastAyah()" title="End verse"></i>
           <i class="bi bi-paint-bucket h2"  @click="showModal"></i>
           <i class="bi bi-arrows-fullscreen h6"  @click="toggleFullScreen" title="Full screen"></i>
          </div>
         </div>
        </div>

        <!-- Main content  -->
        <div class="pt-2" ref="targetTafseerElement">
         <TafseerSection :information="information" :isFullScreen="isFullScreen" :expanded="expanded" :showMoreLink="showMoreLink" :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @toggle-full-screen="toggleFullScreen" @handle-touch-start="handleTouchStart" @handle-touch-move="handleTouchMove" @handle-touch-end="handleTouchEnd" @toggle-expand="toggleExpand" @close-alert-text="closeAlertText" />
        </div>

        <div class="container-fluid text-center mobile-only">
          <div class="row">
            <div class="col">
              <i :class="isOpen ? 'bi bi-x-circle' : 'bi bi-plus-circle-fill'" class="text-center mobile-only h3 pt-3" @click="toggleContent"></i>
            </div>
          </div>
        </div>
        
        <!-- toolbar mobile -->
        <div v-if="isOpen" class="collapse-content mobile-only" >
          <div class="card text-bg-light card-body">
            <TafseerActions :targetTafseerRef="'targetTafseerElement'" :tafseer="tafseer" @open-modal="openModal" @submit-form="submitForm" />
          </div>
        </div>


        <SurahInfoModal :information="information" />
      </div>

       <!-- Transliteration Section -->
       <div class="tab-pane content" id="messages" role="tabpanel" v-if="information != null">
        <div class="">
         <div>
          <!-- Ayah Controls -->
          <div class=" pb-3">

            <!-- desktop top features -->
          <div :style="iconStyle">
            <div class="col pb-2 ">
              <i  :class="isOpen ? 'bi bi-x-circle-fill' : 'bi bi-plus-circle-fill'" class="top-toolbar-btn text-left hide-on-mobile h4" @click="toggleContent"></i>
            </div>
            <div v-if="isOpen" class=" hide-on-mobile ">
              <div class="text-center">
                <div  class="row pt-2">
                  <div class="col"><i  class="bi bi-file-earmark-text text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" title="Write a note" @click="openModal('transliterationNote')" ></i></div>
                  <div class="col"><WhatsAppShareTransliteration :transliterationToShare="information.transliteration" /></div>
                  <div class="col"><TwitterShareTransliteration  :targetElementRef="'targetElement'" :transliterationText="information.transliteration" /></div>
                  <div class="col"><i 
                    @click="submitFormTransliteration" 
                    class="bi bi-bookmark text-right mr-2 h4" 
                    aria-expanded="false" 
                    title="Bookmark verse"
                  ></i></div>
                  <div class="col"><CopyTransliterationText  :textToCopy="information.transliteration" /></div>
                  <div class="col"><ScreenTransliterationCapture  :targetTransliterationRef="'targetTransliterationElement'" /></div>
                  <div class="col"><PdfDownloadTransliteration  :targetTransliterationRef="'targetTransliterationElement'" /></div>
                  <div class="col"><i class="bi bi-paint-bucket h2"  @click="showModal"></i></div>
                  <div class="col"><i title="Report a bug"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="bi bi-bug text-right mr-2 h4" aria-expanded="false" data-bs-placement="top" ></i></div>
                  <div class="col"><i class="bi bi-arrows-fullscreen h4" @click="toggleFullScreen" title="Full screen"></i></div>
                </div>
              </div>
              <hr style="border: 2px solid #333;">                
            </div>                      
          </div>

           <!-- mobile navigation -->
           <div class="dropdown mobile-only">
            <div :style="iconStyle" class="icon-container">
             <i class="bi bi-chevron-bar-left h4" @click="goToFirstAyah()" title="Last verse"></i>
             <i class="bi bi-arrow-left-circle h4" @click="goToPreviousAyah()" title="Previous verse"></i>
             <i class="bi bi-arrow-right-circle h4" @click="goToNextAyah()" title="Next verse"></i>
             <i class="bi bi-chevron-bar-right h4" @click="goToLastAyah()" title="End verse"></i>
             <i class="bi bi-paint-bucket h2" @click="showModal"></i>
             <i class="bi bi-arrows-fullscreen h6" @click="toggleFullScreen" title="Full screen"></i>
            </div>
           </div>
          </div>

          <div ref="targetTransliterationElement">
           <TransliterationSection :information="information" :isFullScreen="isFullScreen" :expanded="expanded" :showMoreLink="showMoreLink" :showAlertText="showAlertText" :showAlert="showAlert" :showErrorAlert="showErrorAlert" :showAlertTextNote="showAlertTextNote" @toggle-full-screen="toggleFullScreen" @handle-touch-start="handleTouchStart" @handle-touch-move="handleTouchMove" @handle-touch-end="handleTouchEnd" @toggle-expand="toggleExpand" @close-alert-text="closeAlertText" />
          </div>

          <div class="container-fluid text-center mobile-only">
            <div class="row">
              <div class="col">
                <i :class="isOpen ? 'bi bi-x-circle' : 'bi bi-plus-circle-fill'" class="text-center mobile-only h3 pt-3" @click="toggleContent"></i>
              </div>
            </div>
          </div>

          <!-- toolbar mobile -->
          <div v-if="isOpen" class="collapse-content mobile-only" >
            <div class="card text-bg-light card-body">
              <TransliterationActions :targetTransliterationRef="'targetTransliterationElement'" :transliteration="transliteration" @open-modal="openModal" @submit-form="submitForm" />
            </div>
          </div>
          <!-- end toolbar mobile -->

          
          <SurahInfoModal :information="information" />

         </div>
        </div>

       </div>

       <!-- overview Section -->
       <div class="tab-pane content" id="data" role="tabpanel" v-if="information != null">
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
            <PdfDownload :targetTranslationRef="'targetTransliterationElement'" />
            -->
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

          <div ref="targetGroupElement">
            <GroupSection 
              :information="information"
              :isFullScreen="isFullScreen"
              :expanded="expanded"
              :showMoreLink="showMoreLink"
              :showAlertText="showAlertText"
              :showAlert="showAlert"
              :showErrorAlert="showErrorAlert"
              :showAlertTextNote="showAlertTextNote"
              @toggle-full-screen="toggleFullScreen"
              @handle-touch-start="handleTouchStart"
              @handle-touch-move="handleTouchMove"
              @handle-touch-end="handleTouchEnd"
              @toggle-expand="toggleExpand"
              @close-alert-text="closeAlertText"
            />
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
                <GroupActions :targetGroupRef="'targetGroupElement'" :transliteration="transliteration" @open-modal="openModal" @submit-form="submitForm" />
                <!--
                <PdfDownload class="pl-2 pb-2 mt-2 text-left" :targetTransliterationRef="'targetTransliterationElement'" />
                -->
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
     <!-- -->
     <div >
      <BookmarksAndNotes :information="information" :iconColor="iconColor" />
     </div>
     
     <CorrectionModal />
     <!-- Modals -->
     <TranslationNote ref="translationNote" :information="modalInformation" />
     <TafseerNote ref="tafseerNote" :information="modalInformation" />
     <TransliterationNote ref="transliterationNote" :information="modalInformation" />

    </div>

   </div>
 

    <!-- Bootstrap theme Modal -->
    <div class="modal fade" id="styleModal" tabindex="-1" aria-labelledby="styleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="styleModalLabel">Customize Your Layout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-left">
          
            <form>
              <div class="row">
                <!-- Row 1: Select Default Style and Background Color -->
                <div class="col-md-12">
                  <div class="mb-3">
                    <label for="styleSelect" class="form-label">Select Default Style</label>
                    <select
                      id="styleSelect"
                      v-model="selectedStyle"
                      @change="applyStyle"
                      class="form-control"
                    >
                      <option v-for="style in defaultStyles" :key="style.name" :value="style">
                        {{ style.name }}
                      </option>
                    </select>
                  </div>
                </div>

                <hr class="container">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="bgColor" class="form-label">Background Color</label>
                    <input type="color" id="bgColor" v-model="bgColor" class="form-control" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="iconColor" class="form-label">Icons Color</label>
                    <input type="color" id="iconColor" v-model="iconColor" class="form-control" />
                  </div>
                </div>

                <!-- Row 2: Text Color and Shadow Style -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="textColor" class="form-label">Text Color</label>
                    <input type="color" id="textColor" v-model="textColor" class="form-control" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="shadow-dropdown" class="form-label">Shadow Style</label>
                    <select v-model="selectedShadow" id="shadow-dropdown" class="form-control">
                      <option v-for="shadow in shadows" :key="shadow.name" :value="shadow.style">
                        {{ shadow.name }}
                      </option>
                    </select>
                  </div>
                </div>

                <!-- Row 3: Font Style Checkboxes -->
                <div class="col-md-6">
                  <div class="mb-3" >
                    <label class="form-label">Font Style</label>
                    <div class="form-check" style="display:flex">
                      <input class="form-check-input" type="checkbox" id="boldCheckbox" v-model="isBold" />
                      <label class="form-check-label" for="boldCheckbox">Bold</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="italicCheckbox" v-model="isItalic" />
                      <label class="form-check-label" for="italicCheckbox">Italic</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="lightCheckbox" v-model="isLight" />
                      <label class="form-check-label" for="lightCheckbox">Light</label>
                    </div>
                  </div>
                </div>
                <!-- Row 4: Text Transformation and Text Alignment -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Text Transformation</label>
                    <select v-model="textTransform" class="form-control">
                      <option value="none">None</option>
                      <option value="uppercase">Uppercase</option>
                      <option value="lowercase">Lowercase</option>
                      <option value="capitalize">Capitalize</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="fontFamily" class="form-label">Font Family</label>
                    <select id="fontFamily" v-model="fontFamily" class="form-control">
                      <option v-for="font in fontFamilies" :key="font" :value="font">
                        {{ font }}
                      </option>
                    </select>
                  </div>
                </div>
                <!-- Row 5: Font Size and Font Spacing -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="fontSize" class="form-label">Font Size (px)</label>
                    <input
                      type="number"
                      id="fontSize"
                      v-model.number="fontSize"
                      class="form-control"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="fontSpacing" class="form-label">Font Spacing (px)</label>
                    <input
                      type="number"
                      id="fontSpacing"
                      v-model.number="fontSpacing"
                      class="form-control"
                    />
                  </div>
                </div>
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
import SpeechToText from './SpeechToText.vue'
import PdfDownload from './pdf/PdfDownload.vue'
import PdfDownloadTafsser from './pdf/PdfDownloadTafsser.vue'
import PdfDownloadTransliteration from './pdf/PdfDownloadTransliteration.vue'
import AdvancedSearch from './search/AdvancedSearch.vue'

import AddBookmark from './folder_manager/AddBookmark.vue';
import FolderSelectionModal from './folder_manager/FolderSelectionModal.vue';
import GroupSection from './GroupSection.vue';


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
  PdfDownload,
  AddBookmark,
  FolderSelectionModal,
  GroupSection,
  PdfDownloadTransliteration,
  PdfDownloadTafsser,
  AdvancedSearch
 },

 mounted() {
  this.loadSavedStyles();
  this.applyStylesToCards(); // Ensure styles are applied to cards initially
  this.getSurat(); // Call getSurat to populate the surah list
  this.initRecognition();
  if (this.defaultStyles.length > 0) {
    this.selectedStyle = this.defaultStyles[0];
    this.applyStyle();
  }
  this.loadBackgroundColor();
},
props: ['information', 'selectedFolderId'],
 data() {
  return {
    isAdvancedSearchVisible: false, // Controls the visibility of AdvancedSearch
    searchTerm: "",
    results:[],
    filteredResults: [],
    selectedSurah: null,
    selectedAyah: null,
    selectedTafseer: null,
    userId: null,
    bookmarkSubmitted: false, // Set initial state
    selectedFolderId: null,
    isVisible1: false,
    isOpen: false,
    recognition: null,
    isListening: false,
    transcript: '',
    selectedStyle: null,
    defaultStyles: [
      {
        name: 'Default',
        backgroundColor: '#ffffff',
        iconColor: '#000000',
        textColor: '#000000',
        fontStyle: 'Arial, sans-serif',
        textShadow: 'None'
      },
      {
        name: 'Dyslexia',
        backgroundColor: '#FDFD96',
        iconColor: '#000000',
        textColor: '#000080',
        fontStyle: 'Arial, sans-serif',
        textShadow: 'None'
      },
      {
        name: 'Dysgraphia',
        backgroundColor: '#FFFDD0',
        iconColor: '#000000',
        textColor: '#00008B',
        fontStyle: 'Arial, sans-serif',
        textShadow: 'None'
      },
      {
        name: 'Hyperlexia',
        backgroundColor: '#F5F5DC',
        iconColor: '#000000',
        textColor: '#06402B',
        fontStyle: 'Arial, sans-serif',
        textShadow: 'None'
      },
      {
        name: 'Visual Proccesing disorder',
        backgroundColor: '#fff',
        iconColor: '#000000',
        textColor: 'black',
        fontStyle: 'Arial, sans-serif',
        textShadow: 'None'
      },
      {
        name: 'ADHD',
        backgroundColor: '#ADD8E6',
        iconColor: '#000000',
        textColor: '#696969',
        fontStyle: "Arial, sans-serif",
        textShadow: 'None'
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
    selectedStyle: {
      textColor: '#000',
      backgroundColor: '#fff',
      iconColor: '#000000',
    },
    // Initial styles
    fontFamily: 'Arial, sans-serif',
    fontSize: 16,
    fontSpacing: 0,
    selectedShadow: 'none',
    // Font style options
    isBold: false,
    isItalic: false,
    isLight: false,
    isUnderline: false,
    isStrikethrough: false,
    // Text transformation and alignment
    textTransform: 'none',
    textAlign: 'left',
    // For showing success message
    showSuccessMessage: false,   
    isCollapsed: false,
    showSuccessMessage: false,
    showMessage: false,
    message: 'Theme has been applied successfully!',
    filteredSurah: [],
   //twitter/whatsapp
   information: {
    translation: '',
    transliteration: '', // Example translated text
   },
   selectedSurahIndex: null,
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
   currentSurah: null,
   currentVerse: null,
   currentTafseer: '',
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
      letterSpacing: `${this.fontSpacing}px`,
      fontWeight: this.isBold ? 'bold' : this.isLight ? '300' : 'normal',
      fontStyle: this.isItalic ? 'italic' : 'normal',
      textShadow: this.selectedShadow,
      textDecoration: this.isUnderline ? 'underline' : this.isStrikethrough ? 'line-through' : 'none',
      textTransform: this.textTransform,
      textAlign: this.textAlign,
    };
  },
  iconStyle() {
      return {
        color: this.iconColor,
        fill: this.iconColor, // Add this line for SVG icons
      };
    },
    textStyle() {
      return {
        color: this.textColor,
      };
    }
},
methods: {
  submitForm() {
    // if (!this.selectedFolderId) {
      //   console.error("Folder ID is required.");
      //   this.showErrorAlert = true;
      //   this.hideAlertAfterDelay();
      //   return;
      // }
    const formData = {
      // folder_id: this.selectedFolderId,
      surah_name: this.information.ayah.surah.name_en,
      ayah_num: this.information.ayah_id,
      ayah_verse_ar: this.information.ayah.ayah_text,
      ayah_verse_en: this.information.translation,
      user_id: this.userId,
    };
    axios.post('/bookmarks', formData)
      .then(response => {
        console.log(response.data.message);
        localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
        this.showAlert = true;
        this.showErrorAlert = false;
        this.hideAlertAfterDelay();
        // Display a confirmation message with the bookmarked ayah and folder
        // this.$refs.bookmarkConfirmation.textContent = 
        //   `Successfully bookmarked ayah ${this.information.ayah_id} to folder "${this.selectedFolderId}"`;
      })
    },
  submitFormTafseer() {
    const formData = {
      // folder_id: this.selectedFolderId,
      surah_name: this.information.ayah.surah.name_en,
      ayah_num: this.information.ayah_id,
      ayah_verse_ar: this.information.ayah.ayah_text,
      ayah_verse_en: this.information.translation,
      user_id: this.userId,
    };
    axios.post('/bookmarks', formData)
      .then(response => {
        console.log(response.data.message);
        localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
        this.showAlert = true;
        this.showErrorAlert = false;
        this.hideAlertAfterDelay();
        // Display a confirmation message with the bookmarked ayah and folder
        // this.$refs.bookmarkConfirmation.textContent = 
        //   `Successfully bookmarked ayah ${this.information.ayah_id} to folder "${this.selectedFolderId}"`;
      })
    },
  submitFormTransliteration() {
    const formData = {
      // folder_id: this.selectedFolderId,
      surah_name: this.information.ayah.surah.name_en,
      ayah_num: this.information.ayah_id,
      ayah_verse_ar: this.information.ayah.ayah_text,
      ayah_verse_en: this.information.translation,
      user_id: this.userId,
    };
    axios.post('/bookmarks', formData)
      .then(response => {
        console.log(response.data.message);
        localStorage.setItem(`bookmarkSubmitted_${this.information.ayah_id}`, true);
        this.showAlert = true;
        this.showErrorAlert = false;
        this.hideAlertAfterDelay();
        // Display a confirmation message with the bookmarked ayah and folder
        // this.$refs.bookmarkConfirmation.textContent = 
        //   `Successfully bookmarked ayah ${this.information.ayah_id} to folder "${this.selectedFolderId}"`;
      })
    },
  hideAlertAfterDelay() {
    setTimeout(() => {
      this.showAlert = false;
      this.showErrorAlert = false;
    }, 3000); // Hide alerts after 3 seconds
  },
  toggleAdvancedSearch() {
    this.isAdvancedSearchVisible = !this.isAdvancedSearchVisible; // Toggle the visibility
  },
  async fetchSurahs() {
    try {
      const response = await fetch('/get_surat'); // Adjust the API endpoint as needed
      this.surat = await response.json();
    } catch (error) {
      console.error('Error fetching surahs:', error);
    }
  },
  async fetchRandomSurah() {
    if (this.surat.length === 0) {
      console.error('No surahs available');
      return;
    }

    const randomIndex = Math.floor(Math.random() * this.surat.length);
    this.selectedSurah = this.surat[randomIndex];

    try {
      const response = await fetch(`/api/ayah/${this.selectedSurah.id}`); // Fetch ayahs for the selected surah
      const ayahs = await response.json();
      this.selectedAyah = ayahs[Math.floor(Math.random() * ayahs.length)].ayah_text; // Randomly select an ayah
    } catch (error) {
      console.error('Error fetching ayahs:', error);
    }
  },
  toggleContent1() {
    this.isVisible1 = !this.isVisible1; // Toggle the visibility
  },
  openModal(modalName) {
    if (modalName === 'folderSelection') {
      const folderSelectionModal = this.$refs.folderSelectionModal;
      if (folderSelectionModal) {
        const bootstrapModal = new bootstrap.Modal(folderSelectionModal.$el);
        bootstrapModal.show();
      } else {
        console.error('Folder selection modal not found');
      }
    } else {
      console.error('Unknown modal:', modalName);
    }
  },
  initRecognition() {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!SpeechRecognition) {
      alert('Your browser does not support Speech Recognition.');
      return;
    }

    this.recognition = new SpeechRecognition();
    this.recognition.lang = 'en-US';
    this.recognition.interimResults = false;
    this.recognition.maxAlternatives = 1;

    this.recognition.onresult = (event) => {
      const result = event.results[0][0].transcript;
      this.transcript += result + '\n';
    };

    this.recognition.onerror = (event) => {
      console.error('Speech Recognition Error:', event.error);
    };

    this.recognition.onend = () => {
      this.isListening = false;
    };
  },
  startRecognition() {
    if (!this.recognition) {
      this.initRecognition();
    }
    this.transcript = ''; // Clear previous transcript
    this.recognition.start();
    this.isListening = true;
  },
  stopRecognition() {
    if (this.recognition && this.isListening) {
      this.recognition.stop();
      this.isListening = false;
    }
  },
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
  applyStyle() {
    if (this.selectedStyle) {
      this.bgColor = this.selectedStyle.backgroundColor || this.bgColor;
      this.textColor = this.selectedStyle.textColor || this.textColor;
      this.iconColor = this.selectedStyle.iconColor || this.iconColor;
      this.fontFamily = this.selectedStyle.fontStyle || this.fontFamily;
    }
  },
  loadBackgroundColor() {
      // Check if a background color is saved in localStorage
      const savedBgColor = localStorage.getItem('bgColor');
      const savedtextColor = localStorage.getItem('textColor');
      const savediconColor = localStorage.getItem('iconColor');
      if (savedBgColor) {
        this.bgColor = savedBgColor; // Set the color picker to the saved color
        this.textColor = savedtextColor;
        this.iconColor = savediconColor;
      }
    },
  applyCustomStyles() {
    const settings = {
      bgColor: this.bgColor,
      textColor: this.textColor,
      fontFamily: this.fontFamily,
      fontSize: this.fontSize,
      fontSpacing: this.fontSpacing,
      selectedShadow: this.selectedShadow,
      isBold: this.isBold,
      isItalic: this.isItalic,
      isLight: this.isLight,
      isUnderline: this.isUnderline,
      isStrikethrough: this.isStrikethrough,
      textTransform: this.textTransform,
      textAlign: this.textAlign,
      iconColor: this.iconColor
    };
    localStorage.setItem('textStyles', JSON.stringify(settings));
    localStorage.setItem('bgColor', this.bgColor);
    localStorage.setItem('textColor', this.textColor);
    localStorage.setItem('iconColor', this.iconColor);

    // Apply styles to the container
    // Object.assign(this.$el.style, this.containerStyle);

    // Apply icon color to all icons
    const icons = this.$el.querySelectorAll('i');
    icons.forEach(icon => {
      icon.style.color = this.iconColor;
    });

    // Save settings to localStorage
    localStorage.setItem('textStyles', JSON.stringify(settings));

    // Apply styles to the card content
    this.applyStylesToCards(); // Ensure this method is defined and applied

    this.showSuccessMessage = true;
    setTimeout(() => {
      this.showSuccessMessage = false;
      const modalElement = document.getElementById('styleModal');
      const modalInstance = bootstrap.Modal.getInstance(modalElement);
      modalInstance.hide();
    }, 3000);
  },
  applyStylesToCards() {
    // Example of applying styles to card elements
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
      card.style.backgroundColor = this.bgColor;
      card.style.color = this.textColor;
      card.style.fontFamily = this.fontFamily;
      card.style.fontSize = `${this.fontSize}px`;
      card.style.letterSpacing = `${this.fontSpacing}px`;
      card.style.fontWeight = this.isBold ? 'bold' : this.isLight ? '300' : 'normal';
      card.style.fontStyle = this.isItalic ? 'italic' : 'normal';
      card.style.textShadow = this.selectedShadow;
      card.style.textDecoration = this.isUnderline ? 'underline' : this.isStrikethrough ? 'line-through' : 'none';
      card.style.textTransform = this.textTransform;
      card.style.textAlign = this.textAlign;
      card.style.iconColor = this.iconColor;
    });
  },
  loadSavedStyles() {
    const savedSettings = JSON.parse(localStorage.getItem('textStyles'));
    if (savedSettings) {
      this.bgColor = savedSettings.bgColor || this.bgColor;
      this.textColor = savedSettings.textColor || this.textColor;
      this.fontFamily = savedSettings.fontFamily || this.fontFamily;
      this.fontSize = savedSettings.fontSize || this.fontSize;
      this.fontSpacing = savedSettings.fontSpacing || this.fontSpacing;
      this.selectedShadow = savedSettings.selectedShadow || this.selectedShadow;
      this.isBold = savedSettings.isBold || this.isBold;
      this.isItalic = savedSettings.isItalic || this.isItalic;
      this.isLight = savedSettings.isLight || this.isLight;
      this.isUnderline = savedSettings.isUnderline || this.isUnderline;
      this.isStrikethrough = savedSettings.isStrikethrough || this.isStrikethrough;
      this.textTransform = savedSettings.textTransform || this.textTransform;
      this.textAlign = savedSettings.textAlign || this.textAlign;
      this.iconColor = savedSettings.iconColor || this.iconColor;

      // Apply the loaded styles to the container
      this.applyCustomStyles(); // Ensure this applies the styles to the container
    }
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
  async getSurat() {
    try {
      const response = await axios.get('/get_surat'); // Ensure this URL is correct
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
            surah_id: this.selectedSurahId,
          },
        });
        this.ayat = response.data;
        this.dropdownHidden = false; // Show Ayah dropdown after fetching
      } catch (error) {
        console.error('Error fetching ayat:', error);
        this.ayat = []; // Clear ayat on error
        this.dropdownHidden = true; // Hide Ayah dropdown
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
        const ayahId = selectedAyah.id; // Assuming ayah has 'id' field, adjust if necessary
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

   this.$nextTick(() => {
      this.autoHighlightFirstAyah();
    });
  },
  autoHighlightFirstAyah() {
    if (this.ayat.length > 0) {
      this.selectedIndexAyah = 0; // Select the first Ayah
      this.scrollToSelectedAyah(); // Scroll to the first Ayah (optional)
      this.getTafseers(this.ayat[0].id, 0); // Fetch Tafseer, translation, etc. for the first Ayah
    }
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

.highlight {
  background-color: yellow;
  font-weight: bold;
}
.result-item {
  padding: 10px;
  border-bottom: 1px solid #ccc;
}

.button-33 {
  background-color: rgba(0, 191, 166, 0.2);
  color: rgb(255, 255, 255);
  border: 1px solid rgba(0, 191, 166);
}

.top-toolbar-btn{
  background-image: linear-gradient(144deg,#AF40FF, #5B42F3 50%,#00DDEB);

}
</style>