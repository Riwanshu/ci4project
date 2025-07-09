<!DOCTYPE HTML>
<html>

<head>
	<?= view('head') ?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<!-- 🔥 Inline CSS for Stylish Coupon Modal -->
	<style>
		.modal-content {
			border-radius: 20px;
			box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
		}

		.modal-body .list-group-item {
			border: none;
			border-radius: 10px;
			margin-bottom: 10px;
			transition: background 0.3s, transform 0.2s;
		}

		.modal-body .list-group-item:hover {
			background-color: #f0f0f0;
			transform: scale(1.02);
			cursor: pointer;
		}

		.modal-title {
			font-weight: bold;
			color: #333;
		}

		.badge {
			font-size: 0.9rem;
		}
	</style>
</head>

<body>
	<div class="colorlib-loader"></div>
	<div id="page">
		<?= view('navbar') ?>

		<!-- Breadcrumb -->
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col">
						<p class="bread"><span><a href="<?= base_url('/') ?>">Home</a></span> / <span>Shopping Cart</span></p>
					</div>
				</div>
			</div>
		</div>

		<!-- Cart Area -->
		<div class="colorlib-product">
			<div class="container">

				<?php
				$subtotal = 0;
				$totalBeforeDiscount = 0;
				$totalDiscount = 0;

				foreach ($cart as $item) {
					$price = (float)$item['price'];
					$discount = isset($item['discount']) ? (float)$item['discount'] : 0;
					$quantity = (int)$item['quantity'];

					$discountAmount = ($price * $discount) / 100;
					$discountedPrice = $price - $discountAmount;
					$itemTotal = $discountedPrice * $quantity;

					$subtotal += $itemTotal;
					$totalDiscount += $discountAmount * $quantity;
					$totalBeforeDiscount += $price * $quantity;
				}

				$delivery = ($totalBeforeDiscount > 500) ? 0 : 50;
				$couponPercent = $coupon_percent ?? 0;
				$couponDiscount = ($subtotal * $couponPercent) / 100;
				$grand_total = $subtotal + $delivery - $totalDiscount - $couponDiscount;
				?>

				<!-- Process Bar -->
				<div class="row row-pb-lg">
					<div class="col-md-10 offset-md-1">
						<div class="process-wrap">
							<div class="process text-center active">
								<p><span>01</span></p>
								<h3>Shopping Cart</h3>
							</div>
							<div class="process text-center">
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

				<!-- Cart Items -->
				<div class="row row-pb-lg">
					<div class="col-md-12">
						<div class="product-name d-flex">
							<div class="one-forth text-left px-4"><span>Product Details</span></div>
							<div class="one-eight text-center"><span>Price</span></div>
							<div class="one-eight text-center"><span>Quantity</span></div>
							<div class="one-eight text-center"><span>Total</span></div>
							<div class="one-eight text-center px-4"><span>Remove</span></div>
						</div>

						<?php foreach ($cart as $item):
							$price = (float)$item['price'];
							$quantity = (int)$item['quantity'];
							$discount = isset($item['discount']) ? (float)$item['discount'] : 0;
							$discountAmount = ($price * $discount) / 100;
							$discountedPrice = $price - $discountAmount;
							$total = $discountedPrice * $quantity;
						?>
							<div class="product-cart d-flex">
								<div class="one-forth">
									<div class="product-img" style="background-image: url('images/<?= esc($item['image']) ?>');"></div>
									<div class="display-tc">
										<h3><?= esc($item['name']) ?></h3>
									</div>
								</div>
								<div class="one-eight text-center">
									<div class="display-tc">
										<span class="price">
											<del>$<?= number_format($price, 2) ?></del><br>
											<span style="color:green;">$<?= number_format($discountedPrice, 2) ?> (<?= $discount ?>% off)</span>
										</span>
									</div>
								</div>
								<div class="one-eight text-center">
									<div class="display-tc">
										<input type="text" name="quantity" class="form-control input-number text-center" value="<?= esc($quantity) ?>" readonly>
									</div>
								</div>
								<div class="one-eight text-center">
									<div class="display-tc"><span class="price">$<?= number_format($total, 2) ?></span></div>
								</div>
								<div class="one-eight text-center">
									<div class="display-tc">
										<a href="<?= base_url('cart/remove/' . $item['id']) ?>" class="closed"></a>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Coupon Section -->
				<div class="row row-pb-lg">
					<div class="col-md-12">
						<div class="total-wrap">
							<div class="row">
								<div class="col-sm-8">
									<form action="<?= base_url('cart/apply-coupon') ?>" method="post">
										<div class="row form-group">
											<div class="col-sm-9">
												<?php $appliedCoupon = session()->getFlashdata('applied_coupon') ?? ''; ?>

												<!-- Coupon Input -->
												<input type="text" name="coupon_code" id="couponInput"
													class="form-control input-number"
													placeholder="Your Coupon Number..."
													value="<?= esc($appliedCoupon) ?>"
													data-bs-toggle="modal" data-bs-target="#couponModal" readonly>

												<!-- Modal -->
												<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content p-3">
															<div class="modal-header border-0">
																<h5 class="modal-title" id="couponModalLabel">🎁 Available Coupons</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																<div class="list-group">
																	<button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-code="SAVE10">
																		<span><strong>SAVE10</strong> — 10% off</span> <span class="badge bg-success">10%</span>
																	</button>
																	<button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-code="SAVE25">
																		<span><strong>SAVE25</strong> — 25% off</span> <span class="badge bg-warning text-dark">25%</span>
																	</button>
																	<button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-code="HALFOFF">
																		<span><strong>HALFOFF</strong> — 50% off</span> <span class="badge bg-danger">50%</span>
																	</button>
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
											<div class="col-sm-3">
												<input type="submit" value="Apply Coupon" class="btn btn-primary">
											</div>
										</div>
										<?php if (session()->getFlashdata('coupon_error')): ?>
											<div class="text-danger mt-1"><?= session()->getFlashdata('coupon_error') ?></div>
										<?php endif; ?>
									</form>
								</div>

								<!-- Order Summary -->
								<div class="col-sm-4 text-center">
									<div class="total">
										<div class="sub">
											<p><span>Subtotal:</span> <span>$<?= number_format($subtotal, 2) ?></span></p>
											<p><span>Delivery:</span>
												<span>$<?= number_format($delivery, 2) ?><?= ($delivery == 0) ? ' (Free over $500)' : '' ?></span>
											</p>
											<p><span>You Saved:</span> <span style="color:red;">- $<?= number_format($totalDiscount, 2) ?></span></p>
											<?php if ($couponDiscount > 0): ?>
												<p><span>Coupon:</span> <span style="color:red;">- $<?= number_format($couponDiscount, 2) ?></span></p>
											<?php endif; ?>
										</div>
										<div class="grand-total">
											<p><span><strong>Total:</strong></span> <span>$<?= number_format($grand_total, 2) ?></span></p>
											<form action="<?= base_url('place-order') ?>" method="post">
												<input type="hidden" name="subtotal" value="<?= $subtotal ?>">
												<input type="hidden" name="delivery" value="<?= $delivery ?>">
												<input type="hidden" name="total_discount" value="<?= $totalDiscount ?>">
												<input type="hidden" name="coupon_discount" value="<?= $couponDiscount ?>">
												<input type="hidden" name="grand_total" value="<?= $grand_total ?>">
												<button type="submit" class="btn btn-success mt-3">Proceed to Checkout</button>
											</form>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

				<?= view('footer') ?>
			</div>
		</div>
	</div>

	<!-- Got to Top -->
	<div class="gototop js-top"><a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a></div>

	<?= view('script') ?>

	<!-- ✅ Working Modal Close Script -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const modalElement = document.getElementById('couponModal');
			const couponInput = document.getElementById('couponInput');

			const couponModal = new bootstrap.Modal(modalElement);

			document.querySelectorAll('[data-code]').forEach(btn => {
				btn.addEventListener('click', function() {
					const code = this.getAttribute('data-code');
					couponInput.value = code;
					couponModal.hide(); // modal closes
				});
			});
		});
	</script>


</body>

</html>