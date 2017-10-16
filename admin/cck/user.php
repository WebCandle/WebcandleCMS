<?php
$CMS['table'] = 'user' ;
$CMS['show_title'] = 'المدراء' ;
//$CMS['show_contract'] = '`id` != 1' ; //super admin
$CMS['is_arg'] = false ;
$CMS['show_order_by'] = 'name' ;
$CMS['show_order_by_method'] = 'ASC' ; //ASC DESC
$CMS['edit_title'] = 'تعديل' ;
$CMS['add_title'] = 'اضافة' ;

function _get_permission_name($row) {
	return getColumn( $row['group_id'] ,  'user_group','name' );
}
//show element
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'display_name' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return _get_permission_name($row);' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  _CMS_USER_NAME ,'name' => 'name' , 'type' => 'text' , 'lang' => 'en' , 'rule_required' => true , 'rule_not_in' => true , 'rule_not_in_table' => 'user' , 'rule_not_in_column' => 'name' ) ;
$CMS['elem'][] = array( 'title' => _CMS_USER_PASS , 'password' => true , 'name' => 'pass' , 'type' => 'text' , 'lang' => 'en' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' => _CMS_USER_MAIL , 'name' => 'mail' , 'type' => 'text' , 'lang' => 'en' ,  'rule_mail' => true , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' => 'الأسم الثلاثي' , 'name' => 'display_name' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  'الصلاحيات' , 'name' => 'group_id' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'user_group' , 'option_title' => 'name' , 'option_value' => 'id'  ) ;
$CMS['elem'][] = array( 'value' => time() , 'created' => true , 'name' => 'created' , 'type' => 'hidden' , 'lang' => 'en' ) ;
?>