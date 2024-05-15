@extends('layouts.app')

@section('content')

<!-- Section: Design Block -->
<section class="">
  <!-- Jumbotron -->
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" >
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
          
        <div class="col-lg-6  mb-lg-0 hide-on-mobile">
          <img src="images/mob-auth.png" width="90%">
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card">
            <div class="card-body py-5 px-md-5">
              <form>
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <h2 class="fw-normal mt-3 pb-3" style="font-family:inter"><b>Login to your account</b></h2>

                <div class="row">
                  <div class="form-outline mb-4">
                    <label class="form-label" style="font-weight:bold" >Email address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                 </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example27">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>

                
                <!-- Submit button -->
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-block mb-4 text-white" style="background: #00BFA6;">
                  <span>Login</span>
                </button>

                <div class="text-center">
                  @if (Route::has('password.request'))
                      <a class="btn btn-link" href="{{ route('password.request') }}">
                          {{ __('Forgot Your Password?') }}
                      </a>
                  @endif
                  <p class="mb-3 pb-lg-2" style="color: #000000;">Don't have an account? <a href="/register"
                      style="color: #00BFA6;">Register here</a></p>
                </div>
                <hr >

                <!-- Register buttons -->
                <div class="text-center">
                  <b>or login with:</b>
                  <a href="{{ url('auth/facebook') }}" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating " style="font-size: 22px; color:#00BFA6;">
                    <i class="fab fa-facebook-f"></i>
                  </a>

                  <a href="{{ url('auth/google') }}" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating " style="font-size: 22px; color:#00BFA6;">
                    <i class="fab fa-google"></i>
                  </a>
                
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->
@endsection

<style>
  @media (max-width: 575px) {

/* Hide the content on mobile devices */
.hide-on-mobile {
 display: none;
}

.custom-dropdown {
 max-height: 200px;
 /* Adjust the value as needed */
 overflow-y: auto;
}
}

@media (max-width: 767px) {

/* Hide the content on mobile devices */
.hide-on-mobile {
 display: none;
}

.custom-dropdown {
 max-height: 200px;
 /* Adjust the value as needed */
 overflow-y: auto;
}

}
</style>