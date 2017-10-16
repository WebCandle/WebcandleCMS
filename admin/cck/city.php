<?php
$CMS['table'] = 'city' ;
$CMS['show_title'] = 'المناطق' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_activation'] = false ;
$CMS['is_delete'] = false ;
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name_ar' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name_en' ) ;
//elements
foreach( $langs as $title => $lang )
$CMS['elem'][] = array( 'title' =>  'الاسم'.' ( '.$title.' )' , 'name' => 'name_'.$lang , 'type' => 'text' , 'lang' => $lang , 'rule_required' => true ) ;
?>