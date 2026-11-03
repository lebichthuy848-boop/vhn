<div class="row">
    <div class="col-sm-12">
        <div style="width: 100%; background: #1C8D21;">
            <div class="btn-group btn-breadcrumb">
                <?php
                $end_breadcrumbs = count($breadcrumbs) - 1;
                $start_breadcrumbs = 0;
                foreach ($breadcrumbs as $breadcrumb) {
                    $class_active = ' class="btn btn-success"';
                    $start_breadcrumbs++;
                    if ($start_breadcrumbs === $end_breadcrumbs) {
                        $class_active = ' class="btn btn-success active"';
                    }

                    if ($start_breadcrumbs === $end_breadcrumbs + 1) {
                        $char = '';
                    } else {
                        $char = '';
                    }
                    echo anchor($breadcrumb['url'], $breadcrumb['name'], $class_active) . $char;
                }
                ?>
            </div>
        </div>
    </div>
</div>