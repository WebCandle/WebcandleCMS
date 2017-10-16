<?php
$CMS['table'] = 'menu' ;
$CMS['show_title'] = _CMS_MENU_MANAGEMENT ;
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name' ) ;
$CMS['edit_title'] = _CMS_EDIT_MENU ;
$CMS['add_title'] = _CMS_ADD_MENU ;
$CMS['url_after_edit'] = cms_url( 'cck' , $CMS['table'] ) ;
$i = 0 ;
foreach( $langs as $title => $lang ) 
	$CMS['elem'][] = array( 'title' =>  _CMS_MENU_TITLE.' ( '.$title.' )' , 'id' => 'elem'.$i++ , 'name' => 'title_'.$lang , 'type' => 'text' , 'lang' => $lang ) ;
$CMS['elem'][] = array( 'title' => _CMS_MENU_IMAGE , 'id' => 'elem'.$i++ , 'name' => 'img' , 'folder' => 'image' , 'max' => 3 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' , 'lang' => LANG ) ;
foreach( $langs as $title => $lang )
	$CMS['elem'][] = array( 'title' => _CMS_MENU_BODY.' ( '.$title.' )' , 'id' => 'elem'.$i++ , 'name' => 'body_'.$lang , 'type' => 'textarea' , 'lang' => $lang , 'editable' => true ) ;
/*$CMS['elem'][] = array( 'title' => 'الأسم الثاني' , 'id' => 'elem2' , 'name' => 'lname' , 'type' => 'text' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'title' => 'حول' , 'id' => 'elem3' , 'name' => 'msg' , 'type' => 'textarea' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'title' => 'العمر' , 'id' => 'elem4' , 'name' => 'age' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'range' , 'option_first' => 1 , 'option_last' => 10 ) ;
$CMS['elem'][] = array( 'title' => 'المدينة' , 'id' => 'elem5' , 'name' => 'city' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'city' , 'option_value' => 'id' , 'option_title' => 'name' , 'option_contract' => ' `pid` = 2' ) ;
$CMS['elem'][] = array( 'title' => 'الصورة الشخصية' , 'id' => 'elem6' , 'name' => 'img1' , 'max' => 5 , 'type' => 'file' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'title' => '2الصورة الشخصية' , 'id' => 'elem12' , 'name' => 'img2' , 'max' => 5 , 'type' => 'file' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'id' => 'elem7' , 'name' => 'id' , 'type' => 'hidden' , 'value' => 1 ) ;
$CMS['elem'][] = array( 'title' => 'لمحة' , 'id' => 'elem8' , 'name' => 'story' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => true ) ;*/
?>