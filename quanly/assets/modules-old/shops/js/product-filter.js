$(document).ready(function() {
    $('.page-option-view').on('click', function() {
        var param = 'viewcat';
        var this_value = $(this).attr('id');
        var query_string_value = getQuerystring(param);
        var query_string_character = '?';

        if (document.location.search.length) {
            query_string_character = '&';
        }

        if (query_string_value === '') {
            window.location.href = document.URL + query_string_character + param + '=' + this_value;
        } else {
            window.location.href = updateQueryStringParameter(document.URL, param, this_value);
        }
        return false;
    });

    $('#id-sort').on('change', function() {
        var param = 'sort';
        var this_value = $(this).val();
        var query_string_value = getQuerystring(param);
        var query_string_character = '?';

        if (document.location.search.length) {
            query_string_character = '&';
        }

        if (query_string_value === '') {
            window.location.href = document.URL + query_string_character + param + '=' + this_value;
        } else {
            window.location.href = updateQueryStringParameter(document.URL, param, this_value);
        }
    });

    $('#id-per-page').on('change', function() {
        var param = 'per_page';
        var this_value = $(this).val();
        var query_string_value = getQuerystring(param);
        var query_string_character = '?';

        if (document.location.search.length) {
            query_string_character = '&';
        }

        if (query_string_value === '') {
            window.location.href = document.URL + query_string_character + param + '=' + this_value;
        } else {
            window.location.href = updateQueryStringParameter(document.URL, param, this_value);
        }
    });
});

function getQuerystring(key, default_) {
    if (default_ == null)
        default_ = "";
    key = key.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + key + "=([^&#]*)");
    var qs = regex.exec(window.location.href);
    if (qs == null)
        return default_;
    else
        return qs[1];
}

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?|&])" + key + "=.*?(&|#|$)", "i");
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
        var hash = '';
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.indexOf('#') !== -1) {
            hash = uri.replace(/.*#/, '#');
            uri = uri.replace(/#.*/, '');
        }
        return uri + separator + key + "=" + value + hash;
    }
}