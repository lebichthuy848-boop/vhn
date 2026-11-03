<div class="rating-box">
    <div style="width:<?php echo $data['percent']; ?>%" class="rating"></div>
</div>
<p class="rating-links"> <a href="#"><?php echo $data['count']; ?> Review(s)</a> <span class="separator">|</span> <a href="#"><?php echo $data['message']; ?></a> </p>

<div class="pull-right" id="add_ratings" style="display: inline;">
    <div class="pull-left">
        <!-- ratings will display here, make sure u bind #prd in the javascrript below -->
        <div id="prd"></div>
    </div>
    <?php if ($data['button']): ?>
        <div class="pull-left">
            <button class="btn btn-primary btn-xs" id="submit" type="button">Rating</button>
        </div>
    <?php endif; ?>
</div>