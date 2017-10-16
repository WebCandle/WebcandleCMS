<?php
$CMS['table'] = 'home' ;
$CMS['show_title'] = _CMS_GALLERY_HOME ;
$CMS['edit_title'] = _CMS_EDIT_GALLERY_HOME ;
$CMS['add_title'] = _CMS_ADD_GALLERY_HOME ;
//$CMS['is_arg'] = true ;
$CMS['show_order_by'] = 'size' ;
$CMS['show_row_height'] = 60 ;
//$CMS['show_order_by_method'] = 'DESC' ; //ASC DESC

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title_'.LANG , 'width' => '40%' ) ;
$CMS['show'][] = array( 'type' => 'image' , 'max' => 5 , 'width' => '40%' ) ;
$CMS['show'][] = array( 'type' => 'date' , 'name' => 'date' ,  'width' => '20%' ) ;
//elements
foreach( $langs as $title => $lang )
$CMS['elem'][] = array( 'title' =>  _CMS_MENU_TITLE.' ( '.$title.' )' , 'name' => 'title_'.$lang , 'type' => 'text' , 'lang' => $lang ) ;
$CMS['elem'][] = array( 'title' => _CMS_IMAGE_SIZE , 'name' => 'size' , 'type' => 'select' , 'option_type' => 'array' , 'options' => array( _SMALL => 1 , _MEDUM => 2 , _LARG => 3 ) , 'lang' => LANG ) ;
$CMS['elem'][] = array( 'title' => _CMS_MENU_IMAGE ,'name' => 'img' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' , 'lang' => LANG ) ;
$CMS['elem'][] = array( 'value' => time() , 'created' => true , 'name' => 'date' , 'type' => 'hidden' , 'lang' => 'en' ) ;
?>