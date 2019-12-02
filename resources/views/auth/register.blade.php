

<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Font Awesome Icons -->
  <link href="/css/all.css" rel="stylesheet" type="text/css">
  <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="/css/signup.css" rel="stylesheet" type="text/css">

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
            <h5 class="card-title text-center">Sign up</h5>
            <form class="form-signin" method="POST" action="{{ route('register') }}">
              @csrf
              <div class="form-label-group">
                <input name="name" type="text" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Username" required autocomplete="name" autofocus>
                <label for="name">Username</label>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="form-label-group">
                <input name="email" type="email" id="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email here">
                <label for="email">Email address</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              
              <hr>

              <div class="form-label-group">
                <input name="password" type="password" id="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="Password">
                <label for="password">Password</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              
              <div class="form-label-group">
                <input name="password_confirmation" type="password" id="password-confirm" class="form-control" required autocomplete="new-password" placeholder="Confirm Password">
                <label for="password-confirm">Confirm Password</label>
              </div>
              
              <div class="form-label-group">
                <input type="checkbox" name="vehicle1" value="Bike" id='tos' required/>
                <label for='tos' class="py-0">
                  I have read and accept GoHundred's
                  <a href="/privacy_policy">Privacy Policy</a> 
                  and
                  <a href="/terms-of-service">Terms of Service</a> <br>
                </label>
              </div>

              <button class="btn btn-lg btn-primary btn-block text-uppercase mt-4" type="submit">Sign Up</button>
              <a class="d-block text-center mt-2 small" href="/login">Log In</a>
              <hr>
              <a href="redirect/google" class="btn btn-lg btn-google btn-block text-uppercase"><i class="fab fa-google mr-2"></i> Sign up with Google</a>
              <a href="redirect/twitter" class="btn btn-lg btn-twitter btn-block text-uppercase"><i class="fab fa-twitter mr-2"></i> Sign up with Twitter</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

