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
    <title>Gohundred</title>

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
                    <h2 class="title">Let's get you started with monitoring campaigns</h2>
                </div>
                <div class="card-body">
                    <form class="wizard-container" method="POST" action="{{ route('stepResult') }}" id="step-form">
                        @csrf
                        <input type="hidden" id="campaign-type" name="campaign-type" value="brand"/>
                        <input type="hidden" id="campaign-keyword" name="campaign-keyword" value="keyword"/>
                        <input type="hidden" id="campaign-domain" name="campaign-domain" value="domain"/>
                        <input type="hidden" id="campaign-notification" name="campaign-notification" value="notification"/>

                        <ul class="tab-list">
                            <li class="tab-list__item active">
                                <a class="tab-list__link" href="#tab1" id="link-tab1" data-toggle="tab">
                                    <span class="step">1</span>
                                    <span class="desc">step</span>
                                </a>
                            </li>
                            <li class="tab-list__item">
                                <a class="tab-list__link" href="#tab2" id="link-tab2" data-toggle="tab">
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
                                    <div class="text-center">
                                        <p class="h3 text-center">Choose your type of campaign(You can always add more later)</p>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button href="#" class="btn btn-light campaign-type" type="brand">
                                            <strong>Brand</strong>
                                        </button>
                                        
                                        <p>Find out who talks about your brand</p>
                                        <button href="#" class="btn btn-light campaign-type" type="competition">
                                            <strong>Competition</strong>
                                        </button>

                                        <p>Figure out what your competitors are up to</p>
                                        <button href="#" class="btn btn-light campaign-type" type="topic">
                                            <strong>Topic</strong>
                                        </button>
                                        <p>Get instant news on topics related to your bisiness</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="form">
                                    <div class="input-group">
                                        <p class="h6">Type the name of the brand,competitor or topic that you wish to keep your eyes on</p>
                                    </div>
                                    <div class="input-group mt-3">
                                        <input class="input--style-1" id="keyword" type="text" name="cpt-Domain" placeholder="Keyword" required>
                                    </div>
                                    <div class="input-group mt-2">                                
                                        <input class="input--style-1" id="domain" type="text" name="keyword" placeholder="Domain" required>
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
                                        <button class="btn btn-success notification-type" type="slack">Slack intergration</button>
                                        <p>or</p>
                                        <button class="btn btn-danger notification-type" type="email">Email notifications</button>
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
    <script src="/js/global.js"></script>

</body>

</html>
<!-- end document-->