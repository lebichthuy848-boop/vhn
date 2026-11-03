<?php if (isset($partner_none) && is_array($partner_none) && !empty($partner_none)): ?>
  <section>
    <div class="box-partner">
      <div class="container">
        <div class="row">
          <div id="partner" class="owl-carousel owl-theme">
            <?php foreach ($partner_none as $value): ?>
              <div class="item">
                <a href="<?php echo ($value['link']); ?>"><img src="<?php echo base_url(get_module_path('images') . ((trim($value['image']) != '') ? $value['image'] : $value['image'])); ?>" alt="" class="img-fluid"></a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>
