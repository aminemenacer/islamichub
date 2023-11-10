<template>
<div class="id">

<p>reminder</p>
<!--
  <div class="row">
    <TabView>
      <TabPanel v-for="item in reminder" :key="item.id" :header="item.category">
        <p class="m-0">{{ item.text }}</p>
        <span>{{ item.count }}</span>
      </TabPanel>
    </TabView>
  </div>
-->
</div>
</template>

<script>
import reminder from '/Users/amine/Desktop/islamichub/storage/adhkar.json';

export default {
  data() {
    return {
      reminder
    };
  }
};
</script>

<style>

</style>
