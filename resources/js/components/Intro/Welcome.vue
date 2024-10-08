<!-- components/Welcome.vue -->
<template>
  <div class="tab-pane active" id="home" role="tabpanel" v-if="!information">
    <h4 class="text-center"><strong>Welcome to Islamic Connect</strong></h4>
    <p class="text-center ayah-translation" style="line-height: 1.6em;">
      Welcome to Islamic Connect, a platform built on the belief that knowledge leads to understanding, and understanding fosters acceptance. Our goal is to provide a space where individuals from all walks of life can explore, learn, and grow together in their journey toward greater awareness of Islam.
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

