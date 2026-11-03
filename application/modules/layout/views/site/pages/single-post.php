<article>
	<?php $this->load->view('breadcrumb'); ?>
	<section>
    <div class="box-warpper">
      <div class="container">
        <div class="block-single--post">
          <h1><?php echo isset($row['title']) ? $row['title'] : ''; ?></h1>
          <div class="meta-list">
            <span class="date-post"><i class="far fa-clock"></i> <?php echo get_day_of_week_vi($row['addtime']); ?> - <?php echo date('d/m/Y H:i', $row['addtime']); ?></span>
					</div>
          <div class="block-content">
            <?php echo isset($row['bodyhtml']) ? $row['bodyhtml'] : ''; ?>
          </div>
        </div>
				<?php if (isset($related_posts) && trim($related_posts) != ''): ?>
					<div class="block-post-related">
						<div class="block-title">
	            <h3>TIN TỨC LIÊN QUAN</h3>
	          </div>
						<div class="row">
							<?php echo $related_posts; ?>
						</div>
					</div>
				<?php endif; ?>
      </div>
    </div>
  </section>
	<?php echo isset($posts_news) ? $posts_news : ''; ?>
  <?php $this->load->view('block-partner'); ?>
</article>
