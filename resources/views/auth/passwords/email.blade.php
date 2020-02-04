
<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Font Awesome Icons -->
  <link href="/css/all.css" rel="stylesheet" type="text/css">
  <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="/css/signup.css" rel="stylesheet" type="text/css">

  <title>GoHundred-Grow Your Brand</title>
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
                <div class="animate form login_form">
                    <section class="login_content">
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif



                        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                            <h5 class="card-title text-center">{{ __('Forgot Your Password?')}}</h5>
                            {{ csrf_field() }}


                            <br>
                            <div class="col">
                                <span class="kt-login__account-msg text-center mt-2">
                                    Reset your GoHundred password:
                                </span>&nbsp;&nbsp;
                            </div>
                            <br>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                @if ($errors->has('email'))
                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                                <div class="form-label-group">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Emal Address">
                                    <label for="email">Email Address</label>
                                </div>
                            </div>

                            <div class="form-signin">
                                <button type="submit" class="btn btn-md btn-info btn-block">Send Password Reset Link</button>
                                <!-- <a class="reset_pass" href="{{route('login')}}">Login</a> -->
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
                    </section>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</body>

