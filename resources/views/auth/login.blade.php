
<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Font Awesome Icons -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/css/all.css" rel="stylesheet" type="text/css">
  <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="/css/signup.css" rel="stylesheet" type="text/css">

  <title>Logging to GoHundred</title>
  <link rel="shortcut icon" href="/assets/media/logos/GoHundred-icon.png" />
  <!-- Google Fonts -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet"> -->
  <!-- <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'> -->

  <!-- Plugin CSS -->
  <!-- <link href="/css/magnific-popup.css" rel="stylesheet"> -->

  <!-- Theme CSS - Includes Bootstrap -->
  <!-- <link href="/css/creative.css" rel="stylesheet"> -->

</head>


<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->

<body>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-img-left d-none d-md-flex">
             <!-- Background image for card set in CSS! -->
          </div>
          <div class="card-body">
            <h5 class="card-title text-center">{{ __('Log in')}}</h5>
            <form method="POST" action="{{ route('login') }}" class="form-signin">
            @csrf
              <div class="form-label-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Emal Address">
                <label for="email">Email Address</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-label-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                <label for="password">Password</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="row kt-login__extra">

                    <div class="form-group col mt-2 small">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                    </div>
                <div class="col kt-align-right">
                  <a href="{{route('password.request')}}" id="kt_login_forgot" class="kt-link kt-login__link mt-2 small">Forgot Password ?</a>
                </div>
				</div>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">{{ __('Log in')}}</button>
              <div class="kt-login__account">
                <div class="col">
                  <span class="kt-login__account-msg text-center mt-2 small">
                    Don't have an account yet ?
                  </span>&nbsp;&nbsp;
                </div>
                <div class="kt-align-right">
                  <a href="/register" id="kt_login_signup" class="kt-link kt-link--light kt-login__account-link mt-2 small">Sign Up</a>
                </div>
              </div>
              <hr>
              <a href="redirect/google" class="btn btn-lg btn-google btn-block text-uppercase"><i class="fab fa-google mr-2"></i> Log in with Google</a>
              <a href="redirect/twitter" class="btn btn-lg btn-twitter btn-block text-uppercase"><i class="fab fa-twitter mr-2"></i> Log in with Twitter</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

