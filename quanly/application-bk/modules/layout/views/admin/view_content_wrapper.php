<!-- BEGIN: Content-->
<div class="app-content content">
	<div class="content-overlay"></div>
	<div class="content-wrapper">
		<div class="content-body">
			<div id="notify" class="col-lg-12">
					<?php $this->load->view('view_notify'); ?>
			</div>
			<?php $this->load->view($main_content); ?>
		</div>
	</div>
</div>