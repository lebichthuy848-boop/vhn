var tags = document.getElementById("site_hotline").value;
res = tags.split(",");
jQuery(".tm-input").tagsManager({
    prefilled: res,
    CapitalizeFirstLetter: false, //khong viet hoa chu cai dau
    AjaxPush: null,
    AjaxPushAllTags: null,
    AjaxPushParameters: null,
    delimiters: [9, 13, 44],
    backspace: [8],
    blinkBGColor_1: '#FFFF9C',
    blinkBGColor_2: '#CDE69C',
    hiddenTagListName: 'hidden-tags',
    hiddenTagListId: null,
    deleteTagsOnBackspace: true, //false: không cho xóa tag
    tagsContainer: null,
    tagCloseIcon: '×',
    tagClass: '',
    validator: null,
    onlyTagList: false
});

jQuery.each(jQuery('textarea[data-autoresize]'), function() {
    var offset = this.offsetHeight - this.clientHeight;

    var resizeTextarea = function(el) {
        jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
    };
    jQuery(this).on('keyup input', function() {
        resizeTextarea(this);
    }).removeAttr('data-autoresize');
});