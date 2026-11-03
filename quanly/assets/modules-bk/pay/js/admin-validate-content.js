$(document).ready(function () {
    jQuery.validator.addMethod("amountCheck", function () {
        var isSuccess = false;
        var amount = $('#amount').val();
        var customer_id = $('#customer_id').val();

        var id = 0;
        if ($('#id').length) {
            id = $('#id').val();
        }

        var strURL = base_url + 'pay/check_quantity_availablity';
        var data = {'amount': amount, 'customer_id': customer_id, 'id': id, 'ajax': 1};
        $.ajax({
            url: strURL,
            type: 'POST',
            async: false,
            data: data,
            success: function (response) {
                var getData = $.parseJSON(response);
                if (getData.status === 'success') {
                    isSuccess = true;
                }
            }
        });

        return isSuccess;
    }, 'Số tiền trả đã vượt quá số tiền thiếu của khách hàng này!');

    $("#f-content").validate({
        rules: {
            customer_id: {
                required: true
            },
            amount: {
                required: true,
                amountCheck: true
            }
        },
        messages: {
            customer_id: {
                required: 'Chọn khách hàng'
            },
            amount: {
                required: 'Nhập số tiền trả'
            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
});

$(document).on('change', '#customer_id', function() {
    var id = $(this).val();
    if (id == 0) {
        alert('Vui lòng chọn khách hàng!');
        return false;
    }
    var data = {
        'id': id
    };
    $.ajax({
        async: false,
        url: base_url + 'customers/get-arrears-ajax',
        type: 'POST',
        cache: false,
        data: data,
        dataType: 'json',
        success: function(response) {
            //console.log(response);
            if(response.status === "success"){
                let arrears = parseFloat(response.content);
                $('#arrears').text(numberFormat(arrears));
            }
        },
        error: function(e) {
            console.log('Lỗi: ' + e.responseText);
        }
    });
    return false;
});

function numberFormat(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

function numberFormatDecode(num) {
    return num.toString().replace(/,/g, "");
}