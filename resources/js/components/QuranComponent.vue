<template>
<div id="app">
  <h2 class="pt-3 pb-3 text-center"><strong>The Holy Quran</strong></h2>

  <div class="container-fluid text-center">

    <!-- main section search-->
    <div class="row container pt-3">
      <div class="col">
        <form class="d-flex" role="search">
          <label class="pr-2 pt-2">Search:</label>
          <input class="form-control me-2" type="search" placeholder="Search Keyword" aria-label="Search">
        </form>
      </div>
      <div class="col">
        <form style="display:flex">
          <label class="pt-2 pr-3">Results:</label>
          <select class="form-control">
            <option>Select</option>
            <option>Car</option>
            <option>Bike</option>
            <option>Scooter</option>
            <option>Cycle</option>
            <option>Horse</option>
          </select>
        </form>
      </div>
    </div>
    <hr>

    <!-- multiple input sections -->
    <div class="container-fluid text-center pb-5">
      <div class="row container-fluid">
        <div class="col-md-8" style="display:flex">

          <label class="pt-2 pl-2 pr-2">Surah:</label>
          <form class="col-md-2">
            <select class="form-control ">
              <option>Select</option>
            </select>
          </form>

          <label class="pt-2 pl-4 pr-2">Ayah:</label>
          <form class="col-md-2">
            <select class="form-control">
              <option>Select</option>
            </select>
          </form>

          <label class="pt-2 pl-4 pr-3">Page:</label>
          <form class="col-md-2">
            <select class="form-control">
              <option>Select</option>
            </select>
          </form>

          <button class="btn btn-outline-success" type="submit">Search</button>
        </div>

        <div class="col-md-4" style="display:flex">
          <label class="pt-2 pr-3">Mushaf:</label>
          <form class="col-md-4">
            <select class="form-control ">
              <option>Select</option>
            </select>
          </form>

          <label class="pt-2 pl-2 pr-3">Reciter:</label>
          <form class="col-md-4">
            <select class="form-control">
              <option>Select</option>
            </select>
          </form>
        </div>
      </div>
      <hr>

      <!-- accordion headers-->
      <div class="row container-fluid">
        <div class="col-8 pt-3">
          <Accordion style="border:2px solid lightgrey" :multiple="true" :activeIndex="[0,1]" >
            <AccordionTab style="color:black" header="Translation">
              <div class="m-0 fas fa-fw fa-play text-right"></div>
              <p class="text-left mt-2 m-0">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
            </AccordionTab>
            <AccordionTab header="Tafseer">
              <div class="m-0 fas fa-fw fa-play text-right"></div>
              <p class="text-left mt-2 m-0">
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
                ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Consectetur, adipisci velit, sed quia non numquam eius modi.
              </p>
            </AccordionTab>
            <AccordionTab header="Transliteration">
              <div class="m-0 fas fa-fw fa-play text-right"></div>
              <p class="text-left mt-2 m-0">
                At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui
                officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.
              </p>
            </AccordionTab>
          </Accordion>
        </div>
        <div class="col-4" >
          <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
              <div class="m-0 mr-3 fas fa-fw fa-play text-right"></div>
              <div class="m-0 mr-3 fas fa-fw fa-pause text-right"></div>
              <div class="m-0 fas fa-fw fa-stop text-right"></div>
            </div>
            <div class="col-3"></div>
          </div>
          <div class="row mt-3 text-center" >
            <div class="col-3">
              <div><b>Surah 1</b></div>
            </div>
            <div class="col-6 text-center" >
              <div class="m-0 fas fa-fw mt-1 fa-arrow-left"></div>
              472
              <div class="m-0 fas fa-fw mt-1 fa-arrow-right text-right"></div>
            </div>
            <div class="col-3">
              <div><b>Surah 2</b></div>
            </div>
          </div>

          <img src="/images/quran_img.png" style="width:90%; border:4px solid lightgrey">
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>
