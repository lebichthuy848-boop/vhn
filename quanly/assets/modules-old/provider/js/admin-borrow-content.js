tblAppendGrid = 'tblAppendGrid';
products_selected = [];
$(function () {
    jQuery.validator.addMethod("codeFormat", function () {
        var isSuccess = false;
        var code = $('#code').val();

        var strURL = base_url + 'output_voucher/check_borrow_code_format';
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
    }, 'Số phiếu sai định dạng!<br/>Định dạng đúng: PXxxxxxxxx<br/>Trong đó x là các số từ 0 đến 9');

    jQuery.validator.addMethod("codeCheck", function () {
        var isSuccess = false;
        var code = $('#code').val();

        var id = 0;
        if ($('#id').length) {
            id = $('#id').val();
        }

        var strURL = base_url + 'output_voucher/check_borrow_code_availablity';
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

    jQuery.validator.addMethod("quantityCheck", function () {
        var isSuccess = false;
        var quantity = $('#quantity').val();

        var id = 0;
        if ($('#id').length) {
            id = $('#id').val();
        }

        var strURL = base_url + 'products/check_quantity_availablity';
        var data = {'quantity': quantity, 'id': id, 'ajax': 1};
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
    }, 'Số lượng vượt quá sản phẩm trong kho');

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

    $('#' + tblAppendGrid).appendGrid({
        caption: 'PHIẾU XUẤT',
        initRows: 1,
        columns: [
            {
                name: 'product_id',
                display: 'Sản phẩm',
                type: 'custom',
                customBuilder: function (parent, idPrefix, name, uniqueIndex) {
                    var ctrlId = idPrefix + '_' + name + '_' + uniqueIndex;
                    var ctrl = document.createElement('select');
                    $.each(products, function (key, val) {
                        ctrl.add(createOption(key, val));
                    });
                    $(ctrl).attr({
                        'id': ctrlId,
                        'name': ctrlId,
                        'class': 'select_on_change'
                    }).appendTo(parent).chosen({search_contains: true});
                    return ctrl;
                },
                customGetter: function (idPrefix, name, uniqueIndex) {
                    return $('#' + idPrefix + '_' + name + '_' + uniqueIndex).chosen().val();
                },
                customSetter: function (idPrefix, name, uniqueIndex, value) {
                    $('#' + idPrefix + '_' + name + '_' + uniqueIndex).val(value).trigger('chosen:updated');
                }
            },
            {
                name: 'quantity',
                display: 'Số lượng',
                type: 'number',
                ctrlAttr: {maxlength: 100, min: 1},
                ctrlCss: {width: '60px', 'text-align': 'right'},
                value: 1,
                onChange: function (evt, rowIndex) {
                    changeValueRowIndex(rowIndex);
                }
            },
            {
                name: 'unit_price',
                display: 'Đơn giá',
                type: 'number',
                ctrlAttr: {maxlength: 100, readonly: 'readonly'},
                ctrlCss: {width: '60px', 'text-align': 'right'},
                value: 0,
                onChange: function (evt, rowIndex) {
                    changeValueRowIndex(rowIndex);
                }
            },
            {name: 'monetized', display: 'Thành tiền', type: 'number', ctrlAttr: {maxlength: 100, readonly: 'readonly'}, ctrlCss: {width: '60px', 'text-align': 'right'}, value: 0},
            {
                name: 'discount',
                display: 'CK',
                type: 'number',
                ctrlAttr: {maxlength: 100, step: 1000, min: 0},
                ctrlCss: {width: '60px', 'text-align': 'right'},
                value: 0,
                onChange: function (evt, rowIndex) {
                    setTotal();
                }
            },
            {
                name: 'VAT',
                display: 'VAT',
                type: 'text',
                ctrlAttr: {maxlength: 100},
                ctrlCss: {width: '60px', 'text-align': 'right'},
                value: 0,
                onChange: function (evt, rowIndex) {
                    setTotal();
                }
            },
            {name: 'note', display: 'Ghi chú', type: 'textarea', ctrlAttr: {maxlength: 100}, ctrlCss: {width: '100px'}}
        ],
        initData: product_init
    });
});
function createOption(value, text) {
    var option = document.createElement('option');
    option.text = text;
    option.value = value;
    return option;
}

$(document).ready(function () {
    setTotal();
    $('#f-content').on('submit', function () {
        //check quantity
        var id = 0;
        if ($('#id').length) {
            id = $('#id').val();
        }
        var data_append_grid = $('#tblAppendGrid').appendGrid('getAllValue');
        var str_err = '';
        for (var i = 0; i < data_append_grid.length; i++) {
            if (!quantityCheck(id, data_append_grid[i]['product_id'], data_append_grid[i]['quantity'])) {
                str_err += 'Số lượng sản phẩm này đã vượt quá số lượng trong kho\n';
            }
        }
        if ($.trim(str_err) != '') {
            alert(str_err);
            return false;
        }

        var count = $('#' + tblAppendGrid).appendGrid('getRowCount');

        var strURL = base_url + 'phieu-xuat/them-ajax';
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

    $(".chosen-select").chosen({search_contains: true});
});

$(document).on('change', '.select_on_change', function () {
    var rowIndex = 0;
    var id = $(this).val();
    if (id == 0) {
        return false;
    }

    /*
     if (jQuery.inArray(id, products_selected) != -1) {
     alert('Sản phẩm này đã tồn tại!');
     return false;
     } else {
     products_selected.push(id);
     }
     */
    //console.log(products_selected);

    //var rowCount = $('#tblAppendGrid').appendGrid('getRowCount');//lay tong so ban ghi
    //console.log(rowCount);

    var select_on_change = $('.select_on_change');
    select_on_change.each(function (index) {
        if ($(this).val() == id) {
            rowIndex = index;
            return false;
        }
    });
    //console.log(rowIndex);
    //return false;

    //var str_id = $(this).attr('id');
    //var rowIndex = Math.abs(parseInt(str_id.replace(tblAppendGrid + "_product_id_", "") - 1));
    //console.log(rowIndex);

    //var data = $('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex);//lay gia tri cua cot    
    //console.log(data);
    //$('#' + tblAppendGrid).appendGrid('setCtrlValue', 'quantity', rowIndex, 10);//set gia tri cua cot
    //return false;

    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));//lay gia tri cua cot


    //console.log(id);
    var strURL = base_url + 'products/ajax_get';
    var data = {'id': id};
    $.ajax({
        url: strURL,
        type: 'POST',
        cache: false,
        data: data,
        dataType: 'json',
        success: function (response) {
            //console.log(response);
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'unit_price', rowIndex, response.content.retail_price);//set gia tri cua cot
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, quantity * parseFloat(response.content.retail_price));//set gia tri cua cot
            setTotal();
        },
        error: function (e) {
            console.log('Lỗi: ' + e.responseText);
        }
    });
    return false;
});

