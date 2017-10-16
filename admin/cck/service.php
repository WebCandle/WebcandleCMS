<?php
$CMS['table'] = 'service' ;
$CMS['show_title'] = 'الخدمات' ;
$CMS['is_delete'] = true ;
$CMS['is_add'] = true ;
$CMS['is_activation'] = true ;
$CMS['is_arg'] = true ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['show_order_by'] = 'arg' ;
$CMS['show_row_height'] = 60;

$CMS['relation'] = array( 'title' => 'القسم' , 'type' => 'one_to_many' , 'pid' => 'category_id' , 'option_table' => 'service_category' , 'option_title' => 'title' , 'option_value' => 'id' ) ;

$CMS['show_filter'] = array( 'title' , 'description' ) ;
$CMS['show_limit'] = 50 ; //pagination
//show element
function service_line1($row){
	return '../service_'.$row['id'] ;
}

$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' , 'link' => 'return service_line1($row);' , 'self' => false ) ;
$CMS['show'][] = array( 'type' => 'image' , 'name' => 'img' , 'max' => 1 , 'width' => '200px' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'القسم' , 'name' => 'category_id' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'service_category' , 'option_title' => 'title' , 'option_value' => 'id'  ) ;
$CMS['elem'][] = array( 'title' =>  'السعر' , 'name' => 'price' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true , 'rule_number' => true ) ;
$CMS['elem'][] = array( 'title' => 'صورة مميزة' , 'name' => 'img' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' , 'lang' => LANG ) ;
$CMS['elem'][] = array( 'title' =>  "خدمة سريعة" , 'name' => 'front' , 'type' => 'radio' , 'lang' => 'ar' , 'option_type' => 'array' , 'options' => array( 'نعم' => 1 , 'لا' => 0 ) ) ;
$CMS['elem'][] = array( 'title' =>  'معلومات مطلوبة من الزبون لاتمام طلب الخدمة' , 'type' => 'module' , 'html' => 'module_service_options_html.php' , 'php' => 'module_service_options_php.php' ) ;
$CMS['elem'][] = array( 'title' =>  'اضافة عرض لمدة محددة' , 'type' => 'module' ) ;
$CMS['elem'][] = array( 'title' =>  'السعر بعد الحسم' , 'name' => 'price_discount' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true , 'rule_number' => true ) ;
$CMS['elem'][] = array( 'title' =>  'من تاريخ' , 'name' => 'date_start' , 'type' => 'date' ) ;
$CMS['elem'][] = array( 'title' =>  'إلى تاريخ' , 'name' => 'date_end' , 'type' => 'date' ) ;
$CMS['elem'][] = array( 'title' =>  "عرض في صفحة العروض فقط" , 'name' => 'just_in_offer_page' , 'type' => 'radio' , 'lang' => 'ar' , 'option_type' => 'array' , 'options' => array( 'نعم' => 1 , 'لا' => 0 ) ) ;
$CMS['elem'][] = array( 'title' =>  'اضافة بنر اعلاني' , 'type' => 'module' ) ;
$CMS['elem'][] = array( 'title' =>  'رابط البنر' , 'name' => 'banner_link' , 'type' => 'text' , 'lang' => 'en' ) ;
$CMS['elem'][] = array( 'title' => 'صورة البنر' , 'name' => 'banner' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' , 'lang' => LANG ) ;
$CMS['elem'][] = array( 'title' =>  "أو عرض خدمات عشوائية" , 'name' => 'random_services' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'range' , 'option_first' => 0 , 'option_last' => 20 ) ;
$CMS['elem'][] = array( 'title' => 'نص الصفحة' , 'name' => 'body' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => true ) ;
$CMS['elem'][] = array( 'title' => 'الوصف' , 'name' => 'description' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
$CMS['elem'][] = array( 'title' => 'الكلمات المفتاحية' , 'name' => 'keywords' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
?>