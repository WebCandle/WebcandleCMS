<?php
$CMS['table'] = 'banner' ;
$CMS['show_title'] = 'الاعلانات' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_arg'] = false ;
$CMS['is_delete'] = false ;
$CMS['is_add'] = false ;
$CMS['show_row_height'] = 60 ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name' , 'width' => '40%' ) ;
$CMS['show'][] = array( 'type' => 'image' , 'max' => 1 , 'width' => '60%' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'الاسم' , 'name' => 'name' , 'type' => 'text' , 'lang' => LANG ) ;
/*$CMS['elem'][] = array( 'title' =>  'رابط' , 'name' => 'link' , 'type' => 'text' , 'lang' => 'en' ) ;*/
$CMS['elem'][] = array( 'title' => "الصورة" ,'name' => 'img' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' , 'lang' => LANG ) ;
?>