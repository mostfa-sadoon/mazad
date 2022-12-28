@if(Session::has('success'))
    {{-- <div class="container"> --}}
        <div class="col-md-12">
                <div class="alert alert-success text-center alert-dismissible show" role="alert" style="margin: 10px; 0px">
                    <span class="text-white" style="font-weight: bold;">{{Session::get('success')}}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
    {{-- </div> --}}
@endif
