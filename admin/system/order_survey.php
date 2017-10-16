<h1 class="content-title">احصائيات الطلبات</h1><br />
<div style="text-align:center; line-height: 30px;">

<table cellpadding="" cellspacing="2" border="0" style="width:100%; margin: 0 auto;">
<tr>
	<th class="content-title">اسم العميل</th>
    <th class="content-title">المبلغ المدفوع</th>
    <th class="content-title">عدد الخدمات</th>
    <th class="content-title">البريد الالكتروني</th>
    <th class="content-title">معلومات عن العميل</th>
</tr>
<?php
function customer_get_orders_url($customer_id) {
	return cms_link( 'cck/order_by_customer' , 'customer_id='.$customer_id ) ;
}
function customer_get_url($customer_id) {
	return cms_link( 'cck/customer/edit' , 'cms_id='.$customer_id.'&redirect_to='.urlencode(cms_current_link()) ) ;
}
$res = mysql_query( 'SELECT * FROM `order` where `status` in ( "complete","active") group by `customer_id` ;');
while( $row = mysql_fetch_assoc( $res ) ) {
	if( $row['customer_id'] ) {
		$customer_name = html(getColumn($row['customer_id'],'customer','fname').' '.getColumn($row['customer_id'],'customer','lname')) ;
		$note = stripslashes(str_replace(PHP_EOL,' ',getColumn( $row['customer_id'] , 'customer','note' ))) ;
		$customer_url = customer_get_url($row['customer_id']) ;
		$customer_email = getColumn( $row['customer_id'] , 'customer','email' ) ;
	} else {
		$customer_name =$note =  ' - عميل مجهول - ' ;
		$customer_email = $customer_url = '' ;
	}
	$order_url = customer_get_orders_url($row['customer_id']) ;
	echo '<tr><td><a href="'.$customer_url.'"><h4>'.$customer_name.'</h4></a></td><td><a>($'. customer_total_order_paid( $row['customer_id'] ).')</a></td><td><a href="'.$order_url.'">('. customer_order_count( $row['customer_id'] ).')</a></td><td><a href="mailto:'.$customer_email.'">'.$customer_email.'</a></td><td><p>('.$note.')</p></td></tr>';
}
?>
</table>
<br />
</div>