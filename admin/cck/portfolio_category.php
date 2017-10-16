<?php
$CMS['table'] = 'portfolio_category' ;
$CMS['show_title'] = 'أقسام الأعمال' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_arg'] = true ;
$CMS['is_delete'] = true ;
$CMS['is_activation'] = true ;
$CMS['show_order_by'] = 'arg' ;
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' ) ;

//elements
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  "عدد الصور في كل سطر" , 'name' => 'c' , 'type' => 'radio' , 'lang' => 'ar' , 'option_type' => 'array' , 'options' => array( '2' => 2 , '3' => 3 ) ) ;
?>