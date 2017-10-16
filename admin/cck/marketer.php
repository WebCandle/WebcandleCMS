<?php
$CMS['table'] = 'marketer' ;
$CMS['show_title'] = 'المسوقون' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_activation'] = true ;
$CMS['is_delete'] = true ;
$CMS['is_arg'] = true ;
$CMS['show_order_by'] = 'arg' ;
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'الاسم' , 'name' => 'name' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
?>