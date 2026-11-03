tblAppendGrid = 'tblAppendGrid';
products_selected = [];
$(function () {
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

    $('#' + tblAppendGrid).appendGrid({
        caption: 'BÁO GIÁ',
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
                name: 'unit',
                display: 'Đơn vị tính',
                type: 'text',
                ctrlAttr: {maxlength: 150, readonly: 'readonly'},
                ctrlCss: {width: '100px', 'text-align': 'left'},
                value: '',
                onChange: function (evt, rowIndex) {
                    changeValueRowIndex(rowIndex);
                }
            },
            {
                name: 'quantity',
                display: 'Số lượng',
                type: 'number',
                ctrlAttr: {maxlength: 50, min: 1},
                ctrlCss: {'text-align': 'right'},
                value: 1,
                onChange: function (evt, rowIndex) {
                    changeValueRowIndex(rowIndex);
                }
            },
            {
                name: 'unit_price',
                display: 'Đơn giá',
                type: 'text',
                ctrlAttr: {maxlength: 100, readonly: 'readonly'},
                ctrlCss: {'text-align': 'right'},
                value: 0,
                onChange: function (evt, rowIndex) {
                    changeValueRowIndex(rowIndex);
                }
            },
            {
                name: 'discount',
                display: 'CK',
                type: 'number',
                ctrlAttr: {maxlength: 100, step: 1000, min: 0},
                ctrlCss: {'text-align': 'right'},
                value: 0,
                onChange: function (evt, rowIndex) {
                    setTotal();
                }
            },
            {name: 'monetized', display: 'Thành tiền', type: 'text', ctrlAttr: {maxlength: 100, readonly: 'readonly'}, ctrlCss: {'text-align': 'right'}, value: 0}
        ]
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
    $(".chosen-select").chosen({search_contains: true});
});

$(document).on('change', '.select_on_change', function () {
    var rowIndex = 0;
    var customer_id = $('#customer_id').val();
    var id = $(this).val();
    if (id == 0) {
        return false;
    }

    var select_on_change = $('.select_on_change');
    select_on_change.each(function (index) {
        if ($(this).val() == id) {
            rowIndex = index;
            return false;
        }
    });
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));//lay gia tri cua cot

    var strURL = base_url + 'products/ajax_get';
    var data = {
        'id': id,
        'customer_id': customer_id
    };
    $.ajax({
        url: strURL,
        type: 'POST',
        cache: false,
        data: data,
        dataType: 'json',
        success: function (response) {
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'unit', rowIndex, response.content.unit);
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'unit_price', rowIndex, numberFormat(parseFloat(response.content.price)));
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, numberFormat(quantity * parseFloat(response.content.price)));
            setTotal();
        },
        error: function (e) {
            console.log('Lỗi: ' + e.responseText);
        }
    });
    return false;
});


$(document).on('click', '#click_view', function () {
    var id = 0;
    var data_append_grid = $('#' + tblAppendGrid).appendGrid('getAllValue');
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

    var strURL = base_url + 'bao-gia-ajax';
    var data = $(document.forms[0]).serialize();
    data = data + '&' + $.param({'count': count});
    $.ajax({
        url: strURL,
        type: 'POST',
        cache: false,
        data: data,
        dataType: 'json',
        success: function (response) {
            alert(response.message);
            if (response.status == 'success') {
                $('#element_print').html(response.content.data);
            }
        },
        error: function (e) {
            console.log('Lỗi: ' + e.responseText);
        }
    });

    return false;
});

$(document).on("click", "#click_print", function () {
    $("#element_print").print({
        globalStyles: true,
        mediaPrint: false,
        stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
        noPrintSelector: ".noPrint"
    });
});

$(document).on("keydown blur", "#VAT", function () {
    setTotal();
});

function changeValueRowIndex(rowIndex) {
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    var unit_price = parseFloat(numberFormatDecode($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'unit_price', rowIndex)));
    $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, numberFormat(quantity * unit_price));
    setTotal();
}

function changeValueTotal(rowIndex) {
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    var unit_price = parseFloat(numberFormatDecode($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'unit_price', rowIndex)));
    $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, numberFormat(quantity * unit_price));
    setTotal();
}

function setTotal() {
    var total_number = 0;
    var data = $('#' + tblAppendGrid).appendGrid('getAllValue');
    for (var i = 0; i < data.length; i++) {
        var monetized = parseFloat(numberFormatDecode(data[i].monetized));
        var discount = parseFloat(data[i].discount);
        total_number += (monetized + discount);
    }
    if (total_number > 0) {
        total_number += (total_number * parseFloat($('#VAT').val()) / 100);
        $('#total_number').text(numberFormat(total_number));
        $('#total_text').text($.trim(docso(total_number)));
    }
}

mangso = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
function dochangchuc(so, daydu)
{
    var chuoi = "";
    chuc = Math.floor(so / 10);
    donvi = so % 10;
    if (chuc > 1) {
        chuoi = " " + mangso[chuc] + " mươi";
        if (donvi == 1) {
            chuoi += " mốt";
        }
    } else if (chuc == 1) {
        chuoi = " mười";
        if (donvi == 1) {
            chuoi += " một";
        }
    } else if (daydu && donvi > 0) {
        chuoi = " lẻ";
    }
    if (donvi == 5 && chuc >= 1) {
        chuoi += " lăm";
    } else if (donvi > 1 || (donvi == 1 && chuc == 0)) {
        chuoi += " " + mangso[ donvi ];
    }
    return chuoi;
}
function docblock(so, daydu)
{
    var chuoi = "";
    tram = Math.floor(so / 100);
    so = so % 100;
    if (daydu || tram > 0) {
        chuoi = " " + mangso[tram] + " trăm";
        chuoi += dochangchuc(so, true);
    } else {
        chuoi = dochangchuc(so, false);
    }
    return chuoi;
}
function dochangtrieu(so, daydu)
{
    var chuoi = "";
    trieu = Math.floor(so / 1000000);
    so = so % 1000000;
    if (trieu > 0) {
        chuoi = docblock(trieu, daydu) + " triệu";
        daydu = true;
    }
    nghin = Math.floor(so / 1000);
    so = so % 1000;
    if (nghin > 0) {
        chuoi += docblock(nghin, daydu) + " nghìn";
        daydu = true;
    }
    if (so > 0) {
        chuoi += docblock(so, daydu);
    }
    return chuoi;
}
function docso(so)
{
    if (so == 0)
        return mangso[0];
    var chuoi = "", hauto = "";
    do {
        ty = so % 1000000000;
        so = Math.floor(so / 1000000000);
        if (so > 0) {
            chuoi = dochangtrieu(ty, true) + hauto + chuoi;
        } else {
            chuoi = dochangtrieu(ty, false) + hauto + chuoi;
        }
        hauto = " tỷ";
    } while (so > 0);
    return chuoi + ' đồng';
}

function numberFormat(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

function numberFormatDecode(num) {
    return num.toString().replace(/,/g, "");
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