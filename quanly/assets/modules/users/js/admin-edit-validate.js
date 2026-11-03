jQuery.each(jQuery('textarea[data-autoresize]'), function() {
    var offset = this.offsetHeight - this.clientHeight;

    var resizeTextarea = function(el) {
        jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
    };
    jQuery(this).on('keyup input', function() {
        resizeTextarea(this);
    }).removeAttr('data-autoresize');
});

$(document).ready(function() {
    jQuery.validator.addMethod("usernameCheck", function() {
        var isSuccess = false;

        var username = $('#username').val();
        var userid = $('#userid').val();

        var strURL = base_url + 'admin/users/check_current_username_availablity';
        var data = { 'username': username, 'userid': userid, 'ajax': 1 };
        $.ajax({
            url: strURL,
            type: 'POST',
            async: false,
            data: data,
            success: function(response) {
                var getData = $.parseJSON(response);
                if (getData.status === 'success') {
                    isSuccess = true;
                }
            }
        });

        return isSuccess;
    }, 'Tên đăng nhập này đã có người sử dụng');

    jQuery.validator.addMethod("useremailCheck", function() {
        var isSuccess = false;

        var email = $('#email').val();
        var userid = $('#userid').val();

        var strURL = base_url + 'admin/users/check_current_email_availablity';
        var data = { 'email': email, 'userid': userid, 'ajax': 1 };
        $.ajax({
            url: strURL,
            type: 'POST',
            async: false,
            data: data,
            success: function(response) {
                var getData = $.parseJSON(response);
                if (getData.status === 'success') {
                    isSuccess = true;
                }
            }
        });

        return isSuccess;
    }, 'Email này đã có người sử dụng');

    $("#f-user-add").validate({
        rules: {
            username: {
                required: true,
                minlength: 5,
                maxlength: 60,
                usernameCheck: true
            },
            full_name: {
                required: true,
                minlength: 5,
                maxlength: 60
            },
            email: {
                required: true,
                email: true,
                useremailCheck: true
            },
            passconf: {
                equalTo: "#password"
            }
        },
        messages: {
            username: {
                required: 'Nhập tên đăng nhập'
            },
            full_name: {
                required: 'Nhập họ tên'
            },
            email: {
                required: 'Nhập email',
                email: 'Nhập đúng định dạng email'
            },
            passconf: {
                equalTo: 'Mật khẩu lặp lại không đúng với mật khẩu'
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
});