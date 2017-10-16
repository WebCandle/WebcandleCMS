<?php
$CMS['table'] = 'country' ;
$CMS['show_title'] = 'جميع الدول' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_activation'] = true ;
$CMS['is_delete'] = true ;
$CMS['show_order_by'] = 'arg' ;
$CMS['is_arg'] = true ;
$CMS['is_add'] = true ;
$CMS['show_limit'] = 140 ;
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'calling_code' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'iso_code_2' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'اسم الدولة' , 'name' => 'name' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'رمز النداء الدولي' , 'name' => 'calling_code' , 'type' => 'text' , 'lang' => 'en' , 'rule_required' => true , 'rule_not_in' => true , 'rule_not_in_table' => 'country' , 'rule_not_in_column' => 'calling_code' ) ;
$CMS['elem'][] = array( 'title' =>  'رمز الدولة iso code 2' , 'name' => 'iso_code_2' , 'type' => 'text' , 'lang' => 'en' , 'rule_required' => true, 'rule_not_in' => true , 'rule_not_in_table' => 'country' , 'rule_not_in_column' => 'iso_code_2' ) ;
?>