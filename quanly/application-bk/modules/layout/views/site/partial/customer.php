<option value="0">Chọn</option>
<?php echo display_option_select($customers, 'id', array('full_name', 'customer_types_name'), isset($id) ? $id : 0); ?>