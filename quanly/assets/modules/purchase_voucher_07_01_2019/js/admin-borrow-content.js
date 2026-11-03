tblAppendGrid = 'tblAppendGrid';
products_selected = [];
products_options = [];
$(function() {
    $('#tblAppendGrid').appendGrid({
        caption: 'PHIẾU NHẬP',
        initRows: 1,
        columns: [{
                name: 'product_id',
                display: 'Sản phẩm',
                type: 'custom',
                customBuilder: function(parent, idPrefix, name, uniqueIndex) {
                    var ctrlId = idPrefix + '_' + name + '_' + uniqueIndex;
                    var ctrl = document.createElement('select');
                    $.each(products, function(key, val) {
                        ctrl.add(createOption(key, val));
                    });
                    $(ctrl).attr({
                        'id': ctrlId,
                        'name': ctrlId,
                        'class': 'select_on_change',
                        'style': 'width: 285px;'
                    }).appendTo(parent).chosen({ enable_split_word_search: false });

                    $('<button>', { type: 'button', style: 'height: 22px; width: 32px; float: right; margin-top: -23px;margin-left: 26px;', "data-toggle": "modal", "data-target": "#product-modal", class: 'ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only append product_add', id: ctrlId + '_add' }).button({
                        icons: {
                            primary: "ui-icon-plusthick",
                        }
                    }).appendTo(parent);

                    return ctrl;
                },
                customGetter: function(idPrefix, name, uniqueIndex) {
                    return $('#' + idPrefix + '_' + name + '_' + uniqueIndex).chosen().val();
                },
                customSetter: function(idPrefix, name, uniqueIndex, value) {
                    $('#' + idPrefix + '_' + name + '_' + uniqueIndex).val(value).trigger('chosen:updated');
                }
            },
            {
                name: 'warehouse_id',
                display: 'Kho hàng',
                displayCss: { 'text-align': 'center' },
                type: 'custom',
                customBuilder: function(parent, idPrefix, name, uniqueIndex) {
                    var ctrlId = idPrefix + '_' + name + '_' + uniqueIndex;
                    var ctrl = document.createElement('select');
                    $.each(warehouse, function(key, val) {
                        ctrl.add(createOption(key, val));
                    });
                    $(ctrl).attr({
                        'id': ctrlId,
                        'name': ctrlId,
                        'style': 'width: 185px;'
                    }).appendTo(parent).chosen({ enable_split_word_search: false });
                    return ctrl;
                },
                customGetter: function(idPrefix, name, uniqueIndex) {
                    return $('#' + idPrefix + '_' + name + '_' + uniqueIndex).chosen().val();
                },
                customSetter: function(idPrefix, name, uniqueIndex, value) {
                    $('#' + idPrefix + '_' + name + '_' + uniqueIndex).val(value).trigger('chosen:updated');
                }
            },
            {
                name: 'unit',
                display: 'Đơn vị tính',
                displayCss: { 'text-align': 'center' },
                type: 'text',
                ctrlAttr: { maxlength: 100, readonly: 'readonly' },
                ctrlCss: { width: '120px', 'text-align': 'center' },
                value: '',
                onChange: function(evt, rowIndex) {
                    changeValueRowIndex(rowIndex);
                }
            },
            {
                name: 'quantity',
                display: 'Số lượng',
                displayCss: { 'text-align': 'center' },
                type: 'number',
                ctrlAttr: { maxlength: 100, min: 0 },
                ctrlCss: { width: '65px', 'text-align': 'right' },
                value: 1,
                onChange: function(evt, rowIndex) {
                    changeValueRowIndex(rowIndex);
                }
            },
            {
                name: 'unit_price',
                display: 'Đơn giá',
                displayCss: { 'text-align': 'center' },
                type: 'text',
                ctrlAttr: { maxlength: 100, step: 1000, min: 0 },
                ctrlCss: { width: '130px', 'text-align': 'right' },
                value: 0,
                onChange: function(evt, rowIndex) {
                    changeValueRowIndex(rowIndex);
                }
            },
            {
                name: 'monetized',
                display: 'Thành tiền',
                displayCss: { 'text-align': 'center', 'color': '#ff0000' },
                type: 'text',
                ctrlAttr: { maxlength: 100, readonly: 'readonly' },
                ctrlCss: { width: '130px', 'text-align': 'right' },
                value: 0
            },
            {
                name: 'provider_id',
                display: 'Nhà CC',
                displayCss: { 'text-align': 'center' },
                type: 'custom',
                customBuilder: function(parent, idPrefix, name, uniqueIndex) {
                    var ctrlId = idPrefix + '_' + name + '_' + uniqueIndex;
                    var ctrl = document.createElement('select');
                    $.each(provider, function(key, val) {
                        ctrl.add(createOption(key, val));
                    });
                    $(ctrl).attr({
                        'id': ctrlId,
                        'name': ctrlId,
                        'style': 'width: 200px;'
                    }).appendTo(parent).chosen({ enable_split_word_search: false });
                    return ctrl;
                },
                customGetter: function(idPrefix, name, uniqueIndex) {
                    return $('#' + idPrefix + '_' + name + '_' + uniqueIndex).chosen().val();
                },
                customSetter: function(idPrefix, name, uniqueIndex, value) {
                    $('#' + idPrefix + '_' + name + '_' + uniqueIndex).val(value).trigger('chosen:updated');
                }
            }
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

$(document).ready(function() {
    setTotal();

    $('#f-content').on('submit', function() {
        removeEmptyRows();
        var count = $('#tblAppendGrid').appendGrid('getRowCount');

        var strURL = base_url + 'phieu-nhap/them-ajax';
        var data = $(document.forms[0]).serialize() + '&' + $.param({ 'count': count });
        $('#processing-modal').modal('show');
        $.ajax({
            url: strURL,
            type: 'POST',
            cache: false,
            data: data,
            dataType: 'json',
            success: function(response) {
                $('#processing-modal').modal('hide');
                alert(response.message);
                if (response.status == 'success') {
                    window.location.href = response.content.data;
                }
            },
            error: function(e) {
                $('#processing-modal').modal('hide');
                console.log('Lỗi: ' + e.responseText);
            }
        });

        return false;
    });

    $(".chosen-select").chosen({ enable_split_word_search: false });
    openLastChosen();
});

$(document).on('change', '.select_on_change', function() {
    var attr_id = $(this).attr('id');
    var attr_arr = attr_id.split("_");
    var uniqueIndex = attr_arr[attr_arr.length - 1];
    var rowIndex = $('#' + tblAppendGrid).appendGrid('getRowIndex', uniqueIndex);

    var id = $(this).val();
    if (id == 0) {
        return false;
    }

    $('.select_on_change').not(this).each(function() {
        var $val = $(this).val();
        if (($val != 0) && !(jQuery.inArray($val, products_options) != -1)) {
            products_options.push($val);
        }
    });

    if (jQuery.inArray(id, products_options) != -1) {
        alert('Đã tồn tại sản phẩm này vui lòng chọn sản phẩm khác!');
        removeRow(rowIndex);
        appendRow();
        products_options = [];
        $('.select_on_change').each(function() {
            var $val = $(this).val();
            if (($val != 0) && !(jQuery.inArray($val, products_options) != -1)) {
                products_options.push($val);
            }
        });
        //console.log(products_options);
        setTotal();
        return false;
    } else {
        products_options.push(id);
        //console.log(products_options);
    }

    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex)); //lay gia tri cua cot

    var strURL = base_url + 'products/ajax_get';
    var data = { 'id': id };
    $.ajax({
        url: strURL,
        type: 'POST',
        cache: false,
        data: data,
        dataType: 'json',
        success: function(response) {
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'unit', rowIndex, response.content.unit); //set gia tri cua cot
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'unit_price', rowIndex, numberFormat(response.content.unit_price)); //set gia tri cua cot
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, numberFormat(quantity * parseFloat(response.content.unit_price))); //set gia tri cua cot
            setTotal();
            appendRow();
        },
        error: function(e) {
            console.log('Lỗi: ' + e.responseText);
        }
    });
    return false;
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

function openLastChosen() {
    //$('.select_on_change').last().chosen().trigger('chosen:open');
    $('.select_on_change').last().chosen().trigger('chosen:activate');
}

function removeEmptyRows() {
    var count = $('#' + tblAppendGrid).appendGrid('getRowCount');
    for (var i = 0; i < count; i++) {
        if ($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'product_id', i) == 0) {
            $('#' + tblAppendGrid).appendGrid('removeRow', i);
        }
    }
}

function removeRow(rowIndex) {
    $('#' + tblAppendGrid).appendGrid('removeRow', rowIndex);
}

function appendRow() {
    removeEmptyRows();
    $('#' + tblAppendGrid).appendGrid('appendRow', 1);
    openLastChosen();
}

function setTotal() {
    var total_number = 0;
    var data = $('#' + tblAppendGrid).appendGrid('getAllValue');
    for (var i = 0; i < data.length; i++) {
        total_number += parseFloat(numberFormatDecode(data[i].monetized));
    }
    var total_VAT_number = total_number;
    if (total_number > 0) {
        $('#total_VAT_number').text(numberFormat(total_VAT_number));

        var timeout;
        var processing = false;
        timeout = setTimeout(function() {
            if (!processing) {
                var total_VAT_text = $.trim(docso(total_VAT_number));
                total_VAT_text = capitalizeFirstLetter(total_VAT_text);
                $('#total_VAT_text').text(total_VAT_text);
            }
        }, 300);
        return false;
    }
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

mangso = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];

function dochangchuc(so, daydu) {
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
        chuoi += " " + mangso[donvi];
    }
    return chuoi;
}

