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
            <h5 class="card-title text-center">Password Reset</h5>
            <form role="form" method="POST" action="{{ route('password.request', ['token' => $token]) }}">
            
              @csrf

              <div class="form-label-group">
                <input name="email" type="email" id="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email here">
                <label for="email">Email address</label>
              </div>
              
              <hr>

              <div class="form-label-group">
                <input name="password" type="password" id="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="Password">
                <label for="password">Password</label>
              </div>
              
              <div class="form-label-group">
                <input name="password_confirmation" type="password" id="password-confirm" class="form-control" required autocomplete="new-password" placeholder="Confirm Password">
                <label for="password-confirm">Confirm Password</label>
              </div>

              <div class="form-signin">
              <button class="btn btn-md btn-info btn-block" type="submit">Reset Password</button>
                </div>

              <div class="clearfix"></div>

                <div class="separator">

                    <div class="clearfix"></div>
                    <br />

                    <div>
                        <p>©2019 All Rights Reserved.</p>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

