<?php
$CMS['table'] = 'user_group' ;
$CMS['show_title'] = 'الصلاحيات' ;
$CMS['is_arg'] = false ;
$CMS['is_activation'] = false ;
$CMS['edit_title'] = 'تعديل' ;
$CMS['add_title'] = 'اضافة' ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'اسم المجموعة' ,'name' => 'name' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'الصلاحيات' ,'name' => 'permission' , 'type' => 'checkbox' , 'option_table' => 'user_permission' , 'option_value' => 'route' , 'option_title' => 'title' , 'relation_json' => 'permission' ) ;
?>