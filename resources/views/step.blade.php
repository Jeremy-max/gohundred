<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="AuThemes Templates">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="AuThemes Templates">

    <!-- Title Page-->
    <title>Au Form Wizard</title>

    <!-- Icons font CSS-->
    <link href="/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="/css/creative.css" rel="stylesheet">



    <!-- Main CSS-->
    <link href="/css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-img-1 ">
        <div class="wrapper ">
            <div class="card card-1">
                <div class="card-heading">
                    <h2 class="title">Let's set up everything for you</h2>
                </div>
                <div class="card-body">
                    <form class="wizard-container" method="POST" action="#" id="js-wizard-form">
                        <ul class="tab-list">
                            <li class="tab-list__item active">
                                <a class="tab-list__link" href="#tab1" data-toggle="tab">
                                    <span class="step">1</span>
                                    <span class="desc">step</span>
                                </a>
                            </li>
                            <li class="tab-list__item">
                                <a class="tab-list__link" href="#tab2" data-toggle="tab">
                                    <span class="step">2</span>
                                    <span class="desc">step</span>
                                </a>
                            </li>
                            <li class="tab-list__item">
                                <a class="tab-list__link" href="#tab3" data-toggle="tab">
                                    <span class="step">3</span>
                                    <span class="desc">step</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="form">
                                    <div class="input-group">
                                        <p class="h6">To find mentions of your brand<br>Add your domain, your location and social media profiles</p>
                                    </div>
                                    <div class="input-group mt-3">
                                        <input class="input--style-1" type="text" name="useDomain" placeholder="YOUR DOMAIN---(www.example.com)" required autofocus>
                                        <input class="input--style-1 mt-2" type="text" name="userLocation" placeholder="LOCATION---(USA)" required="required">
                                        <input class="input--style-1 mt-2" type="text" name="userFacebook" placeholder="FACEBOOK---(www.facebook.com/username)" required="required">
                                        <input class="input--style-1 mt-2" type="text" name="userTwitter" placeholder="TWITTER---(www.twitter.com/username)" required="required">
                                    </div>
                                    <div class="input-group mt-2">
                                        <input class="input--style-1" type="text" name="userinstagram" placeholder="INSTAGRAM---(www.instagram.com/username)" required="required">
                                        <a class="btn--next" href="#">next step</a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="form">
                                    <div class="input-group">
                                        <p class="h6">To monitor your competitors add their domain and social media profiles and keywords to find new competitors.<br>You can add 2 competitors on the free plan</p>
                                    </div>
                                    <div class="input-group mt-3">
                                        <input class="input--style-1" type="text" name="cpt-Domain" placeholder="DOMAIN---(www.example.com)" required="required">
                                        <input class="input--style-1 mt-2" type="text" name="cpt-Facebook" placeholder="FACEBOOK---(www.facebook.com/username)" required="required">
                                        <input class="input--style-1 mt-2" type="text" name="cpt-Twitter" placeholder="TWITTER---(www.twitter.com/username)" required="required"> 
                                        <input class="input--style-1 mt-2" type="text" name="cpt-instagram" placeholder="INSTAGRAM---(www.instagram.com/username)" required="required">
                                    </div>
                                    <div class="input-group mt-2">                                

                                        <input class="input--style-1" type="text" name="keyword" placeholder="Keyword" required="required">
                                        <a class="btn--next" href="#">next step</a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <div class="form">
                                    <div class="input-group text-center">
                                        <p class="h6 ">Choose your preferred channel to get notifications and information from GoHundred</p>
                                    </div>
                                    <div class="text-center">
                                        <a class = "social" href="#">Slack intergration</a>
                                        <p>or</p>
                                        <a class = "social" href="#">Email notifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="/js/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.bootstrap.wizard.min.js"></script>


    <!-- Main JS-->
    <!-- <script src="/js/global.js"></script> -->

</body>

</html>
<!-- end document-->