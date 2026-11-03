<article id="main-content">
	<?php $this->load->view('breadcrumb'); ?>
	<section>
    <div class="box-product-filter-wrapper">
      <div class="container">
				<div class="product-filter-header">
          <div class="header-title">
            <h1><?php echo isset($row['name']) ? convert_to_uppercase($row['name']) : ''; ?></h1>
            <p><?php echo isset($row['slogun']) ? nl2br($row['slogun']) : ''; ?></p>
          </div>
          <div class="header-choise-selectbar">
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="selectbar-item">
                  <label for="collection">Category</label>
                  <select class="form-control" name="collection" id="collection">
                    <?php echo display_option_select($collection, 'lurl', 'lname', current_url()); ?>
                  </select>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="selectbar-item">
                  <label for="filter">Filter</label>
                  <select class="form-control" name="filter" id="filter">
                    <?php echo display_option_select($filter, 'id', 'name', isset($get['filter']) ? $get['filter'] : 0); ?>
                  </select>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="selectbar-item">
                  <label for="sort_by">Sort</label>
                  <select class="form-control" name="sort_by" id="sort_by">
                    <?php echo get_option_select($this->config->item('items', 'shops_modules_cat_sort'), isset($get['sort_by']) ? $get['sort_by'] : $this->config->item('default', 'shops_modules_cat_sort')); ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
				<div class="row row-0px">
					<?php echo isset($rows) ? $rows : ''; ?>
				</div>
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
</article>
