<template>
<div id="app">

  <h2 class="pt-3 text-center"><strong>Ahadith Al-Qudsi</strong></h2>
  <p class="container text-center">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
  <div class="row py-3">
    <div class="col-lg-12 mx-auto">
      <div class="container-fluid table-responsive container-fluid" v-for="item in hadith" :key="item.id">
        <table id="example" style="width:100%" class="table table-striped table-responsive table-bordered custom-class"><b class="pb-2">Reference: {{ item.reference }}</b>
          <thead class="table-success">
            <tr class="text-center">

              <th>Hadith (English)</th>
              <th>Hadith (Arabic)</th>
              <th>Narrator</th>

            </tr>
          </thead>
          <tbody style="background:white">
            <tr class="text-center">
              <td>{{ item.text }}</td>
              <td>{{ item.arabic }}</td>
              <td>{{ item.narrator }}</td>
            </tr>
          </tbody>

        </table>

      </div>
    </div>          

  </div>
</div>
</template>

<script>
import hadith from '/Users/amine/Desktop/islamichub/storage/three_main/qudsi_book.json';

export default {
  data() {
    return {
      items: [],
      hadith,
      view: [],
    }
  },

}
</script>

<style>

</style>
