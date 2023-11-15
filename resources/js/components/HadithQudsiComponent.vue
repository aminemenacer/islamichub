<template>
<div id="app">

  <h2 class="pt-3 text-center"><strong>Ahadith Al-Qudsi</strong></h2>
  <p class="container text-center">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>

  <div class="row py-3">
    <div class="col-lg-12 mx-auto">

      <div class="table-responsive container-fluid" v-for="item in hadiths" :key="item.id">
        <table id="example" style="width:100%" class="table table-striped table-responsive table-bordered custom-class" v-for="hadiths in item.view" :key="hadiths.id">
          <thead class="table-success">
            <tr class="text-center">
              <th class="col-md-1">ID</th>
              <th class="col-md-1">Narrator</th>
              <th class="col-md-6">Hadith (Arabic)</th>
              <th class="col-md-6">Hadith (English)</th>

              <!--
              <th class="col-md-1">Chapter ID</th>
              <th class="col-md-1">Book ID</th>
              -->
            </tr>
          </thead>
          <tbody style="background:white">
            <tr class="text-center">
              <td class="col-md-1">{{ item.id }}</td>
              <td class="col-md-1">{{ hadiths.narrator }}</td>
              <td class="col-md-6">{{ item.arabic }}</td>
              <td class="col-md-6">{{ item.arabic }}</td>

              <!--
              <td class="col-md-1">{{ item.chapterId }}</td>
              <td class="col-md-1">{{ item.bookId }}</td>
              -->
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
      items: {},
      hadiths: "",
      view: []
    }
  }
}
</script>

<style>

</style>
