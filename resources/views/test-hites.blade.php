<form method="post" action="{{ url('/') }}/pay">
	<input type="hidden" name="amount" value="1000">
	<input type="hidden" name="currency" value="USD">
	<input type="hidden" name="customer_email" value="hanan03328367366@gmail.com">
	<input type="hidden" name="order_id" value="xx">
	<input type="hidden" name="merchant" value="bp2igV9ORor9U1BgJVD8xWwF0omKvNQezSIIhpn5">
	<input type="submit" class="btn btn-info btn-lg" value="{{__('data.PWQ')}}">
</form>