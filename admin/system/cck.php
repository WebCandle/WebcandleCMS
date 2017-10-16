<?php
$CMS['action'] = URL_A ;
$CMS['id'] = $_GET['cms_id'] ;
$CMS['pid'] = $_GET['cms_pid'] ;
$CMS['filter'] = urldecode( $_GET['cms_filter'] ) ;
$CMS['html'] = '' ;
$CMS['dir_path'] = '../files/' ;
$CMS['is_arg'] = false ;
$CMS['is_delete'] = true ;
$CMS['is_edit'] = true ;
$CMS['is_add'] = true ;
$CMS['is_activation'] = true ;
$CMS['is_confirm'] = false ;
$CMS['show_row_height'] = 25 ;
$CMS['show_width'] = 780 ;
$CMS['show_limit'] = 20 ; //pagination
$CMS['show_page'] = (is_numeric( $_GET['cms_page'] ) && $_GET['cms_page'] >=1 ) ? $_GET['cms_page'] : 1 ; //pagination start from 1 and takes $_GET['cms_page']
$CMS['date_format'] = 'Y-m-d' ;
if( LANG == 'en' ) {
	$CMS['js_vars'] = "
	var js_vars = new Array() ;
	js_vars['valid_form'] = true ;
	js_vars['ajax_is_working_now'] = false ;
	js_vars['message_invalid_file_extension'] = 'Invalid Extension !' ;
	js_vars['message_are_you_sure_to_delete'] = 'You cannot back after delete , are you sure ?' ;
	js_vars['message_are_you_sure_to_delete_file'] = 'Are you sure you want to delete file' ;
	js_vars['message_activation_error'] = 'Sorry, Activation error please try agian' ;
	js_vars['message_confirmation_error'] = 'Sorry, Confirmation error please try agian' ;
	js_vars['message_delete_file_error'] = 'Sorry an error happend when try to delete the file, please try again later !' ;
	js_vars['message_delete_error'] = 'Sorry an error happend when try to delete that, please try again later !' ;
	js_vars['message_arrange_error'] = 'Sorry an error happend when try to arrange that, please try again later !' ;
" ;
} else {
	$CMS['js_vars'] = "
	var js_vars = new Array() ;
	js_vars['valid_form'] = true ;
	js_vars['ajax_is_working_now'] = false ;
	js_vars['message_invalid_file_extension'] = 'عذراً, الملف الذي أدخلته غير مسموح به !' ;
	js_vars['message_are_you_sure_to_delete'] = 'هل أنت متأكد أنك تريد اتمام عملية الحذف ؟' ;
	js_vars['message_are_you_sure_to_delete_file'] = 'هل أنت متأكد أنك تريد حذف هذا الملف ؟' ;
	js_vars['message_activation_error'] = 'Sorry, Activation error please try agian' ;
	js_vars['message_confirmation_error'] = 'Sorry, Confirmation error please try agian' ;
	js_vars['message_delete_file_error'] = 'Sorry an error happend when try to delete the file, please try again later !' ;
	js_vars['message_delete_error'] = 'Sorry an error happend when try to delete that, please try again later !' ;
	js_vars['message_arrange_error'] = 'Sorry an error happend when try to arrange that, please try again later !' ;
" ;
}
include 'cck/'.ACTION.'.php' ;
if( $CMS['action'] == 'add' || $CMS['action'] == 'edit' ) include 'cckAddEdit.php' ;
else include 'cckShow.php' ;
?>