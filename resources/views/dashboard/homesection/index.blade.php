<?php
$active_links = ['homesections' , 'showhomesections'];
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
                                <li class="breadcrumb-item active"> {{__('admin/sidebar.home_section')}}
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

                                    <h3 class="card-title">{{__('admin/sidebar.home_section')}}</h3>

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
                                                <th>{{__('admin/forms.'.Config::get('app.locale').'.description')}} </th>
                                                <th> {{__('admin/forms.cover')}} </th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @isset($homesections)
                                                @foreach($homesections as $homesection)
                                                    <tr class="">
                                                        <td>{{$homesection->name}}</td>
                                                        <td>{{$homesection->desc}}</td>
                                                        <td><img src="{{$homesection->logo}}" class="img-thumbnail" style="width: 50px;"></td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                                {{--  @if ($category->parent_id != null)    --}}
                                                                {{--  @endif  --}}
                                                                <a href="{{ route('admin.HomeSection.edit', ['id'=> $homesection->id]) }}" class="btn btn-info box-shadow-3 mr-1 "><i class="ft-edit"></i></a>
                                                                <a href="{{ route('admin.HomeSection.delete',$homesection->id) }}" class="btn btn-danger delete box-shadow-3 mr-1 "><i class="ft-delete"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                            </tbody>
                                        </table>
                                        <div class="float-right mr-1">
                                            {{-- <div>{!! $homesections -> links() !!}</div> --}}
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
