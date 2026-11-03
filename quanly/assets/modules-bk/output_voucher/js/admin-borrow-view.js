$(document).on("click", "#btn-print-pdf", function () {
    $(".el-print-only").removeClass('print-only');
    $("#element-print-pdf").print({
        globalStyles: true,
        mediaPrint: false,
        stylesheet: "https://fonts.googleapis.com/css?family=Inconsolata",
        noPrintSelector: ".noPrint"
    });
    $(".el-print-only").addClass('print-only');
});

$(document).on("click", "#btn-print-default", function (event) {
    event.preventDefault();
    printContent('element-print-default');
    return false;
});

$(document).on("click", ".btn-confirm", function() {
    bootbox.confirm("Bạn có xác nhận đơn hàng này?", function(result) {
        if (result === true) {
            var id = parseInt($(".btn-confirm").attr('data-id'));
            $('#notify').html('Đang xử lý...').fadeIn(5000);
            /*var data = {
                'id': id,
                'status': 1
            };*/
            var data = $(document.forms[0]).serialize() + '&' + $.param({ 'id': id, 'status': 1 });
            // console.log(data); return false;
            $.ajax({
                url: base_url + 'phieu-xuat/confirm-ajax',
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $("#notify").html(response.message);
                    if (response.status === 'success') {
                        $('.btn-group-action').remove();
                        $("#btn-group-action").prepend('<button class="btn btn-success" type="button">Đơn hàng thành công</button>');
                    }
                },
                error: function(e) {
                    console.log('Error processing your request: ' + e.responseText);
                }
            });
        }
    });
    return false;
});

$(document).on("click", ".btn-cancel", function() {
    bootbox.confirm("Bạn có hủy đơn hàng này?", function(result) {
        if (result === true) {
            var id = parseInt($(".btn-confirm").attr('data-id'));
            $('#notify').html('Đang xử lý...').fadeIn(5000);
            var data = {
                'id': id,
                'status': -1
            };
            $.ajax({
                url: base_url + 'phieu-xuat/confirm-ajax',
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $("#notify").html(response.message);
                    if (response.status === 'success') {
                        $('.btn-group-action').remove();
                        $("#btn-group-action").prepend('<button class="btn btn-danger" type="button">Đã hủy</button>');
                    }
                },
                error: function(e) {
                    console.log('Error processing your request: ' + e.responseText);
                }
            });
        }
    });
    return false;
});