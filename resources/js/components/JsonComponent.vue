<template>
  <div>
  <div>
    <h2 class="text-center mb-3 mt-4">Names of Allah</h2>
  </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item" v-for="item in jsonData" :key="item.id"><h3>{{ item.name }}</h3><h5>{{ item.text }}</h5>  </li>
    </ul>
  </div>
</template>

<script>
import jsonData from '/Users/amine/Desktop/islamichub/storage/test.json';

export default {
  data() {
    return {
      jsonData
    };
  }
};
</script>

<style>

</style>



