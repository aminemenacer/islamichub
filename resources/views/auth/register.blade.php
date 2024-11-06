@extends('layouts.app')

@section('content')


<!-- Section: Design Block -->
<section class="">
  <!-- Jumbotron -->
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">

        <div class="col-lg-6  mb-lg-0 hide-on-mobile">
          <img src="images/mob-auth.png" width="90%">
        </div>


        <div class="col-lg-6 mb-lg-0">
          <div class="card" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; border-radius:10px">
            <div class="card-body px-md-5">
              <form method="POST" action="{{ route('register') }}">
                @csrf
                <h2 class="fw-normal mt-4 pb-3" style="font-family:inter"><b>Create an account</b></h2>


                <div class="form-outline mb-2">
                  <label for="name" class="col-md-4 col-form-label text-left">{{ __('Name') }}</label>

                  <div class="col-md-12">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                      value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>

                <div class="form-outline mb-2">
                  <label for="email" class="col-md-4 col-form-label text-left">{{ __('Email Address') }}</label>

                  <div class="col-md-12">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                      name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>

                <div class="form-outline mb-2">
                  <label for="password" class="col-md-4 col-form-label text-left">{{ __('Password') }}</label>

                  <div class="col-md-12">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                      name="password" required autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>

                <div class="form-outline mb-2">
                  <label for="password-confirm"
                    class="col-md-4 col-form-label text-left">{{ __('Confirm Password') }}</label>

                  <div class="col-md-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                      required autocomplete="new-password">
                  </div>
                </div>

                <div class="row mb-0">
                  <div class="pt-1 mb-2">
                    <button type="submit" class="btn btn-lg btn-block text-white" style="background: #00BFA6"
                      type="button">Submit</button>
                  </div>
                  <p class="mt-3 text-center">Already have an account ? Click <a href="/login">here</a> to login.</p>
                </div>

                <hr>
                <!-- <div class="text-center">
                  <b>or login with:</b>

                  <a href="{{ url('auth/facebook') }}" class="btn btn-link btn-floating" style="font-size: 22px;
                  color:#00BFA6;">
                  <i class="bi bi-facebook"></i>
                  </a> 

                  <a href="{{ url('auth/google') }}" class="btn btn-link btn-floating"
                    style="font-size: 22px; color:#00BFA6;">
                    <i class="bi bi-google"></i>
                  </a>

                   <a href="{{ url('auth/linkedin') }}" class="btn btn-link btn-floating" style="font-size: 22px;
                  color:#00BFA6;">
                  <i class="bi bi-linkedin"></i>
                  </a> 
                </div> -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Jumbotron -->
</section>

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