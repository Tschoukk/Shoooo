@extends('layouts.app')
@section('content')

<section id="form" style="margin-top:20px;"><!--form-->
	<div class="container">		
		<!-- @if(Session::has('flash_message_error'))
            <div class="alert alert-error alert-block" style="background-color:#f4d2d2">
                <button type="button" class="close" data-dismiss="alert">×</button> 
					<strong>{!! session('flash_message_error') !!}</strong>					
            </div>
		@endif -->

		<div class="alert alert-danger print-error-msg" style="display:none">

        	<ul></ul>

    	</div>

		<form>
			{{ csrf_field() }}
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Bill To</h2>
							<div class="form-group">
								<input name="billing_name" id="billing_name" @if(!empty($userDetails->name)) value="{{ $userDetails->name }}" @endif type="text" placeholder="Billing Name" class="form-control" />
							</div>
							<div class="form-group">
								<input name="billing_address" id="billing_address" @if(!empty($userDetails->address)) value="{{ $userDetails->address }}" @endif type="text" placeholder="Billing Address" class="form-control" />
							</div>
							<div class="form-group">	
								<input name="billing_city" id="billing_city" @if(!empty($userDetails->city)) value="{{ $userDetails->city }}" @endif type="text" placeholder="Billing City" class="form-control" />
							</div>
							<div class="form-group">
								<input name="billing_state" id="billing_state" @if(!empty($userDetails->state)) value="{{ $userDetails->state }}" @endif type="text" placeholder="Billing State" class="form-control" />
							</div>
							<div class="form-group">
								<select id="billing_country" name="billing_country" class="form-control">
									<option value="">Select Country</option>
									@foreach($countries as $country)
										<option value="{{ $country->name }}" @if(!empty($userDetails->country) && $country->name == $userDetails->country) selected @endif>{{ $country->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<input name="billing_pincode" id="billing_pincode" @if(!empty($userDetails->name)) value="{{ $userDetails->pincode }}" @endif type="text" placeholder="Billing Pincode" class="form-control" />
							</div>
							<div class="form-group">
								<input name="billing_mobile" id="billing_mobile" @if(!empty($userDetails->mobile)) value="{{ $userDetails->mobile }}" @endif type="text" placeholder="Billing Mobile" class="form-control" />
							</div>
							<div class="form-check">
							    <input type="checkbox" class="form-check-input" id="billing_copyAddress" name="billing_copyAddress">
							    <label class="form-check-label" for="copyAddress">Shipping Address same as Billing Address</label>
							</div>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2></h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Ship To</h2>
							<div class="form-group">
								<input name="shipping_name" id="shipping_name" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->name }}" @endif type="text" placeholder="Shipping Name" class="form-control" />
							</div>
							<div class="form-group">
								<input name="shipping_address" id="shipping_address" @if(!empty($shippingDetails->address)) value="{{ $shippingDetails->address }}" @endif type="text" placeholder="Shipping Address" class="form-control" />
							</div>
							<div class="form-group">	
								<input name="shipping_city" id="shipping_city" @if(!empty($shippingDetails->city)) value="{{ $shippingDetails->city }}" @endif type="text" placeholder="Shipping City" class="form-control" />
							</div>
							<div class="form-group">
								<input name="shipping_state" id="shipping_state" @if(!empty($shippingDetails->state)) value="{{ $shippingDetails->state }}" @endif type="text" placeholder="Shipping State" class="form-control" />
							</div>
							<div class="form-group">
								<select id="shipping_country" name="shipping_country" class="form-control">
									<option value="">Select Country</option>
									@foreach($countries as $country)
										<option value="{{ $country->name }}" @if(!empty($shippingDetails->country) && $country->name == $shippingDetails->country) selected @endif>{{ $country->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<input name="shipping_pincode" id="shipping_pincode" @if(!empty($shippingDetails->pincode)) value="{{ $shippingDetails->pincode }}" @endif type="text" placeholder="Shipping Pincode" class="form-control" />
							</div>
							<div class="form-group">
								<input name="shipping_mobile" id="shipping_mobile" @if(!empty($shippingDetails->mobile)) value="{{ $shippingDetails->mobile }}" @endif type="text" placeholder="Shipping Mobile" class="form-control" />
							</div>
							<button class="btn btn-info" data-toggle="dropdown">Check Out</button>
					</div><!--/sign up form-->
				</div>
			</div>
		</form>
	</div>
</section><!--/form-->

<script type="text/javascript">

    $(document).ready(function() {

        $(".btn-info").click(function(e){

            e.preventDefault();

            var _token = $("input[name='_token']").val();
            var billing_name = $("input[name='billing_name']").val();
			var billing_address = $("input[name='billing_address']").val();
			var billing_city = $("input[name='billing_city']").val();
			var billing_state = $("input[name='billing_state']").val();
			var billing_country = $('#billing_country option:selected').text();
			var billing_pincode = $("input[name='billing_pincode']").val();
			var billing_mobile = $("input[name='billing_mobile']").val();
			var billing_copyAddress = $("input[name='billing_mobile']").val();

			var shipping_name = $("input[name='shipping_name']").val();
			var shipping_address = $("input[name='shipping_address']").val();
			var shipping_city = $("input[name='shipping_city']").val();
			var shipping_state = $("input[name='shipping_state']").val();
			var shipping_country = $('#shipping_country option:selected').text();
			var shipping_pincode = $("input[name='shipping_pincode']").val();
			var shipping_mobile = $("input[name='shipping_mobile']").val();
    
            $.ajax({
                url: '{{ url('create-checkout') }}',
                type:'POST',
                data: {_token, billing_name, billing_address, billing_city, billing_state, billing_country, billing_pincode, billing_mobile, billing_copyAddress,
					shipping_name, shipping_address, shipping_city, shipping_state, shipping_country, shipping_pincode, shipping_mobile},
                success: function(data) {
                    if($.isEmptyObject(data.error)){                        
						window.location = '{{ url("/") }}';
                    }else{
                        printErrorMsg(data.error);
                    }
                }
            });
        }); 

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    });

</script>

@endsection