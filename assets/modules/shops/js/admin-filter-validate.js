$(document).ready(function () {
    $("#f-content").validate({
        rules: {
            name: {
                required: true
            },
            alias: {
                required: true
            }
        },
        messages: {
            name: {
                required: 'Nhập tên loại sản phẩm'
            },
            alias: {
                required: 'Nhập liên kết tĩnh'
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

    $("#name").on('keyup blur', function () {
        $("#alias").val(get_slug($(this).val()));
        return false;
    });
});