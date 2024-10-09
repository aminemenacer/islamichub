<template>
  <div>
    <div class="container pt-3">
      <div class="row gx-4  align-items-center justify-content-between">
        <div class="col-md-7 order-2 order-md-1">
          <div class="mt-3 mt-md-0">
            <h2 class="display-5 fw-bold">Support Us</h2>
            <p class="lead">
              Support Islamic Connect: Build a Bridge to Islamic Knowledge. 
              At Islamic Connect, we are committed to providing free, easy-to-access Islamic resources to people worldwide.
              Your generous donations allow us to maintain and expand our platform, offering AI-powered tools, authentic Quranic content,
              and educational materials to those seeking knowledge, including new Muslims and non-Muslims.
            </p>
            <p class="lead">
              By donating, you are helping us spread the message of Islam to communities who need it most, 
              fostering understanding and peace. Join us in making Islamic knowledge more accessible and impactful. 
              Every donation, big or small, is a step toward a more enlightened world.
            </p>

            <!-- GoFundMe Embed -->
            <div class="gfm-embed" data-url="https://www.gofundme.com/f/empowerment-through-quran-support-islamic-connects-mission/widget/large?sharesheet=CAMPAIGN_PAGE&attribution_id=undefined"></div>
            <!-- End of GoFundMe Embed -->

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    // Dynamically load the GoFundMe embed script after the component is mounted
    const script = document.createElement('script');
    script.src = "https://www.gofundme.com/static/js/embed.js";
    script.defer = true;
    document.body.appendChild(script);
  }
}
</script>

<style>

</style>
