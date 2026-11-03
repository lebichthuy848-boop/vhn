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
        caption: 'XEM PHIẾU XUẤT',
        initRows: 1,
        columns: [
            {
                name: 'product_id',
                display: 'Sản phẩm',
                type: 'custom',
                ctrlAttr: {'readonly': 'readonly'},
                customBuilder: function (parent, idPrefix, name, uniqueIndex) {
                    var ctrlId = idPrefix + '_' + name + '_' + uniqueIndex;
                    var ctrl = document.createElement('select');
                    $.each(products, function (key, val) {
                        ctrl.add(createOption(key, val));
                    });
                    $(ctrl).attr({
                        'id': ctrlId,
                        'name': ctrlId,
                        'disabled': 'disabled'
                    }).appendTo(parent).chosen({search_contains: true});
                    return ctrl;
                },
                customGetter: function (idPrefix, name, uniqueIndex) {
                    return $('#' + idPrefix + '_' + name + '_' + uniqueIndex).chosen().val();
                },
                customSetter: function (idPrefix, name, uniqueIndex, value) {
                    $('#' + idPrefix + '_' + name + '_' + uniqueIndex).val(value).trigger('chosen:updated');
                }
            },
            {name: 'quantity', display: 'Số lượng', type: 'number', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '80px', 'text-align': 'right'}, value: 1},
            {name: 'unit_price', display: 'Đơn giá', type: 'number', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '80px', 'text-align': 'right'}, value: 0},
            {name: 'monetized', display: 'Thành tiền', type: 'number', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '80px', 'text-align': 'right'}, value: 0},
            {name: 'VAT', display: 'VAT', type: 'text', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '80px', 'text-align': 'right'}, value: 0},
            {name: 'note', display: 'Ghi chú', type: 'textarea', ctrlAttr: {'readonly': 'readonly'}, ctrlCss: {width: '110px'}}
        ],
        initData: product_init,
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
function createOption(value, text) {
    var option = document.createElement('option');
    option.text = text;
    option.value = value;
    return option;
}

$(document).ready(function () {
    $(".chosen-select").chosen();
});