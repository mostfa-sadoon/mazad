<?php
$active_links = ['categories' , 'showcategories'];
?>

@extends('layouts.admin')

@section('style')

    <style>

        table thead{
            background-color: #E3EBF3;
        }
        
        table tr th{
            cursor: pointer;
        }
        
        div.dataTables_wrapper div.dataTables_filter label {
            display: block !important;
        }

        .dataTables_scrollHead{
            overflow: auto !important;
        }
        .dataTables_scrollBody{
            overflow: initial !important;
            max-height: 1000px !important;
        }
        .card-body{
            padding-top: 0px !important;
        }
        .dropdown .dropdown-menu .dropdown-item {
            padding: 3px 10px !important;
        }

    </style>

@endsection

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
                                <li class="breadcrumb-item"><a href="">{{$category->name}}</a>
                                </li>
                                <li class="breadcrumb-item active"> {{__('admin/forms.attributes')}} 
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">

                                    <h3 class="card-title">{{__('admin/forms.attributes')}}</h3>

                                    <a href="{{ route('admin.attributes.create', ['category_id'=> $category->id]) }}" class="btn btn-info box-shadow-3 mr-1 "><i class="ft-add"></i> اضافه</a>

                                     <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
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
                                    <div class="card-body card-dashboard">


                                        <table
                                            class="table w-100 text-center display nowrap table-bordered scroll-vertical">
                                            <thead >
                                            <tr>
                                                <th>{{ __('admin/forms.name') }}</th>
                                                <th>{{ __('admin/forms.type') }}</th>
                                                <th>{{__('admin/forms.operations')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($attributes)
                                                @foreach($attributes as $attr)
                                                    <tr>
                                                        <td>{{$attr -> name}}</td>
                                                        <td>
                                                            @if ($attr->type == 0)
                                                            اختيار من متعدد
                                                            @elseif ($attr->type == 1)
                                                            قيمه رقميه
                                                            @elseif ($attr->type == 2)
                                                            قيمه نصيه
                                                            @endif

                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic example">

                                                                @if ($attr->type == 0)
                                                                <a href="{{ route('admin.sub_attributes', ['attribute_id'=> $attr->id]) }}" class="btn btn-outline-primary box-shadow-3 mr-1 ">الصفات الفرعيه</a>
                                                                @endif
                                                                
                                                                <a href="{{ route('admin.attributes.edit', ['id'=> $attr->id , 'category_id'=> $category->id]) }}" class="btn btn-info box-shadow-3 mr-1 "><i class="ft-edit"></i></a>

                                                                <a href="{{ route('admin.attributes.delete', ['id'=> $attr->id , 'category_id'=> $category->id]) }}" class="btn btn-danger delete box-shadow-3 mr-1 "><i class="ft-delete"></i></a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset


                                            </tbody>
                                        </table>

                                        <div class="justify-content-center d-flex">
                                            {!! $attributes->appends(Request::except('page'))->render() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @stop


    @section('script')


    @stop

