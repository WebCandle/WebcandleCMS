<?php
$CMS['table'] = 'page' ;
$CMS['section'] = 'menu1' ;
$CMS['show_title'] = 'روابط تهمك' ;
$CMS['is_arg'] = true ; //there is arg culomn in the table and have to put number in it
$CMS['is_delete'] = true ;
$CMS['is_add'] = true ;
$CMS['is_activation'] = true ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['show_contract'] = ' `menu_id` = 1 ' ;
$CMS['show_order_by'] = 'arg' ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'رابط' , 'name' => 'link' , 'type' => 'text' , 'lang' => 'en' ) ;
$CMS['elem'][] = array( 'title' => 'نص الصفحة' , 'name' => 'body' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => true ) ;
$CMS['elem'][] = array( 'title' => 'الوصف' , 'name' => 'description' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
$CMS['elem'][] = array( 'title' => 'الكلمات المفتاحية' , 'name' => 'keywords' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
$CMS['elem'][] = array( 'name' => 'menu_id' , 'type' => 'hidden' , 'value' => '1' ) ;
?>