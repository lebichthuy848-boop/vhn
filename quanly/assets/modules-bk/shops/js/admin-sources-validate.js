function BrowseServer() {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            SetFileField(url);
        }
    };
    window.open(base_url + 'ckeditor/kcfinder/browse.php?type=images&dir=images/news',
            'uploads', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600'
            );
}

function SetFileField(fileUrl) {
    document.getElementById('logo').value = fileUrl;
}

$(document).ready(function() {
    $('.confirm_bootstrap').on('click', function(e, confirmed) {
        var link = $(this).attr('href');
        if (!confirmed) {
            e.preventDefault();
            BootstrapDialog.confirm({
                title: 'XÁC NHẬN THÔNG TIN',
                message: 'Bạn có thật sự muốn xóa hãng sản xuất này? Nếu đồng ý, tất cả dữ liệu liên quan sẽ bị xóa. Bạn sẽ không thể phục hồi lại chúng sau này!',
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
    
    $("#f-sources").validate({
        rules: {
            title: {
                required: true
            },
            link: {
                url: true
            }
        },
        messages: {
            title: {
                required: 'Nhập tên hãng sản xuất'
            },
            link: {
                url: 'Nhập đúng định dạng url hãng sản xuất'
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