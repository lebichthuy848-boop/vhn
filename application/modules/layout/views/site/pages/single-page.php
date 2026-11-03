<article id="main-content">
  <section>
    <div class="box-banner-pages" style="background-image: url(<?php echo get_image(get_module_path('posts') . (isset($row['homeimgfile']) ? $row['homeimgfile'] : ''), get_module_path('posts') . 'no-image.png'); ?>);">
      <div class="container">
        <h1><?php echo isset($row['title']) ? $row['title'] : ''; ?></h1>
        <div class="meta-list">
          <span class="date-post"><i class="far fa-clock"></i> <?php echo get_day_of_week_vi($row['addtime']); ?> - <?php echo date('d/m/Y H:i', $row['addtime']); ?></span>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="box-about-wrapper">
      <div class="container">
        <div class="block-content">
          <?php echo isset($row['bodyhtml']) ? $row['bodyhtml'] : ''; ?>
          <?php $this->load->view('addthis'); ?>
        </div>
      </div>
    </div>
  </section>
</article>