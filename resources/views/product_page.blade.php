<!DOCTYPE html>
<html>
<head>
	<title>Product</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 </head>
<body>
	<div class="container">
		<div class="navbar-default">
			<div class="nav navbar-nav">
				<div class="navbar-brand">
					<p>Products</p>
				</div>
				
				
			</div><br><br><br>
			<spn class=" nav navbar-nav pull-right">
					<button class="btn btn-success glyphicon glyphicon-shopping-cart"><a href="/product/cart">Cart<span class="badge">{{ Session::has('cart')? Session::get('cart')->itemsQuantity :'' }}</span></a></button>
				</span>
			</div>
		</div>
	</div>
	@if (Session::has('success'))
		<div class="row">
			<div class="col-md-6">
				<div id="charge-message" class="alert alert-success">
					{{ Session::get('success') }}
					
				</div>
			</div>
		</div>
	@endif
	<div class="container">
		
		<div class="row">

			@foreach ($products as $product)
			<div class="col-md-4">
					<div class="well">
						<form method="post" action="/product/{{ $product->id }}">
						<p>{{ $product->item }}</p>

						
							{{ csrf_field() }}
							<span class="pull-right">{{ $product->price }}Naira</span>
							<input type="submit" name="" value="AddToCart" class="glyphicon glyphicon-plus btn btn-success">
						</form>
					
						<!-- bb -->
					</div>

			</div>
			@endforeach
			</div>
			<!-- End of loop -->
		
	</div>
</body>
</html>