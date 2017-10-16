<?php
$CMS['table'] = 'service_show' ;
$CMS['show_title'] = 'الباقات' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_arg'] = true ;
$CMS['is_activation'] = true ;
$CMS['show_order_by'] = 'arg' ;
$CMS['is_delete'] = true ;
$CMS['is_add'] = true ;


$CMS['relation'] = array( 'title' => 'نوع الباقة' , 'type' => 'one_to_many' , 'pid' => 'type_id' , 'option_table' => 'service_type' , 'option_title' => 'name' , 'option_value' => 'id' ) ;
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'الباقة' , 'name' => 'type_id' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'service_type' , 'option_title' => 'name' , 'option_value' => 'id'  ) ;
$CMS['elem'][] = array( 'title' =>  'الخدمة' , 'name' => 'service_id' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'service' , 'option_title' => 'title' , 'option_value' => 'id'  ) ;
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'الوصف' , 'name' => 'desc' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
$CMS['elem'][] = array('type' => 'module' , 'html' => 'module2_html.html' ) ;
?>