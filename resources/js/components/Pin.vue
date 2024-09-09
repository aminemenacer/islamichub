<template>
  <div class="card">
    <img :src="pin.image" class="card-img-top" alt="Pin Image">
    <div class="card-body">
      <h5 class="card-title">{{ pin.title }}</h5>
      <p class="card-text">{{ pin.description }}</p>
    </div>
  </div>
</template>
<style>
.waterfall {
  display: flex;
  flex-wrap: wrap;
}

.card {
  width: 250px;
  margin: 10px;
  border: 1px solid #ddd;
  border-radius: 0.25rem;
}

.card-img-top {
  width: 100%;
  height: auto;
}
</style>
<script>
export default {
  props: {
    pin: {
      type: Object,
      required: true
    }
  }
};
</script>