<?php
$CMS['table'] = 'ticket' ;
$CMS['section'] = 'ticket_answered' ;
$CMS['show_title'] = 'التذاكر المجابة' ;
$CMS['is_arg'] = false ; //there is arg culomn in the table and have to put number in it
$CMS['is_activation'] = false ;
$CMS['is_add'] = false ;
$CMS['show_order_by'] = 'created' ;
$CMS['show_order_by_method'] = 'DESC' ; //ASC DESC
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['show_contract'] = ' `status` = "closed" ' ;
$CMS['show_row_height'] = false ;

function _get_ticket_status($row) {
	global $ticket_status ;
	switch( $row['status'] ) {
		case 'open' : $color = 'green' ; break ;
		case 'customer-reply' : $color = '#FF6600' ; break ;
	}
	return '<span style="color:'.$color.';">'.$ticket_status[$row['status']].'</span>' ;
}
function _get_ticket_link($row) {
	return 'الموضوع : <a href="'.cms_link('system/ticket','tid='.$row['id'].'&redirect='.urlencode(cms_current_link())).'">'.filter($row['title']).'</a>, العميل : '.(empty($row['name'])?'<a href="'.cms_link('cck/customer/edit','cms_id='.$row['customer_id'].'&redirect_to='.urlencode(cms_current_link())).'">'.html(getColumn($row['customer_id'],'customer','name')).'</a>': html($row['name']).', بريده الالكتروني : <a href="mailto:'.html($row['email']).'">'.html($row['email']).'</a><br />القسم : '.getColumn( $row['department_id'] , 'ticket_department','name') ) ;
}
//show element
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return _get_ticket_link($row);' , 'width' => '560px' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return _get_ticket_status($row);' , 'width' => '80px' ) ;
$CMS['show'][] = array( 'type' => 'date' , 'name' => 'created', 'width' => '80px' ) ;
//elements

$CMS['elem'][] = array( 'title' =>  "الحالة" , 'name' => 'status' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'array' , 'options' => array_flip($ticket_status) ) ;
?>