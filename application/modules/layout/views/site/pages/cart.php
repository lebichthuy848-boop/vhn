<article>
	<section>
		<div class="box-cart">
			<div class="container">
				<?php $this->load->view('breadcrumb'); ?>
				<div class="row">
					<?php if (!$this->cart->contents()): ?>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<h2>GIỎ HÀNG</h2>
							<p>
								Giỏ hàng trống!
							</p>
						</div>
					<?php else: ?>
					<form method="post" action="<?php echo base_url('cap-nhat-gio-hang'); ?>">
						<div class="col-lg-9 col-md-9 col-sm-9">
							<h2>GIỎ HÀNG</h2>							
								<div class="block-cart-warpper">
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th class="product-name" colspan="3">Sản phẩm</th>
													<th class="product-price">Giá</th>
													<th class="product-quantity">Số lượng</th>
													<th class="product-subtotal">Tổng</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i = 0;
												$count = count($this->cart->contents());
												foreach ($this->cart->contents() as $items):
													$i++;
													?>
													<tr>
														<td><a href="<?php echo site_url('xoa-san-pham-gio-hang?rowid=' . $items['rowid']); ?>" class="remove"><i class="material-icons">highlight_off</i></a></td>
														<td class="product-thumbnail"><a href="<?php echo $items['url']; ?>"><img src="<?php echo base_url('uploads/shops/' . $items['img']); ?>" alt="" class="img-responsive"></a></td>
														<td class="product-name">
															<input type="hidden" name="rowid[]" id="rowid" value="<?php echo $items['rowid']; ?>" />
															<a href="<?php echo $items['url']; ?>"><?php echo $items['name']; ?></a>
														</td>
														<td><span><?php echo formatRice($items['price']); ?> ₫</span></td>
														<td>
															<div class="input-group">
																<span class="input-group-btn">
																	<button class="btn btn-default minus-btn" type="button">-</button>
																</span>																
																<input type="text" step="1" min="1" name="quantity[]" value="<?php echo $items['qty']; ?>" title="Qty" class="qty form-control" size="4">
																<span class="input-group-btn">
																	<button class="btn btn-default plus-btn" type="button">+</button>
																</span>
															</div>
														</td>
														<td class="product-subtotal"><span><?php echo formatRice($items['subtotal']); ?> ₫</span></td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="next-shop">
									<a href="<?php echo site_url('san-pham'); ?>" class="btn">← Tiếp tục mua hàng</a>
								</div>							
							<br>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3">
							<div class="block-totalcart">
								<h3 class="title">TỔNG GIỎ HÀNG</h3>
								<table cellspacing="0">
									<tbody>
										<tr class="cart-subtotal">
											<th>Tổng phụ</th>
											<td><span><?php echo formatRice($items['subtotal']); ?> ₫</span></td>
										</tr>
										<tr class="order-total">
											<th>Tổng</th>
											<td><strong><span><?php echo formatRice($this->cart->total()); ?> ₫</span></strong> </td>
										</tr>
									</tbody>
								</table>
								<button type="submit" class="btn btn-danger btn-block">CẬP NHẬT GIỎ HÀNG</button>
								<a href="<?php echo site_url('thanh-toan'); ?>" class="btn btn-primary btn-block">THANH TOÁN</a>
							</div>
						</div>
					</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
</article>