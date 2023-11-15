<template>
<div>

  <h2 class=" pt-3 pb-3 text-center"><strong>The 99 Names of Allah (SWT) with meaning</strong></h2>
  <p class="container text-center">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>

  <div class="container text-center">
    <div class="row">
      <div class="col-md-4 pb-2" v-for="item in allahNames" :key="item.id" :header="item.name">
        <Card style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;border-radius:20px; border:2px solid #8fd19e;height: 100% !important;">
          <template #title> <h2>{{ item.name }}</h2> </template>
          <template #content>
              <b>{{item.text}}</b>
          </template>
        </Card>
      </div>

    </div>
  </div>
</div>
</template>

<script>
import allahNames from '/Users/amine/Desktop/islamichub/storage/allah_names.json';

export default {
  data() {
    return {
      allahNames
    };
  }
};
</script>

<style>

</style>
