/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.allowedContent = true;//chap nhan class
    config.htmlEncodeOutput = false;
    config.entities = false;
    config.autoParagraph = false;
    config.contentsCss = [ 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css' ];
    config.extraPlugins = 'video,bt_table,glyphicons,fontawesome';
};
CKEDITOR.dtd.$removeEmpty['span'] = false;
CKEDITOR.dtd.$removeEmpty['i'] = false;
