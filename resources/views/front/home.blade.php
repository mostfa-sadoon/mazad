@extends('layouts.site')
@section('title')
@lang('app/all.mazadkniss')
@endsection
@section('content')




<!-- Start Content Page -->
<div id="content" class="home-page">

@include('front.includes.items.success_model')

    <section class="head-slide">

    {{--  _________________________________________ Slider _________________________________________  --}}
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="swiper-head">
                        <div class="swiper-wrapper">
                            @foreach ($slider as $item)
                                <div class="swiper-slide">
                                 <a href="{{$item->url}}">   <img src="{{ $item->image }}" /></a>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <script>
                        // Params
                        var Swipes = new Swiper('.swiper-head', {
                            loop: true,
                            autoplay: {
                                delay: 5000,
                            },
                        });
                    </script>
                </div>
                <div class="col-sm-4">
                    <div class="e3-head">
                        @foreach($sidebarbanners as $banner)
                        <a href="{{ $banner->url }}"><img src="{{ asset('assets/images/banner/'.Config::get('app.locale') .'/'. $banner->img)}}" /></a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>

    {{--  _________________________________________ Categories _________________________________________  --}}
    <div class="container">
        <section class="swiper-container loading">
            <div class="swiper-wrapper">

                @foreach ($categories as $item)
                    <div class="swiper-slide">
                        <a href="{{ route('client.auctions', ['category_id'=>$item->id]) }}">
                            <div class="image"><img src="{{ $item->image }}" class="entity-img" /></div>
                            <div class="content">
                                <h2 class="title">{{ $item->name }}</h2>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>

            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        </section>
    </div>

    <section class="sec-text">
        <div class="container">
            <div class="text-boxs">
                <div class="">
                    @if($homeSections)
                    @foreach ($homeSections as $homeSection)
                        <div class="col-sm-6">
                            <div class="text-box">
                                <div class="ico"><img src="{{$homeSection->logo}}" /></div>
                                <div class="content">
                                    <h2>{{$homeSection->name}}</h2>
                                    <p>{{$homeSection->desc}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="tabs_home">
        <nav>
            <div class="container">
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active"><a class="nav-link" href="#progress-auctions" aria-controls="progress-auctions" role="tab" data-toggle="tab">@lang('app/all.latest_auctions')</a></li>

                    <li role="presentation"><a class="nav-link" href="#soon-auctions" aria-controls="soon-auctions" role="tab" data-toggle="tab">@lang('app/all.soon_auctions')</a></li>

                    <li role="presentation"><a class="nav-link" href="#closed-auctions" aria-controls="closed-auctions" role="tab" data-toggle="tab">@lang('app/all.closed_auctions')</a></li>

                </ul>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="container">
                <div class="row">
                    <div role="tabpanel" class="tab-pane active" id="progress-auctions">
                        <div class="mazadat">

                            @php
                                $advs_exists = false;
                            @endphp

                            @foreach ($latest_auctions as $i => $item)

                                @if ($i+1 == 9)
                                    @include('front.includes.items.advrtisment')
                                    @php
                                        $advs_exists = true;
                                    @endphp
                                @endif

                                <div class="col-md-3 col-sm-6 col-xs-6">
                                @include('front.includes.items.auction' , ['item' => $item , 'type'=>'latest'])
                                </div>

                            @endforeach

                            @if ($advs_exists == false)
                                @include('front.includes.items.advrtisment',['mainbanners' =>$mainbanners])
                            @endif

                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="soon-auctions">
                        <div class="mazadat">

                            @php
                                $advs_exists = false;
                            @endphp

                            @foreach ($soon_actions as $i => $item)

                                @if ($i+1 == 9)
                                    @include('front.includes.items.advrtisment')
                                    @php
                                        $advs_exists = true;
                                    @endphp
                                @endif

                                <div class="col-md-3 col-sm-6 col-xs-6">
                                @include('front.includes.items.auction' , ['item' => $item , 'type'=>'soon'])
                                </div>

                            @endforeach

                            @if ($advs_exists == false)
                                @include('front.includes.items.advrtisment')
                            @endif

                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="closed-auctions">
                        <div class="mazadat">

                            @php
                                $advs_exists = false;
                            @endphp

                            @foreach ($closed_auctions as $i => $item)

                                @if ($i+1 == 9)
                                    @include('front.includes.items.advrtisment')
                                    @php
                                        $advs_exists = true;
                                    @endphp
                                @endif

                                <div class="col-md-3 col-sm-6 col-xs-6">
                                @include('front.includes.items.auction' , ['item' => $item , 'type'=>'closed'])
                                </div>

                            @endforeach

                            @if ($advs_exists == false)
                                @include('front.includes.items.advrtisment')
                            @endif

                        </div>
                    </div>
                </div>
                <div class="foot">
                    <a class="btn-arrow" href="{{ route('client.auctions') }}">@lang('app/all.view_more')</a>
                </div>
            </div>
        </div>

    </section>

    <script>

        $(document).ready(function () {

            $(".ok").click(function(){
                $("#successfullyBid").fadeOut(200);
            })

        });

        // Params
        var sliderSelector = '.swiper-container',
            options = {
                init: false,
                speed: 800,
                slidesPerView: 10, // or 'auto'
                slidesPerColumn: 2,
                slidesPerGroup: 3,
                spaceBetween: 15,
                grabCursor: true,
                autoplay: {
                    delay: 3000
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    1023: {
                        slidesPerView: 4,
                        spaceBetween: 0
                    }
                },
                // Events
                on: {
                    init: function () {
                        this.autoplay.stop();
                    },
                    imagesReady: function () {
                        this.autoplay.start();
                        this.el.classList.remove('loading');
                    }
                }
            };
        var mySwiper = new Swiper(sliderSelector, options);

        // Initialize slider
        mySwiper.init();
    </script>


</div>
<!-- End Content Page -->




@endsection

@section('scripts')

@endsection
