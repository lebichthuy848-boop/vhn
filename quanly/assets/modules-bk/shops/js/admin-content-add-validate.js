var delay = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

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

jQuery.each(jQuery('textarea[data-autoresize]'), function () {
    var offset = this.offsetHeight - this.clientHeight;

    var resizeTextarea = function (el) {
        jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
    };
    jQuery(this).on('keyup input', function () {
        resizeTextarea(this);
    }).removeAttr('data-autoresize');
});

function BrowseServer(id) {
    window.KCFinder = {
        callBack: function (url) {
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

function get_slug(str) {
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/!|@|\$|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\'| |\"|\&|\#|\[|\]|~/g, "-");
    str = str.replace(/-+-/g, "-"); //thay thế 2- thành 1-
    str = str.replace(/^\-+|\-+$/g, "");//cắt bỏ ký tự - ở đầu và cuối chuỗi
    return str;
}

$(document).ready(function () {
    jQuery.validator.addMethod("priceCheck", function () {
        var isSuccess = false;

        var price = $('.mask-price').val().replace(/\./g, '');
        if (price >= 1000) {
            isSuccess = true;
        }

        return isSuccess;
    }, 'Giá sản phẩm phải từ 1000 trở lên');

    jQuery.validator.addMethod("numberCheck", function () {
        var isSuccess = false;

        var number = $('.mask-number').val().replace(/\./g, '');
        if (number > 0) {
            isSuccess = true;
        }

        return isSuccess;
    }, 'Số lượng sản phẩm phải từ 1 trở lên');

    jQuery.validator.addMethod("codeCheck", function () {
        var isSuccess = false;

        var product_code = $('#product_code').val();

        var strURL = base_url + 'admin/shops/check_product_code_availablity';
        var data = {'product_code': product_code, 'ajax': 1};
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
    }, 'Mã này đã tồn tại');

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
                required: true,
                codeCheck: true
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

    $("#idtitle_1").on('keyup blur', function () {
        var title = $(this).val();
        $("#idalias").val(get_slug(title));
        /*
         var strURL = base_url + 'admin/shops/alias';
         var form_data = {'title': title};
         
         $.ajax({
         type: "POST",
         url: strURL,
         data: form_data,
         success: function (html) {
         $("#idalias").val(html);
         }
         });
         */

        return false;
    });

    $("#idtitle").on('keyup blur', function () {
        delay(function () {
            var title = $("#idtitle").val();
            var strURL = base_url + 'admin/shops/alias';
            var form_data = {'title': title};

            $.ajax({
                type: "POST",
                url: strURL,
                data: form_data,
                success: function (html) {
                    $("#idalias").val(html);
                }
            });
            
            return false;
        }, 3000);
    });
});