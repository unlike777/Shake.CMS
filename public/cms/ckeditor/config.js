/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	config.language = 'ru';

	config.toolbar = 'Shake.CMS';

	config.filebrowserBrowseUrl = '/cms/elfinder/elfinder.html';
	config.filebrowserWindowHeight = 520;

	config.extraPlugins = 'mediaembed,autogrow';
	
	config.stylesSet = [
		{ name: 'Красный текст', element: 'span', attributes: { 'class': 'red' } }
	];

	config.coreStyles_bold = { element : 'b', overrides : 'strong' };
	config.coreStyles_italic = { element : 'i', overrides : 'em' };

	config.pasteFromWordRemoveFontStyles = true;
	config.forceEnterMode = true;
	
	config.colorButton_colors = '9370DB,04BCF9,FF69B4,FF5B3E,32CD32,E22727,AA0000,FA0000,FA7800,0AAA00,000050,64145A,FFC887,F0DC00,A0F000,0078F0';
	
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbar = [
		{ name: 'document', items : [ 'Source','ShowBlocks','Print'] },
		{ name: 'clipboard', items : [ 'Cut','Copy','PasteText','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace' /*,'-','SelectAll'*/ ] },
		{ name: 'links', items : [ 'Link','Unlink' ] },
		{ name: 'insert', items : [ '-','Image','MediaEmbed','Iframe','Flash','Table'/*,'Smiley'*/,'SpecialChar'] },
		{ name: 'insert', items : ['-','About'] },
		'/',
		{ name: 'styles', items : [ 'FontSize','Format', 'Styles' ] },    /* ,'Font' */
		{ name: 'paragraph', items : [ '-','Bold','Italic','Underline','Strike'] },
		{ name: 'paragraph', items : [ '-','JustifyLeft','JustifyCenter','JustifyRight' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'basicstyles', items : [ '-','NumberedList','BulletedList', '-','Subscript','Superscript', '-','Blockquote'] },
		{ name: 'basicstyles', items : [ '-','RemoveFormat'] }
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	//config.removeButtons = 'Underline,Subscript,Superscript';
};
