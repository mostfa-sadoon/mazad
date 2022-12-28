@if ( (auth('client') && auth('client')->id() != $auction->client_id) || !auth('client') )
<label class="add-fav">
    <input type="checkbox" />
    <div class="fav-ico">
        <a href="{{ route('favourits.add', ['id'=> $auction->id]) }}">
            @if ($client_favourite)
                <img class="img-nofav" src="{{ asset('assets/front/images/icons/fav-2.svg') }}" />
            @else
                <img class="img-nofav" src="{{ asset('assets/front/images/icons/fav.svg') }}" />
            @endif
        </a>
    </div>
</label>
@endif