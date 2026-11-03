//<![CDATA[
function today() {
    var d = new Date();
    var curr_date = d.getDate();
    if (curr_date < 10) {
        curr_date = '0' + curr_date;
    }
    var curr_month = d.getMonth() + 1;
    if (curr_month < 10) {
        curr_month = '0' + curr_month;
    }
    var curr_year = d.getFullYear();
    var today = curr_date + "-" + curr_month + "-" + curr_year;

    return today;
}

$(function() {
    $('#date-picker-start').datepicker({
        format: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true,
        startDate: "01-01-1970",
        endDate: today()
    });
});

$(document).ready(function() {
    $('#datePicker').datepicker({
        format: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true
    });

    $('#datePicker1').datepicker({
        format: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true
    });

    $('#datePickerStartday').datepicker({
            format: 'dd-mm-yyyy',
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            showOn: 'focus',
            language: 'vi',
            autoclose: true,
            startDate: "01-01-1970",
            endDate: today()
        }).change(dateChanged)
        .on('changeDate', dateChanged);

    $('#datePickerEndday').datepicker({
        format: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true,
        startDate: today()
    });

    $('#datePickerMonth').datepicker({
        format: 'mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true
    });
});

function dateChanged(ev) {
    var start_date = $('#start_date').val();
    if (start_date != '') {
        $('#datePickerEndday').datepicker('setStartDate', start_date);
    }
}
//]]>