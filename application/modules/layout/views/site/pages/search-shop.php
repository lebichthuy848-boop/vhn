<article class="bg-article">
	<section class="container">
		<div class="bg-container">
			<div class="row row-5px">
				<div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-5px">
					<?php $this->load->view('breadcrumb'); ?>
					<div class="box-warpper-post">
            <div class="block-header-title">
              <h3>Kết quả tìm kiếm cho từ khóa: "<?php echo isset($q) ? $q : ''; ?>"</h3>
            </div>
            <div class="row row-3px">
							<?php echo isset($rows) ? $rows : ''; ?>
							<div class="clearfix"></div>
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
					<?php $this->load->view('block-news'); ?>
				</div>
				<?php $this->load->view('block-right'); ?>
			</div>
		</div>
	</section>
</article>
