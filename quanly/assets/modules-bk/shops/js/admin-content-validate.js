var tags = document.getElementById("Tags").value;
res = tags.split(",");
jQuery(".tm-input").tagsManager({
    prefilled: res,
    CapitalizeFirstLetter: true,
    AjaxPush: null,
    AjaxPushAllTags: null,
    AjaxPushParameters: null,
    delimiters: [9, 13, 44],
    backspace: [8],
    blinkBGColor_1: '#FFFF9C',
    blinkBGColor_2: '#CDE69C',
    hiddenTagListName: 'hidden-tags',
    hiddenTagListId: null,
    deleteTagsOnBackspace: true, //false: không cho xóa tag
    tagsContainer: null,
    tagCloseIcon: '×',
    tagClass: '',
    validator: null,
    onlyTagList: false
});

jQuery.each(jQuery('textarea[data-autoresize]'), function() {
    var offset = this.offsetHeight - this.clientHeight;

    var resizeTextarea = function(el) {
        jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
    };
    jQuery(this).on('keyup input', function() {
        resizeTextarea(this);
    }).removeAttr('data-autoresize');
});

function BrowseServer(id) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            document.getElementById(id).value = url;
        }
    };

    if (typeof kcwindow === 'undefined' || kcwindow.closed) {
        kcwindow = window.open(base_url + 'ckeditor/kcfinder/browse.php?type=images&dir=images/shops&langCode=vi',
                'uploads', 'status=0, toolbar=0, location=0, menubar=0, ' +
                'directories=0, resizable=1, scrollbars=0, width=800, height=600'
                );

    } else {
        kcwindow.focus();
    }
    kcwindow.document.title = "Quản lý ảnh sản phẩm";
}

$(document).ready(function() {
    jQuery.validator.addMethod("priceCheck", function() {
        var isSuccess = false;

        var price = $('.mask-price').val().replace(/\./g, '');
        if (price >= 1000) {
            isSuccess = true;
        }

        return isSuccess;
    }, 'Giá sản phẩm phải từ 1000 trở lên');

    jQuery.validator.addMethod("numberCheck", function() {
        var isSuccess = false;

        var number = $('.mask-number').val().replace(/\./g, '');
        if (number > 0) {
            isSuccess = true;
        }

        return isSuccess;
    }, 'Số lượng sản phẩm phải từ 1 trở lên');

    $('.mask-price').mask('000.000.000', {reverse: true});
    $('.mask-number').mask('000.000.000', {reverse: true});

    $("#f-content").validate({
        rules: {
            title: {
                required: true
            },
            alias: {
                required: true
            },
            product_code: {
                required: true
            },
            product_number: {
                required: true
            },
            product_price: {
                required: true,
                priceCheck: true
            },
            product_discounts: {
                required: true,
                number: true,
                max: 100
            },
            hometext: {
                required: true
            }
        },
        messages: {
            title: {
                required: 'Nhập tên sản phẩm'
            },
            alias: {
                required: 'Nhập liên kết tĩnh'
            },
            product_code: {
                required: 'Nhập mã sản phẩm'
            },
            product_number: {
                required: 'Nhập số lượng sản phẩm',
            },
            product_price: {
                required: 'Nhập giá sản phẩm'
            },
            product_discounts: {
                required: 'Nhập giảm giá'
            },
            hometext: {
                required: 'Nhập nội dung giới thiệu cho sản phẩm'
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

    $("#idtitle").on('keyup blur', function() {
        var title = $(this).val();
        var strURL = base_url + 'admin/shops/alias';
        var form_data = {'title': title};

        $.ajax({
            type: "POST",
            url: strURL,
            data: form_data,
            success: function(html) {
                $("#idalias").val(html);
            }
        });

        return false;
    });
});