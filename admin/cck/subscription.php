<?php
$CMS['table'] = 'subscription' ;
$CMS['show_title'] = 'المشتركون' ;
$CMS['is_arg'] = false ;
$CMS['show_order_by'] = 'email' ;
$CMS['show_order_by_method'] = 'ASC' ; //ASC DESC
$CMS['edit_title'] = 'تعديل' ;
$CMS['add_title'] = 'اضافة' ;
$CMS['is_delete'] = true ;
$CMS['is_add'] = true ;
$CMS['is_activation'] = false ;
$CMS['show_limit'] = 50 ;

//filter
$CMS['show_filter'] = array( 'email' ) ;
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'email' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'البريد الالكتروني' ,'name' => 'email' , 'type' => 'text' , 'lang' => 'en' , 'rule_required' => true , 'rule_mail' => true , 'rule_not_in' => true , 'rule_not_in_table' => 'subscription' , 'rule_not_in_column' => 'email' ) ;
$CMS['elem'][] = array( 'name' => 'customer' ,  'value' => '0' ,'type' => 'hidden' , 'lang' => 'en' ) ;
?>