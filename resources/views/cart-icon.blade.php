@section('cart')
<div class="dropdown">    
    <button type="button" onclick="window.location='{{ url("cart") }}'" class="btn btn-info" data-toggle="dropdown">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
    </button>    
</div>
@endsection