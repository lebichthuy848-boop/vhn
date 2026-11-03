tblAppendGrid = 'tblAppendGrid';
products_selected = [];
products_options = [];
rowIndexProcessing = 0;
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
                    }).appendTo(parent).chosen({enable_split_word_search: false});
					
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
				displayCss: { 'text-align': 'center' },
                type: 'text',
                ctrlAttr: {maxlength: 150, readonly: 'readonly'},
                ctrlCss: {width: '100px', 'text-align': 'center'},
                value: '',
                onChange: function (evt, rowIndex) {
                    changeValueRowIndex(rowIndex);
                }
            },
            {
                name: 'quantity',
                display: 'Số lượng',
				displayCss: { 'text-align': 'center' },
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
                display: 'Đơn giá (-VAT)',
				displayCss: { 'text-align': 'center' },
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
                display: 'CK (%)',
				displayCss: { 'text-align': 'center' },
                type: 'text',
                ctrlAttr: {max: 100, min: 0},
                ctrlCss: {'text-align': 'right'},
                value: 0,
                onChange: function (evt, rowIndex) {
                    changeValueRowIndex(rowIndex);
                }
            },
            {
				name: 'monetized',
				display: 'Thành tiền (-VAT)',
				displayCss: { 'text-align': 'center', 'color': '#ff0000' },
				type: 'text',
				ctrlAttr: {maxlength: 100, readonly: 'readonly'},
				ctrlCss: {'text-align': 'right'},
				value: 0
			}
        ],
        initData: product_init
    });
	
	if ($('#id').length) {
		openLastChosen();
	}else{
		openCustomerChosen();
	}
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
		var customer_id = $('#customer_id').val();
		if (customer_id == 0) {
			alert('Vui lòng chọn khách hàng!');
			return false;
		}
        //check quantity
        var id = 0;
        if ($('#id').length) {
            id = $('#id').val();
        }
		removeEmptyRows();
		
        var data_append_grid = $('#tblAppendGrid').appendGrid('getAllValue');
        var str_err = '';
        for (var i = 0; i < data_append_grid.length; i++) {
            var is_err = $.trim(quantityCheck(id, data_append_grid[i]['product_id'], data_append_grid[i]['quantity']));
            if (is_err != '') {
                str_err += 'Số lượng ' + is_err + ' đã vượt quá số lượng trong kho\n';
            }
        }
        if ($.trim(str_err) != '') {
            alert(str_err);
			appendRow();
            return false;
        }

        var count = $('#' + tblAppendGrid).appendGrid('getRowCount');

        var strURL = base_url + 'bao-gia/them-ajax';
        var data = $(document.forms[0]).serialize() + '&' + $.param({'count': count});
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

    $(".chosen-select").chosen({enable_split_word_search: false});	
});

$(document).on('change', '.select_on_change', function () {
	var attr_id = $(this).attr('id');
	var attr_arr = attr_id.split("_");
	var uniqueIndex = attr_arr[attr_arr.length - 1];	
	
    var rowIndex = $('#' + tblAppendGrid).appendGrid('getRowIndex', uniqueIndex);
	//console.log('rowIndex: ' + rowIndex);
    var customer_id = $('#customer_id').val();
    var id = $(this).val();
    if (id == 0 ) {
        return false;
    }
	
	if (customer_id == 0) {
		alert('Vui lòng chọn khách hàng!');
        return false;
    }

    $('.select_on_change').not(this).each(function(){
		var $val = $(this).val();
		if(($val != 0) && !(jQuery.inArray($val, products_options) != -1)){
			products_options.push($val);
		}
	});
	
	if(jQuery.inArray(id, products_options) != -1) {
		alert('Đã tồn tại sản phẩm này vui lòng chọn sản phẩm khác!');
		removeRow(rowIndex);
		appendRow();
		products_options = [];
		$('.select_on_change').each(function(){
			var $val = $(this).val();
			if(($val != 0) && !(jQuery.inArray($val, products_options) != -1)){
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
	
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
	
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
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'unit_price', rowIndex, numberFormat(response.content.price));
            $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, numberFormat(quantity * parseFloat(response.content.price)));
            setTotal();
			appendRow();
        },
        error: function (e) {
            console.log('Lỗi: ' + e.responseText);
        }
    });
    return false;
});

function changeValueRowIndex(rowIndex) {
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    var unit_price = parseFloat(numberFormatDecode($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'unit_price', rowIndex)));
    var discount = parseFloat(numberFormatDecode($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'discount', rowIndex)));
    $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, numberFormat(quantity * unit_price * (1 - discount/100)));
    setTotal();
}

function changeValueTotal(rowIndex) {
    var quantity = parseInt($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'quantity', rowIndex));
    var unit_price = parseFloat(numberFormatDecode($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'unit_price', rowIndex)));
    $('#' + tblAppendGrid).appendGrid('setCtrlValue', 'monetized', rowIndex, numberFormat(quantity * unit_price));
    setTotal();
}

function openLastChosen(){
	$('.select_on_change').last().chosen().trigger('chosen:open');
}

function openCustomerChosen(){
	$('#customer_id').chosen().trigger('chosen:open');
}

function removeEmptyRows(){
	var count = $('#' + tblAppendGrid).appendGrid('getRowCount');
	for (var i = 0; i < count; i++) {
		if($('#' + tblAppendGrid).appendGrid('getCtrlValue', 'product_id', i) == 0){
			$('#' + tblAppendGrid).appendGrid('removeRow', i);
		}
	}
}

function removeRow(rowIndex){	
	$('#' + tblAppendGrid).appendGrid('removeRow', rowIndex);
}

function appendRow(){
	removeEmptyRows();	
	$('#' + tblAppendGrid).appendGrid('appendRow', 1);
	openLastChosen();
}

