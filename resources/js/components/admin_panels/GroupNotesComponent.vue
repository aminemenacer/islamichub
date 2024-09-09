<template>
<div>
 <h2 class="pt-4 pb-3 text-center"><strong>Note's & Reflection's Board</strong></h2>
 <p class="lead container">This page is a space to share your personal Islamic reflections and insights with others. Together, we can inspire, learn, and grow in our faith, helping each other on our spiritual journeys through shared thoughts and reflections.</p>

 <div>
  <!-- Container visible only on mobile screens -->
  <div class="container text-center mt-3 d-md-none">
   <div class="row pb-2 text-center">
    <div class="col">
     <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#B70D52;background:#ead1dc">
      <a href="/bookmarks" style="text-decoration:none;color:#B70D52;background:#ead1dc">Bookmarks</a>
     </span>
    </div>
    <div class="col">
     <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#0263FF;background:#c2d8fb">
      <a href="/collection" style="text-decoration:none;color:#0263FF;background:#c2d8fb">Collections</a>
     </span>
    </div>
    <div class="col">
     <span class="badge h3" style="width:100%;font-size:18px;border-radius:10px; color:#3D8F67;background:#d1f4d0">
      <a href="/notes" style="text-decoration:none;color:#3D8F67;background:#d1f4d0">Notes</a>
     </span>
    </div>
   </div>
  </div>

  <!-- Notes Container -->
  <div class="container container-notes">
   <div class=" row collage">
    <div class="collage-item mb-4 " v-for="note in notes" :key="note.id">
     <!-- Note Card -->
     <div class="card" style="border-radius:8px; padding:4px;background:white; border: 2px solid rgba(0, 191, 166);">
      <div class="card-body">
       <!-- Note details -->
       <div>
        <h5><strong>Surah Name:</strong></h5>
        <p>{{ note.surah_name }}</p>
       </div>
       <div class="mt-2">
        <h5><strong>Note:</strong></h5>
        <p v-html="truncatedHtml(note.ayah_notes)"></p>
       </div>
       <hr />
       <i class="bi bi-eye-fill h4" style="color:rgb(0, 191, 166); cursor:pointer" @click="viewModal(note)"></i>
      </div>
     </div>
    </div>
   </div>
  </div>

  <!-- View Note Modal -->
  <div class="modal fade" id="viewNotes" tabindex="-1" aria-labelledby="viewNotesLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header">
      <h5 class="modal-title text-dark" id="viewNotesLabel"><b>View Note</b></h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
     </div>
     <div class="modal-body">
      <div >
       <div class="mb-3">
        <label class="form-label"><strong>Surah Name:</strong></label>
        <p class="mt-2 text-dark text-left">{{ form.surah_name }}</p>
       </div>
       <div class="mb-3">
        <label class="form-label"><strong>Ayah Verse Arabic:</strong></label>
        <p class="mt-2 text-dark text-left">{{ form.ayah_verse_ar }}</p>
       </div>
       <div class="mb-3">
        <label class="form-label"><strong>English Info:</strong></label>
        <p class="mt-2 text-dark text-left">{{ form.ayah_verse_en }}</p>
       </div>
       <div class="mb-3">
        <label class="form-label"><strong>Notes:</strong></label>
        <div class="mt-2 text-dark text-left" v-html="form.ayah_notes"></div>
       </div>
       <div class="mb-3">
        <label class="form-label"><strong>Date Created:</strong></label>
        <p class="mt-2 text-dark text-left">{{ extractDate(form.created_at) }}</p>
       </div>
      </div>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>
</template>

<style scoped>
.container-notes {
 column-count: 4;
 max-width: 1500px;
}

.row.collage {
 display: block;
}

.collage-item {
 break-inside: avoid;
}

.card {
 background-color: #ffffff;
 padding: 1em;
 margin-bottom: 1.5em;
}

@media (max-width: 992px) {
 .container {
  column-count: 2;
 }
}

@media (max-width: 576px) {
 .container {
  column-count: 1;
 }
}
</style>

<script>
export default {
 data() {
  return {
   notes: [],
   form: {
    surah_name: "",
    ayah_verse_ar: "",
    ayah_verse_en: "",
    ayah_notes: "",
    created_at: "",
   },
  };
 },
 mounted() {
  this.fetchNotes();
 },
 methods: {
  async fetchNotes() {
   try {
    const response = await fetch(`/fetch-notes`);
    if (!response.ok) {
     throw new Error("Network response was not ok");
    }
    const data = await response.json();
    console.log("Fetched notes:", data); // Add this line to see what data is returned

    this.notes = data;
   } catch (error) {
    console.error(
     "There was a problem with the fetch operation:",
     error
    );
   }
  },
  viewModal(note) {
   this.form = {
    ...note
   };
   $("#viewNotes").modal("show"); // Show the Bootstrap modal
  },
  extractDate(dateTimeString) {
   return dateTimeString.split('T')[0];
  },
  truncatedHtml(html, maxLength = 400) {
   const div = document.createElement("div");
   div.innerHTML = html;
   const plainText = div.textContent || div.innerText || "";
   if (plainText.length > maxLength) {
    const truncatedText = plainText.substring(0, maxLength) + "...";
    return truncatedText;
   }
   return plainText;
  },
 },
};
</script>
