<?php
$CMS['table'] = 'client_view' ;
$CMS['show_title'] = 'آراء العملاء' ;
$CMS['is_arg'] = true ; //there is arg culomn in the table and have to put number in it
$CMS['is_activation'] = true ;
$CMS['show_order_by'] = 'arg' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['show_row_height'] = 60 ;
$CMS['is_delete'] = true ;
$CMS['is_add'] = true ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name' ) ;
$CMS['show'][] = array( 'type' => 'image' , 'name' => 'img' , 'max' => 1 , 'width' => '200px' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'الاسم' , 'name' => 'name' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'الرأي' , 'name' => 'view' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
$CMS['elem'][] = array( 'title' => 'صورة العميل' , 'name' => 'img' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' ) ;
?>