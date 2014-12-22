/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	//config.skin = 'bootstrapck';
	config.language = 'en';
    //config.extraPlugins = 'uicolor';
    config.height = 300;
    //config.width  = 700;
	config.toolbar =
	[

		['Source','-','Templates','Bold','Italic','Underline','Strike','-','Subscript','Superscript','NumberedList','BulletedList','-','Outdent','Indent','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Image','Table','HorizontalRule','Smiley','PageBreak','Link','Unlink','Maximize'],
		['Styles', 'Format', 'Font','FontSize','TextColor','BGColor']
	];
	config.filebrowserBrowseUrl = '/utilities/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '/utilities/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '/utilities/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl ='/utilities/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '/utilities/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl ='/utilities/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
