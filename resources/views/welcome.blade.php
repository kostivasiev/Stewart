<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Stewart Tech - Equipment and Fuel Manager</title>

    <!-- Bootstrap Core CSS -->
    <link href="template/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="template/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="template/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="template/css/creative.min.css" rel="stylesheet">
    <link rel="stylesheet" href="template/css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="template/https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="template/https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Stewart Tech</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#equipment-manager">Equipment Manager</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#fuel-stations">Fuel Stations</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#pricing">Pricing</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <h1 id="homeHeading"><font color="">Cloud based equipment and <br>fuel management system <font></h1>
                <hr>
                <p><font color="">Enable your mechanics to record each work order and track who fuels your equipment<font></p>
                <a href="#about" class="btn btn-primary btn-xl page-scroll">Find Out More</a>
            </div>
        </div>
    </header>

    <section id="equipment-manager" class="features" >

          <div class="col-md-4" style="display:none">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Drivers</h3>
              </div>
              <div class="panel-body">
                <button type="button" class="btn" onclick="locate_me()">Locate Me</button>
                <iframe src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d3173039.290901767!2d-114.92664457107433!3d39.04561597213512!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e0!4m3!3m2!1d40.559862599999995!2d-111.89982979999999!4m5!1s0x80ca64ce0898b639%3A0xb6c2482aa3366fed!2sRobert+Holt+Farms%2C+95+E+Main+St%2C+Enterprise%2C+UT+84725!3m2!1d37.57365!2d-113.71902999999999!5e0!3m2!1sen!2sus!4v1523281345314" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                <div id="demo"></div>
              </div>
            </div>
          </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h2>Equipment Manager</h2>
                        <p class="text-muted">Track all maintenance for your equipment</p>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-8">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <!-- <img src="uploads/workorder.png" alt=""  class="media-object" alt="" style="max-height:100px;"/> -->
                                    <h3>Work Orders</h3>
                                    <p class="text-muted">With the easy to use interface, record all work done on your equipment.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <!-- <img src="uploads/intervals.png" alt=""  class="media-object" alt="" style="max-height:100px;"/> -->
                                    <h3>Intervals</h3>
                                    <p class="text-muted">Schedule service intervals for your equipment so you never overlook another oil change.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="icon-present text-primary"></i>
                                    <h3>Alerts</h3>
                                    <p class="text-muted">When a service interval is up, you'll receive a text message letting you know your equipment needs work.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <!-- <img src="uploads/parts.png" alt=""  class="media-object" alt="" style="max-height:100px;"/> -->
                                    <h3>Parts and Supplies</h3>
                                    <p class="text-muted">Assign parts and supplies to equipment for quick reference during services.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="device-container">
                        <div class="device-mockup iphone6_plus portrait white">
                            <div class="device">
                                <div class="screen">
                                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                  <!-- <img src="uploads/manager.png" alt=""  class="img-responsive" alt="" /> </div> -->
                                <div class="button">
                                    <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


        <section class="bg-primary" id="about">
            <div class="container">
            </div>
        </section>

    <section id="fuel-stations" class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h2>Fuel System</h2>
                        <p class="text-muted">Know who is using your fuel!</p>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="device-container">
                        <div class="device-mockup iphone6_plus portrait white">
                            <div class="device">
                                <div class="screen">
                                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                    <!-- <img src="http://stewarttechsystems.com/images/img/Fuel.png" class="img-responsive" alt="">  -->
                                  </div>
                                <div class="button">
                                    <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="icon-screen-smartphone text-primary"></i>
                                    <h3>Security</h3>
                                    <p class="text-muted">Lock out unauthorized users to protect your fuel when you are not around.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="icon-camera text-primary"></i>
                                    <h3>Alerts</h3>
                                    <p class="text-muted">Receive a text alert when you or someone else fuels.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="icon-present text-primary"></i>
                                    <h3>Reports</h3>
                                    <p class="text-muted">View historical reports containing user, stataion, equipment, gallons, and date.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="icon-lock-open text-primary"></i>
                                    <h3>Peace of Mind</h3>
                                    <p class="text-muted">Rest easy knowing that your fuel is protected 24 hours a day.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <aside class="bg-primary">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Try a demo</h2>
                <a onclick="start_demo()" class="btn btn-default btn-xl sr-button">Start Demo Now!</a>
            </div>
        </div>
    </aside>
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Nice Features!</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond text-primary sr-icons"></i>
                        <h3>Cloud Based</h3>
                        <p class="text-muted">Access your system from anywhere over the internet and know your data is safe.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-paper-plane text-primary sr-icons"></i>
                        <h3>Mobile Ready</h3>
                        <p class="text-muted">It doesn't matter what plateform you use. You can do everything from a computer, tablet, or mobile phone!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"></i>
                        <h3>Interval Alerts</h3>
                        <p class="text-muted">We'll let you know when your equipment intervals are up so you can focus on your business.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-heart text-primary sr-icons"></i>
                        <h3>Easy to Use</h3>
                        <p class="text-muted">It's so easy to use, you can create and submit a work order in under a minute.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing">
      <div class="container">
          <div class="row">
              <div class="col-lg-12 text-center">
                  <h2 class="section-heading">Pricing - Equipment Manager</h2>
                  <hr class="primary">
              </div>
          </div>
      </div>
      <div class="plans">
  <div class="plan">
    <h2 class="plan-title">Basic</h2>
    <p class="plan-price">$10<span>/mo</span></p>
    <ul class="plan-features">
      <li><strong>25</strong> equipment</li>
      <li><strong>10</strong> users</li>
      <li><strong>1</strong> connected fuel boxes*</li>
    </ul>
    <a href="{{ route('register') }}" class="btn btn-primary">Sign Up Now</a>
    <br>
    <a href="index.html" class="btn btn-default">15 day trial</a>
  </div>
  <div class="plan plan-tall">
    <h2 class="plan-title">Plus</h2>
    <p class="plan-price">$50<span>/mo</span></p>
    <ul class="plan-features">
      <li><strong>150</strong> equipment</li>
      <li><strong>Unlimited</strong> users</li>
      <li><strong>5</strong> connected fuel boxes*</li>
    </ul>
    <a href="{{ route('register') }}" class="btn btn-success">Sign Up Now</a>
    <br>
    <a href="index.html" class="btn btn-default">15 day trial</a>
  </div>
  <div class="plan">
    <h2 class="plan-title">Pro</h2>
    <p class="plan-price">$99<span>/mo</span></p>
    <ul class="plan-features">
      <li><strong>Unlimited</strong> users</li>
      <li><strong>250</strong> equipment</li>
      <li><strong>10</strong> connected fuel boxes*</li>
    </ul>
    <a href="{{ route('register') }}" class="btn btn-primary">Sign Up Now</a>
    <br>
    <a href="index.html" class="btn btn-default">15 day trial</a>
  </div>
  *Fuel Boxes are purchased seperately from the subscription plans.