function changeValueRowIndex(rowIndex) {
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    var unit_price = parseFloat($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'unit_price', rowIndex));
    $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, quantity * unit_price);
    setTotal();
}

function changeValueTotal(rowIndex) {
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    var unit_price = parseFloat($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'unit_price', rowIndex));
    $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, quantity * unit_price);
    setTotal();
}

function setTotal() {
    var total_number = 0;
    var data = $('#' + tblAppendGrid).appendGrid('getAllValue');
    for (var i = 0; i < data.length; i++) {
        var monetized = parseFloat(data[i].monetized);
        var VAT = monetized * parseFloat(data[i].VAT) / 100;
        var discount = parseFloat(data[i].discount);
        total_number += (monetized + VAT - discount);
    }
    if (total_number > 0) {
        $('#total_number').text(numberFormat(total_number));
        var strURL = base_url + 'ajax_read_number_to_text';
        var data = {'number': total_number};
        $.ajax({
            url: strURL,
            type: 'POST',
            cache: false,
            data: data,
            dataType: 'json',
            success: function (response) {
                $('#total_text').text(response.content);
            },
            error: function (e) {
                console.log('Lỗi: ' + e.responseText);
            }
        });
        return false;
    }
}

function numberFormat(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
}

function quantityCheck(id, product_id, quantity) {
    var isSuccess = false;

    var strURL = base_url + 'products/check_quantity_availablity';
    var data = {'id': id, 'product_id': product_id, 'quantity': quantity, 'ajax': 1};
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
}