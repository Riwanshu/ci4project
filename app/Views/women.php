<!DOCTYPE HTML>
<html>
<?= view('head') ?>

<body>

	<div class="colorlib-loader"></div>

	<div id="page">
		<?= view('navbar') ?>

		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col">
						<p class="bread"><span><a href="index.html">Home</a></span> / <span>Women</span></p>
					</div>
				</div>
			</div>
		</div>

		<div class="breadcrumbs-two">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="breadcrumbs-img" style="background-image: url(images/cover-img-1.jpg);">
							<h2>Women's</h2>
						</div>
						<div class="menu text-center">
							<p><a href="#">New Arrivals</a> <a href="#">Best Sellers</a> <a href="#">Extended Widths</a> <a href="#">Sale</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="colorlib-featured">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 text-center">
						<div class="featured">
							<div class="featured-img featured-img-2" style="background-image: url(images/img_bg_2.jpg);">
								<h2>Casuals</h2>
								<p><a href="#" class="btn btn-primary btn-lg">Shop now</a></p>
							</div>
						</div>
					</div>
					<div class="col-sm-4 text-center">
						<div class="featured">
							<div class="featured-img featured-img-2" style="background-image: url(images/women.jpg);">
								<h2>Dress</h2>
								<p><a href="#" class="btn btn-primary btn-lg">Shop now</a></p>
							</div>
						</div>
					</div>
					<div class="col-sm-4 text-center">
						<div class="featured">
							<div class="featured-img featured-img-2" style="background-image: url(images/item-11.jpg);">
								<h2>Sports</h2>
								<p><a href="#" class="btn btn-primary btn-lg">Shop now</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="colorlib-product">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-xl-3">
						<div class="row">
							<div class="col-sm-12">
								<div class="side border mb-1">
									<h3>Brand</h3>
									<ul>
										<li><a href="#">Nike</a></li>
										<li><a href="#">Adidas</a></li>
										<li><a href="#">Merrel</a></li>
										<li><a href="#">Gucci</a></li>
										<li><a href="#">Skechers</a></li>
									</ul>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="side border mb-1">
									<h3>Size/Width</h3>
									<div class="block-26 mb-2">
										<h4>Size</h4>
										<ul>
											<li><a href="#">7</a></li>
											<li><a href="#">7.5</a></li>
											<li><a href="#">8</a></li>
											<li><a href="#">8.5</a></li>
											<li><a href="#">9</a></li>
											<li><a href="#">9.5</a></li>
											<li><a href="#">10</a></li>
											<li><a href="#">10.5</a></li>
											<li><a href="#">11</a></li>
											<li><a href="#">11.5</a></li>
											<li><a href="#">12</a></li>
											<li><a href="#">12.5</a></li>
											<li><a href="#">13</a></li>
											<li><a href="#">13.5</a></li>
											<li><a href="#">14</a></li>
										</ul>
									</div>
									<div class="block-26">
										<h4>Width</h4>
										<ul>
											<li><a href="#">M</a></li>
											<li><a href="#">W</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="side border mb-1">
									<h3>Style</h3>
									<ul>
										<li><a href="#">Slip Ons</a></li>
										<li><a href="#">Boots</a></li>
										<li><a href="#">Sandals</a></li>
										<li><a href="#">Lace Ups</a></li>
										<li><a href="#">Oxfords</a></li>
									</ul>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="side border mb-1">
									<h3>Colors</h3>
									<ul>
										<li><a href="#">Black</a></li>
										<li><a href="#">White</a></li>
										<li><a href="#">Blue</a></li>
										<li><a href="#">Red</a></li>
										<li><a href="#">Green</a></li>
										<li><a href="#">Grey</a></li>
										<li><a href="#">Orange</a></li>
										<li><a href="#">Cream</a></li>
										<li><a href="#">Brown</a></li>
									</ul>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="side border mb-1">
									<h3>Material</h3>
									<ul>
										<li><a href="#">Leather</a></li>
										<li><a href="#">Suede</a></li>
									</ul>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="side border mb-1">
									<h3>Technologies</h3>
									<ul>
										<li><a href="#">BioBevel</a></li>
										<li><a href="#">Groove</a></li>
										<li><a href="#">FlexBevel</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-9 col-xl-9">
						<div class="row row-pb-md">
							<?php foreach ($womenproducts as $product): ?>
								<div class="col-md-3 col-lg-3 mb-4 text-center">
									<div class="product-entry border">
										<a href="#" class="prod-img">
											<img src="<?= base_url('images/' . $product['image']) ?>" class="img-fluid" alt="<?= ($product['name']) ?>">
										</a>
										<div class="desc">
											<h2><a href="#"><?= esc($product['name']) ?></a></h2>
											<span class="price">$<?= esc($product['price']) ?></span>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>

						<div class="row">
							<div class="col-md-12 text-center">
								<div class="block-27">
									<ul>
										<li><a href="#"><i class="ion-ios-arrow-back"></i></a></li>
										<li class="active"><span>1</span></li>
										<li><a href="#">2</a></li>
										<li><a href="#">3</a></li>
										<li><a href="#">4</a></li>
										<li><a href="#">5</a></li>
										<li><a href="#"><i class="ion-ios-arrow-forward"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="colorlib-partner">
			<div class="container">
				<div class="row">
					<div class="col-sm-8 offset-sm-2 text-center colorlib-heading colorlib-heading-sm">
						<h2>Trusted Partners</h2>
					</div>
				</div>
				<div class="row">
					<div class="col partner-col text-center">
						<img src="images/brand-1.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
					</div>
					<div class="col partner-col text-center">
						<img src="images/brand-2.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
					</div>
					<div class="col partner-col text-center">
						<img src="images/brand-3.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
					</div>
					<div class="col partner-col text-center">
						<img src="images/brand-4.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
					</div>
					<div class="col partner-col text-center">
						<img src="images/brand-5.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
					</div>
				</div>
			</div>
		</div>

		<?= view('footer') ?>

	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a>
	</div>

	<?= view('script') ?>

</body>

</html>