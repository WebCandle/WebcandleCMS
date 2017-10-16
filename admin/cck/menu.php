<?php
$CMS['table'] = 'menu' ;
$CMS['show_title'] = 'القائمة' ;
$CMS['is_arg'] = true ;
$CMS['show_order_by'] = 'arg' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_activation'] = false ;
$CMS['is_delete'] = false ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name_ar' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name_en' ) ;
//elements
foreach( $langs as $title => $lang )
$CMS['elem'][] = array( 'title' =>  'العنوان'.' ( '.$title.' )' , 'name' => 'name_'.$lang , 'type' => 'text' , 'lang' => $lang , 'rule_required' => true ) ;
?>