<article id="main-content">
	<?php if(isset($obm_none) && is_array($obm_none) && !empty($obm_none)): ?>
    <?php foreach ($obm_none as $key => $value): ?>
      <div class="box-obm" style="background-image: url(<?php echo get_media('images', $value['image'], 'no-image.png'); ?>);">
        <div class="container">
          <div class="block-content">
            <?php echo $value['content']; ?>
          </div>
          <a href="<?php echo $value['link']; ?>" class="btn btn-link">Xem thêm</a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
	<?php if(isset($procedure_obm_none) && is_array($procedure_obm_none) && !empty($procedure_obm_none)): ?>
		<section>
			<div class="box-procedure-obm">
				<div class="container">
					<h2 class="title">QUY TRÌNH TƯ VẤN OBM</h2>
					<div class="row">
						<?php foreach ($procedure_obm_none as $key => $value): ?>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
								<div class="block-images">
									<a href="<?php echo $value['link']; ?>"><img src="<?php echo get_media('images', $value['image'], 'no-image.png'); ?>" class="img-fluid" alt=""></a>
								</div>
								<div class="block-content">
									<h3><?php echo $value['title']; ?></h3>
									<p><?php echo $value['content']; ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
	<section>
		<div class="box-form-obm">
			<div class="container">
				<form id="f-advisory" action="#" method="post">
					<div class="form-group">
					  <label for="full-name">Tên của bạn (bắt buộc)</label>
					  <input type="text" class="form-control" id="f-advisory-full-name" placeholder="">
					</div>
					<div class="form-group">
					  <label for="email">Địa chỉ Email (bắt buộc)</label>
					  <input type="email" class="form-control" id="f-advisory-email" placeholder="">
					</div>
					<div class="form-group">
					  <label for="name-company">Tên Công ty</label>
					  <input type="text" class="form-control" id="f-advisory-company" placeholder="">
					</div>
					<div class="form-group">
					  <label for="phone">Điện thoại</label>
					  <input type="text" class="form-control" id="f-advisory-phone" placeholder="">
					</div>
					<div class="form-group">
					  <label for="address">Địa chỉ</label>
					  <input type="text" class="form-control" id="f-advisory-address" placeholder="">
					</div>
					<div class="form-group">
					  <label for="demand">Nhu cầu của quý vị</label>
					  <input type="text" class="form-control" id="f-advisory-need" placeholder="">
					</div>
					<div class="form-group">
					  <label for="category">Loại sản phẩm</label>
					  <input type="text" class="form-control" id="f-advisory-category" placeholder="">
					</div>
					<div class="form-group">
					  <label for="virtue">Công dụng</label>
					  <input type="text" class="form-control" id="f-advisory-uses" placeholder="">
					</div>
					<div class="form-group">
					  <label for="capacity">Dung tích</label>
					  <input type="text" class="form-control" id="f-advisory-capacity" placeholder="">
					</div>
					<div class="form-group">
					  <label for="orther-require">Yêu cầu khác</label>
					  <textarea class="form-control" id="f-advisory-note" rows="8" cols="80"></textarea>
					</div>
					<div class="form-group">
					  <label for="price">Giá thành</label>
					  <input type="text" class="form-control" id="f-advisory-price" placeholder="">
					</div>
					<div class="form-group">
					  <label for="message">Thông điệp</label>
					  <textarea class="form-control" id="f-advisory-message" rows="8" cols="80"></textarea>
					</div>
					<div class="form-group">
					  <label for="do-time">Thời gian thực hiện</label>
					  <textarea class="form-control" id="f-advisory-execution-time" rows="8" cols="80"></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Gửi đi</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</article>
