
	<section class="top-page-links">
		<div class="container">
			<div class="top-links">
				<ul>
					<li><a @if ($page == 'profile') style="color: #FFC759;" @endif href="{{ route('client.profile') }}">@lang('app/all.my_info')</a></li>
					<li><a @if ($page == 'my_auctions') style="color: #FFC759;" @endif href="{{ route('client.my_auctions') }}">@lang('app/all.my_auctions')</a></li>
					<li><a @if ($page == 'my_bids') style="color: #FFC759;" @endif href="{{ route('client.my_bids') }}">@lang('app/all.my_bids')</a></li>
				</ul>
			</div>
		</div>
	</section>