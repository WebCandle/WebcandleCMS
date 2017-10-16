<?php
$CMS['table'] = 'gallery' ;
$CMS['show_title'] = 'معرض الصور المتحرك' ;
$CMS['is_arg'] = true ; //there is arg culomn in the table and have to put number in it
$CMS['is_activation'] = true ;
$CMS['show_order_by'] = 'arg' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['show_row_height'] = 60 ;
$CMS['is_delete'] = true ;
$CMS['is_add'] = true ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' ) ;
$CMS['show'][] = array( 'type' => 'image' , 'max' => 1 , 'width' => '200px' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'الرابط' , 'name' => 'link' , 'type' => 'text' , 'lang' => 'en' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'الوصف' , 'name' => 'desc' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
$CMS['elem'][] = array( 'title' => 'الصورة' , 'name' => 'img' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' ) ;
?>