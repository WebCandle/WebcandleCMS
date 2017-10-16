<?php
$CMS['table'] = 'customer' ;
$CMS['show_title'] = 'العملاء' ;
$CMS['is_arg'] = false ;
$CMS['show_order_by'] = 'fname' ;
$CMS['show_order_by_method'] = 'ASC' ; //ASC DESC
$CMS['edit_title'] = 'تعديل معلومات عميل' ;
$CMS['add_title'] = 'اضافة عميل' ;
$CMS['show_filter'] = array( 'fname' ,  'lname' ,'email' , 'phone','note' ) ;
$CMS['show_contract'] = '`confirmed` = 1' ;
$CMS['is_activation'] = true ;
$CMS['show_row_height'] = false ;

//functions

//$country = array( 'المملكة العربية السعودية' , 'قطر' , 'الامارات' , 'البحرين' , 'الكويت' , 'عمان' , 'الأردن' , 'مصر' , 'سوريا' , 'ليبيا' , 'تونس' , 'العراق' , 'لبنان' , 'السودان' , 'الجزائر' , 'المغرب' , 'موريتانيا' , 'اليمن' , 'فلسطين');
foreach( $country as $v ) $ccc[$v] = $v ;
function customer_get_orders_url_on_show($row) {
	return cms_link( 'cck/order_by_customer' , 'customer_id='.$row['id'] ) ;
}
function customer_send_to_mail($row) { 
	return '<a href="mailto:'.$row['email'].'" style="color:green;">'.$row['email'].'</a>' ;
}
function customer_get_info( $row ) {
	global $country;
	return '<div style="font-size:14px; line-height:20px;">الاسم : '.html($row['fname'].' '.$row['lname']).'<br />البريد الالكتروني : '.customer_send_to_mail($row).'<br />رقم الجوال : '.html($row['calling_code'].$row['mobile']).'<br />البلد : '.$country[$row['country']].'<br />المنطقة : '.html($row['address']).'<br />ملاحظات عن العميل : '.stripslashes($row['note']).'</div>' ;
}
//show element
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return customer_get_info( $row );' , 'width' => '500px' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'link' => 'return customer_get_orders_url_on_show($row) ;' , 'value' => 'return "عرض الطلبات" ;', 'width' => '100px' , 'self' => true ) ;
$CMS['show'][] = array( 'type' => 'date' , 'name' => 'created', 'width' => '100px' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'الاسم الاول' ,'name' => 'fname' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'الاسم الاخير' ,'name' => 'lname' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'اسم الشركة' ,'name' => 'company' , 'type' => 'text' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'title' => 'كلمة المرور' , 'password' => true , 'name' => 'pass' , 'type' => 'text' , 'lang' => 'en' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' => 'البريد الالكتروني' , 'name' => 'email' , 'type' => 'text' , 'lang' => 'en' ,  'rule_mail' => true , 'rule_not_in' => true , 'rule_not_in_table' => 'customer' , 'rule_not_in_column' => 'email' ) ;
$CMS['elem'][] = array( 'title' => 'رمز النداء الدولي' , 'name' => 'calling_code' , 'type' => 'text' , 'lang' => 'en' ) ;
$CMS['elem'][] = array( 'title' => 'رقم الجوال' , 'name' => 'mobile' , 'type' => 'text' , 'lang' => 'en' ) ;
$CMS['elem'][] = array( 'title' =>  'البلد' , 'name' => 'country' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'array' , 'options' => array_flip($country) ) ;
$CMS['elem'][] = array( 'value' => time() , 'created' => true , 'name' => 'created' , 'type' => 'hidden' , 'lang' => 'en' ) ;
$CMS['elem'][] = array( 'title' => 'المنطقة' , 'name' => 'address' , 'type' => 'text' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'title' => 'ملاحظات عن العميل' , 'name' => 'note' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
?>