</div>
    </section>
    <section>
      <div class="container">
          <div class="row">
              <div class="col-lg-12 text-center">
                  <h2 class="section-heading">Pricing - Fuel Stations</h2>
                  <hr class="primary">
              </div>
          </div>
      </div>
      <div class="container">
          <div class="row">
              <div class="col-lg-10">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="media-body">
                      <h2>Fuel Station - Basic</h2>
                      Secures 1 pump<br>
                      Contact Sales
                      <!-- <strong>$4800</strong> -->
                    </div>
                    <div class="media-right">
                      <a href="#">
                        <!-- <img src="http://stewarttechsystems.com/images/img/Fuel.png" class="media-object" alt="" style="max-height:100px;"> -->
                      </a>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-10">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="media-body">
                      <h2>Fuel Station - Plus</h2>
                      Secures 2 pump<br>
                      Contact Sales
                      <!-- <strong>$5500</strong> -->
                    </div>
                    <div class="media-right">
                      <a href="#">
                        <!-- <img src="http://stewarttechsystems.com/images/img/Fuel.png" class="media-object" alt="" style="max-height:100px;"> -->
                      </a>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-10">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="media-body">
                      <h2>Fuel Station - Pro</h2>
                      Secures 3 pump<br>
                      Contact Sales
                      <!-- <strong>$6200</strong> -->
                    </div>
                    <div class="media-right">
                      <a href="#">
                        <!-- <img src="http://stewarttechsystems.com/images/img/Fuel.png" class="media-object" alt="" style="max-height:100px;"> -->
                      </a>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>

    </section>


    <!-- <aside class="bg-dark">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>What else do we offer?</h2>
                <a href="template/http://startbootstrap.com/template-overviews/creative/" class="btn btn-default btn-xl sr-button">Go to Store</a>
            </div>
        </div>
    </aside> -->

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Let's Get In Touch!</h2>
                    <hr class="primary">
                    <p>Want to know more? Give us a call or send us an email, and we will get back to you as soon as possible!</p>
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>801-341-9256</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                    <p><a href="mailto:sales@stewart-tech.com">sales@stewart-tech.com</a></p>
                </div>
            </div>
        </div>
    </section>
    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}" id="demo-form">
      {{ csrf_field() }}
      <input name="cell_number" type="hidden" value="(000) 000-0000">
      <input name="password" type="hidden" value="(000) 000-0000">
    </form>

    <script src="https://embed.small.chat/TESKBPVSPGETQ5J7V5.js" async></script>
    <script>
    function start_demo(){
      $("#demo-form").submit();
    }

    var x = document.getElementById("demo");

    function getLocation() {
        if (navigator.geolocation) {
            console.log('position 2');
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
          console.log('position 3');
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
      console.log('position');
        x.innerHTML = "Latitude: " + position.coords.latitude +
        "<br>Longitude: " + position.coords.longitude;
    }

    function locate_me(){
      console.log('locate me');
      getLocation();
    }

    </script>

    <!-- jQuery -->
    <script src="template/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="template/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="template/vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="template/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="template/js/creative.min.js"></script>

</body>

</html>
