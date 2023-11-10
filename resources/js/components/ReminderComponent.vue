<template>
<div class="id">

  <div class="row">

    <Card class="col-md-3 text-center " style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;border-radius:20px; border:1px solid grey" v-for="item in reminder" :key="item.id" :header="item.category">
      <template #title class="text-center">{{ item.category }}</template>
      
      <div v-for="items in array" :key="items.id" class="pt-2 pb-2 pl-2 pr-2">
        <p class="m-0">
          {{items.text}}
        </p>
      </div>      
    </Card>

  </div>

</div>
</template>

<script>
import reminder from '/Users/amine/Desktop/islamichub/storage/adhkar.json';

export default {
  data() {
    return {
      items:[],
      reminder
    };
  }
};
</script>


<style>

</style>
