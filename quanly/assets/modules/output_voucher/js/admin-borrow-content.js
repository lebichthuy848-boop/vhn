function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

function debounce(func, wait) {
    var timeout;

    return function() {
        var context = this,
            args = arguments;

        var executeFunction = function() {
            func.apply(context, args);
        };

        clearTimeout(timeout);
        timeout = setTimeout(executeFunction, wait);
    };
}

tblAppendGrid = 'tblAppendGrid';
products_selected = [];
products_options = [];
rowIndexProcessing = 0;
$(function() {
    $('#' + tblAppendGrid).appendGrid({
        caption: 'PHIẾU XUẤT',
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
                        'style': 'width: 300px;',
                        'class': 'select_on_change'
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
                name: "image",
                display: "Hình ảnh",
                type: "custom",
                customBuilder: function(parent, idPrefix, name, uniqueIndex) {
                    var ctrlId = idPrefix + '_' + name + '_' + uniqueIndex;
                    var ctrl = document.createElement('img');
                    $(ctrl).attr({
                        'id': ctrlId,
                        'name': ctrlId,
                        'src': base_url + 'uploads/products/no-image-icon.png',
                        'style': 'width: 37px; height: 21px;',
                        'class': 'img-responsive'
                    }).appendTo(parent);
                    $(ctrl).closest('td').addClass('text-center');

                    return ctrl;
                },
                customGetter: function(idPrefix, name, uniqueIndex) {
                    // console.log('abc');
                    // console.log($('#' + idPrefix + '_' + name + '_' + uniqueIndex).attr('src'));
                    return $('#' + idPrefix + '_' + name + '_' + uniqueIndex).attr('src');
                },
                customSetter: function(idPrefix, name, uniqueIndex, value) {
                    // console.log('src:' + value);
                    $('#' + idPrefix + '_' + name + '_' + uniqueIndex).attr('src', value);
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
                        'style': 'width: 185px;',
                        'class': 'warehouse_id_on_change'
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
                ctrlAttr: { maxlength: 80, readonly: 'readonly' },
                ctrlCss: { width: '100px', 'text-align': 'center' },
                value: ''
            },
            {
                name: 'quantity',
                display: 'Số lượng',
                displayCss: { 'text-align': 'center' },
                type: 'text',
                ctrlAttr: { maxlength: 50, min: 1, class: 'quantity-auto-focus'},
                ctrlCss: { 'text-align': 'right' },
                value: 1,
                onChange: function(evt, rowIndex) {
                    // changeValidateQuantity(rowIndex);
                    //changeValueRowIndex(rowIndex);
                }
            },
            {
                name: 'unit_price',
                display: 'Đơn giá',
                displayCss: { 'text-align': 'center' },
                type: 'text',
                ctrlAttr: { maxlength: 100, readonly: 'readonly', class: 'mask-number' },
                ctrlCss: { 'text-align': 'right' },
                value: 0
            },
            {
                name: 'price_discount_percent',
                display: '%',
                displayCss: { 'text-align': 'center' },
                type: 'text',
                ctrlAttr: { maxlength: 100, class: 'price-discount-percent' },
                ctrlCss: { 'text-align': 'right', width: '50px' },
                value: 0
            },
            {
                name: 'price_discount',
                display: 'Ck',
                displayCss: { 'text-align': 'center' },
                type: 'text',
                ctrlAttr: { maxlength: 100, class: 'price-discount mask-number-not-reverse' },
                ctrlCss: { 'text-align': 'right', width: '80px' },
                value: 0
            },
            {
                name: 'monetized',
                display: 'Thành tiền',
                displayCss: { 'text-align': 'center', 'color': '#ff0000' },
                type: 'text',
                ctrlAttr: { maxlength: 100, readonly: 'readonly', class: 'mask-number-not-reverse' },
                ctrlCss: { 'text-align': 'right' },
                value: 0
            }
        ],
        initData: product_init,
        beforeRowRemove: function(caller, rowIndex) {
            var bool = confirm("Bạn có muốn bỏ sản phẩm này khỏi đơn hàng?");
            if (bool) {
                var data = $('#' + tblAppendGrid).appendGrid('getAllValue');
                if(data.length == 1) {
                    alert('Không thể xóa sản phẩm này!');
                    return false;
                }
            }
            return bool;
        },
        afterRowRemoved: function(caller, rowIndex) {
            setTotal();
        }
    });

    if ($('#id').length) {
        openLastChosen();
    } else {
    	var customer_id = $('#customer_id').val();
        if (customer_id == 0) {
            alert('Vui lòng chọn khách hàng!');
            openCustomerChosen();
            return false;
        }else{
        	 openLastChosen();
        }
    }
});


