<?php
$CMS['table'] = 'choosen' ;
$CMS['show_title'] = 'اخترنا لكم' ;
$CMS['is_arg'] = true ; //there is arg culomn in the table and have to put number in it
$CMS['is_activation'] = false ;
$CMS['show_order_by'] = 'arg' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['show_row_height'] = 60 ;
$CMS['is_delete'] = false ;
$CMS['is_add'] = false ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' ) ;
$CMS['show'][] = array( 'type' => 'image' , 'max' => 1 , 'width' => '200px' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'الرابط' , 'name' => 'link' , 'type' => 'text' , 'lang' => 'en' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' => 'صورة الخلفية' , 'name' => 'img' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' ) ;
?>