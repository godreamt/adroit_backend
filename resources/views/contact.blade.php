@extends("layout.base")


@section('title')Contact Us @endsection
@section('keywords') Contact Us @endsection
@section('description') Contact Us @endsection

@section('body')

<section class="inner_page_section_padding mt-3">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contact_inner text-center">
                        <div class="mb-2">
                            <i class="fas fa-mobile-alt"></i>
                            <p>Call to</p>
                        </div>
                        <a href="tel:+917760261711">+91 776 0261 711</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="contact_inner text-center">
                        <div class="mb-2">
                            <i class="fas fa-envelope"></i>
                            <p>Mail to</p>
                        </div>
                        <a href="mailto:customercare@adroitconchem.com">customercare@adroitconchem.com</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="inner_page_section_padding mb-4 pt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 col-sm-6">
                    <div class="address_box text-center">
                        <h4><i class="fas fa-map-marker-alt"></i> Bangalore</h4>
                        <p>A place to experience with experiment!</p>
                        <!-- <span>+91 898989898</span>
                        <span>mail@gmail.com</span> -->
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                        <div class="address_box text-center">
                                <h4><i class="fas fa-map-marker-alt"></i> Mangalore</h4>
                                <p>Gate way of Karnataka.</p>
                                <!-- <span>+91 787878445</span>
                                <span>mail@gmail.com</span> -->
                            </div>
                </div>
                <div class="col-md-4 col-sm-6">
                        <div class="address_box text-center">
                                <h4><i class="fas fa-map-marker-alt"></i> Udupi</h4>
                                <p>Growing city.</p>
                                <!-- <span>+91 5656567845</span>
                                <span>mail@gmail.com</span> -->
                            </div>
                </div>
            </div>
        </div>
    </section>
    <section class="map_section">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15510.242087672521!2d74.68465093188843!3d13.623631950145267!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbc8e067b158c71%3A0x3b3eb31736debdcb!2sKundapura%2C+Karnataka!5e0!3m2!1sen!2sin!4v1565947841679!5m2!1sen!2sin" frameborder="0" style="border:0" allowfullscreen></iframe>
    </section>
    <!-- end of page body section -->

@endsection