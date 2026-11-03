<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-5px">
  <aside>
		<?php if (isset($support_online_none) && is_array($support_online_none) && !empty($support_online_none)): ?>
	    <div class="box-content-catelogy">
	      <div class="block-title">
	        <h3>HỖ TRỢ TRỰC TUYẾN</h3>
	      </div>
	      <div class="block-content">
					<?php foreach ($support_online_none as $value): ?>
	        	<a href="<?php echo ($value['link']); ?>"><img src="<?php echo base_url(get_module_path('images') . ((trim($value['image']) != '') ? $value['image'] : $value['image'])); ?>" alt="" class="img-fluid"></a>
					<?php endforeach; ?>
	      </div>
	    </div>
		<?php endif; ?>
    <div class="box-content-catelogy block-introdue">
      <div class="block-title">
        <h3>GIỚI THIỆU VỀ CHÚNG TÔI</h3>
      </div>
      <div class="block-content">
				<?php echo isset($info_introdues_none['content']) ? $info_introdues_none['content'] : ''; ?>
      </div>
    </div>
		<?php echo isset($posts_news) ? $posts_news : ''; ?>
		<?php $this->load->view('block-partner'); ?>
		<?php if (isset($advertise_none) && is_array($advertise_none) && !empty($advertise_none)): ?>
	    <div class="box-content-catelogy">
	      <div class="block-title">
	        <h3>QUẢNG CÁO</h3>
	      </div>
	      <div class="block-advertise">
					<?php foreach ($advertise_none as $value): ?>
	        	<a href="<?php echo ($value['link']); ?>"><img src="<?php echo base_url(get_module_path('images') . ((trim($value['image']) != '') ? $value['image'] : $value['image'])); ?>" alt="" class="img-fluid"></a>
					<?php endforeach; ?>
	      </div>
	    </div>
		<?php endif; ?>
    <div class="box-content-catelogy">
      <div class="block-title">
        <h3>THỐNG KÊ TRUY CẬP</h3>
      </div>
      <div class="block-totalonline">
        <ul>
          <li><img src="<?php echo get_asset('img_path'); ?>users.png" alt="" class="img-fluid"> Đang truy cập : <span id="online"></span></li>
          <li><img src="<?php echo get_asset('img_path'); ?>today.png" alt="" class="img-fluid"> Hôm nay : <span id="today"></span></li>
          <li><img src="<?php echo get_asset('img_path'); ?>month.png" alt="" class="img-fluid"> Tháng hiện tại  : <span id="thismonth"></span></li>
          <li><img src="<?php echo get_asset('img_path'); ?>today.png" alt="" class="img-fluid"> Tổng lượt truy cập : <span id="total"></span></li>
        </ul>
      </div>
    </div>
  </aside>
</div>
