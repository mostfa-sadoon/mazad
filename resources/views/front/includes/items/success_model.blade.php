@if(Session::has('success_model'))
	<div class="modal fade notifications-pop in" id="successfullyBid" tabindex="-1" role="dialog" aria-labelledby="successfullyBidLabel" style="display: block; padding-right: 19px;">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div class="image">
						<img src="{{ asset('assets/front/images/icons/delete-1.svg')}}" />
					</div>
					<p>{{Session::get('success_model')}}</p>
					<div class="modal-btns">
						<button type="button" class="btn btn-success ok" data-dismiss="modal">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endif