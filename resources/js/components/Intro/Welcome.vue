<!-- components/Welcome.vue -->
<template>
  <div class="tab-pane active" id="home" role="tabpanel" v-if="!information">
    <h4 class="text-center"><strong>Welcome to Islamic Connect</strong></h4>
    <p class="text-center ayah-translation" style="line-height: 1.6em;">
      Islamic Connect is a revolutionary platform committed to making the profound teachings of the Noble Quran accessible to all. It transcends being just a website; it's a Sadaqah Jariyah perpetual charity that enriches individuals and communities for generations to come.
    </p>
  </div>
</template>

<script>
export default {
  name: 'Welcome',
  props: {
    information: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped>
/* Styles for the Welcome component */
</style>
