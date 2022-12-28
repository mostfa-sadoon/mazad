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
                                <li class="breadcrumb-item active"> {{__('admin/sidebar.categories')}}
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

                                    <h3 class="card-title">{{__('admin/sidebar.categories')}}</h3>

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
                                                <th>الاسم </th>
                                                @if($maincategory==false)
                                                  <th>القسم الرئيسي </th>
                                                @endif
                                                <th> {{__('admin/forms.cover')}} </th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($categories)
                                                @foreach($categories as $category)
                                                    <tr class="@if ($category->parent_id == null)  text-primary  @endif">
                                                        <td>{{$category -> name}}</td>
                                                            @if($maincategory==false)
                                                            <td>{{$category -> _parent -> name  ?? '--' }}</td>
                                                            @endif
                                                        <td><img src="{{$category->image}}" class="img-thumbnail" style="width: 50px;"></td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic example">

                                                                {{--  @if ($category->parent_id != null)    --}}
                                                                    <a href="{{ route('admin.attributes', ['category_id'=> $category->id]) }}" class="btn btn-outline-primary box-shadow-3 mr-1 ">{{ __('app/all.main_page')}}</a>
                                                                {{--  @endif  --}}
                                                                 @if ($category->parent_id == null)
                                                                 <a href="{{ route('admin.subcategories', ['category_id'=> $category->id]) }}" class="btn btn-outline-primary box-shadow-3 mr-1 ">{{ __('app/all.sub_categories')}}</a>

                                                                 @endif
                                                                <a href="{{ route('admin.categories.edit', ['id'=> $category->id]) }}" class="btn btn-info box-shadow-3 mr-1 "><i class="ft-edit"></i></a>
                                                                <a href="{{ route('admin.categories.delete', ['id'=> $category->id]) }}" class="btn btn-danger delete box-shadow-3 mr-1 "><i class="ft-delete"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset


                                            </tbody>
                                        </table>
                                        <div class="float-right mr-1">
                                            <div>{!! $categories -> links() !!}</div>
                                        </div>

                                        <div class="justify-content-center d-flex">

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
