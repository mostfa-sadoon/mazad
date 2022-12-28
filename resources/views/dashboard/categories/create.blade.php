<?php
$active_links = ['categories' , 'addcategories'];
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
                                    <form class="form" action="{{route('admin.categories.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-body">


                                            <h4 class="form-section"><i class="ft-home"></i> بيانات القسم </h4>

                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cover"> {{ __('admin/forms.cover') }} </label>
                                                        <input type="file" id="cover" class="form-control" name="cover">
                                                        @error("cover")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="row">

                                                @foreach (array_keys(config('laravellocalization.supportedLocales')) as
                                                $locale)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="{{ $locale . '.name' }}">{{
                                                            __('admin/forms.'.$locale.'.name') }}</label>
                                                        <input type="text" name="{{ $locale }}[name]"
                                                            id="{{ $locale . '.name' }}" class="form-control"
                                                            value="{{ old($locale . '.name') }}">
                                                        @error($locale.'.name')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                @endforeach

                                            </div>


                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group mt-1">
                                                        <input type="radio" name="type" value="1" class="switchery"
                                                               data-color="success" />
                                                        <label class="card-title ml-1">
                                                            قسم رئيسي
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group mt-1">
                                                        <input type="radio" name="type" checked value="2" class="switchery" data-color="success" />
                                                        <label class="card-title ml-1">
                                                            قسم فرعي
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-md-6 " id="cats_list">
                                                    <div class="form-group">
                                                        <label> اختر قسم</label>
                                                        <select name="parent_id" class="select2 form-control">
                                                            <option disabled selected >من فضلك أختر قيمه</option>
                                                                @if($categories && $categories -> count() > 0)
                                                                @foreach($categories as $category)
                                                                <option value="{{$category->id }}">{{$category->name}}
                                                                </option>
                                                                @endforeach
                                                                @endif
                                                            </optgroup>
                                                        </select>
                                                        @error('parent_id')
                                                        <span class="text-danger"> {{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

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