<!-- components/Welcome.vue -->
<template>
  <div class="tab-pane active" id="home" role="tabpanel" v-if="!information">
    <h4 class="text-center"><strong>Welcome to Islamic Connect</strong></h4>
    <p class="text-center ayah-translation" style="line-height: 1.6em;">
      Welcome to Islamic Connect, a platform built on the belief that knowledge leads to understanding, and understanding fosters acceptance.
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

