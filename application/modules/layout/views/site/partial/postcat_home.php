<?php if (isset($data) && is_array($data) && !empty($data)): ?>
    <?php
    foreach ($data as $data_cat):
        if (isset($data_cat['items']) && !empty($data_cat['items'])):
            ?>
            <?php if (isset($data_cat['type']) && $data_cat['type'] == 'NEWS'): ?>
            <div class="box-content-catelogy">
                <div class="block-title">
                    <h3><?php echo convert_to_uppercase($data_cat['name']); ?></h3>
                </div>
                <div class="block-content">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                            <?php
                            if(isset($data_cat['items'][0])){
                                $row = $data_cat['items'][0];
                                unset($data_cat['items'][0]);
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
                        <?php if (isset($data_cat['items']) && !empty($data_cat['items'])): ?>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                            <?php
                            foreach ($data_cat['items'] as $value):
                                $data_id = $value['id'];
                                $data_title = convert_to_uppercase($value['title']);
                                $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
                                $data_image = array(
                                    'src' => get_image(get_module_path('posts') . $value['homeimgfile'], get_module_path('posts') . 'no-image-thumb.png'),
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
            <?php elseif (isset($data_cat['type']) && $data_cat['type'] == 'SERVICE'): ?>
            <div class="box-content-catelogy">
                <div class="block-title">
                    <h3><?php echo convert_to_uppercase($data_cat['name']); ?></h3>
                </div>
                <div class="block-content">
                    <div class="row row-5px">
                        <div id="service" class="owl-carousel owl-navigations">
                            <?php
                            foreach ($data_cat['items'] as $value):
                                $data_id = $value['id'];
                                $data_title = convert_to_uppercase($value['title']);
                                $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
                                $data_image = array(
                                    'src' => get_media('posts', $value['homeimgfile'], 'no-image.png', '120x90x1'),
                                    'alt' => $value['homeimgalt']
                                );
                                $data_date = date('d/m/Y', $value['addtime']);
                                ?>
                            <div class="item">
                                <div class="service-item">
                                    <div class="block-images">
                                        <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="" class="img-fluid"></a>
                                    </div>
                                    <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php elseif (isset($data_cat['type']) && $data_cat['type'] == 'KNOWLEDGE'): ?>
            <div class="box-content-catelogy">
                <div class="block-title">
                    <h3><?php echo convert_to_uppercase($data_cat['name']); ?></h3>
                </div>
                <div class="block-content">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                            <?php
                            if(isset($data_cat['items'][0])){
                                $row = $data_cat['items'][0];
                                unset($data_cat['items'][0]);
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
                        <?php if (isset($data_cat['items']) && !empty($data_cat['items'])): ?>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                            <?php
                            foreach ($data_cat['items'] as $value):
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
            <?php elseif (isset($data_cat['type']) && $data_cat['type'] == 'APPLICATION'): ?>
            <div class="box-content-catelogy">
                <div class="block-title">
                    <h3><?php echo convert_to_uppercase($data_cat['name']); ?></h3>
                </div>
                <div class="block-content">
                    <div class="service-item-type2">
                        <?php
                        if(isset($data_cat['items'][0])){
                            $row = $data_cat['items'][0];
                            unset($data_cat['items'][0]);
                            $data_id = $row['id'];
                            $data_title = convert_to_uppercase($row['title']);
                            $data_link = site_url($row['categories']['alias'] . '/' . $row['alias'] . '-' . $data_id);
                            $data_image = array(
                                'src' => get_media('posts', $row['homeimgfile'], 'no-image.png', '1024x768x1'),
                                'alt' => $row['homeimgalt']
                            );
                            $data_hometext = word_limiter($row['hometext'], 28);
                        }
                        ?>
                        <div class="block-images">
                            <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="" class="img-fluid"></a>
                        </div>
                        <div class="block-description">
                            <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                            <p><?php echo $data_hometext; ?></p>
                            <?php if (isset($data_cat['items']) && !empty($data_cat['items'])): ?>
                            <ul>
                                <?php
                                foreach ($data_cat['items'] as $value):
                                    $data_id = $value['id'];
                                    $data_title = $value['title'];
                                    $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
                                    ?>
                                <li><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <?php elseif (isset($data_cat['type']) && $data_cat['type'] == 'SOLUTION'): ?>
            <div class="box-content-catelogy">
                <div class="block-title">
                    <h3><?php echo convert_to_uppercase($data_cat['name']); ?></h3>
                </div>
                <div class="block-content block-content-product">
                    <ul>
                        <?php
                        foreach ($data_cat['items'] as $value):
                            $data_id = $value['id'];
                            $data_title = convert_to_uppercase(word_limiter($value['title'], 14));
                            $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
                            $data_image = array(
                                'src' => get_media('posts', $value['homeimgfile'], 'no-image.png', '1024x768x1'),
                                'alt' => $value['homeimgalt']
                            );
                            $data_date = date('d/m/Y', $value['addtime']);
                            ?>
                        <li>
                            <div class="product-item">
                                <div class="block-images">
                                    <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="" class="img-fluid"></a>
                                </div>
                                <div class="block-description">
                                    <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                                    <small><?php echo $data_date; ?></small>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>