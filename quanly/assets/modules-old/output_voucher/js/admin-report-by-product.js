//<![CDATA[
$(document).on("click", "#click_print", function () {
    $("#element_print").print({
        globalStyles: true,
        mediaPrint: false,
        stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
        noPrintSelector: ".noPrint"
    });
});

$(document).ready(function() {    
    $('#datePickerFromday').datepicker({
        format: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true,
        startDate: "01-01-1970"
    });

    $('#datePickerToday').datepicker({
        format: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true,
        startDate: "01-01-1970"
    });
    
    $(".chosen-select").chosen({search_contains: true});
});
//]]>