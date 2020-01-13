@extends("layout.base")


@section('title')Innovating in construction @endsection
@section('keywords')ADROIT-US CONCHEM INDIA PVT LTD, ADROIT-US CONCHEM, ADROIT-US, Adroit, AdroitUS @endsection
@section('description') ADROIT-US acquired Swedish technology for updated production facility and setup state-of-the art- Research and Development center to bring the technology close to the customer by developing innovative, cost effective  , user and eco-friendly products for tile and stone installation system with high level of quality , by using latest technology and resources. Technical support team helps you find innovative solutions for various issues related to construction. @endsection


@section('body')

 <!-- about section -->
 <div class="about_section" id="aboutSection">
        <div class="container scrollme">
            <div class="about_wrapper animateme" data-when="view" data-from="0.75" data-to="0" data-opacity="0" data-translatey="100">
                <p>ADROIT-US acquired Swedish technology for updated production facility and setup state-of-the art- Research and Development center to bring the technology close to the customer by developing innovative, cost effective  , user and eco-friendly products for tile and stone installation system with high level of quality , by using latest technology and resources. Technical support team helps you find innovative solutions for various issues related to construction.</p>
            </div>
            <div class="line scrollme animateme" data-when="view" data-from="0.55" data-to="0.05" data-scale="0"></div>
        </div>
    </div>
    <!-- clients section -->
    <div class="clients_section">
        <div class="container">
            <div class="clents_wrapper scrollme">
                <h5 class="animateme" data-when="view" data-from="0.75" data-to="0" data-opacity="0" data-translatey="100">We are In</h5>
                <div class="row">
                    <div class="col-lg col-md-3 col-sm-4 col-6">
                        <div class="logo_box text-center animateme" data-when="span" data-from="0.10" data-to="0" data-opacity="0" data-translatey="80">
                            <img src="/assets/images/location-pin.svg" class="img-fluid">
                            Kundapura
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-sm-4 col-6">
                        <div class="logo_box text-center animateme" data-when="span" data-from="0.30" data-to="0" data-opacity="0" data-translatey="120">
                            <img src="/assets/images/location-pin.svg" class="img-fluid">
                            Upupi
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-sm-4 col-6">
                        <div class="logo_box text-center animateme" data-when="span" data-from="0.50" data-to="0" data-opacity="0" data-translatey="160">
                            <img src="/assets/images/location-pin.svg" class="img-fluid">
                            Mangalore
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-sm-4 col-6">
                        <div class="logo_box text-center animateme" data-when="span" data-from="0.70" data-to="0" data-opacity="0" data-translatey="200">
                            <img src="/assets/images/location-pin.svg" class="img-fluid">
                            Bhatkala
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-sm-4 col-6">
                        <div class="logo_box text-center animateme" data-when="span" data-from="0.90" data-to="0" data-opacity="0" data-translatey="240">
                            <img src="/assets/images/location-pin.svg" class="img-fluid">
                            Karkala
                        </div>
                    </div>
                    <div class="w-100 d-none d-lg-block"></div>
                    <div class="col-lg col-md-3 col-sm-4 col-6">
                        <div class="logo_box text-center animateme" data-when="span" data-from="0.10" data-to="0" data-opacity="0" data-translatey="80">
                            <img src="/assets/images/location-pin.svg" class="img-fluid">
                            Bangalore
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-sm-4 col-6">
                        <div class="logo_box text-center animateme" data-when="span" data-from="0.30" data-to="0" data-opacity="0" data-translatey="120">
                            <img src="/assets/images/location-pin.svg" class="img-fluid">
                            Kerala
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-sm-4 col-6">
                        <div class="logo_box text-center animateme" data-when="span" data-from="0.50" data-to="0" data-opacity="0" data-translatey="160">
                            <img src="/assets/images/location-pin.svg" class="img-fluid">
                            Tamilnadu
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-sm-4 col-6">
                        <div class="logo_box text-center animateme" data-when="span" data-from="0.70" data-to="0" data-opacity="0" data-translatey="200">
                            <img src="/assets/images/location-pin.svg" class="img-fluid">
                            Andhra Pradesh
                        </div>
                    </div>
                    <div class="col-lg col-md-3 col-sm-4 col-6">
                        <div class="logo_box text-center animateme" data-when="span" data-from="0.90" data-to="0" data-opacity="0" data-translatey="240">
                            <img src="/assets/images/location-pin.svg" class="img-fluid">
                            Maharashtra
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rewiew section -->
    <div class="review_section">
        <div class="container">
            <div class="review_wrapper">
                <div class="row align-items-center">
                    <div class="col-md-6 d-none d-md-block scrollme">
                        <div class="review_img_box text-center animateme" data-when="span" data-from="0.5" data-to="0" data-opacity="0" data-translatey="-100">
                            <!-- <img src="/assets/images/reviewbg.png" class="img-fluid"> -->
                        </div>
                    </div>
                    <div class="col-md-6 p_relative">
                        <span class="quotes">"</span>
                        <div class="owl-carousel review_inner">
                            @foreach ($reviews as $review)
                                <div class="item text-center">
                                    <div>
                                        {!! $review->review !!}
                                    </div>
                                    <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi ab molestias atque
                                        deleniti obcaecati recusandae quos quidem repellendus minus odio reiciendis nemo.
                                    </p> -->
                                    <h3>{{ $review->name }}</h3>
                                </div>
                            @endforeach
                            <!-- <div class="item text-center">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi ab molestias atque
                                    deleniti obcaecati recusandae quos quidem repellendus minus odio reiciendis nemo.
                                </p>
                                <h3>Jone Doe</h3>
                            </div>
                            <div class="item text-center">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi ab molestias atque
                                    deleniti obcaecati recusandae quos quidem repellendus minus odio reiciendis nemo.
                                </p>
                                <h3>Jone Doe</h3>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- new product section -->
    <div class="newproduct_section">
        <div class="container scrollme">
            <div class="newproduct_wrapper owl-carousel p_relative animateme" data-when="view" data-from="0.55" data-to="0.05" data-scale="0.8" data-opacity="0">
                @foreach ($categories as $category)
                    <div class="item">
                        <div class="newproduct_inner p_relative">
                            <a href="#">
                                <img src="{{ $category->featuredImage }}" class="img-fluid">
                                <div class="product_text p_absolute">
                                    <h2>{{ $category->title }}</h2>
                                    <div class="line-set">{!! $category->shortDescription !!}</div>
                                    <a href="/products/{{ $category->slug }}" class="btn moreBtn ease">View More</a>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                <!-- <div class="item">
                    <div class="newproduct_inner p_relative">
                        <a href="#">
                            <img src="/assets/images/p2.jpg" class="img-fluid">
                            <div class="product_text p_absolute">
                                <h2>Product Name</h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi reprehenderit
                                    laborum doloremque facere impedit deserunt cum nulla nam tempora, facilis iure.</p>
                                <a href="#" class="btn moreBtn ease">View More</a>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="newproduct_inner p_relative">
                        <a href="#">
                            <img src="/assets/images/p3.jpg" class="img-fluid">
                            <div class="product_text p_absolute">
                                <h2>Product Name</h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi reprehenderit
                                    laborum doloremque facere impedit deserunt cum nulla nam tempora, facilis iure.</p>
                                <a href="#" class="btn moreBtn ease">View More</a>
                            </div>
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- product section -->
    <div class="products_section">
        <div class="container scrollme">
            <div class="products_wrapper">
                <h1 class="animateme" data-when="view" data-from="0.05" data-to="0" data-opacity="0" data-translatey="100">Our Products</h1>
                <div class="product_slider_wrapper">
                    <div class="row">
                        @foreach ($bestSellingProducts as $product)
                            <div class="col-lg-3 col-md-6 col-12 pb-3">
                                <div class="product_inner p_relative ease animateme" data-when="view" data-from="{{ $product->animate }}" data-to="0" data-opacity="0" data-translatey="100">

                                <span class="tags">Best seller</span>
                                    <a href="#">
                                        <div class="product_imgBox">
                                            <img src="{{ $product->featuredImage }}" class="img-fluid">
                                            <h2>{{ $product->title }}</h2>
                                        </div>
                                        <div class="product_textBox">

                                            {!! $product->shortDescription !!}
                                        </div>
                                    </a>
                                    <div class="card_footer">
                                        <a href="/product/{{ $product->slug }}" class="btn card_footer_btn">View</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- <div class="col-lg-3 col-md-6 col-12 pb-3">
                            <div class="product_inner p_relative ease animateme" data-when="view" data-from="0.40" data-to="0" data-opacity="0" data-translatey="100">
                                <a href="#">
                                    <div class="product_imgBox">
                                        <img src="/assets/images/p2.jpg" class="img-fluid">
                                        <h2>Water Proofing</h2>
                                    </div>
                                    <div class="product_textBox">

                                        <p>ADHPlast Readymade Plaster is a mix of carefully selected raw materials,
                                            Portland cement and graded fillers.</p>
                                    </div>
                                </a>
                                <div class="card_footer">
                                    <a href="#" class="btn card_footer_btn">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 pb-3">
                            <div class="product_inner ease p_relative animateme" data-when="view" data-from="0.65" data-to="0" data-opacity="0" data-translatey="100">
                                <a href="#">
                                    <div class="product_imgBox">
                                        <img src="/assets/images/p3.jpg" class="img-fluid">
                                        <h2>Plastering</h2>
                                    </div>
                                    <div class="product_textBox">

                                        <p>AAC BLOCK LAYING ADHESIVE is a factory prepared blend of carefully selected
                                            raw materials. AAC BLOCK LAYING ADHESIVE is a factory prepared blend of carefully selected
                                            raw materials</p>
                                    </div>
                                </a>
                                <div class="card_footer">
                                    <a href="#" class="btn card_footer_btn">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 pb-3">
                            <div class="product_inner ease p_relative animateme" data-when="view" data-from="0.90" data-to="0" data-opacity="0" data-translatey="100">
                                <a href="#">
                                    <div class="product_imgBox">
                                        <img src="/assets/images/p1.jpg" class="img-fluid">
                                        <h2>Cleaners</h2>
                                    </div>
                                    <div class="product_textBox">

                                        <p>Non Shrinking and non Cracking</p>
                                    </div>
                                </a>
                                <div class="card_footer">
                                    <a href="#" class="btn card_footer_btn">View</a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="/products" class="viewAllBtn btn">View All <i class="ml-2 fas fa-long-arrow-alt-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="gallery_section">
        <div class="container">
            <div class="gallery_wrapper p_relative d-flex align-items-center justify-content-center scrollme animateme" data-when="enter" data-from="0.5" data-to="0" data-crop="false" data-opacity="0" data-scale="1.5">
                <div class="gallery_inner text-center">
                    <h2>Send Us an enquiry</h2>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium tempore porro inventore
                        adipisci
                        debitis aliquam accusantium.</p>
                    <a href="javascript:;" class="btn gallery_btn p_relative ease" data-toggle="modal"
                        data-target="#equireModal">Click</a>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade enquire_modal" id="equireModal" tabindex="-1" role="dialog" aria-labelledby="equireModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="enquiry-app">
                    <div class="modal_inner">
                            <h5>Enquire Now</h5>
                            <form action="" class="popup_enquireForm" id="EnquireForm" @submit="sendEnquiry($event)">
                                <!-- <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select name="cetegory" class="form-control">
                                                <option disabled selected>Select Category</option>
                                                <option value="">product one</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select name="product" class="form-control">
                                                <option disabled selected>Select Product</option>
                                                <option value="">product one</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Full Name" required v-model="enquiryData.fullName">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" required v-model="enquiryData.mobileNumber">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email Id" required v-model="enquiryData.email">
                                </div>
                                <div class="form-group">
                                    <textarea name="info" class="form-control" placeholder="Enter Your Info.." required v-model="enquiryData.customerInfo"></textarea>
                                </div>
                                <div class="form-group">
                                    <textarea name="message" class="form-control" placeholder="Message.." required v-model="enquiryData.enquiryText"></textarea>
                                </div>
                                <div class="row">
                                    <div v-if="error !=''" class="w-100 py-3 text-center alert alert-danger">Given data is invalid</div>
                                    <div v-if="result !=''" class="w-100 py-3 text-center alert alert-success"><% result %></div>
                                </div>
                                <div class="popUpfrm_btnBox mt-4 text-center">
                                    <button type="submit" class="btn site_btn">Send</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script type="text/javascript" src="/assets/js/enquiry.js"></script>
@endsection