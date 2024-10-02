<!-- components/Welcome.vue -->
<template>
  <div class="tab-pane active" id="home" role="tabpanel" v-if="!information">
    <h3 class="text-center"><strong>Welcome to Islamic Connect</strong></h3>
    <img src="images/calligraphy.png" width="40%">
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

