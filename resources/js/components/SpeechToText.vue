<template>
  <div class="speech-to-text">
    <button @click="startListening" :disabled="listening">Start Listening</button>
    <button @click="stopListening" :disabled="!listening">Stop Listening</button>
    <p v-if="error" class="error">{{ error }}</p>
    <p v-if="interimTranscript">{{ interimTranscript }}</p>
    <p>{{ finalTranscript }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      listening: false,
      finalTranscript: '',
      interimTranscript: '',
      error: null,
      recognition: null,
    };
  },
  mounted() {
    if (!('webkitSpeechRecognition' in window)) {
      this.error = 'Web Speech API is not supported by this browser. Please use Chrome or Firefox.';
      return;
    }

    this.recognition = new webkitSpeechRecognition();
    this.recognition.continuous = true;
    this.recognition.interimResults = true;

    this.recognition.onstart = () => {
      this.listening = true;
      this.error = null;
    };

    this.recognition.onerror = (event) => {
      this.error = 'Error occurred in recognition: ' + event.error;
      this.listening = false;
    };

    this.recognition.onend = () => {
      this.listening = false;
    };

    this.recognition.onresult = (event) => {
      let interimTranscript = '';
      for (let i = event.resultIndex; i < event.results.length; ++i) {
        if (event.results[i].isFinal) {
          this.finalTranscript += event.results[i][0].transcript;
        } else {
          interimTranscript += event.results[i][0].transcript;
        }
      }
      this.interimTranscript = interimTranscript;
    };
  },
  methods: {
    startListening() {
      this.finalTranscript = '';
      this.interimTranscript = '';
      this.recognition.start();
    },
    stopListening() {
      this.recognition.stop();
    },
  },
};
</script>

<style scoped>
.speech-to-text {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
}
button {
  margin: 10px;
}
.error {
  color: red;
}
</style>
