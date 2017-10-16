<?php
$CMS['table'] = 'user_permission' ;
$CMS['show_title'] = 'الصلاحيات' ;
$CMS['is_arg'] = false ;
$CMS['is_activation'] = false ;
$CMS['show_order_by'] = 'route' ;
$CMS['show_order_by_method'] = 'ASC' ; //ASC DESC
$CMS['edit_title'] = 'تعديل' ;
$CMS['add_title'] = 'اضافة' ;
$CMS['show_limit'] = 100 ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'route' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'العنوان' ,'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'المسار' ,'name' => 'route' , 'type' => 'text' , 'lang' => 'en' , 'rule_required' => true ) ;
?>