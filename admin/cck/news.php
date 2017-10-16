<?php
$CMS['table'] = 'news' ;
$CMS['show_title'] = 'أخبار الشركة' ;
$CMS['is_arg'] = false ; //there is arg culomn in the table and have to put number in it
$CMS['is_activation'] = true ;
$CMS['show_order_by'] = 'created' ;
$CMS['show_order_by_method'] = 'DESC' ; //ASC DESC
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' ) ;
$CMS['show'][] = array( 'type' => 'date' , 'name' => 'created' ) ;
//elements
$CMS['elem'][] = array( 'value' => time() , 'created' => true , 'name' => 'created' , 'type' => 'hidden' , 'lang' => 'en' ) ;
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' => 'النص' , 'name' => 'body' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => true ) ;
$CMS['elem'][] = array( 'title' => 'الوصف' , 'name' => 'description' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
$CMS['elem'][] = array( 'title' => 'الكلمات المفتاحية' , 'name' => 'keywords' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
?>