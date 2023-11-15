<template>
<div id="app">
  <h2 class="pt-3 pb-3 text-center"><strong>Quran Information</strong></h2>
  <p class="container text-center">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>

  <div class="row pb-5 text-left">
    <!--
    <Accordion :multiple="true" class="col-md-12 pb-3 text-left" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;border-radius:20px;">
      <AccordionTab v-for="item in cards" :key="item.id" :header="item.surah">
        <div class=" text-center ">
          <div class="row">
            <div class="col-6">
              <span class="pb-2 text-left" style="display:flex"><strong>Ayah</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.ayaatiha }}</p>

              <hr>
              <span class="pb-2 text-left" style="display:flex"><strong>Its Verses</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.ayaatiha }}</p>

              <hr>
              <span class="pb-2 text-left" style="display:flex"><strong>Meaning of the Name</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.maeni_asamuha }}</p>

              <hr>
              <span class="pb-2 text-left" style="display:flex"><strong>The Meaning of her Name</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.sabab_tasmiatiha }}</p>

              <hr>
              <span class="pb-2 text-left" style="display:flex"><strong>Her Names</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.asmawuha }}</p>

              <hr>
              <span class="pb-2 text-left" style="display:flex"><strong>It's General Purpose</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.maqsiduha_aleamu }}</p>

            </div>
            <div class="col-6">

              <span class="pb-2 text-left" style="display:flex"><strong>The Reason for its Descent</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.sabab_nuzuliha }}</p>

              <hr>
              <span class="pb-2 text-left" style="display:flex"><strong>Her Grace</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.fadluha }}</p>

              <hr>
              <span class="pb-2 text-left" style="display:flex"><strong>It's Occasions</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.munasabatiha }}</p>

              <hr>
              <span class="pb-2 text-left" style="display:flex"><strong>It's Occasions</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.munasabatiha }}</p>

            </div>

            

          </div>
        </div>

      </AccordionTab>
    </Accordion>
    -->
    <div class="container-fluid row" v-for="item in cards" :key="item.id" :header="item.surah">
      <Panel class="col-md-4" header="Header">
              <span class="pb-2 text-left" style="display:flex"><strong>Her Grace</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.fadluha }}</p>

              <hr>
              <span class="pb-2 text-left" style="display:flex"><strong>It's Occasions</strong><br>
              </span>
              <p class="m-0 text-left"> {{ item.munasabatiha }}</p>
      </Panel>
      
    </div>

   

  </div>
</div>
</template>

<script>
import cards from '/Users/amine/Desktop/islamichub/storage/cards.json';

export default {
  data() {
    return {
      cards,
      item: []
    };
  }
}
</script>

<style scoped>
img {
  width: 100%;
}
</style>
