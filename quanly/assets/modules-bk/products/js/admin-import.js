//<![CDATA[
$(document).ready(function() {
    $("#is_purchase_voucher").on('ifChanged', function() {
        if ($(this).is(':checked')) {
            $('.is-purchase-voucher-option').removeClass('hide');
        } else {
            $('.is-purchase-voucher-option').addClass('hide');
        }
    });
});
//]]>