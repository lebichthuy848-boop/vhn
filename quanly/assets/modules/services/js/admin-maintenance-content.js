$(function () {
    jQuery.validator.addMethod("codeFormat", function () {
        var isSuccess = false;
        var code = $('#code').val();

        var strURL = base_url + 'services/check_maintenance_code_format';
        var data = {'code': code, 'ajax': 1};
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
    }, 'Số phiếu sai định dạng!<br/>Định dạng đúng: BHxxxxx<br/>Trong đó x là các số từ 0 đến 9');

    jQuery.validator.addMethod("codeCheck", function () {
        var isSuccess = false;
        var code = $('#code').val();

        var id = 0;
        if ($('#id').length) {
            id = $('#id').val();
        }

        var strURL = base_url + 'services/check_maintenance_code_availablity';
        var data = {'code': code, 'id': id, 'ajax': 1};
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
    }, 'Số phiếu này đã sử dụng');

    $("#f-content").validate({
        onkeyup: false,
        rules: {
            code: {
                required: true,
                codeFormat: true,
                codeCheck: true
            }
        },
        messages: {
            alias: {
                required: 'Nhập số phiếu'
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

    $('#tblAppendGrid').appendGrid({
        caption: 'Thiết bị',
        initRows: 1,
        columns: [
            {
                name: 'consignment_id',
                display: 'Mã thiết bị',
                type: 'custom',
                customBuilder: function (parent, idPrefix, name, uniqueIndex) {
                    var ctrlId = idPrefix + '_' + name + '_' + uniqueIndex;
                    var ctrl = document.createElement('select');
                    $.each(consignment, function (key, val) {
                        ctrl.add(createOption(key, val));
                    });
                    $(ctrl).attr({
                        'id': ctrlId,
                        'name': ctrlId
                    }).appendTo(parent).chosen({search_contains: true});
                    return ctrl;
                },
                customGetter: function (idPrefix, name, uniqueIndex) {
                    return $('#' + idPrefix + '_' + name + '_' + uniqueIndex).chosen().val();
                },
                customSetter: function (idPrefix, name, uniqueIndex, value) {
                    $('#' + idPrefix + '_' + name + '_' + uniqueIndex).val(value).trigger('chosen:updated');
                },
                onChange: handleChange
            },
            {name: 'unit', display: 'Đơn vị tính', type: 'text', ctrlAttr: {maxlength: 100}, ctrlCss: {width: '110px'}},
            {name: 'quantity', display: 'SL', type: 'number', ctrlAttr: {maxlength: 100}, ctrlCss: {width: '70px', 'text-align': 'right'}, value: 1},
            {name: 'returned', display: 'Trả/chưa', type: 'select', ctrlCss: {width: '80px'}, ctrlOptions: {0: 'Chưa trả', 1: 'Đã trả'}},
            {name: 'status', display: 'Tình trạng', type: 'textarea', ctrlAttr: {maxlength: 100}, ctrlCss: {width: '135px'}},
            {name: 'note', display: 'Nội dung BH', type: 'textarea', ctrlAttr: {maxlength: 100}, ctrlCss: {width: '180px'}},
            {name: 'fee', display: 'Chi phí sửa', type: 'textarea', ctrlAttr: {maxlength: 100}, ctrlCss: {width: '100px', 'text-align': 'left'}}
        ],
        initData: consignment_init
    });
});

function createOption(value, text) {
    var option = document.createElement('option');
    option.text = text;
    option.value = value;
    return option;
}
function handleChange(evt, rowIndex) {
    alert('Selected Value = ' + evt.target.value);
}

$(document).ready(function () {
    $('#f-content').on('submit', function () {
        var customer_id = $('#customer_id').val();
        if (customer_id == 0) {
            alert('Chưa chọn khách hàng!');
            return false;
        }

        var count = $('#tblAppendGrid').appendGrid('getRowCount');

        var strURL = base_url + 'sua-chua-bao-hanh/them-ajax';
        var data = $(document.forms[0]).serialize();
        data = data + '&' + $.param({'count': count});
        $('#processing-modal').modal('show');
        $.ajax({
            url: strURL,
            type: 'POST',
            cache: false,
            data: data,
            dataType: 'json',
            success: function (response) {
                $('#processing-modal').modal('hide');
                alert(response.message);
                if (response.status == 'success') {
                    window.location.href = response.content.data;
                }
            },
            error: function (e) {
                $('#processing-modal').modal('hide');
                console.log('Lỗi: ' + e.responseText);
            }
        });

        return false;
    });

    $('#customer_id').on('change', function () {
        var id = $(this).val();
        if (id == 0) {
            return false;
        }
        //console.log(id);
        var strURL = base_url + 'sua-chua-bao-hanh/get-info-customer-ajax';
        var data = {'id': id, 'ajax': 1};
        $.ajax({
            url: strURL,
            type: 'POST',
            cache: false,
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    $('#address').val(response.content.data.address);
                    $('#phone').val(response.content.data.phone);
                    $('.info-customer').removeClass('hide');
                } else {
                    $('.info-customer').addClass('hide');
                }
            },
            error: function (e) {
                console.log('Lỗi: ' + e.responseText);
            }
        });

        return false;
    });
    $(".chosen-select").chosen({search_contains: true});

    $('#f-customer').on('submit', function () {
        var full_name = $('#f_full_name').val();
        var customer_types_id = $('#f_customer_types_id').val();
        var address = $('#f_address').val();
        var phone = $('#f_phone').val();
        var tel = $('#f_tel').val();
        var email = $('#f_email').val();
        var discount_HDPARAGON = $('#f_discount_HDPARAGON').val();
        var discount_HIKVISION = $('#f_discount_HIKVISION').val();
        var delivery_address = $('#f_delivery_address').val();
        var tax_code = $('#f_tax_code').val();
        var contact = $('#f_contact').val();
        var freight_id = $('#f_freight_id').val();
        var note = $('#f_note').val();
        $.ajax({
            url: base_url + 'customers/ajax_admin_add',
            data: {
                'ajax': 1,
                'full_name': full_name,
                'customer_types_id': customer_types_id,
                'address': address,
                'phone': phone,
                'tel': tel,
                'email': email,
                'discount_HDPARAGON': discount_HDPARAGON,
                'discount_HIKVISION': discount_HIKVISION,
                'delivery_address': delivery_address,
                'tax_code': tax_code,
                'contact': contact,
                'freight_id': freight_id,
                'note': note
            },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status == 'success') {
                    $('#myModal2').modal('hide');
                    $('#customer_id').html(response.content.data);
                    $('#customer_id').chosen().trigger("chosen:updated");
                }
            },
            error: function (e) {
                alert('Error processing your request: ' + e.responseText);
            }
        });
        return false;
    });
});