$(document).ready(function () {
    $('#customer_id').on('change', function () {
        var id = $(this).val();
        if (id == 0) {
            return false;
        }
        //console.log(id);
        var strURL = base_url + 'muon-hang/get-info-customer-ajax';
        var data = {'id': id, 'ajax': 1};
        $.ajax({
            url: strURL,
            type: 'POST',
            cache: false,
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    $('#email').val(response.content.data.email);
                    $('#phone').val(response.content.data.phone);
                }
            },
            error: function (e) {
                console.log('Lỗi: ' + e.responseText);
            }
        });

        return false;
    });

    $(".chosen-select").chosen();
});