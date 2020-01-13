@extends("layout.base")
@section('title') About Us @endsection
@section('keywords') About Adroit @endsection
@section('description') About Adroit @endsection
@section('body')

<section class="inner_page_section_padding">
        <div class="container">
            <h2 class="page_heading_1">Our History</h2>
            <p>ADROIT-US CONCHEM INDIA PVT LTD is a founded by a group of professionals from relevant industry having rich experience and international exposure. The company as incorporated in the year 2018 and started its operations during the beginning of 2019. Our production facility is currently located at bangalore in india.</p>
            <p>ADROIT-US acquired Swedish technology for updated production facility and setup state-of-the art- Research and Development center to bring the technology close to the customer by developing innovative, cost effective  , user and eco-friendly products for tile and stone installation system with high level of quality , by using latest technology and resources. Technical support team helps you find innovative solutions for various issues related to construction.</p>
            <p>Our state-of-the art manufacturing plant located Bangalore equipped with the latest machinery and the finest production team.</p>
            <p>“ADROIT” it self its meaning “innovative” and “skillful”, our aim is to develop and serve our customers with unique and innovative solutions in tile and stone installation systems and other allied products in construction field. We develop products of high quality with international standard and are tailored to the enhanced properties as per market requirements.</p>
            <p>Our products range includes thinset adhesive, thickset adhesive, tile grout, wall care products, tile and stone care products, waterproofing and various range of admixtures etc.</p>
            <p>Our sales and marketing department is headed by experts who have 20-25 years of rich experience in relevant industry.</p>
            <p>Please feel free to call us for any sales and products related enquiry- we would like to associate with our range of products</p>
        </div>
    </section>

    <section class="paralex_box about_text text-white p_relative d-flex align-items-center justify-content-center">
        <div class="container text-center">
            <h1>ADROIT-US CONCHEM INDIA PVT LTD</h1>
            <h3 class="mt-3">Innovating In Construction</h3>
        </div>
    </section>

    <section class="inner_page_section_padding team_section pb-4">
        <div class="container">
            <h2 class="page_heading_big">Our Team</h2>

            <div class="our_team_slider owl-carousel p_relative">
                @foreach ($teams as $team)
                <div class="item">
                    <div class="team_wrapper">
                        <img src="{{ $team->profileImage }}" alt="{{ $team->fullName }}" class="img-fluid">
                        <div class="team_text">
                            <h4>{{ $team->fullName }}</h4>
                            <p>{{ $team->designation }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- <div class="item">
                    <div class="team_wrapper">
                        <img src="/assets/images/team.jpg" alt="" class="img-fluid">
                        <div class="team_text">
                            <h4>Jone Doe</h4>
                            <p>Marketing Manager</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="team_wrapper">
                        <img src="/assets/images/team.jpg" alt="" class="img-fluid">
                        <div class="team_text">
                            <h4>Jone Doe</h4>
                            <p>Marketing Manager</p>
                        </div>
                    </div>
                </div>
                <div class="item"> -->
                        <!-- <div class="team_wrapper">
                            <img src="/assets/images/team.jpg" alt="" class="img-fluid">
                            <div class="team_text">
                                <h4>Jone Doe</h4>
                                <p>Marketing Manager</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                            <div class="team_wrapper">
                                <img src="/assets/images/team.jpg" alt="" class="img-fluid">
                                <div class="team_text">
                                    <h4>Jone Doe</h4>
                                    <p>Marketing Manager</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                                <div class="team_wrapper">
                                    <img src="/assets/images/team.jpg" alt="" class="img-fluid">
                                    <div class="team_text">
                                        <h4>Jone Doe</h4>
                                        <p>Marketing Manager</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                    <div class="team_wrapper">
                                        <img src="/assets/images/team.jpg" alt="" class="img-fluid">
                                        <div class="team_text">
                                            <h4>Jone Doe</h4>
                                            <p>Marketing Manager</p>
                                        </div>
                                    </div>
                                </div> -->

            </div>
        </div>
    </section>
    <!-- end of page body section -->

@endsection