function createOption(value, text) {
    let option = document.createElement('option');
    option.text = text;
    option.value = value;
    return option;
}

$(document).ready(function() {
    $('.mask-number-not-reverse').mask('000,000,000.0', { reverse: true });
    $('.mask-number').mask('000,000,000', { reverse: true });

    $(".chosen-select").chosen({ enable_split_word_search: false });
    $(".chosen-select-enable-search").chosen({ search_contains: true });

    setTotal();
});

$(document).on('submit', '#f-content', function() {
    var customer_id = $('#customer_id').val();
    if (customer_id == 0) {
        alert('Vui lòng chọn khách hàng!');
        openCustomerChosen();
        return false;
    }
    //check quantity
    var id = 0;
    if ($('#id').length) {
        id = $('#id').val();
    }
    removeEmptyRows();

    /*
    var data_append_grid = $('#tblAppendGrid').appendGrid('getAllValue');
    var str_err = '';
    var warehouse_id = 0;//parseInt($('#warehouse_id').val());
    for (var i = 0; i < data_append_grid.length; i++) {
        var is_err = $.trim(quantityCheck(id, data_append_grid[i]['product_id'], warehouse_id, data_append_grid[i]['quantity']));
        if (is_err != '') {
            str_err += 'Số lượng ' + is_err + ' đã vượt quá số lượng trong kho\n';
        }
    }
    if ($.trim(str_err) != '') {
        alert(str_err);
        appendRow();
        return false;
    }
    */

    var count = $('#' + tblAppendGrid).appendGrid('getRowCount');
    var strURL = base_url + 'phieu-xuat/them-ajax';
    var data = $(document.forms[0]).serialize() + '&' + $.param({ 'count': count });
    console.log(data);
    // return false;
    
    $.ajax({
        url: strURL,
        type: 'POST',
        cache: false,
        data: data,
        dataType: 'json',
        beforeSend: function(){
            $('#processing-modal').modal('show');
        },
        success: function(response) {
            if (response.status == 'success') {
                window.location.href = response.content.data;
            }else{
                alert(response.message);
            }
        },
        error: function(e) {
            console.log('Lỗi: ' + e.responseText);
        },
        complete: function(){
            $('#processing-modal').modal('hide');
        }
    });

    return false;
});

$(document).on('keydown blur', '#discount_percent', function() {
    setTotal();
});

$(document).on('keydown blur', '#cash', function() {
    setTotal();
});

