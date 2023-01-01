
                                <a href="{{ route('client.auction.show', ['slug'=>$item->slug]) }}" class="mazad-box @if ( ($item->recognition_id != 0) ) mazad-special @endif">

                                    <div class="image">
                                        <div class="img">
                                            <img style="width: 100%;height: 211px;" src="{{ $item->cover }}" />

                                            {{--  @if ( (auth('client') && auth('client')->id() != $item->client_id) || !auth('client') )
                                            <label class="add-fav">
                                                <input type="checkbox" />
                                                <div class="fav-ico">
                                                    <img class="img-nofav" src="{{ asset('assets/front/images/icons/fav.svg') }}" />
                                                    <img class="img-fav" src="{{ asset('assets/front/images/icons/fav-2.svg') }}" />
                                                </div>
                                            </label>
                                            @endif  --}}
                                            @if ($type == 'favorite')
                                            <label class="add-fav">
                                                <input type="checkbox" />
                                                <div class="fav-ico">
                                                    <img class="img-nofav fav-img" data-id={{$item->id}} src="{{ asset('assets/front/images/icons/fav-2.svg') }}" />
                                                </div>
                                            </label>
                                            <script>
                                                $(document).ready(function(){

                                                    $('.fav-img').on('click', function () {
                                                        console.log($(this).data('id'))
                                                            $.ajax({
                                                                url: "{{ route('favourits.add' , ['id'=> $item->id]) }}",
                                                                method: "get",
                                                                success: function (result) {
                                                                    window.location.reload();
                                                                    //console.log(result)
                                                                }

                                                            })
                                                    });



                                                });
                                            </script>
                                            @endif

                                        </div>

                                        @if ($type == 'closed')
                                            <div class="countdown">
                                                <div id="time-id-001">Closed</div>
                                            </div>
                                            <div class="sold">{{ getAuctionStatus($item)[1] }}</div>
                                        @else
                                            @if (getAuctionStatus($item)[0] != 4)
                                                <div class="countdown">
                                                    <div id="{{ $type }}-time-id-{{ $item->id }}"></div>
                                                </div>
                                            @else
                                                <div class="countdown">
                                                    <div id="time-id-001">@lang('app/all.start_in') {{ $item->start_date }}</div>
                                                </div>
                                            @endif
                                            <div class="sold">{{ getAuctionStatus($item)[1] }}</div>
                                        @endif

                                    </div>
                                    <div class="content">
                                        <div class="d-flex flex-center justify-content-between">
                                            <h2 class="name">{{ $item->name }}</h2>
                                            <span class="date">{{ $item->end_date }} {{ $item->end_time }}</span>
                                        </div>
                                        <p class="location"><img src="{{ asset('assets/front/images/icons/location.svg') }}" /> {{ $item->city->name }}, {{ $item->city->country->name }}</p>
                                        <p class="description">{{ $item-> description}}</p>
                                        <div class="d-flex flex-center justify-content-between">
                                            <p class="price">
                                                @if ($item->bidings && count($item->bidings) != 0)
                                                {{ number_format($item->bidings()->max('value')) }}
                                                @else
                                                {{ number_format($item->min_price) }}
                                                @endif
                                                <span class="currency">{{ $item->country->currency }}</span></p>
                                            <span class="bids">{{ count($item->bidings) }} @lang('app/all.Bids')</span>
                                        </div>
                                    </div>
                                </a>
                                <script>
                                    // Set the date we're counting down to
                                    function countDown(){
                                        let countDownDate = new Date("{{ $item->end_date }} {{ $item->end_time }}").getTime();

                                    // Update the count down every 1 second
                                    let x = setInterval(function () {

                                        // Get today's date and time
                                        let now = new Date().getTime();

                                        // Find the distance between now and the count down date
                                        let distance = countDownDate - now;

                                        // Time calculations for days, hours, minutes and seconds
                                        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                        // Output the result in an element with id="demo"
                                        document.getElementById("{{ $type }}-time-id-{{ $item->id }}").innerHTML = "<span><p>" + days + "</p><b>@lang('app/all.Days')</b></span> : <span><p>" + hours + "</p><b>@lang('app/all.h')</b></span> : <span><p>" + minutes + "</p><b>@lang('app/all.m')</b></span> : <span><p>" + seconds + "</p><b>@lang('app/all.s')</b></span>";

                                        // If the count down is over, write some text
                                        if (distance < 0) {
                                            clearInterval(x);
                                            document.getElementById("{{ $type }}-time-id-{{ $item->id }}").innerHTML = "Closed";
                                        }
                                    }, 1000);
                                    }
                                    countDown()
                                </script>