function setTotal() {
    var total_number = 0;
    var data = $('#' + tblAppendGrid).appendGrid('getAllValue');
    for (var i = 0; i < data.length; i++) {
        var monetized = parseFloat(numberFormatDecode(data[i].monetized));
		if (isNaN(monetized)) {
			monetized = 0;
		}
        total_number += monetized;
    }
	
	var total_percent_VAT_number = total_number * parseFloat(10) / 100;//%
	var total_VAT_number = total_number + total_percent_VAT_number;//tổng
    if (total_number > 0) {
        $('#total_number').text(numberFormat(total_number));		
        $('#total_percent_VAT_number').text(numberFormat(total_percent_VAT_number));
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
    var product_name_quantity_availablity = '';//neu khac rong thi vuot qua so luong

    var strURL = base_url + 'products/check_quantity_availablity';
    var data = {'id': id, 'product_id': product_id, 'quantity': quantity, 'ajax': 1};
    $.ajax({
        url: strURL,
        type: 'POST',
        async: false,
        data: data,
        success: function (response) {
            var getData = $.parseJSON(response);
            if (getData.status === 'danger') {
                product_name_quantity_availablity = getData.content.name;
            }
        }
    });

    return product_name_quantity_availablity;
}

$('#customer-modal').on('show.bs.modal', function (event) {
    $('#f-customer')[0].reset();
});

$(document).on('submit', '#f-customer', function (event) {
    event.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: base_url + 'customers/ajax_admin_add',
        data: formData,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status == 'success') {
                $('#customer-modal').modal('hide');
                $('#customer_id').html(response.content);
                $('#customer_id').chosen().trigger("chosen:updated");
				$('#customer_id').trigger('change');
            }
        },
        error: function (e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('change', '#customer_id', function () {
	var id = $(this).val();
	if (id == 0) {
		return false;
	}
	reload_grid(id);	
	return false;
});

function reload_grid(customer_id){
	var data = $('#' + tblAppendGrid).appendGrid('getAllValue');
	var data_quantity = [];
	var data_discount = [];
	var product_ids = [];
	product_ids.push(0);
	for (var i = 0; i < data.length; i++) {
        product_ids.push(parseInt(data[i].product_id));
		data_quantity.push(parseInt(data[i].quantity));
		data_discount.push(data[i].discount);
    }
	
	var strURL = base_url + 'products/ajax_gets';
	var data = {
		'ids': product_ids.toString(),
		'customer_id': customer_id
	};
	$.ajax({
		url: strURL,
		type: 'POST',
		cache: false,
		data: data,
		dataType: 'json',
		success: function (response) {
			if (response.status == 'success') {
				$('#type').text(response.content.customer.type);
				$('#address').text(response.content.customer.address);
				$('#phone').text(response.content.customer.phone);
				$('#email').text(response.content.customer.email);				
				$('.info-customer').removeClass('hide');				
				
				var content = response.content.data;
				var content_length = content.length;
				if(content_length > 0){
					var product_reload = [];
					for (var i = 0; i < content_length; i++){
						var product_item = {};
						product_item['product_id'] = content[i]['id'];
						product_item['unit'] = content[i]['unit'];
						product_item['quantity'] = data_quantity[i];
						product_item['unit_price'] = numberFormat(parseFloat(content[i]['price']));
						product_item['monetized'] = numberFormat(parseInt(data_quantity[i]) * parseFloat(content[i]['price']));
						product_item['discount'] = data_discount[i];
						product_reload.push(product_item);
					}
					$('#' + tblAppendGrid).appendGrid('load', product_reload);
					setTotal();
				}
				appendRow();
				openLastChosen();
			} else {
				$('.info-customer').addClass('hide');
			}
		},
		error: function (e) {
			console.log('Lỗi: ' + e.responseText);
		}
	});
}

$(document).on('change', '#quotation_customer_id', function () {
	var customer_id = $(this).val();
	if (customer_id == 0) {
		//alert('Vui lòng chọn khách hàng!');
		return false;
	}
	var strURL = base_url + 'customers/ajax_admin_get';
	var data = {
		'id': customer_id
	};
	$.ajax({
		url: strURL,
		type: 'POST',
		cache: false,
		data: data,
		dataType: 'json',
		success: function (response) {
			if (response.status == 'success') {
				$('#quotation-type').text(response.content.type);
				$('#quotation-address').text(response.content.address);
				$('#quotation-phone').text(response.content.phone);
				$('#quotation-email').text(response.content.email);				
				$('.quotation-info-customer').removeClass('hide');
			} else {
				$('.quotation-info-customer').addClass('hide');
			}
		},
		error: function (e) {
			console.log('Lỗi: ' + e.responseText);
		}
	});
	return false;
});

$('#quotation-modal').on('show.bs.modal', function (event) {
    $('#f-quotation')[0].reset();
	$('.quotation-info-customer').addClass('hide');
	$('#quotation_customer_id').closest('.form-group').find('.chosen-container').css({"width": "300px", "max-width": "100%"});
});

$(document).on('submit', '#f-quotation', function (event) {
    event.preventDefault();
	var customer_id = $('#quotation_customer_id').val();
	if (customer_id == 0) {
		alert('Vui lòng chọn khách hàng!');
		return false;
	}
    var formData = {
		'customer_id': customer_id
	};
    $.ajax({
        url: base_url + 'products/ajax_export_excel',
        data: formData,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
			if (response.status == 'success') {
                $('#quotation-modal').modal('hide');
            }
			var $a = $("<a>");
			$a.attr("href",response.file);
			$("body").append($a);
			$a.attr("download", response.file_name);
			$a[0].click();
			$a.remove();
        },
        error: function (e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});