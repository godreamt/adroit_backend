<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=0">
    <meta name="HandheldFriendly" content="true" />

    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="title" content="ADROIT-US CONCHEM INDIA PVT LTD - @yield('title')">
    <!-- <link rel="icon" href=""> -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/plugins/bootstrap-4.1/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/plugins/bootstrap-4.1/css/bootstrap-grid.min.css" crossorigin="anonymous">

    <!-- owl slider -->
    <link rel="stylesheet" href="/assets/plugins/owl-carousel/owl.carousel.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/plugins/owl-carousel/owl.theme.default.css" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="/assets/css/animate.css">
    <!-- aos animation -->
    <!-- <link rel="stylesheet" type="text/css" href="/assets/css/aos.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="/assets/css/jquery.simplyscroll.css"> -->
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Passion+One&display=swap" rel="stylesheet">
    <!-- font awesome css -->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- <script src="/assets/js/jquery-3.2.1.min.js" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-145676247-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-145676247-1');
    </script>


    <title>ADROIT-US CONCHEM INDIA PVT LTD - @yield('title')</title>
</head>

<body>
    <header class="header_wrapper ease">
        <div class="container-fluid px-0">
            <nav class="navbar navbar-expand-lg py-0">
                <!-- <div class="nav-header"> -->
                <a href="/" class="navbar-brand">
                    <img src="/assets/images/logo.png" class="logo_img color img-fluid ease">
                    <img src="/assets/images/logo-w.png" class="logo_img white img-fluid ease">
                </a>
                <button class="navbar-toggler menu_burger_btn" type="button" onclick="toggleMenu();">
                    <span class="bar ease"></span>
                    <span class="bar ease"></span>
                    <span class="bar ease"></span>
                </button>
                <!-- </div> -->
                <div class="mobile_menu_outer"></div>
                <div class="navbar-collapse flex-column menu_wrapper ease">
                    <ul class="navbar-nav main_menuBar ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active ease" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active ease" href="/about-us">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active ease" href="/products">Products</a>
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="productlist.html" id="aboutDropdown"
                                role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">Products</a>
                            <div class="dropdown-menu subMenuBox" aria-labelledby="aboutDropdown">
                                <a class="dropdown-item" href="productlist.html">Adhesives</a>
                                <a class="dropdown-item" href="#">Block Adhesive</a>
                                <a class="dropdown-item" href="#">Grouts</a>
                                <a class="dropdown-item" href="#">Waterproofing</a>
                                <a class="dropdown-item" href="#">Plastering</a>
                                <a class="dropdown-item" href="#">Cleaners</a>
                            </div>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link active" href="/careers">Careers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/contact-us">Contact</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>


    @if(Request::path() === '/')
        <!-- page body section -->
        <div class="hero_header home_banner p_relative d-flex align-items-center justify-content-center">
            <video autoplay loop muted playsinline src="/assets/images/video.mp4" class="banner_video"></video>
            <div class="layer"></div>
            <div class="home_banner_content p_relative">
                <h2>Innovating in construction</h2>
                <p>ADROIT-US CONCHEM INDIA PVT LTD is founded by a group of professionals from relevant industry having rich experience and international exposure.</p>
                <a href="/about-us" class="btn more_btn ease">Read More</a>
            </div>
            <a href="#aboutSection" class="scroll_down_btn"><span></span></a>
        </div>

        <!-- <div class="hero_header home_banner p_relative d-flex align-items-center justify-content-center">
            <div class="owl-carousel hero_slider">
                <div class="item" style="background-image: url(images/product1.jpg)"></div>
                <div class="item" style="background-image: url(images/product2.jpg)"></div>
                <div class="item" style="background-image: url(images/product3.jpg)"></div>
            </div>
            <div class="layer"></div>
            <div class="home_banner_content p_relative">
                <h2>Innoving in construction</h2>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium tempore porro inventore adipisci
                    debitis aliquam accusantium.</p>
                <a href="#" class="btn more_btn ease">Read More</a>
            </div>
            <a href="#aboutSection" class="scroll_down_btn"><span></span></a>
        </div> -->

    @else
        <!-- page body section -->
        <section class="innerpage_bannerSection aboutBanner">
            <h3>@yield('title')</h3>
        </section>
    @endif


    @yield('body')



    <!-- footer form -->
    <div class="form_section">
        <div class="container">
            <div class="form_wrapper" id="contact-us-app">
                <h2>Contact Us</h2>
                <form action="post" class="footer_form" @submit="sendContact($event)" > 
                    <div class="row">
                            <div class="col-md-4 col-12">
                                    <div class="form-group p_relative label_trans">
                                        <label>Full Name</label>
                                        <input type="text" name="name" class="form-control" required v-model="contactData.fullName">
                                    </div>
                                </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group p_relative label_trans">
                                <label>Email</label>
                                <input type="email" name="email" required class="form-control" v-model="contactData.email">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                                <div class="form-group p_relative label_trans">
                                    <label>Mobile Number</label>
                                    <input type="number" name="mobile" required class="form-control" v-model="contactData.mobileNumber">
                                </div>
                            </div>
                       <div class="col-md-8 col-12">
                            <div class="form-group p_relative">
                                <textarea name="message" class="form-control" required placeholder="Contact reason" v-model="contactData.reasonText"></textarea>
                            </div>
                       </div>
                        <div class="col-md-4 col-12 align-self-end">
                            <div class="row">
                                <div v-if="error !=''" class="w-100 py-3 text-center text-danger">Given data is invalid</div>
                                <div v-if="result !=''" class="w-100 py-3 text-center text-success"><% result %></div>
                            </div>
                            <button type="submit" class="btn submit_btn ease mb-3">Submit</button>
                        </div>
                    </div>
                </form>
                <!-- <p>Sign up to receive offers, promotions and other marketing emails from ADHCrete. You can opt out of
                    them at any time.</p> -->
            </div>
        </div>
    </div>
    <!-- end page body section -->

    @inject('provider', 'App\Http\Controllers\CategoryController')
    <footer>
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="footer_inner">
                            <h4 class="footer_title">Contact Us</h4>
                            <div>
                                <p><span class="d-block">Registered Office:</span>
                                    ADROIT-US CONCHEM INDIA PVT LTD <br>
                                    Vakwady village <br>
                                    Kundapura Taluk <br>
                                    Udupi Dist. Karnataka 576222
                                </p>
                                <!-- <p>Landline : <a href="#" class="d-block">(12345) 123456/896</a></p>
                                <p>Mobile No : <a href="#" class="d-block">1234567890, 1234567890, 1234567890</a></p> -->
                            </div>
                            <!-- <div>
                                <p><span class="d-block">Factory :</span>
                                    your factory
                                    address pincode 123 456
                                </p>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="footer_inner">
                            <h4 class="footer_title">Our Products</h4>
                            <ul class="list-unstyled list_arrow row">
                                @foreach( $provider::getCat() as $item )
                                    <li class="col-sm-6"><i class="fas fa-angle-double-right mr-1"></i> <a href="/products/{{ $item->slug }}">{{ $item->title }}</a></li>
                                @endforeach
                                <!-- <li class="col-sm-6"><i class="fas fa-angle-double-right mr-1"></i> <a href="#">Plasters</a></li>
                                <li class="col-sm-6"><i class="fas fa-angle-double-right mr-1"></i> <a href="#">Adhesives</a></li>
                                <li class="col-sm-6"><i class="fas fa-angle-double-right mr-1"></i> <a href="#">Grouts</a></li>
                                <li class="col-sm-6"><i class="fas fa-angle-double-right mr-1"></i> <a href="#">Primers</a></li>
                                <li class="col-sm-6"><i class="fas fa-angle-double-right mr-1"></i> <a href="#">Admixtures</a></li>
                                <li class="col-sm-6"><i class="fas fa-angle-double-right mr-1"></i> <a href="#">Waterproofing</a></li>
                                <li class="col-sm-6"><i class="fas fa-angle-double-right mr-1"></i> <a href="#">Tile and Stone Care</a></li>
                                <li class="col-sm-6"><i class="fas fa-angle-double-right mr-1"></i> <a href="#">Wall Putty</a></li> -->
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 col-sm-6">
                        <div class="footer_inner">
                            <h4 class="footer_title">Call Us At</h4>
                            <ul class="list-unstyled">
                                <li>All over India - 1234567890</li>
                                <li>Bengaluru - 1234567890</li>
                                <li>Mysuru - 1234567890</li>
                                <li>Mangaluru - 1234567890</li>
                                <li>Hubballi - 1234567890</li>
                            </ul>
                        </div>
                    </div> -->
                    <div class="col-md-3 col-sm-6">
                        <div class="footer_inner">
                            <h4 class="footer_title">Note</h4>
                            <p>Contact us on 24x7, for getting any of supports related to product.</p>
                            <h5>CUSTOMER CARE</h5>
                            <div class="mb-2"><i class="fas fa-phone mr-1"></i> Call us :<a  href="tel:+917760261711">+91 776 0261 711</a></div>
                            <div><i class="fas fa-envelope mr-1"></i> Email us : <a
                                    href="mailto:customercare@adroitconchem.com">customercare@adroitconchem.com</a></div>
                        </div>
                    </div>
                </div>
                <div class="social_link_box text-center">
                    <a href="#" class="ease"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="ease"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="ease"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="ease"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="container text-center">
                <p>&copy; 2019. Adroit. All rights Reserved. Designed By <a href="http://www.godreamt.com">Godreamt Technologies</a>.</p>
            </div>
        </div>
    </footer>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <!-- font awesome -->
    <!-- <script src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script> -->
    <!-- bootstrap -->
    <script src="/assets/plugins/bootstrap-4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- owl slider -->
    <script src="/assets/plugins/owl-carousel/owl.carousel.js" crossorigin="anonymous"></script>
    <!-- scroll animation -->
    <script type="text/javascript" src="/assets/js/jquery.scrollme.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.validate.js"></script>
    <script type="text/javascript" src="/assets/js/vue.min.js"></script>
    <script type="text/javascript" src="/assets/js/axios.js"></script>

    <!-- <script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script> -->
    <script type="text/javascript" src="/assets/js/script.js"></script>
    <script type="text/javascript" src="/assets/js/contact-us.js"></script>
    @yield('script')
</body>

</html>
