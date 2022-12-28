<?php
$active_links = ['quetion' , 'editquetion'];
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
                            <li class="breadcrumb-item"><a href="{{route('admin.categories')}}">{{ __('admin/sidebar.categories') }}</a>
                            </li>
                            <li class="breadcrumb-item"><a href=""> {{__('admin/forms.edit')}} </a>
                            </li>
                            <li class="breadcrumb-item active"> {{$quetion->quetion}}
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
                                {{-- <h4 class="card-title" id="basic-layout-form"> تعديل قسم رئيسي </h4> --}}
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
                                    <form class="form" action="{{route('admin.Quetion.update')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input name="id" value="{{$quetion->id}}" type="hidden">
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-home"></i> بيانات السؤال </h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-sm-10">
                                                         
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach (array_keys(config('laravellocalization.supportedLocales')) as
                                                $locale)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ __('admin/forms.'.$locale.'.quetion') }}</label>
                                                        <input type="text" name="{{ $locale }}[quetion]"
                                                            class="form-control"
                                                            value="{{ $quetion->translateOrNew($locale)->quetion }}">
                                                        @error($locale.'.quetion')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ __('admin/forms.'.$locale.'.answer') }}</label>
                                                        <textarea rows="5" type="text" name="{{ $locale }}[answer]" class="form-control">
                                                            {{ $quetion->translateOrNew($locale)->answer }}
                                                        </textarea>
                                                        @error($locale.'.desc')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
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

<script>

    console.log($('input:radio[name="type"]:checked').val());

    if($('input:radio[name="type"]:checked').val() == 1){
        $('select[name=parent_id]').val('')
    }

    $('input:radio[name="type"]').change(
        function(){
            if (this.checked && this.value == '1') {  // 1 if main cat - 2 if sub cat
                $('#cats_list').attr('class' , 'col-md-6 hidden');
                $('select[name=parent_id]').val('')

            }else{
                $('#cats_list').attr('class' , 'col-md-6');
            }
        });
</script>
@stop
