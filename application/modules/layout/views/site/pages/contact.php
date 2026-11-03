<article id="main-content">
	<!-- <section>
    <div class="box-banner-pages" style="background-image: url(<?php echo get_asset('img_path'); ?>about-banner-images.jpg);">
      <div class="container">
        <h3>LIÊN HỆ</h3>
      </div>
    </div>
  </section> -->
	<section>
		<div class="mapper-pages-contact">
			<div class="embed-responsive embed-responsive-21by9">
				<?php echo isset($iframe_map) ? $iframe_map : ''; ?>
			</div>
			<div class="container">
				<div class="block-content-contact-pages">
					<h3><?php echo isset($info_contact_map_none['title']) ? $info_contact_map_none['title'] : ''; ?></h3>
					<div class="block-description">
						<?php echo isset($info_contact_map_none['content']) ? $info_contact_map_none['content'] : ''; ?>
					</div>
				</div>
			</div>
		</div>
    <div class="container">
      <div class="block-contact-page">
        <div class="row">
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
            <h2>THÔNG TIN LIÊN HỆ</h2>
            <?php echo isset($site_content_contact) ? $site_content_contact : ''; ?>
          </div>
          <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6">
            <h2>GỬI TIN NHẮN LIÊN HỆ</h2>
						<?php $this->load->view('layout/notify'); ?>
						<form class="form-horizontal" action="<?php echo site_url('lien-he'); ?>" method="post">
							<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									<div class="form-group">
		                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Họ và tên">
		              </div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									<div class="form-group">
		                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
		              </div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									<div class="form-group">
		                <input type="text" class="form-control" id="phone" name="phone" placeholder="Điện thoại">
		              </div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									<div class="form-group">
		                <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ">
		              </div>
								</div>
							</div>
              <div class="form-group">
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Tiêu đề">
              </div>
              <div class="form-group">
                <textarea class="form-control" id="message" name="message" rows="6" placeholder="Nội dung"></textarea>
              </div>
              <button type="submit" class="btn submit-contact" name="button">GỬI TIN NHẮN</button>
            </form>
            <div class="clearfix"></div>
            <br>
          </div>
        </div>
      </div>
    </div>
  </section>
</article>
