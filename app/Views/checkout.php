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
						<p class="bread"><span><a href="index.html">Home</a></span> / <span>Checkout</span></p>
					</div>
				</div>
			</div>
		</div>


		<div class="colorlib-product">
			<div class="container">
				<div class="row row-pb-lg">
					<div class="col-sm-10 offset-md-1">
						<div class="process-wrap">
							<div class="process text-center active">
								<p><span>01</span></p>
								<h3>Shopping Cart</h3>
							</div>
							<div class="process text-center active">
								<p><span>02</span></p>
								<h3>Checkout</h3>
							</div>
							<div class="process text-center">
								<p><span>03</span></p>
								<h3>Order Complete</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8">
						<form method="post" action="<?= base_url('checkout') ?>" class="colorlib-form">
							<h2>Billing Details</h2>
							<div class="row">
								<!-- Country Dropdown -->
								<div class="col-md-12">
									<div class="form-group">
										<label for="country">Select Country</label>
										<div class="form-field">
											<i class="icon icon-arrow-down3"></i>
											<select name="country" id="people" class="form-control">
												<option value="#">Select country</option>
												<option value="Alaska" <?= ($checkout['country'] ?? '') == 'Alaska' ? 'selected' : '' ?>>Alaska</option>
												<option value="China" <?= ($checkout['country'] ?? '') == 'China' ? 'selected' : '' ?>>China</option>
												<option value="Japan" <?= ($checkout['country'] ?? '') == 'Japan' ? 'selected' : '' ?>>Japan</option>
												<option value="Korea" <?= ($checkout['country'] ?? '') == 'Korea' ? 'selected' : '' ?>>Korea</option>
												<option value="Philippines" <?= ($checkout['country'] ?? '') == 'Philippines' ? 'selected' : '' ?>>Philippines</option>
											</select>
										</div>
									</div>
								</div>

								<!-- First Name -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="fname">First Name</label>
										<input type="text" name="first_name" value="<?= $checkout['first_name'] ?? '' ?>" id="fname" class="form-control" placeholder="Your firstname">
									</div>
								</div>

								<!-- Last Name -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="lname">Last Name</label>
										<input type="text" name="last_name" value="<?= $checkout['last_name'] ?? '' ?>" id="lname" class="form-control" placeholder="Your lastname">
									</div>
								</div>

								<!-- Company Name -->
								<div class="col-md-12">
									<div class="form-group">
										<label for="companyname">Company Name</label>
										<input type="text" name="company_name" value="<?= $checkout['company_name'] ?? '' ?>" id="companyname" class="form-control" placeholder="Company Name">
									</div>
								</div>

								<!-- Address -->
								<div class="col-md-12">
									<div class="form-group">
										<label for="address">Address</label>
										<input type="text" name="address_line1" value="<?= $checkout['address_line1'] ?? '' ?>" id="address" class="form-control" placeholder="Enter Your Address">
									</div>
									<div class="form-group">
										<input type="text" name="address_line2" value="<?= $checkout['address_line2'] ?? '' ?>" id="address2" class="form-control" placeholder="Second Address">
									</div>
								</div>

								<!-- City -->
								<div class="col-md-12">
									<div class="form-group">
										<label for="towncity">Town/City</label>
										<input type="text" name="city" value="<?= $checkout['city'] ?? '' ?>" id="towncity" class="form-control" placeholder="Town or City">
									</div>
								</div>

								<!-- State -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="stateprovince">State/Province</label>
										<input type="text" name="state" value="<?= $checkout['state'] ?? '' ?>" id="stateprovince" class="form-control" placeholder="State Province">
									</div>
								</div>

								<!-- Zip -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="zippostalcode">Zip/Postal Code</label>
										<input type="text" name="zip_code" value="<?= $checkout['zip_code'] ?? '' ?>" id="zippostalcode" class="form-control" placeholder="Zip / Postal">
									</div>
								</div>

								<!-- Email -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="email">E-mail Address</label>
										<input type="text" name="email" value="<?= $checkout['email'] ?? '' ?>" id="email" class="form-control" placeholder="Email">
									</div>
								</div>

								<!-- Phone -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="phone">Phone Number</label>
										<input type="text" name="phone" value="<?= $checkout['phone'] ?? '' ?>" id="phone" class="form-control" placeholder="">
									</div>
								</div>

								<!-- Optional Radios -->
								<div class="col-md-12">
									<div class="form-group">
										<div class="radio">
											<label><input type="radio" name="optradio"> Create an Account? </label>
											<label><input type="radio" name="optradio"> Ship to different address</label>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>

					<div class="col-lg-4">
						<div class="row">
							<div class="col-md-12">
								<div class="cart-detail">
									<h2>Cart Total</h2>
									<ul>
										<?php foreach ($cart as $item): ?>
											<?php
											$price = (float)$item['price'];
											$qty = (int)$item['quantity'];
											$discount = isset($item['discount']) ? (float)$item['discount'] : 0;
											$discountAmount = ($price * $discount) / 100;
											$discountedPrice = $price - $discountAmount;
											$total = $discountedPrice * $qty;
											?>
											<li><span><?= $qty ?> x <?= esc($item['name']) ?></span> <span>$<?= number_format($total, 2) ?></span></li>
										<?php endforeach; ?>
										<li><span>Subtotal</span> <span>$<?= number_format($subtotal, 2) ?></span></li>
										<li><span>Shipping</span> <span>$<?= number_format($delivery, 2) ?></span></li>
										<li><span>You Saved</span> <span style="color:red;">- $<?= number_format($total_discount, 2) ?></span></li>
										<?php if ($coupon_discount > 0): ?>
											<li><span>Coupon</span> <span style="color:red;">- $<?= number_format($coupon_discount, 2) ?></span></li>
										<?php endif; ?>
										<li><strong>Order Total</strong> <strong>$<?= number_format($grand_total, 2) ?></strong></li>
									</ul>
								</div>
							</div>

							<div class="w-100"></div>

							<div class="col-md-12">
								<div class="cart-detail">
									<h2>Payment Method</h2>
									<div class="form-group">
										<div class="col-md-12">
											<div class="radio">
												<label><input type="radio" name="payment_method" value="bank" required> Direct Bank Transfer</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="radio">
												<label><input type="radio" name="payment_method" value="check"> Check Payment</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="radio">
												<label><input type="radio" name="payment_method" value="paypal"> Paypal</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="checkbox">
												<label><input type="checkbox" name="terms" required> I have read and accept the terms and conditions</label>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<p><a href="#" class="btn btn-primary">Place an order</a></p>
							</div>
						</div>
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