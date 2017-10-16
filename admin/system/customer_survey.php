<h1 class="content-title">احصائيات العملاء</h1><br />
<div style="text-align:center; line-height: 30px;">

<table cellpadding="" cellspacing="2" border="0" style="width:100%; margin: 0 auto;">
<tr>
	<th class="content-title">اسم العميل</th>
    <th class="content-title">المبلغ المدفوع</th>
    <th class="content-title">الخدمات التي زارها</th>
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
function customer_service_visits_count( $customer_id ) {
	$q = 'select COUNT(*) as c from `customer_visits` where `customer_id` = "'.$customer_id.'" group by `service_id` ; ' ;
	$r = mysql_fetch_assoc(mysql_query($q) );
	return $r['c'] ;
}
$res = mysql_query( 'SELECT * FROM `customer` where `active` = 1 ;');
while( $row = mysql_fetch_assoc( $res ) ) {
	$customer_name = html( $row['fname'] .' '. $row['lname'] ) ;
	$note = stripslashes(str_replace(PHP_EOL,' ', $row['note'] )) ;
	$customer_url = customer_get_url($row['id']) ;
	$customer_email = $row['email'] ;
	$order_url = customer_get_orders_url($row['id']) ;
	$total_paid = customer_total_order_paid( $row['id'] ) ;
	$total_paid = $total_paid ? '($'. $total_paid.')' : '' ;
	$visits_url = cms_link( 'system/service_visits_survey_by_customer_id' , 'customer_id='.$row['id'].'&redirect_to='.urlencode(cms_current_link()) ) ;
	echo '<tr><td><a href="'.$customer_url.'"><h4>'.$customer_name.'</h4></a></td><td><a>'.$total_paid.'</a></td><td><a href="'.$visits_url.'">'. customer_service_visits_count( $row['id'] ).'</a></td><td><a href="mailto:'.$customer_email.'">'.$customer_email.'</a></td><td><p>('.$note.')</p></td></tr>';
}
?>
</table>
<br />
</div>