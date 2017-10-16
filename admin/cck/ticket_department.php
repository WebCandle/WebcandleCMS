<?php
$CMS['table'] = 'ticket_department' ;
$CMS['show_title'] = 'أقسام التذاكر' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_activation'] = false ;
$CMS['is_delete'] = true ;
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'الاسم' , 'name' => 'name' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true );
$CMS['elem'][] = array( 'title' =>  'الوصف' , 'name' => 'description' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
?>