$(document).on('change', '.select_on_change', function() {
    var attr_id = $(this).attr('id');
    var attr_arr = attr_id.split("_");
    var uniqueIndex = attr_arr[attr_arr.length - 1];
    var rowIndex = $('#' + tblAppendGrid).appendGrid('getRowIndex', uniqueIndex);
    //console.log('rowIndex: ' + rowIndex);
    var el_parent = $(this).closest('tr');
    var id = $('#' + tblAppendGrid).appendGrid('getCtrlValue', 'product_id', rowIndex);
    // var id = $(this).val();
    if (id == 0) {
        return false;
    }

    var customer_id = $('#customer_id').val();
    if (customer_id == 0) {
        alert('Vui lòng chọn khách hàng!');
        openCustomerChosen();
        return false;
    }

    var warehouse_id = $('#' + tblAppendGrid).appendGrid('getCtrlValue', 'warehouse_id', rowIndex);
    // var price_type = $('#' + tblAppendGrid).appendGrid('getCtrlValue', 'price_type', rowIndex);
    var price_type = 'retail_price';
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    var data = {
        'id': id,
        'warehouse_id': warehouse_id,
        'price_type': price_type
    };
    console.log(data);
    $.ajax({
        url: base_url + 'products/get-details-ajax',
        type: 'POST',
        cache: false,
        data: data,
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.status != 'success') {
                removeA(products_options, id);
                // alert('Sản phẩm này không khả dụng trong kho!');
                alert(response.message);
                removeRow(rowIndex);
                appendRow();
                return false;
            }

            var content = response.content;
            var unit_price = parseFloat(numberFormatDecode(content.price));
            el_parent.find('img').attr('src', content.image);
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'unit', rowIndex, content.unit);
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'unit_price', rowIndex, numberFormat(unit_price));

            changeValidateRow(rowIndex);
            changeValueRowIndex(rowIndex);
            setTotal();
            appendRow();
            el_parent.find('.quantity-auto-focus').focus();
        },
        error: function(e) {
            console.log('Lỗi: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('change', '.warehouse_id_on_change', function() {
    var attr_id = $(this).attr('id');
    var attr_arr = attr_id.split("_");
    var uniqueIndex = attr_arr[attr_arr.length - 1];
    var rowIndex = $('#' + tblAppendGrid).appendGrid('getRowIndex', uniqueIndex);
    //console.log('rowIndex: ' + rowIndex);

    var customer_id = $('#customer_id').val();
    if (customer_id == 0) {
        alert('Vui lòng chọn khách hàng!');
        openCustomerChosen();
        return false;
    }

    var el_parent = $(this).closest('tr');
    var id = $('#' + tblAppendGrid).appendGrid('getCtrlValue', 'product_id', rowIndex);
    if (id == 0) {
        alert('Vui lòng chọn sản phẩm!');
        el_parent.find('.select_on_change').chosen().trigger('chosen:open');
        return false;
    }

    changeValidateQuantity(rowIndex);
});

$(document).on('keypress', '.quantity-auto-focus', function(event){
    var keycode = event.keyCode ? event.keyCode : event.which;
    if(keycode == '13'){
        openLastChosen();
        event.stopPropagation();
        return false;
    }else if (!(keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57))) {
        event.preventDefault();
    }
});

/*$(document).on('change', '.price_type_on_change', function() {
    var attr_id = $(this).attr('id');
    var attr_arr = attr_id.split("_");
    var uniqueIndex = attr_arr[attr_arr.length - 1];
    var rowIndex = $('#' + tblAppendGrid).appendGrid('getRowIndex', uniqueIndex);
    //console.log('rowIndex: ' + rowIndex);
    var id = $('#' + tblAppendGrid).appendGrid('getCtrlValue', 'product_id', rowIndex);
    if (id == 0) {
        return false;
    }

    var customer_id = $('#customer_id').val();
    if (customer_id == 0) {
        alert('Vui lòng chọn khách hàng!');
        openCustomerChosen();
        return false;
    }

    var price_type = $(this).val();
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    var data = {
        'id': id,
        'price_type': price_type
    };
    $.ajax({
        url: base_url + 'products/ajax_get',
        type: 'POST',
        cache: false,
        data: data,
        dataType: 'json',
        success: function(response) {
            let response_content_warehouse = response.content.warehouse;
            if ($.trim(response_content_warehouse) == '') {
                removeA(products_options, id);
                alert('Sản phẩm này không khả dụng trong kho!');
                removeRow(rowIndex);
                appendRow();
                return false;
            }

            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'unit', rowIndex, response.content.unit);
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'unit_price', rowIndex, numberFormat(response.content.price));
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, numberFormat(quantity * parseFloat(response.content.price)));
            changeValidateRow(rowIndex);
            setTotal();
            appendRow();
        },
        error: function(e) {
            console.log('Lỗi: ' + e.responseText);
        }
    });
    return false;
});*/

function changeValidateRow(rowIndex) {
    let product_id_current = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'product_id', rowIndex));

    var checkErrors = -1;
    var count = $('#' + tblAppendGrid).appendGrid('getRowCount');
    for (var z = 0; z < count; z++) {
        let product_id = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'product_id', z));
        if(product_id === product_id_current){
            checkErrors++;
        }
    }
    if(checkErrors > 0){
        alert('Sản phẩm này đã tồn tại. Vui lòng chọn sản phẩm khác!');
        removeRow(rowIndex);
    }
}

