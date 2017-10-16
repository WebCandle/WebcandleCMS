<?php
$CMS['table'] = 'service_type' ;
$CMS['show_title'] = 'أنواع الباقات' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_arg'] = true ;
$CMS['is_activation'] = true ;
$CMS['show_order_by'] = 'arg' ;
$CMS['is_delete'] = true ;
$CMS['is_add'] = true ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'name' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;

?>