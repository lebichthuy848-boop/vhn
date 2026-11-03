//<![CDATA[
function show_alert_success(str) {
    $html = '<div class="alert alert-dismissable alert-success"><button data-dismiss="alert" class="close" type="button">×</button><strong>' + str + '</strong></div>';
    return $html;
}
function show_alert_warning(str) {
    $html = '<div class="alert alert-dismissable alert-warning"><button data-dismiss="alert" class="close" type="button">×</button><strong>' + str + '</strong></div>';
    return $html;
}
function show_alert_danger(str) {
    $html = '<div class="alert alert-dismissable alert-danger"><button data-dismiss="alert" class="close" type="button">×</button><strong>' + str + '</strong></div>';
    return $html;
}

$(document).on("click", "#click_print", function() {
    $("#element_print").print({
        globalStyles: true,
        mediaPrint: false,
        stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
        noPrintSelector: ".noPrint"
    });
});

$(document).ready(function() {
    $("#f-post").on("submit", function(e) {
        bootbox.confirm("Are you payment confirmation?", function(result) {
            if (result === true) {
                var order_id = $('#order_id').val();
                $('#notify').html('Precessing...').fadeIn(5000);
                var strURL = base_url + 'admin/shops/or_view/' + order_id;
                var data = {'order_id': order_id, 'ajax': 1};
                $.ajax({
                    url: strURL,
                    type: 'POST',
                    cache: false,
                    data: data,
                    success: function(response) {
                        var getData = $.parseJSON(response);
                        if (getData.status === 'success') {
                            $('#notify').html(show_alert_success(getData.message));
                            $("section.content").load(base_url + 'admin/shops/or_view/' + order_id, {'get_data': 1, 'ajax': 1});
                        } else if (getData.status === 'warning') {
                            $('#notify').html(show_alert_warning(getData.message));
                        } else {
                            $('#notify').html(show_alert_danger(getData.message));
                        }
                    },
                    error: function() {
                        alert('Error!');
                    }
                });
            }
        });
        return false;
    });
});
//]]>