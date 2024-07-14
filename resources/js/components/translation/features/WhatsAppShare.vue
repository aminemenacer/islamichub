<template>
  <i class="bi bi-whatsapp text-right mr-2 h4"
     @click="shareTextViaWhatsApp3"
     aria-expanded="false"
     data-bs-placement="top"
     title="Share on Whatsapp"
     style="color: rgba(0, 191, 166); cursor: pointer;"></i>
</template>

<script>
export default {
  name: 'WhatsAppShare',
  props: {
    textToShare: {
      type: String,
      required: true
    }
  },
  methods: {
    shareTextViaWhatsApp3() {
     const text3 = this.$refs.targetElement.innerText;
     const url = `https://api.whatsapp.com/send?text=${encodeURIComponent(text3)}`;
     window.open(url, '_blank');
    }
  }
};
</script>

<style scoped>
.text-right {
  text-align: right;
}
.mr-2 {
  margin-right: 0.5rem;
}
.h4 {
  font-size: 1.5rem;
}
</style>
