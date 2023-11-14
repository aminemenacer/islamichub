<template>
<div id="app" class="pt-3">
    <h2 class="text-center"><strong>Donations</strong></h2>
  <p class="text-center container text-left pt-3 pl-3 pr-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>

  <div class="container-fluid py-3">

    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="card" style="border-radius:8px">
          <div class="card-header" style="border-radius:8px">

            <!-- Credit card form content -->
            <div class="tab-content">
              <!-- credit card info-->
              <div id="credit-card" class="tab-pane fade show active pt-3">
                <form role="form" onsubmit="event.preventDefault()">
                  <div class="form-group"> <label for="username">
                      <h6>Card Owner</h6>
                    </label> <input type="text" name="username" placeholder="Card Owner Name" required class="form-control "> </div>
                  <div class="form-group"> <label for="cardNumber">
                      <h6>Card number</h6>
                    </label>
                    <div class="input-group"> <input type="text" name="cardNumber" placeholder="Valid card number" class="form-control " required>
                      <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-8">
                      <div class="form-group"> <label><span class="hidden-xs">
                            <h6>Expiration Date</h6>
                          </span></label>
                        <div class="input-group"> <input type="number" placeholder="MM" name="" class="form-control" required> <input type="number" placeholder="YY" name="" class="form-control" required> </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group mb-4"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                          <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                        </label> <input type="text" required class="form-control"> </div>
                    </div>
                  </div>
                  <div class="card-footer"> <button type="button" class="subscribe btn btn-secondary btn-block shadow-sm"> Confirm Payment </button></div>
                </form>
              </div>
            </div> <!-- End -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<style>
body {
  background: #f5f5f5
}

.rounded {
  border-radius: 1rem
}

.nav-pills .nav-link {
  color: #555
}

.nav-pills .nav-link.active {
  color: white
}

input[type="radio"] {
  margin-right: 5px
}

.bold {
  font-weight: bold
}
</style>
