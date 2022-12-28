<?php
$active_links = ['users' , 'showusers'];
?>
@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    {{-- <h3 class="content-header-title"> العملاء </h3> --}}
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('admin/sidebar.main') }}</a>
                                </li>
                                <li class="breadcrumb-item active"> {{ __('admin/sidebar.clients') }}
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
                                    <div class="card-body card-dashboard" style="overflow-x: auto;">


                                        <form action="{{ route('dashboard.users.index') }}" method="get">
                                            @csrf
                                            <div class="row">
                                                
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text"
                                                            name="search"
                                                            placeholder="بحث">
                                                    </div>
                                                </div>
        
                                                <div class="col-sm-3" style="padding-right: 0px !important;">
                                                    <button type="submit"
                                                        class="btn btn-outline-info btn-min-width box-shadow-3 cat_search_btn">{{__('admin/forms.search')}}
                                                    </button>
                                                    
                                                </div>
        
                                            </div>
                                            <br>
                                        </form>


                                        <table
                                            class="table w-100 text-center display nowrap table-striped table-bordered ">
                                            <thead class="">
                                            <tr>
                                                <th>{{ __('admin/forms.cover') }}</th>
                                                <th>{{ __('admin/forms.name') }}</th>
                                                <th>{{ __('admin/forms.phone') }}</th>
                                                <th>{{ __('admin/forms.email') }}</th>
                                                <th>{{ __('admin/forms.country') }}</th>
                                                <th>{{ __('admin/forms.is_active') }}</th>
                                                {{--  <th>{{ __('admin/forms.operations') }}</th>  --}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                    <tr>
                                                        <td><img src="{{$user->photo}}" class="img-thumbnail" style="width: 50px;"></td>
                                                        <td>{{$user->f_name}} {{$user->l_name}}</td>
                                                        <td>({{$user->country_code}}) {{$user->phone}}</td>
                                                        <td>{{$user->email}}</td>
                                                        <td>{{$user->country->name}}</td>
                                                        <td><a href="{{ route('dashboard.users.change_active', ['id'=>$user->id]) }}">{{ getActiveName($user->is_active) }}</a></td>
                                                        {{--  <td><a href="{{route('admin.send-notification-to-user-page', [ 'id'=> $user->id ])}}"
                                                            class="btn btn-outline-primary box-shadow-3 mr-1 ">{{ __('admin/forms.sent_noty') }}</a></td>  --}}
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                        </table>
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
