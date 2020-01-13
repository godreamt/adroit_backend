@extends("layout.base")
@section('title')Careers @endsection
@section('keywords') Adroit Careers @endsection
@section('description') Adroit Careers @endsection
@section('body')

<section class="inner_page_section_padding mt-3">
    <div class="container">
        <h1 class="career_page_subTitle text-center">Open positions in all locations</h1>
        <div class="row">
            @foreach ($careers as $career)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="javascript:void(0);" class="career_wrapper ease d-block" data-toggle="modal" data-target="#careerModal{{$career->id}}">
                    <h3>{{ $career->title }}</h3>
                    <span><!--<i class="fas fa-map-marker-alt"></i>--> {{ $career->experience }}</span>
                    <span><!--<i class="fas fa-map-marker-alt"></i>--> {{ $career->info }}</span>
                </a>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="careerModal{{$career->id}}" tabindex="-1" role="dialog" aria-labelledby="careerModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content rounded-0">
                        <div class="modal-header careerModal_header pb-0 border-bottom-0">
                            <h3>{{ $career->title }}</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal_inner">
                                <div class="careerDetailBox">
                                    <p><b>Experience : </b> {{ $career->experience }}</p>
                                    <p><b>Info : </b> {{ $career->info }}</p>
                                    <div>
                                        {!! $career->description !!}
                                    </div>
                                    <p><b>mail to :</b> <a href="mailto:gmail@mail.com">gmail@mail.com</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="#" class="career_wrapper ease d-block">
                    <h3>Marketing Manager</h3>
                    <span><i class="fas fa-map-marker-alt"></i> Bangalore</span>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="#" class="career_wrapper ease d-block">
                    <h3>Marketing Manager</h3>
                    <span><i class="fas fa-map-marker-alt"></i> Bangalore</span>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="#" class="career_wrapper ease d-block">
                    <h3>Marketing Manager</h3>
                    <span><i class="fas fa-map-marker-alt"></i> Bangalore</span>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <a href="#" class="career_wrapper ease d-block">
                    <h3>Marketing Manager</h3>
                    <span><i class="fas fa-map-marker-alt"></i> Bangalore</span>
                </a>
            </div> -->
        </div>
    </div>
</section>

<!-- end of page body section -->

@endsection
