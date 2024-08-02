<template>
  <div>
    <button @click="startListening" :disabled="isListening">Start Listening</button>
    <button @click="stopListening" :disabled="!isListening">Stop Listening</button>
    <p>{{ transcript }}</p>
  </div>
</template>

<script>
export default {
  name: 'SpeechRecognition',
  data() {
    return {
      isListening: false,
      transcript: '',
      recognition: null,
    };
  },
  mounted() {
    if ('webkitSpeechRecognition' in window) {
      this.recognition = new webkitSpeechRecognition();
      this.recognition.continuous = true;
      this.recognition.interimResults = false;
      this.recognition.lang = 'en-US';

      this.recognition.onstart = () => {
        this.isListening = true;
      };

      this.recognition.onend = () => {
        this.isListening = false;
      };

      this.recognition.onresult = (event) => {
        this.transcript = event.results[0][0].transcript;
        this.$emit('transcript', this.transcript);
      };

      this.recognition.onerror = (event) => {
        console.error('Speech recognition error', event);
      };
    } else {
      alert('Your browser does not support speech recognition.');
    }
  },
  methods: {
    startListening() {
      if (this.recognition) {
        this.recognition.start();
      }
    },
    stopListening() {
      if (this.recognition) {
        this.recognition.stop();
      }
    },
  },
};
</script>

<style scoped>
button {
  margin: 5px;
}
</style>
