<article>
	<section>
		<div class="box-checkout">
			<div class="container">
				<h2>THANH TOÁN</h2>
				<form action="<?php echo base_url('ket-qua-thanh-toan'); ?>" method="post">
					<div class="row row-20px">
						<div class="col-lg-7 col-md-8 col-sm-8 col-20px border-right-line">
							<div class="checkout-warpper">
								<h3 class="title">THANH TOÁN VÀ GIAO HÀNG</h3>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="form-group">
											<label for="">Họ và tên <abbr class="required" title="Bắt buộc">*</abbr></label>
											<input type="text" class="form-control" id="" placeholder="" name="full_name" size="35">
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="col-lg-6 col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Địa chỉ email <abbr class="required" title="Bắt buộc">*</abbr></label>
											<input type="email" name="email" size="35" required class="form-control">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Số điện thoại <abbr class="required" title="Bắt buộc">*</abbr></label>
											<input type="text" class="form-control" id="" name="phone" size="35" required placeholder="">
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="form-group">
											<label for="">Địa chỉ <abbr class="required" title="Bắt buộc">*</abbr></label>
											<input type="text" class="form-control" id="" name="address" size="35" placeholder="Địa chỉ">
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
								<h3 class="title">THÔNG TIN THÊM</h3>
								<hr style="margin: 5px 0px 15px;">
								<div class="form-group">
									<label for="">Ghi chú đơn hàng</label>
									<textarea class="form-control" placeholder="Ghi chú đơn hàng" name="order_note" rows="3" cols="80"></textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-4 col-sm-4 col-20px">
							<div class="block-totalcart">
								<h3 class="title">ĐƠN HÀNG CỦA BẠN</h3>
								<table cellspacing="0">
									<thead>
										<tr>
											<th class="product-name">SẢN PHẨM</th>
											<th class="product-total">TỔNG CỘNG</th>
										</tr>
									</thead>
									<tbody>
										<?php if ($this->cart->contents()): ?>
											<?php foreach ($this->cart->contents() as $items): ?>
												<tr class="cart-item-checkout">
													<td class="name-product-checkout"><?php echo $items['name']; ?> <strong>x<?php echo $items['qty']; ?></strong></td>
													<td><span><?php echo formatRice($items['subtotal']); ?>&nbsp;₫</span></td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
									<tfoot>
										<tr class="cart-subtotal">
											<th>TỔNG PHỤ</th>
											<td><strong><span><?php echo formatRice($this->cart->total()); ?>&nbsp;₫</span></strong></td>
										</tr>
										<tr class="order-total">
											<th><?php echo $this->lang->line('total_number_price'); ?></th>
											<td><strong><span><?php echo formatRice($this->cart->total()); ?> ₫</span></strong> </td>
										</tr>
									</tfoot>
								</table>
								<?php $forms_of_payment = $this->config->item('forms_of_payment'); ?>
								<?php if(is_array($forms_of_payment) && !empty($forms_of_payment)): ?>
									<div class="box-payment">
										<ul>
											<?php $i=0; foreach($forms_of_payment as $key => $payment): $i++; ?>
												<li>
													<input id="payment_method_<?php echo $key; ?>" type="radio" value="<?php echo $key; ?>" name="forms_of_payment"<?php echo $i==1 ? ' checked="checked"' : ''; ?>>
													<label for="payment_method_<?php echo $key; ?>"><?php echo $payment['title']; ?></label>
													<div class="block-content" id="payment-<?php echo $key; ?>">
														<?php echo $payment['info']; ?>
													</div>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
								<div class="place-order">
									<button type="submit" name="button" class="btn btn-primary">ĐẶT HÀNG</button>
								</div>
							</div>
							<br>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</article>
