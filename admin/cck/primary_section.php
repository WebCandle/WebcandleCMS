<?php
$CMS['table'] = 'page' ;
$CMS['section'] = 'primary_section' ;
$CMS['show_title'] = 'الروابط الرئيسية' ;
$CMS['is_arg'] = true ; //there is arg culomn in the table and have to put number in it
$CMS['is_delete'] = true ;
$CMS['is_add'] = true ;
$CMS['is_activation'] = false ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['show_contract'] = '`pid` = 0 and `menu_id` = 0 ' ;
$CMS['show_order_by'] = 'arg' ;

//show element

//$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return getPage($row) ;' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'رابط' , 'name' => 'link' , 'type' => 'text' , 'lang' => 'en' ) ;
/*$CMS['elem'][] = array( 'title' => 'صورة' , 'name' => 'img' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' , 'lang' => LANG ) ;*/
$CMS['elem'][] = array( 'title' => 'نص الصفحة' , 'name' => 'body' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => true ) ;
$CMS['elem'][] = array( 'title' => 'الوصف' , 'name' => 'description' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
$CMS['elem'][] = array( 'title' => 'الكلمات المفتاحية' , 'name' => 'keywords' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
?>