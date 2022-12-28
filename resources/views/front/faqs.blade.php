@extends('layouts.site')
@section('title')
@lang('app/all.faq')
@endsection
@section('content')





		<!-- Start Content Page -->
		<div id="content" class="page-content">
			{{--  <nav class="breadcrumb-sec" aria-label="breadcrumb">
				<div class="container">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">FAQ</li>
				  </ol>
				</div>
			</nav>  --}}
			<div class="container">
				<div class="row faqs_page">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="faqs_head">
							<h2 class="title_sec">@lang('app/all.faq')</h2>
							<div class="image">
								<img src="/assets/images/logo/FAQs-amico.svg" />
							</div>
						</div>



					<div id="faq" role="tablist" aria-multiselectable="true">

                        @if ($quetions)
                             @foreach ($quetions as $quetion)
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="question1">
                                        <h5 class="panel-title " data-toggle="collapse" data-parent="#faq" href="#answer1" aria-expanded="true" aria-controls="answer1">{{$quetion->quetion}} <span class="ico"></span></h5>
                                    </div>
                                    <div id="answer1" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" aria-labelledby="question1">
                                        <div class="panel-body">
                                            <p>{{$quetion->answer}}</p>
                                        </div>
                                    </div>
                                </div>
                             @endforeach
                        @endif
					</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Content Page -->







@endsection

@section('s
cripts')

@endsection
