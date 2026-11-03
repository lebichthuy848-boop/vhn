<?php if (isset($data) && is_array($data) && !empty($data)):?>
<div class="box-content-catelogy">
    <div class="block-title">
        <h3>TIN TỨC</h3>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
            	<?php
            	if(isset($data[0])){
            	    $row = $data[0];
            	    unset($data[0]);
            	    $data_id = $row['id'];
            	    $data_title = convert_to_uppercase($row['title']);
            	    $data_link = site_url($row['categories']['alias'] . '/' . $row['alias'] . '-' . $data_id);
            	    $data_image = array(
                        'src' => get_media('posts', $row['homeimgfile'], 'no-image.png', '1024x768x1'),
            	        'alt' => $row['homeimgalt']
            	    );
            	    $data_date = date('d/m/Y', $row['addtime']);
            	}
            	?>
                <div class="post-item-first">
                    <div class="block-images">
                        <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="" class="img-fluid"></a>
                    </div>
                    <div class="block-description">
                        <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                        <small><?php echo $data_date; ?></small>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php if (isset($data) && is_array($data) && !empty($data)):?>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
            	<?php
            	foreach ($data as $value):
            	    $data_id = $value['id'];
            	    $data_title = convert_to_uppercase($value['title']);
            	    $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
            	    $data_image = array(
                        'src' => get_media('posts', $value['homeimgfile'], 'no-image.png', '1024x768x1'),
            	        'alt' => $value['homeimgalt']
            	    );
            	    $data_date = date('d/m/Y', $value['addtime']);
            	?>
                <div class="post-item-orther">
                    <div class="block-images">
                        <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="" class="img-fluid"></a>
                    </div>
                    <div class="block-description">
                        <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            	<?php endforeach; ?>
            </div>
        	<?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
