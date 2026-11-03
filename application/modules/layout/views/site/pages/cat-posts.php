<article>
	<?php if(isset($activate_pages) && is_array($activate_pages) && !empty($activate_pages)): ?>
		<?php foreach ($activate_pages as $value): ?>
			<div class="box-obm" style="background-image: url(<?php echo base_url(get_module_path('images') . ((trim($value['image']) != '') ? $value['image'] : $value['image'])); ?>);">
        <div class="container">
          <div class="block-content">
						<!-- <h2><?php echo mb_strtoupper($data_cat['name'], "UTF-8"); ?></h2>
            <?php echo $value['content']; ?> -->
          </div>
        </div>
      </div>
		<?php endforeach; ?>
	<?php endif; ?>
	<section>
    <div class="box-warpper">
      <div class="container">
        <div class="row">
          <?php echo isset($rows) ? $rows : ''; ?>
        </div>
        <div class="clearfix"></div>
				<?php if (isset($pagination) && $pagination != ''): ?>
					<div class="box-pagination">
						<nav>
							<?php echo $pagination; ?>
						</nav>
					</div>
				<?php endif; ?>
      </div>
    </div>
  </section>
	<?php echo isset($posts_news) ? $posts_news : ''; ?>
  <?php $this->load->view('block-partner'); ?>
</article>