function changeValidateQuantity(rowIndex) {
    var id = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'product_id', rowIndex));
    var warehouse_id = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'warehouse_id', rowIndex));
    // var warehouse_id = parseInt($('#warehouse_id').val());
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    var strURL = base_url + 'products/validate-quantity-ajax';
    var data = {
        'id': id,
        'warehouse_id': warehouse_id,
        'quantity': quantity
    };
    // console.log(data);
    // return false;
    var timeout;
    var processing = false;
    timeout = setTimeout(function() {
        if (!processing) {
            $.ajax({
                url: strURL,
                type: 'POST',
                cache: false,
                data: data,
                dataType: 'json',
                success: function(response) {
                    //console.log(response);
                    if (response.status != 'success') {
                        alert(response.message);
                        return false;
                    }
                    changeValueRowIndex(rowIndex);
                },
                error: function(e) {
                    console.log('Lỗi: ' + e.responseText);
                }
            });
        }
    }, 300);

    return false;
}

function changeValueRowIndex(rowIndex) {
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    if (isNaN(quantity)) {
        quantity = 1;
    }
    var unit_price = parseFloat(numberFormatDecode($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'unit_price', rowIndex)));
    if (isNaN(unit_price)) {
        unit_price = 0;
    }
    var discount = parseFloat(numberFormatDecode($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'price_discount', rowIndex)));
    if (isNaN(discount)) {
        discount = 0;
    }
    var monetized = quantity * (unit_price - discount);
    $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, numberFormat(monetized));
    $('.mask-number').mask('000,000,000', { reverse: true });
    setTotal();
}

function changeValueTotal(rowIndex) {
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    var unit_price = parseFloat(numberFormatDecode($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'unit_price', rowIndex)));
    $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, numberFormat(quantity * unit_price));
    setTotal();
}

function openLastChosen() {
    $('.select_on_change').last().chosen().trigger('chosen:open');
}

