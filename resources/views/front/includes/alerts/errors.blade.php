@if(session()->has('error'))
{{-- <div class="container"> --}}
    <div class="col-md-12">
        <div class="alert alert-danger text-center alert-dismissible show" style="margin: 10px; 0px">
            <span class="text-white" style="font-weight: bold;">{{session()->get('error')}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
{{-- </div> --}}
@endif
