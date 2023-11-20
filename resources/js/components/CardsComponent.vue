<template>
<div id="app">
  <h2 class="pt-3 pb-3 text-center"><strong>Surah Information</strong></h2>
  <p class="container text-center">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>

  <div class="row pb-5 text-left">
    <div class="container text-center">
      <div class="row ">
        <Accordion class="col-md-6 mb-3 " v-for="item in cards" :key="item.id">

          <AccordionTab class="btn btn-primary" style="display:flex;"  title="Surah" :header="item.surah">
            <div class="row">
              <div class="col-12">
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
                <hr>

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
          </AccordionTab>
        </Accordion>

      </div>
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
      item: [],
      visible: false
    };
  }
}
</script>

<style scoped>
img {
  width: 100%;
}

.accordion-button:not(.collapsed) {
  color: #0c63e4;
  background-color: #FEB7EE;
}
</style>