function openCustomerChosen() {
    $('#customer_id').chosen().trigger('chosen:open');
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
    var run = debounce(function () {
        var total_number = 0;
        var data = $('#' + tblAppendGrid).appendGrid('getAllValue');
        for (var i = 0; i < data.length; i++) {
            var monetized = parseFloat(numberFormatDecode(data[i].monetized));
            if (isNaN(monetized)) {
                monetized = 0;
            }
            total_number += monetized;
        }

        var discount_percent = parseFloat($('#discount_percent').val());
        if (isNaN(discount_percent)) {
            discount_percent = 0;
        }
        var total_VAT_number = Math.round(total_number * (1 - parseFloat(discount_percent/100)));
        // console.log(total_VAT_number);
        var total_number_current = total_VAT_number;
        var cash_value = numberFormatDecode($('#cash').val());
        var cash = parseFloat(numberFormatDecode($('#cash').val()));
        if(isNaN(cash)){
            cash = 0;
        }
        if (cash == 0) {
            $('#change').val(0);
            $('#prepaid').val(0);
        } else if (cash == total_number_current) {
            $('#change').val(0);
            $('#prepaid').val(numberFormat(total_number));
        }else if(cash > total_VAT_number){
            $('#change').val(numberFormat(cash - total_VAT_number));
            $('#prepaid').val(numberFormat(total_VAT_number));
        }else{
            $('#change').val(0);
            $('#prepaid').val(numberFormat(cash));
        }
        if(cash > total_VAT_number){
            $('#remainder').val(0);
        }else{
            var prepaid = parseFloat(numberFormatDecode($('#prepaid').val()));
            $('#remainder').val(numberFormat(Math.abs(total_VAT_number - prepaid)));
        }

        $('#total_number').text(numberFormat(total_number));
        $('#total_VAT_number').text(numberFormat(total_VAT_number));
        var total_VAT_text = $.trim(docso(total_VAT_number));
        total_VAT_text = capitalizeFirstLetter(total_VAT_text);
        $('#total_VAT_text').text(total_VAT_text);
    }, 500);
    run();
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
        return mangso[0] + ' đồng';
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

function quantityCheck(id, product_id, warehouse_id, quantity) {
    var product_name_quantity_availablity = ''; //neu khac rong thi vuot qua so luong

    var data = { 'id': id, 'product_id': product_id, 'quantity': quantity, 'ajax': 1 };
    //console.log(data);
    $.ajax({
        url: base_url + 'products/check_quantity_availablity',
        type: 'POST',
        async: false,
        data: data,
        success: function(response) {
            //console.log(response);
            var getData = $.parseJSON(response);
            console.log(getData);
            if (getData.status === 'danger') {
                product_name_quantity_availablity = getData.content.name;
            }
        }
    });

    return product_name_quantity_availablity;
}

$('#customer-modal').on('show.bs.modal', function(event) {
    $('#f-customer')[0].reset();
});

$(document).on('submit', '#f-customer', function(event) {
    event.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: base_url + 'customers/ajax_admin_add',
        data: formData,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.status == 'success') {
                $('#customer-modal').modal('hide');
                $('#customer_id').html(response.content);
                $('#customer_id').chosen().trigger("chosen:updated");
                $('#customer_id').trigger('change');
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('keyup', '.price-discount', debounce(function(e){
    var attr_id = $(this).attr('id');
    var attr_arr = attr_id.split("_");
    var uniqueIndex = attr_arr[attr_arr.length - 1];
    var rowIndex = $('#' + tblAppendGrid).appendGrid('getRowIndex', uniqueIndex);

    var unit_price = parseFloat(numberFormatDecode($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'unit_price', rowIndex)));

    //validate value input
    var max = unit_price;
    var min = 0;
    var value = parseFloat(numberFormatDecode($(this).val()));
    if (isNaN(value)) {
        value = 0;
    }
    if (value > max) {
        this.value = numberFormat(max);
    } else if (value <= min) {
        this.value = min;
    }

    var discount = parseFloat(numberFormatDecode($(this).val()));
    if (isNaN(discount)) {
        discount = 0;
    }
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    if (isNaN(quantity) || quantity == 0) {
        quantity = 1;
    }
    var monetized = quantity * (unit_price - discount);
    var percent = parseFloat((discount / unit_price) * 100);
    percent = Math.round((percent + Number.EPSILON) * 100) / 100;

    // console.log(percent);
    $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'price_discount_percent', rowIndex, percent);

    changeValueRowIndex(rowIndex);
},1000));

$(document).on('keyup', '.price-discount-percent', debounce(function(e){
    var attr_id = $(this).attr('id');
    var attr_arr = attr_id.split("_");
    var uniqueIndex = attr_arr[attr_arr.length - 1];
    var rowIndex = $('#' + tblAppendGrid).appendGrid('getRowIndex', uniqueIndex);

    //validate value input
    var max = 100;
    var min = 0;
    var value = parseFloat(numberFormatDecode($(this).val()));
    if (isNaN(value)) {
        value = 0;
    }
    if (value > max) {
        this.value = numberFormat(max);
    } else if (value <= min) {
        this.value = min;
    }

    var percent = parseFloat($(this).val());
    if (isNaN(percent)) {
        percent = 0;
    }
    var unit_price = parseFloat(numberFormatDecode($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'unit_price', rowIndex)));
    if (isNaN(unit_price)) {
        unit_price = 0;
    }
    var discount = (unit_price * percent / 100);
    discount = Math.round((discount + Number.EPSILON) * 100) / 100;//làm tròn số và bỏ sai số
    $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'price_discount', rowIndex, numberFormat(discount));

    changeValueRowIndex(rowIndex);
},500));

$(document).on('keyup', '.quantity-auto-focus', debounce(function(e){
    var attr_id = $(this).attr('id');
    var attr_arr = attr_id.split("_");
    var uniqueIndex = attr_arr[attr_arr.length - 1];
    var rowIndex = $('#' + tblAppendGrid).appendGrid('getRowIndex', uniqueIndex);

    var max = 1000000000;
    var min = 1;
    var value = parseInt($(this).val());
    if (isNaN(value)) {
        value = 0;
    }
    if (value > max) {
        this.value = max;
    } else if (value <= min) {
        this.value = min;
    }

    changeValidateQuantity(rowIndex);
    // changeValueRowIndex(rowIndex);
}, 500));