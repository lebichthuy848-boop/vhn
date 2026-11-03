<article id="main-content">
  <?php
  $image = get_image(get_module_path('shops') . $row['homeimgfile'], get_module_path('shops') . 'no-image.png');
  //$data_price = $row['product_price'];
  //$data_sales_price = get_promotion_price($row['product_price'], $row['product_sales_price']);
  ?>
  <article>
  	<?php $this->load->view('breadcrumb'); ?>
    <section>
      <div class="box-single-product-wrapper">
        <div class="container">
          <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
              <div class="detail-product--slider-producted">
                <?php if (isset($row['options']) && is_array($row['options']) && !empty($row['options'])): ?>
                  <div class="slider-producted">
                    <?php foreach ($row['options'] as $value): $image_option = get_image(get_module_path('shops') . $value['image'], get_module_path('shops') . 'no-image.png'); ?>
                      <a class="item" href="<?php echo $image_option; ?>" data-size="2048x2048" data-med="<?php echo $image_option; ?>" data-med-size="2048x2048" data-author="VHNGROUP">
                        <img src="<?php echo $image_option; ?>" alt="" />
                        <figure class="d-none">VHNGROUP</figure>
                      </a>
                    <?php endforeach;?>
                  </div>
                <?php endif;?>
                <?php if (isset($row['options']) && is_array($row['options']) && !empty($row['options'])): ?>
                  <div class="slider-thumbnail-navigation">
                    <?php foreach ($row['options'] as $value): $image_option = get_image(get_module_path('shops') . $value['image'], get_module_path('shops') . 'no-image.png'); ?>
                      <div class="item">
                        <img width="180" height="180" class="img-fluid" src="<?php echo $image_option; ?>" alt="image"  draggable="false"/>
                      </div>
                    <?php endforeach;?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
              <div class="detail-product--content-producted">
                <h1><?php echo isset($row['title']) ? $row['title'] : ''; ?></h1>
                <small>Mã sản phẩm: <?php echo isset($row['product_code']) ? $row['product_code'] : ''; ?></small>
                <div class="block-content">
                  <?php echo isset($row['bodyhtml']) ? $row['bodyhtml'] : ''; ?>
                </div>
                <a href="#" class="btn btn-success">Buy online</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php if (isset($related_products) && trim($related_products) != ''): ?>
      <section>
        <div class="block-product-related">
          <div class="container">
            <h3 class="header-title">Sản Phẩm Liên Quan</h3>
            <div class="row row-0px">
              <?php echo $related_products; ?>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>
  </article>
<script type="text/javascript">
  var product_id = <?php echo isset($row['id']) ? $row['id'] : 0; ?>;
</script>
