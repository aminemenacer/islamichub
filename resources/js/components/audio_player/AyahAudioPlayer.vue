<template>
    <div>
        <p>{{ ayah.ayah_text }}</p>
    </div>
</template>

<script>
export default {
    props: {
        ayah: {
            type: Object,
            required: true,
        },
    },
    methods: {
        playAudio() {
            // const audioPlayer = new Audio(this.ayah.audio_links);
            // audioPlayer.play();
        },
    },
};
</script>

<style scoped>
/* Optional styles for the audio player */
</style>
