<?php
$CMS['table'] = 'portfolio' ;
$CMS['show_title'] = 'أعمالنا' ;
$CMS['is_arg'] = true ; //there is arg culomn in the table and have to put number in it
$CMS['is_activation'] = true ;
$CMS['show_order_by'] = 'arg' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['show_row_height'] = 60 ;
$CMS['is_delete'] = true ;
$CMS['is_add'] = true ;
$CMS['is_activation'] = false ;

$CMS['relation'] = array( 'title' => 'القسم' , 'type' => 'one_to_many' , 'pid' => 'category_id' , 'option_table' => 'portfolio_category' , 'option_title' => 'title' , 'option_value' => 'id' ) ;
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' ) ;
$CMS['show'][] = array( 'type' => 'image' , 'name' => 'img' , 'max' => 1 , 'width' => '200px' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'title' =>  'الرابط' , 'name' => 'link' , 'type' => 'text' , 'lang' => 'en' ) ;
$CMS['elem'][] = array( 'title' =>  'القسم' , 'name' => 'category_id' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'portfolio_category' , 'option_title' => 'title' , 'option_value' => 'id'  ) ;
$CMS['elem'][] = array( 'title' => 'الصورة' , 'name' => 'img' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' ) ;
?>