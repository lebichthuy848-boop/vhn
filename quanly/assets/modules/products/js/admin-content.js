$(function() {
    jQuery.validator.addMethod("codeCheckFormat", function() {
        var code = document.getElementById('code');
        if(code.value.length < 1 || code.value.length > 15){
            return false;
        }
        return textAlphanumeric(code);
    }, 'Mã sản phẩm không đúng định dạng');

    jQuery.validator.addMethod("codeCheck", function() {
        var isSuccess = false;
        var code = $('#code').val();

        var id = 0;
        if ($('#id').length) {
            id = $('#id').val();
        }

        var strURL = base_url + 'products/check_code_availablity';
        var data = { 'code': code, 'id': id, 'ajax': 1 };
        $.ajax({
            url: strURL,
            type: 'POST',
            async: false,
            data: data,
            success: function(response) {
                var getData = $.parseJSON(response);
                if (getData.status === 'success') {
                    isSuccess = true;
                }
            }
        });
        //console.log(isSuccess);

        return isSuccess;
    }, 'Mã sản phẩm này đã sử dụng');

    jQuery.validator.addMethod("barcodeCheckFormat", function() {
        var barcode = document.getElementById('barcode');
        if(barcode.value.length < 1 || barcode.value.length > 15){
            return false;
        }
        return textAlphanumeric(barcode);
    }, 'Barcode không đúng định dạng');

    jQuery.validator.addMethod("barcodeCheck", function() {
        var isSuccess = false;
        var barcode = $('#barcode').val();

        var id = 0;
        if ($('#id').length) {
            id = $('#id').val();
        }

        var strURL = base_url + 'products/check_barcode_availablity';
        var data = { 'barcode': barcode, 'id': id, 'ajax': 1 };
        $.ajax({
            url: strURL,
            type: 'POST',
            async: false,
            data: data,
            success: function(response) {
                var getData = $.parseJSON(response);
                if (getData.status === 'success') {
                    isSuccess = true;
                }
            }
        });
        //console.log(isSuccess);

        return isSuccess;
    }, 'Barcode này đã sử dụng');

    $("#f-content").validate({
        onkeyup: false,
        rules: {
            name: {
                required: true
            },
            code: {
                required: true,
                codeCheckFormat: true,
                codeCheck: true
            },
            barcode: {
                required: true,
                barcodeCheckFormat: true,
                barcodeCheck: true
            }
        },
        messages: {
            name: {
                required: 'Nhập tên sản phẩm'
            },
            code: {
                required: 'Nhập mã sản phẩm'
            },
            barcode: {
                required: 'Nhập barcode'
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $("#code").on('keyup blur', function () {
        $("#barcode").val($(this).val());
        return false;
    });
});

function textAlphanumeric(inputtext) {
    var alphaExp = /^[0-9a-zA-Z_.-]+$/;
    if (inputtext.value.match(alphaExp)) {
        return true;
    } else {
        return false;
    }
}