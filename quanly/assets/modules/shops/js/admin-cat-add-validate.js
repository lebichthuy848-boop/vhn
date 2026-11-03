jQuery.each(jQuery('textarea[data-autoresize]'), function() {
    var offset = this.offsetHeight - this.clientHeight;

    var resizeTextarea = function(el) {
        jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
    };
    jQuery(this).on('keyup input', function() {
        resizeTextarea(this);
    }).removeAttr('data-autoresize');
});

function BrowseServer() {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            SetFileField(url);
        }
    };

    if (typeof kcwindow === 'undefined' || kcwindow.closed) {
        kcwindow = window.open(base_url + 'ckeditor/kcfinder/browse.php?type=images&dir=shops/cat&langCode=vi',
                'uploads', 'status=0, toolbar=0, location=0, menubar=0, ' +
                'directories=0, resizable=1, scrollbars=0, width=800, height=600'
                );

    } else {
        kcwindow.focus();
    }
    kcwindow.document.title = "Quản lý ảnh sản phẩm";
}

function SetFileField(fileUrl) {
    document.getElementById('homeimg').value = fileUrl;
}

$(document).ready(function() {
    jQuery.validator.addMethod("aliasCheck", function() {
        var isSuccess = false;

        var alias = $('#alias').val();

        var strURL = base_url + 'admin/shops/cat/check_alias_availablity';
        var data = {'alias': alias, 'ajax': 1};
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
    }, 'Liên kết tĩnh này đã sử dụng');

    $("#f-cat").validate({
        rules: {
            title: {
                required: true
            },
            alias: {
                required: true,
                aliasCheck: true
            }
        },
        messages: {
            title: {
                required: 'Nhập tên loại sản phẩm'
            },
            alias: {
                required: 'Nhập liên kết tĩnh'
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

    $("#name").on('keyup blur', function() {
        var title = $(this).val();
        var strURL = base_url + 'admin/shops/alias';
        var form_data = {'title': title};

        $.ajax({
            type: "POST",
            url: strURL,
            data: form_data,
            success: function(html) {
                $("#alias").val(html);
            }
        });

        return false;
    });
});