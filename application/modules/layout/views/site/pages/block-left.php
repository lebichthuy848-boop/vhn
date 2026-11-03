<div class="col-lg-3 col-md-3 col-sm-12 col-lg-pull-9 col-md-pull-9">
  <aside class="hidden-sm">
    <?php if(isset($advertise_none) && is_array($advertise_none) && !empty($advertise_none)): ?>
      <div class="box-advertise">
        <?php foreach ($advertise_none as $value): ?>
          <a target="_blank" href="<?php echo $value['link']; ?>"><img src="<?php echo base_url(get_module_path('images') . ((trim($value['image']) != '') ? $value['image'] : $value['image'])); ?>" alt="" class="img-responsive"></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <?php echo isset($products_bestseller) ? $products_bestseller : ''; ?>
    <div class="clearfix"></div>
    <div class="box-fanpage">
      <h3 class="title">FANPAGE</h3>
      <?php echo isset($fb_page) ? $fb_page : ''; ?>
    </div>
  </aside>
</div>
