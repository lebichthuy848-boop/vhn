$(document).on('submit', '#f-advisory', function() {
    var f_advisory = '#f-advisory-';

    var full_name = $(f_advisory + 'full-name').val();
    if ($.trim(full_name) == '') {
        alert('Vui lòng nhập họ tên!');
        $(f_advisory + 'full-name').focus();
        return false;
    }

    var email = $(f_advisory + 'email').val();
    if ($.trim(email) == '') {
        alert('Vui lòng nhập email!');
        $(f_advisory + 'email').focus();
        return false;
    }

    var company = $(f_advisory + 'company').val();
    var phone = $(f_advisory + 'phone').val();
    var address = $(f_advisory + 'address').val();
    var need = $(f_advisory + 'need').val();
    var category = $(f_advisory + 'category').val();
    var uses = $(f_advisory + 'uses').val();
    var capacity = $(f_advisory + 'capacity').val();
    var note = $(f_advisory + 'note').val();
    var price = $(f_advisory + 'price').val();
    var message = $(f_advisory + 'message').val();
    var execution_time = $(f_advisory + 'execution-time').val();

    var data = {
        'full_name': full_name,
        'email': email,
        'company': company,
        'phone': phone,
        'address': address,
        'need': need,
        'category': category,
        'uses': uses,
        'capacity': capacity,
        'note': note,
        'price': price,
        'message': message,
        'execution_time': execution_time
    };

    $.ajax({
        url: base_url + 'advisory-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            if (response.status === 'success') {
                $('#f-advisory')[0].reset();
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});