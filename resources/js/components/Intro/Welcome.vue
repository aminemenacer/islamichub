<template>
  <!-- Use an article or section tag for better semantics and SEO -->
  <section v-if="!information" aria-labelledby="welcome-heading" class="tab-pane active" id="home" role="tabpanel">
    <h1 id="welcome-heading" class="text-center">
      <strong>Welcome to Islamic Connect</strong>
    </h1>
    <p class="text-center ayah-translation" style="line-height: 1.6em;">
      Welcome to Islamic Connect, a platform built on the belief that knowledge leads to understanding and fosters acceptance.
    </p>
  </section>
</template>

<script>
// Remove the 'defer' attribute as it's not necessary for component scripts in Vue.js
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
/* Ensure the layout is responsive and accessible */
.text-center {
  text-align: center;
}

.ayah-translation {
  margin: 20px 0;
  font-size: 1rem;
}
</style>
