//<![CDATA[
$(document).ready(function() {
    $("#btn-print").on('click', function (event) {
    	event.preventDefault();
        if (confirm("Bạn có thật sự muốn in mã code tất cả sản phẩm?")) {
            printContent('div1');
        }
        return false;
    });

    $(".chosen-select").chosen({search_contains: true});
});
//]]>