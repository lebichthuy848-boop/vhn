$(document).ready(function() {
    $("#module").trigger("change");
    $("#f-content").validate({

        rules: {

            images: {

                required: true

            }

        },

        messages: {

            images: {

                required: 'Chọn ảnh'

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

$(document).on('change', '#module', function(){
    var type = $(this).val();
    if(type == 'brands_block'){
        $('.type-brands').removeClass('hide');
    }else{
        $('.type-brands').addClass('hide');
    }
});