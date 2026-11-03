<article>
	<?php $this->load->view('breadcrumb'); ?>
	<section>
    <div class="box-warpper">
      <div class="container">
        <div class="block-header-title">
          <h3>TIN TỨC</h3>
        </div>
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
