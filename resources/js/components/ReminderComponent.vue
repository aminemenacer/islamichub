<template>
<div class="id">

  <h2 class="pt-3 text-center"><strong>Reminders</strong></h2>
  <p class="container text-center">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>

  <div class="row py-3">
    <div class="col-lg-10 mx-auto">

          <div class="table-responsive " v-for="item in reminder" :key="item.id">
            <table id="example" style="width:100%" class="table table-striped table-responsive table-bordered custom-class" v-for="reminders in item.view" :key="reminders.id">
              <thead class="table-success">
                <tr class="text-center">
                  <th class="col-md-2">Category</th>
                  <th class="col-md-6">Reminder</th>
                  <th class="col-md-1">Repitition</th>
                  <th class="col-md-1">Audio</th>
                </tr>
              </thead>
              <tbody style="background:white">
                <tr class="text-center">
                  <td class="col-md-2">{{ item.category }}</td>
                  <td class="col-md-6">{{ reminders.text }}</td>
                  <td class="col-md-1">{{ reminders.count }}</td>
                  <td class="col-md-1">{{ reminders.audio }}</td>
                </tr>

              </tbody>
            </table>
            
          </div>
        </div>
      </div>

    </div>
</template>

<script>
import reminder from '/Users/amine/Desktop/islamichub/storage/adhkar.json';


export default {
  data() {
    return {
      items: [],
      reminder,
      view: [],
    };
  }
};
</script>

<style>

.custom-class {
   table-layout: fixed;
   width: 100%;
}

</style>
