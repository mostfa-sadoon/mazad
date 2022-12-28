<?php
$active_links = ['auctions' , 'showauctions'];
?>

@extends('layouts.admin')
@section('content')

@section('style')
    <style>
        
.add-primary {padding: 50px 0px;}
.add-primary > h3 {text-align: center;}
.add-primary .primary-boxs {}
.add-primary .primary-boxs ul {width: 600px; margin: 20px auto;}
.add-primary .primary-boxs ul li {}
.add-primary .primary-boxs label {display: block;}
.add-primary .primary-boxs label input {display: none;}
.add-primary .primary-boxs .primary-box {
  display: flex;
  padding: 15px;
  border: 1px solid #eee;
  border-radius: 16px;
  margin-bottom: 15px;
  cursor: pointer;
}
.add-primary .primary-boxs .primary-box .image {width: 60px; margin: 0 15px;}
.add-primary .primary-boxs .primary-box .image img {}
.add-primary .primary-boxs .primary-box .offer {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 0 15px;
}
.add-primary .primary-boxs .primary-box .offer b {color: #0D682F; font-size: 14px;}
.add-primary .primary-boxs .primary-box .offer p {margin: 0px; font-size: 17px; font-weight: 400;}
.add-primary .primary-boxs .primary-box .box-right {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.add-primary .primary-boxs .primary-box .box-right .ico {
  height: 24px;
  width: 24px;
  line-height: 20px;
  background: #F9F9F9;
  border-radius: 50px;
  text-align: center;
  align-self: flex-end;
}
.add-primary .primary-boxs .primary-box .box-right .ico img {transform: scale(0);}
.add-primary .primary-boxs input:checked + .primary-box {border-color: #0D682F;}
.add-primary .primary-boxs input:checked + .primary-box .box-right .ico,
.add-primary .primary-boxs .primary-box:hover .box-right .ico {background: #0D682F;}
.add-primary .primary-boxs input:checked + .primary-box .box-right .ico img {transform: scale(1);}
.add-primary .primary-boxs .primary-box .box-right .price {font-size: 24px; color: #FFC759; line-height: 1;}
.add-primary .foot-btns {margin: 20px 0; text-align: center;}
.add-primary .foot-btns .btn-success {
  border: 2px solid;
  margin: 5px;
  min-width: 200px;
  font-size: 20px;
  font-weight: 600;
  color: #FFF;
  background: #0D682F;
  border-color: #0D682F;
}
    </style>
@endsection

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">{{__('admin/sidebar.main')}} </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.auctions')}}">
                                المزادات </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.auctions')}}">
                                تمييز </a>
                            </li>
                            <li class="breadcrumb-item active"> {{ $auction->name }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            @include('dashboard.includes.alerts.success')
                            @include('dashboard.includes.alerts.errors')


                            <div class="card-content collapse show">
                                <div class="card-body" style="overflow-x: auto">
                                    <form class="form" action="{{route('admin.auction.mark' , ['id'=> $auction -> id])}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-body">


                                            <h4 class="form-section"><i class="ft-home"></i> بيانات التمييز </h4>

                                            <div class="row">

                                                <div class="add-primary">
                        
                                                        <div class="primary-boxs">
                                                            <ul>
                        
                                                                @foreach ($recognitions as $i=>$item)
                                                                    <li>
                                                                        <label>
                                                                            <input type="radio" id="offer_2" value="{{ $item->id }}" name="recognition_id" class="offer_checkbox" @if($i==0) checked @endif >
                                                                            <div class="primary-box">
                                                                                <div class="image">
                                                                                    {{--  <img src="{{ asset('assets/front/images/logo.png') }}" />  --}}
                                                                                </div>
                                                                                <div class="offer">
                                                                                    <b>{{ $item->name }}</b>
                                                                                    <p>{{ $item->days }} Days</p>
                                                                                </div>
                                                                                <div class="box-right">
                                                                                    <div class="ico">
                                                                                        {{--  <img src="{{ asset('assets/front/images/icons/Icon ionic-md-checkmark.svg') }}" />  --}}
                                                                                    </div>
                                                                                    <div class="price">{{ $item->price }} DZD</div>
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                                
                                                            </ul>
                                                        </div>
                        
                                                </div>


                                            </div>


                                        </div>


                                        <div class="form-actions">
                                            <button type="button" class="btn btn-warning mr-1"
                                                onclick="history.back();">
                                                <i class="ft-x"></i> تراجع
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="la la-check-square-o"></i> تحديث
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Basic form layout section end -->
        </div>
    </div>
</div>

@stop

@section('script')

@stop