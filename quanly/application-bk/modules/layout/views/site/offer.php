<div class="offer-banner-section">
    <div class="container">
        <div class="row">
            <?php foreach ($banner_top as $value): ?>
                <div class="col-lg-4 col-xs-12 col-md-4 col-sm-4 wow">
                    <a href="<?php echo $value['link']; ?>"><img alt="<?php echo $value['alt']; ?>" src="<?php echo base_url(get_module_path('images') . $value['image']); ?>"></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>