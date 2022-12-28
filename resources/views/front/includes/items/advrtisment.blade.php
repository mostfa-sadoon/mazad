
            <div class="col-md-12 col-xs-12">
                <div class="banner">
                    @foreach($mainbanners as $banner)
                    <a href="{{ $banner->url }}"><img src="{{ asset('assets/images/banner/'.Config::get('app.locale') .'/'. $banner->img)}}" /></a>
                    @endforeach
                </div>
            </div>
