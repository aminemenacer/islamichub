<template>
<div>

  <h2 class=" pt-3 pb-3 text-center"><strong>The 99 Names of Allah (SWT) with meaning</strong></h2>
  <p class="container text-center">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>

  <div class="row pb-5 text-center container-fluid" >
    
    <Card class="col-md-2 mb-4 ml-2 mr-2 text-center bg-light" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;border-radius:20px; border:2px dashed #8fd19e" v-for="item in jsonData" :key="item.id" :header="item.name">
      <template #title class="text-center"><b>{{ item.name }}</b></template>

      <template #content>
        <p class="m-0"><b>
          {{item.text}}
        </b></p>    

      </template>
      <hr>

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
