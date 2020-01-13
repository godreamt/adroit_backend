@extends("layout.base")


@section('title'){{ $product->title }} @endsection
@section('keywords'){{ $product->title }} @endsection
@section('description') {{ $product->title }} @endsection

@section('body')

<section class="inner_page_section_padding">
       <div class="container">
           <div class="product_viewBox">
                <div class="row">
                    <div class="col-md-5">
                        <div class="product_page_imgBox">
                            <img src="{{ $product->featuredImage}}" alt="product 1" class="img-fluid w-100">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="product_sort_detail">
                            @if($product->bestSeller)
                            <span class="d-inline-block bestTag">Best seller</span>
                            @endif
                            <h2>{{ $product->title }}</h2>
                            <div class="small_diss">
                                {!! $product->shortDescription !!}
                            </div>
                            <!-- <h4>Feature Info </h4> -->
                            <div>
                                {!! $product->featureInfo !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
       </div>
    </section>

    <section class="inner_page_section_padding pt-0">
        <div class="container">
            <h2 class="page_heading_1 mb-4">Description</h2>
            <div>
                {!! $product->description !!}
            </div>
        </div>
    </section>

    
    <section class="inner_page_section_padding about_category_section">
            <div class="container">
                <h2 class="page_heading_1">About {{ $product->category->title}}</h2>
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-6">
                        <div class="about_category_inner">
                            {!! $product->category->shortDescription !!}
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5">
                        <div class="about_category_inner mb-4">
                            <img src="{{$product->category->featuredImage}}" alt="category relate image">
                        </div>
                    </div>
                </div>
            </div>
            <hr style="background-color:rgba(255, 255, 255, 0.5);" class="mt-5">
            <div class="container mt-5">
                <h2 class="page_heading_1">About {{ $product->sub_category->title}}</h2>
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="about_category_inner mb-4">
                            <img src="{{$product->sub_category->featuredImage}}" alt="category relate image">
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-6">
                        <div class="about_category_inner">
                            {!! $product->sub_category->shortDescription !!}
                        </div>
                    </div>
                </div>
            </div>
    </section>

     

    <section class="inner_page_section_padding related_project_section pb-4">
        <div class="container">
            <h2 class="page_heading_1">Related Products</h2>

            <div class="related_project_slider owl-carousel p_relative">
                @foreach($relatedProducts as $product)
                <div class="item">
                        <div class="product_inner ease p_relative animateme" data-when="view" data-from="0.65" data-to="0" data-opacity="0" data-translatey="100">
                                <a href="#">
                                    <div class="product_imgBox">
                                        <img src="{{$product->featuredImage}}" class="img-fluid">
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
                @endForeach
                <!-- <div class="item">
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
                <div class="item">
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
                <div class="item">
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
                    <div class="item">
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
                        </div> -->
                   

            </div>
        </div>
    </section>
    <!-- end of page body section -->

@endsection