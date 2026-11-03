$(document).on("click", "#click_print", function () {
    $("#element_print").print({
        globalStyles: true,
        mediaPrint: false,
        stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
        noPrintSelector: ".noPrint"
    });
});

$(function () {
    $('#tblAppendGrid').appendGrid({
        caption: 'Thiết bị',
        initRows: 1,
        columns: [
            {name: 'consignment_id', display: 'Mã thiết bị', type: 'text', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '180px'}},
            {name: 'unit', display: 'Đơn vị tính', type: 'text', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '127px'}},
            {name: 'quantity', display: 'Số lượng', type: 'number', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '80px', 'text-align': 'right'}, value: 1},
            {name: 'returned', display: 'Trả/chưa', type: 'select', ctrlAttr: {'disabled': 'disabled'}, ctrlCss: {width: '80px'}, ctrlOptions: {0: 'Chưa trả', 1: 'Đã trả'}},
            {name: 'note', display: 'Ghi chú', type: 'text', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '200px'}}
        ],
        initData: consignment_init,
        hideButtons: {
            remove: true,
            removeLast: true,
            append: true,
            insert: true,
            moveUp: true,
            moveDown: true
        }
    });
});

$(document).ready(function () {
    $(".chosen-select").chosen();
});