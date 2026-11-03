//<![CDATA[
$(document).on("click", "#click_print", function() {
    $("#element_print").print({
        globalStyles: true,
        mediaPrint: false,
        stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
        noPrintSelector: ".noPrint"
    });
});

$(document).ready(function() {
    $('#datePickerMonth').datepicker({
        minViewMode: 1,
        format: 'mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true
    });
});
//]]>