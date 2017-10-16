<?php
$CMS['table'] = 'slider' ;
$CMS['show_title'] = 'معرض الصور' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_arg'] = true ;
$CMS['is_activation'] = false ;
$CMS['show_order_by'] = 'arg' ;
$CMS['is_delete'] = true ;
$CMS['is_add'] = true ;
$CMS['show_row_height'] = 60 ;
$CMS['relation'] = array( 'title' => 'القسم' , 'type' => 'one_to_many' , 'pid' => 'pid' , 'option_table' => 'page' , 'option_title' => 'title_ar' , 'option_value' => 'id' ) ;
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'img_title_ar' , 'width' => '60%' ) ;
$CMS['show'][] = array( 'type' => 'image' ,'name' => 'slider' , 'max' => 1 , 'width' => '40%' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'القسم' , 'name' => 'pid' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'page' , 'option_title' => 'title_ar' , 'option_value' => 'id'  ) ;
foreach( $langs as $title => $lang ) 
	$CMS['elem'][] = array( 'title' => 'النص المتحرك ( '.$title.' )' , 'name' => 'img_title_'.$lang , 'type' => 'textarea' , 'lang' => $lang , 'editable' => false ) ;
$CMS['elem'][] = array( 'title' => "الصورة" ,'name' => 'slider' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' , 'lang' => LANG ) ;
?>