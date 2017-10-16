<?php
$CMS['table'] = 'product' ;
$CMS['show_title'] = 'السلع' ;
$CMS['is_arg'] = false ;
$CMS['is_activation'] = false ;
$CMS['show_order_by'] = 'created' ;
$CMS['show_order_by_method'] = 'DESC' ; //ASC DESC
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['relation'] = array( 'title' => 'القائمة' , 'type' => 'one_to_many' , 'pid' => 'menu_id' , 'option_table' => 'menu' , 'option_title' => 'name_ar' , 'option_value' => 'id' ) ;
$CMS['show_row_height'] = 60 ;
$CMS['show_filter'] = array( 'name_ar' , 'name_en' ) ;
global $product_elem_special ;
$product_elem_special = array( 'مميز' => 1 , 'خاص' => 2 , 'لا أحد' => 0 ) ;
function get_product_special_on_show( $row ) {
	global $product_elem_special ;
	foreach( $product_elem_special as $title => $value ) {
		if( $title == 'مميز' ||  $title == 'خاص' ) { $s = 'style="font-weight:bold;color:green;"' ;
		if( $row['special'] == $value ) return '<span '.$s.'>'.$title.'</span>' ; 
		} else return false ;
	}
}
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'name_ar' , 'width' => '300px' ) ;
$CMS['show'][] = array( 'type' => 'image' , 'max' => 1 , 'width' => '200px' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return get_product_special_on_show( $row ) ;' , 'width' => '80px' ) ;
$CMS['show'][] = array( 'type' => 'date' , 'name' => 'created' , 'width' => '100px' ) ;
//elements
foreach( $langs as $title => $lang )
$CMS['elem'][] = array( 'title' =>  "الاسم".' ( '.$title.' )' , 'name' => 'name_'.$lang , 'type' => 'text' , 'lang' => $lang , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  "السعر" , 'name' => 'price' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  "السعر القديم" , 'name' => 'old_price' , 'type' => 'text' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'title' =>  'ادراج ضمن القائمة' , 'name' => 'menu_id' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'menu' , 'option_title' => 'name_ar' , 'option_value' => 'id'  ) ;
$CMS['elem'][] = array( 'title' =>  "عرض في" , 'name' => 'special' , 'type' => 'radio' , 'lang' => 'ar' , 'option_type' => 'array' , 'options' => $product_elem_special ) ;
$CMS['elem'][] = array( 'title' =>  "المناطق" , 'name' => 'cities' , 'type' => 'checkbox' , 'option_table' => 'city' , 'option_contract' => '' , 'option_title' => 'name_ar' , 'option_value' => 'id' , 'relation_table' => 'product_city' ) ;
$CMS['elem'][] = array( 'title' => 'صورة المنتج' , 'name' => 'img' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' , 'lang' => LANG ) ;
$CMS['elem'][] = array( 'title' => 'إضافة إلى معرض الصور' , 'name' => 'slider' , 'folder' => 'slider' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' , 'lang' => LANG ) ;
$CMS['elem'][] = array( 'value' => time() , 'created' => true , 'name' => 'created' , 'type' => 'hidden' , 'lang' => 'en' ) ;
foreach( $langs as $title => $lang )
$CMS['elem'][] = array( 'title' =>  "الوصف".' ( '.$title.' )' , 'name' => 'desc_'.$lang , 'type' => 'textarea' , 'lang' => $lang ) ;
?>