function docblock(so, daydu) {
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

function dochangtrieu(so, daydu) {
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

function docso(so) {
    if (so == 0)
        return mangso[0];
    var chuoi = "",
        hauto = "";
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

$(document).on('click', '.product_add', function() {
    var select_on_change = $('.select_on_change');
    select_on_change.each(function(index) {
        $(this).removeClass('processing');
    });
    var $this = $(this).closest('td').find('.select_on_change');
    $this.addClass('processing');
    //rowIndexProcessing
    //$this.html('<option value="0">Sản phẩm</option>');
    //$this.chosen().trigger("chosen:updated");
    var attr_id = $(this).attr('id');
    var attr_arr = attr_id.split("_");
    var uniqueIndex = attr_arr[attr_arr.length - 2];

    var rowIndexProcessing = $('#' + tblAppendGrid).appendGrid('getRowIndex', uniqueIndex);
    console.log('rowIndexProcessing: ' + rowIndexProcessing);
});

$('#product-modal').on('show.bs.modal', function(event) {
    $('#f-product')[0].reset();
    $('#category_id').closest('.form-group').find('.chosen-container').removeAttr('style');
});

$(document).on('submit', '#f-product', function(event) {
    event.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: base_url + 'products/ajax_admin_add',
        data: formData,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.status == 'success') {
                $('#product-modal').modal('hide');

                var $this = $('.select_on_change.processing');
                $this.html(response.content);
                $this.chosen().trigger("chosen:updated");
                $this.trigger('change');
                $this.addClass('processing');

                //var $this = $(this).closest('td').find('.select_on_change');
                //$('#' + tblAppendGrid).appendGrid('setCtrlValue', 'product_id', rowIndexProcessing, response.content);
                //$('.select_on_change').chosen().trigger("chosen:updated");
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});