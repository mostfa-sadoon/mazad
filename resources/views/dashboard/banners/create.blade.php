<?php
$active_links = ['banners' , 'addbanners'];
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
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية</a>
                            </li>
                            <li class="breadcrumb-item active"> {{__('admin/sidebar.add_cat')}}
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

                            {{-- @if ($errors->any())
                            @foreach ($errors->all() as $error)
                            <div class="container">
                                <div class="alert alert-danger">
                                    <p class="text-white">{{ $error }}</p>
                                </div>
                            </div>
                            @endforeach
                            @endif --}}

                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form class="form" action="{{route('admin.banners.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-home"></i> بيانات القسم </h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label >{{__('admin/forms.type')}}</label>
                                                         <select name="type" class="form-control">
                                                           <option value="main">{{__('app/all.main')}}</option>
                                                           <option value="sidebar">{{__('app/all.sidebar')}}</option>
                                                           <option value="header_Auctions">{{__('app/all.header_Auctions_banner')}}</option>
                                                           <option value="footer_Auctions">{{__('app/all.footer_Auctions')}}</option>
                                                         </select>
                                                        @error(Config::get('app.locale').'.type')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label >{{__('admin/forms.'.Config::get('app.locale').'.url')}}</label>
                                                        <input type="text" name="url" class="form-control" required>
                                                        @error(Config::get('app.locale').'.url')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                @foreach (array_keys(config('laravellocalization.supportedLocales')) as
                                                $locale)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="{{ $locale .'img'}}">{{__('admin/forms.'.$locale.'.img')}}</label>
                                                        <input type="file" name="{{ $locale }}[img]"
                                                            id="{{ $locale . '.img' }}" class="form-control"
                                                            value="{{ old($locale . '.img') }}">
                                                        @error($locale.'.img')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                @endforeach

                                            </div>




                                        </div>

                                        {{-- <textarea name="about_ar" id="" class="form-control ckeditor" cols="30"
                                            rows="10"></textarea> --}}
                                        <div class="form-actions">
                                            <button type="button" class="btn btn-warning mr-1"
                                                onclick="history.back();">
                                                <i class="ft-x"></i> تراجع
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="la la-check-square-o"></i>  {{ __('admin/forms.add') }}
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

<script src="//cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>

<script>
    //ckeditor direction
    CKEDITOR.config.language = "{{ app()->getLocale() }}"

    $('input:radio[name="type"]').change(
        function(){
            if (this.checked && this.value == '1') {  // 1 if main cat - 2 if sub cat
                $('#cats_list').attr('class' , 'col-md-6 hidden');

            }else{
                $('#cats_list').attr('class' , 'col-md-6');
            }
        });

</script>

@stop
