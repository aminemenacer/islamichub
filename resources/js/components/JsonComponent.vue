<template>
<div>

    <h3 class=" pb-4 text-center"><b>The 99 Names of Allah (SWT) with meaning</b></h3>

  <div class="row ">

   
    <Card class="col-md-3 text-center " style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;border-radius:20px; border:1px solid grey" v-for="item in jsonData" :key="item.id" :header="item.name">
      <template #title class="text-center">{{ item.name }}</template>
      
      <template #content class="pt-2 pb-2 pl-2 pr-2">
        <p class="m-0">
          {{item.text}}
        </p>
      </template>
      
    </Card>

  </div>

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
