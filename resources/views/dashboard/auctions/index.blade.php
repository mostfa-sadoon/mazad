<?php
$active_links = ['auctions' , 'showauctions'];
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

        .card-body{
            padding-top: 0px !important;
            overflow-x: auto
        }
.dataTables_scrollBody{
            overflow: initial !important;
            min-height: 1000px !important;
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
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('admin/sidebar.main')}}</a>
                                </li>
                                <li class="breadcrumb-item active"> المزادات
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

                                    <h3 class="card-title">المزادات</h3>

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

                                        
                                        <form action="{{ route('admin.auctions') }}" method="get">
                                            {{--  @csrf  --}}
                                            <div class="row">
                                                
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <select class="form-control my_custom_select" name="auction_type">
                                                            <option selected disabled>@lang('app/all.auction_type')</option>
                                                            <option @if ($auction_type && $auction_type == 1) selected @endif value="1">@lang('app/all.latest_auctions')</option>
                                                            <option @if ($auction_type && $auction_type == 2) selected @endif value="2">@lang('app/all.soon_auctions')</option>
                                                            <option @if ($auction_type && $auction_type == 3) selected @endif value="3">@lang('app/all.closed_auctions')</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text"
                                                            name="search_input" value="{{ $search_input }}"
                                                            placeholder="{{__('admin/forms.search')}}">
                                                    </div>
                                                </div>
        
                                                <div class="col-sm-3" style="padding-right: 0px !important;">
                                                    <button type="submit"
                                                        class="btn btn-outline-info btn-min-width box-shadow-3 cat_search_btn">{{__('admin/forms.search')}}
                                                    </button>

                                                </div>
        
                                            </div>
                                        </form>

                                        <table
                                            class="table table-striped w-100 text-center display nowrap table-bordered  mt-2">
                                            <thead>
                                            <tr>
                                                <th>{{ __('admin/forms.name') }}</th>
                                                <th>الحاله</th>
                                                <th>الدوله</th>
                                                <th>المدينه</th>
                                                <th>القسم</th>
                                                <th>{{ __('admin/forms.image') }}</th>
                                                <th>{{ __('admin/forms.operations') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                
                                                @foreach($auctions as $auction)
                                                    <tr>
                                                        <td >{{$auction->name}}</td>
                                                        <td class="text-info">{{ getAuctionStatus($auction)[1] }}</td>
                                                        <td >{{$auction->city->country->name}}</td>
                                                        <td >{{$auction->city->name}}</td>
                                                        <td >{{$auction->category->name}}</td>
                                                        <td><img src="{{$auction->cover}}" class="img-thumbnail" style="width: 50px;"></td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic example">
    
                                                                <a href="{{ route('client.auction.show', ['slug'=> $auction->slug]) }}" class="btn btn-info box-shadow-3 mr-1 ">عرض</a>

                                                                <a href="{{ route('admin.auction.mark.get', ['id'=> $auction->id]) }}" class="btn btn-info box-shadow-3 mr-1 ">تمييز</a>

                                                                <a href="{{route('admin.auctions.delete', ['id'=> $auction -> id])}}"
                                                                   class="delete btn btn-danger box-shadow-3 mr-1 "><i class="ft-delete"></i></a>
    
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="justify-content-center d-flex">
                                        {!! $auctions->appends(Request::except('page'))->render() !!}
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

