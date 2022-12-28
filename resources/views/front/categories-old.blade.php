@extends('layouts.site')

@section('title')
auctions
@endsection

@section('styles')
@endsection

@section('content')

<div id="content" class="page-content">

    <nav class="breadcrumb-sec" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">categories</li>
            </ol>
        </div>
    </nav>

    @isset($categories)
    <div class="container" style="padding: 40px 0px;">
        <div class="row">
            @foreach ($categories as $category)

            <div class="col-md-3">
                <div style="background-color: #EEFFF4;margin-bottom: 20px !important;padding: 10px 20px;">

                    <ul class="list-unstyled">

                        <li>
                            <img src="{{ $category->image }}" alt="{{$category->name}}-image" style="width: 30px;height: 30px;"> {{$category->name}}
                            
                            @isset($category->childrens)
                            <span class="show-sub fa-active-sub"></span>
                            <ul>
                                @foreach ($category->childrens as $children)
                                <li class="item" style="margin-top: 10px;padding-left: 30px">
                                    <a href="{{ route('auction.create', ['category_id'=>$children->id]) }}"><img src="{{ $children->image }}" alt="{{$children->name}}-image" style="width: 30px;height: 30px;border-radius: 50% 50%;"> {{ $children->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                            @endisset
                        </li>

                    </ul>

                </div>
            </div>

            @endforeach
        </div>
    </div>
    @endisset


</div>








@endsection

@section('scripts')

@endsection