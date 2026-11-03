//<![CDATA[
$(document).ready(function() {
    $('.delete_bootbox').on('click', function(e, confirmed) {
        var link = $(this).attr('href');
        if (!confirmed) {
            e.preventDefault();
            BootstrapDialog.confirm({
                title: 'XÁC NHẬN THÔNG TIN',
                message: 'Bạn có thật sự muốn xóa phiếu xuất này?',
                type: BootstrapDialog.TYPE_DANGER,
                closable: true,
                draggable: true,
                btnCancelLabel: 'Hủy bỏ',
                btnOKLabel: 'Đồng ý',
                btnOKClass: 'btn-primary',
                callback: function(result) {
                    if (result) {
                        window.location.href = link;
                    }
                }
            });
        }
    });

    $('#datePickerFromday').datepicker({
        format: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true,
        startDate: "01-01-1970"
    });

    $('#datePickerToday').datepicker({
        format: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true,
        startDate: "01-01-1970"
    });
});

$(document).on('click', '.order-status', function (event) {
    var $this = $(this).closest('.order-status-container');
    var id = parseInt($this.attr('data-id'));
    if(id == 0){
        return false;
    }
    var status = parseInt($(this).attr('data-status'));
    var status_text = $(this).text();
    var data = {
        'id': id,
        'status': status
    };
    // console.log(data);
    $('#notify').html('Đang xử lý...').fadeIn(5000);
    $.ajax({
        url: base_url + 'phieu-xuat/change-order-status-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            $("#notify").html(response.message);
            if (response.status === 'success') {
                var el_button = $this.find('button');
                el_button.text(status_text);
                el_button.removeClass("btn-success btn-danger btn-default btn-warning btn-info").addClass("btn-" + response.content);
                $this.trigger('click');
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('click', '.delivery-status', function (event) {
    var $this = $(this).closest('.delivery-status-container');
    var id = parseInt($this.attr('data-id'));
    if(id == 0){
        return false;
    }
    var status = parseInt($(this).attr('data-status'));
    var status_text = $(this).text();
    var data = {
        'id': id,
        'status': status
    };
    // console.log(data);
    $('#notify').html('Đang xử lý...').fadeIn(5000);
    $.ajax({
        url: base_url + 'phieu-xuat/change-delivery-status-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            $("#notify").html(response.message);
            if (response.status === 'success') {
                var el_button = $this.find('button');
                el_button.text(status_text);
                el_button.removeClass("btn-success btn-danger btn-default btn-warning btn-info").addClass("btn-" + response.content);
                $this.trigger('click');
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});
//]]>