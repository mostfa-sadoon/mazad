<?php
$active_links = ['banners' , ''];
?>

@extends('layouts.admin')
@section('content')

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">{{__('admin/sidebar.main')}} </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.slider')}}">
                                 الاسلايدر </a>
                            </li>
                            {{-- <li class="breadcrumb-item active"> {{ $slider->name }} --}}
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
                                <div class="card-body">
                                    <form class="form" action="{{route('admin.banners.update' , ['id'=> $banner -> id])}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="type" value="{{$banner->type}}">
                                        <div class="form-body">


                                            <h4 class="form-section"><i class="ft-home"></i> بيانات البانر </h4>



                                            {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label >{{__('admin/forms.type')}}</label>
                                                     <select name="type" class="form-control">
                                                       <option value="main" @if($banner->type=='main') selected @endif>{{__('app/all.main')}}</option>
                                                       <option value="sidebar" @if($banner->type=='sidebar') selected @endif>{{__('app/all.sidebar')}}</option>
                                                       <option value="header_Auctions" @if($banner->type=='header_Auctions') selected @endif>{{__('app/all.header_Auctions')}}</option>
                                                       <option value="footer_Auctions" @if($banner->type=='footer_Auctions') selected @endif>{{__('app/all.footer_Auctions')}}</option>
                                                     </select>
                                                    @error(Config::get('app.locale').'.type')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div> --}}

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label >{{__('admin/forms.'.Config::get('app.locale').'.url')}}</label>
                                                        <input type="text" name="url" class="form-control" value="{{$banner->url}}">
                                                        @error(Config::get('app.locale').'.url')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                @foreach (array_keys(config('laravellocalization.supportedLocales')) as
                                                $locale)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ __('admin/forms.'.$locale.'.img') }}</label>
                                                        <input type="file" id="img" class="form-control" name="{{$locale}}[img]">
                                                        @error($locale.'.img')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <img src="{{ asset('assets/images/banner/'.$locale .'/'. $banner->translateOrNew($locale)->img)}}" class="img-thumbnail" style="margin-top: 2.3rem !important;width: 50px;">
                                                    </div>
                                                </div>
                                                @endforeach
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
