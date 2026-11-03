$(document).on("click", "#click_print", function() {
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
            {name: 'consignment_id', display: 'Mã thiết bị', type: 'text', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '150px'}},
            {name: 'unit', display: 'Đơn vị tính', type: 'text', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '100px'}},
            {name: 'quantity', display: 'SL', type: 'number', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '100px', 'text-align': 'right'}, value: 1},
            {name: 'returned', display: 'Trả/chưa', type: 'select', ctrlAttr: {'disabled': 'disabled'}, ctrlCss: {width: '80px'}, ctrlOptions: {0: 'Chưa trả', 1: 'Đã trả'}},
            {name: 'status', display: 'Tình trạng', type: 'text', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '180px'}},
            {name: 'note', display: 'Nội dung BH', type: 'text', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '254px'}},
            {name: 'fee', display: 'Chi phí sửa', type: 'text', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '150px', 'text-align': 'right'}}
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
//http://jsfiddle.net/hkalbertl/d4dc42kv/
//http://www.jqueryscript.net/table/jQuery-Dynamic-Data-Grid-Plugin-appendGrid.html