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

        var strURL = base_url + 'admin/users/check_username_availablity';
        var data = { 'username': username, 'ajax': 1 };
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

        var strURL = base_url + 'admin/users/check_email_availablity';
        var data = { 'email': email, 'ajax': 1 };
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
            password: {
                required: true,
                minlength: 5
            },
            passconf: {
                required: true,
                minlength: 5,
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
            password: {
                required: 'Nhập mật khẩu'
            },
            passconf: {
                required: 'Nhập mật khẩu lặp lại'
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

    $('#id_email').on('keyup blur', function(e) {
        var email = $(this).val();
        var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
        if (filter.test(email)) {
            var strURL = base_url + 'users/check_email_availablity';
            var data = { 'email': email, 'ajax': 1 };
            id_email = $('#id_email');
            $.ajax({
                url: strURL,
                type: 'POST',
                cache: false,
                data: data,
                success: function(response) {
                    var getData = $.parseJSON(response);
                    var id_email_info = $('#id-email-info');

                    if (getData.status === 'success') {
                        id_email.closest('.form-group').removeClass('has-error');
                        if (!id_email_info.length) {
                            $('<span id="id-email-info" class="help-block text-success">' + getData.message + '</span>').insertAfter(id_email);
                        } else {
                            id_email_info.addClass('text-success');
                            id_email_info.html(getData.message);
                        }
                    } else {
                        id_email.closest('.form-group').addClass('has-error');
                        if (!id_email_info.length) {
                            $('<span id="id-email-info" class="help-block">' + getData.message + '</span>').insertAfter(id_email);
                        } else {
                            id_email_info.removeClass('text-success');
                            id_email_info.html(getData.message);
                        }
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra');
                }
            });
            return false;
        } else {
            $('#id-email-info').remove();
        }
    });
});