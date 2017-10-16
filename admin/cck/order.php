<?php
$CMS['table'] = 'order' ;
$CMS['show_title'] = 'جديد الفواتير' ;
$CMS['is_arg'] = false ;
$CMS['show_order_by'] = 'created' ;
$CMS['show_order_by_method'] = 'ASC' ; //ASC DESC
$CMS['edit_title'] = 'تعديل' ;
$CMS['add_title'] = 'اضافة' ;
$CMS['is_add'] = false ;
$CMS['is_edit'] = false ;
$CMS['is_activation'] = false ;
$CMS['is_delete'] = false ;
$CMS['show_contract'] = ' `confirmed` = 0 ' ;
$CMS['is_confirm'] = true ;
$CMS['show_row_height'] = false ;
//functions
function customer_get_orders_url_on_show($row) {
	return DOMAIN.BASE_PATH.'index.php?page=orders&customer_id='.$row['id'] ;
}
function customer_send_to_mail($row) { 
	return '<a href="mailto:'.$row['email'].'" style="color:green;">'.$row['email'].'</a>' ;
}
function customer_show_info($row) {
	$customer = getRecord( $row['customer_id'] , 'customer');
	return '
		الزبون : '.$customer['name'].' <br />
		رقم الهاتف : '.$customer['phone'].' <br />
		البريد الالكتروني : <a href="mailto:'.$customer['email'].'">'.$customer['email'].'</a> 
	' ;
}
function customer_show_address( $row ) {
	return str_replace( "\n" , '<br />' , stripcslashes($row['address']) ) ;
}
function customer_show_order_link( $row ) {
	return '<a href="'.DOMAIN.BASE_PATH.'index.php?page=order&order_id='.$row['id'].'" target="_blank">الفاتورة</a>' ;
}
//show element
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return customer_show_info($row);' , 'width' => '250px' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return customer_show_address( $row );' , 'width' => '250px' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return customer_show_order_link( $row );' , 'width' => '100px' ) ;
$CMS['show'][] = array( 'type' => 'date' , 'name' => 'created' , 'width' => '80px' ) ;
//show element
//none
?>