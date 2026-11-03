$(function () {
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
                    }).appendTo(parent).chosen();
                    return ctrl;
                },
                customGetter: function (idPrefix, name, uniqueIndex) {
                    return $('#' + idPrefix + '_' + name + '_' + uniqueIndex).chosen().val();
                },
                customSetter: function (idPrefix, name, uniqueIndex, value) {
                    $('#' + idPrefix + '_' + name + '_' + uniqueIndex).val(value).trigger('chosen:updated');
                }
            },
            {name: 'unit', display: 'Đơn vị tính', type: 'text', ctrlAttr: {maxlength: 100}, ctrlCss: {width: '110px'}},
            {name: 'quantity', display: 'Số lượng', type: 'number', ctrlAttr: {maxlength: 100}, ctrlCss: {width: '70px', 'text-align': 'right'}, value: 1},
            {name: 'note', display: 'Ghi chú', type: 'text', ctrlAttr: {maxlength: 100}, ctrlCss: {width: '120px'}}
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

$(document).ready(function () {
    //$('#processing-modal').modal('show');

    $('#f-content').on('submit', function (e) {
        e.preventDefault();
        var count = $('#tblAppendGrid').appendGrid('getRowCount');

        var strURL = base_url + 'muon-hang/them-ajax';
        var data = $(document.forms[0]).serialize();
        data = data + '&' + $.param({'count': count});
        $.ajax({
            url: strURL,
            type: 'POST',
            cache: false,
            data: data,
            dataType: 'json',
            success: function (response) {
                //$('#processing-modal').modal('hide');
                alert(response.message);
                if (response.status == 'success') {
                    window.location.href = response.content.data;
                }
            },
            error: function (e) {
                //$('#processing-modal').modal('hide');
                console.log('Lỗi: ' + e.responseText);
            }
        });

        return false;
    });

    $('#start_date').datepicker({
        onSelect: function () {
            var start_date = $(this).val();
            if (start_date == '') {
                return false;
            }

            var strURL = base_url + 'muon-hang/get-end-date-ajax';
            var data = {'start_date': start_date};
            $.ajax({
                url: strURL,
                type: 'POST',
                cache: false,
                data: data,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        $('#end_date').val(response.content.data);
                    }
                },
                error: function (e) {
                    console.log('Lỗi: ' + e.responseText);
                }
            });

            return false;
        }
    });
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
                    $('#address').val(response.content.data.address);
                    $('#phone').val(response.content.data.phone);
                    $('.info-customer').removeClass('hide');
                }else{
                    $('.info-customer').addClass('hide');
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