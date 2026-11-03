<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-name"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo get_admin_url($module_slug . '/content' . (isset($row['id']) ? ('/' . $row['id']) : '')); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php if (isset($row['id'])): ?>
                        <input type="hidden" value="<?php echo $row['id']; ?>" id="id" name="id">
                    <?php endif;?>
                    <div class="form-group required">
                        <label for="name" class="control-label">Tên thương hiệu</label>
                        <input class="form-control" name="name" id="name" type="text" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>">
                        <?php echo form_error('name'); ?>
                    </div>

                    <div class="form-group required<?php echo form_error('alias') != '' ? ' has-error' : ''; ?>">
                        <label for="alias" class="control-label">Liên kết tĩnh</label>
                        <input class="form-control" name="alias" type="text" id="alias" value="<?php echo isset($row['alias']) ? $row['alias'] : ''; ?>" maxlength="255">
                        <?php echo form_error('alias'); ?>
                    </div>

                    <div class="form-group">
                        <label for="content" class="control-label">Nội dung</label>
                        <?php
                        $content = isset($row['content']) ? $row['content'] : '';
                        $config_mini = array();
                        $config_mini['language'] = 'vi';
                        $config_mini['filebrowserBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
                        $config_mini['filebrowserImageBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=images&dir=images/news';
                        $config_mini['filebrowserFlashBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
                        $config_mini['filebrowserUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
                        $config_mini['filebrowserImageUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=images&dir=images/news';
                        $config_mini['filebrowserFlashUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
                        echo $this->ckeditor->editor("content", $content, $config_mini);
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="title_seo" class="control-label">Title (SEO)</label>
                        <input class="form-control" name="title_seo" type="text" id="title_seo" value="<?php if (isset($row['title_seo'])) echo $row['title_seo']; ?>" maxlength="255">
                    </div>

                    <div class="form-group">
                        <label for="keywords" class="control-label">Keywords (SEO)</label>
                        <textarea class="form-control" data-autoresize name="keywords" id="keywords"><?php if (isset($row['keywords'])) echo $row['keywords']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="description" class="control-label">Description (SEO)</label>
                        <textarea class="form-control" data-autoresize name="description" id="description"><?php if (isset($row['description'])) echo $row['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="other_seo" class="control-label">Other (SEO)</label>
                        <textarea class="form-control" data-autoresize name="other_seo" id="other_seo"><?php if (isset($row['other_seo'])) echo $row['other_seo']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="h1_seo" class="control-label">H1 (SEO)</label>
                        <input class="form-control" name="h1_seo" type="text" id="h1_seo" value="<?php if (isset($row['h1_seo'])) echo $row['h1_seo']; ?>" maxlength="255">
                    </div>

                    <div class="text-center">
                        <?php if (isset($row['id'])): ?>
                            <input class="btn btn-primary" type="submit" value="Lưu thay đổi">
                        <?php else: ?>
                            <input class="btn btn-success" type="submit" value="Thêm">
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>