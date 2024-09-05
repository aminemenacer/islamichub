<template>
    <div>
        <!-- Display this message if no notes are found -->
        <div v-if="notes.length === 0">
            <p>No public notes found.</p>
        </div>

        <!-- Loop through all public notes and display them -->
        <div v-else>
            <div v-for="note in notes" :key="note.id">
                <h3>Surah Name: {{ note.surah_name }}</h3>
                <p>Note: {{ truncatedHtml(note.ayah_notes) }}</p>
                <button @click="viewModal(note)">View Note</button>
            </div>
        </div>

        <!-- Modal to view the full note -->
        <div
            class="modal fade"
            id="viewNotes"
            tabindex="-1"
            aria-labelledby="viewNotesLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewNotesLabel">
                            Surah Name: {{ form.surah_name }}
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Ayah (Arabic): {{ form.ayah_verse_ar }}</p>
                        <p>Ayah (English): {{ form.ayah_verse_en }}</p>
                        <p>Note: {{ form.ayah_notes }}</p>
                        <p>Created At: {{ form.created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

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
            this.form = { ...note };
            $("#viewNotes").modal("show"); // Show the Bootstrap modal
        },
        truncatedHtml(html, maxLength = 150) {
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
