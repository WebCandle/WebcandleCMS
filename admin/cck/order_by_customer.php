<?php
$CMS['table'] = 'order' ;
$CMS['section'] = 'order_by_customer' ;
$CMS['show_title'] = 'طلبات '.getColumn( $_GET['customer_id'] ,'customer','fname').' '.getColumn( $_GET['customer_id'] ,'customer','lname') ;
$CMS['is_arg'] = false ; //there is arg culomn in the table and have to put number in it
$CMS['is_delete'] = true ;
$CMS['is_add'] = false ;
$CMS['is_activation'] = false ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['show_order_by'] = 'created' ;
$CMS['show_order_by_method'] = 'DESC' ;
$CMS['show_row_height'] = false ;
$CMS['show_contract'] = ' `status` != "saved" AND `customer_id` = "'.escape($_GET['customer_id']).'"' ;

//show element
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return show_order($row) ;' , 'width' => '630px' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return show_order_link($row) ;' , 'width' => '90px'  );
//elements
$CMS['elem'][] = array( 'title' =>  'حالة الطلب' , 'name' => 'status' , 'type' => 'select' , 'option_type' => 'array' , 'options' => array_flip($order_status) ) ;
$CMS['elem'][] = array( 'type' => 'module' , 'html' => 'order_sendmail_to_customer_html.php' , 'php' => 'order_sendmail_to_customer_php.php' ) ;
?>