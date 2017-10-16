<?php
$payment_method = array( 'paypal' => 'PayPal' , 'bank_transfer' => 'تحويل بنكي' , 'credit_card' => 'بطاقة الائتمان' ) ;
$q = 'select * from `order` where `id` = "'.escape($_GET['order_id']).'" limit 1;' ;
$res = mysql_query( $q ) ;
if( mysql_num_rows( $res ) )  {
	$row = mysql_fetch_assoc( $res ) ;
	$customer = getRecord( $row['customer_id'] , 'customer' ) ;
	$customer_name = filter( $row['customer_fname'].' '.$row['customer_lname'] ) ;
?>
<style type="text/css">
td { padding: 3px; }
</style>
<h1 class="content-title">فاتورة # <?php echo $_GET['order_id'] ; ?>&nbsp;&nbsp; بتاريخ <span dir="ltr"><?php echo date(DATE_FORMAT,$row['created']) ?></span></h1>
<div style="padding:15px;">
<table width="100%" border="0" cellpadding="0" style="font-size:14px; line-height:35px; text-align:center">
  <tr>
    <td width="28%"><h4>رقم الطلب</h4></td>
    <td><?php echo html(stripslashes($row['id'])) ?></td>
  </tr>
  <tr class="cms-row-odd">
    <td><h4>طريقة الدفع</h4></td>
    <td><?php echo $payment_method[$row['payment_method']] ; ?></td>
  </tr>
  <tr>
    <td><h4>السعر</h4></td>
    <td><?php echo html(stripslashes($row['total_price'])) ?> $</td>
  </tr>
<?php if( $row['payment_method'] == 'bank_transfer' ) : ?>
  <tr class="cms-row-odd">
    <td><h4>صورة التحويل</h4></td>
    <td><a href="../files/image/<?php echo $row['bank_transfer_img'] ?>" target="_blank"><img style="margin:10px;" src="../files/image/<?php echo $row['bank_transfer_img'] ?>" width="300" /></a></td>
  </tr>
  <tr>
    <td><h4>معلومات اضافية عن التحويل</h4></td>
    <td style="text-align:right; padding:0 20px;"><?php if( $row['bank_transfer_info'] ) echo str_replace(PHP_EOL,'<br />',html(stripslashes($row['bank_transfer_info']))) ; else echo 'لا يوجد' ; ?></td>
  </tr>
<?php endif ; ?>
  <tr class="cms-row-odd">
    <td><h4>العميل</h4></td>
    <td>
    	<table width="100%" border="0" cellpadding="0" style="text-align:center">
        	<tr>
            	<td width="20%"><h5>الاسم</h5></td>
                <td><?php echo $customer_name ?></td>
            </tr>
        	<tr>
            	<td><h5>الشركة</h5></td>
                <td><?php echo html(stripslashes($customer['company'])) ?></td>
            </tr>
        	<tr>
            	<td><h5>رقم الجوال</h5></td>
                <td dir="ltr"><?php echo html(stripslashes($customer['calling_code'].' - '.$customer['mobile'])) ?></td>
            </tr>
        	<tr>
            	<td><h5>البريد الالكتروني</h5></td>
                <td dir="ltr"><a href="mailto:<?php echo html(stripslashes($row['customer_email'])) ?>"><?php echo html(stripslashes($row['customer_email'])) ?></a></td>
            </tr>
        	<tr>
            	<td><h5>البلد</h5></td>
                <td><?php echo html(stripslashes($country[$customer['country']])) ?></td>
            </tr>
        	<tr>
            	<td><h5>المنطقة</h5></td>
                <td><?php echo html(stripslashes($customer['address'])) ?></td>
            </tr>
        </table>
	</td>
  </tr></table>
<h1 class="content-title">الخدمات المطلوبة</h1>
<div>
<table width="100%" border="0" cellpadding="0" style="font-size:14px; line-height:35px; text-align:center;">
  <?php
  	$res = mysql_query('select * from `order_service` where `order_id` = "'.escape($_GET['order_id']).'" ;') ;
	echo mysql_error();
	$odd = '';
	while( $option = mysql_fetch_assoc($res)) {
		$opts = json_decode( $option['options'] ) ;
		foreach( $opts as $key => $val ) {
			if( is_array( $val ) ) {
				$options = '<table>' ;
				foreach( $val as $v ) {
					$options .= '<tr><td width="20%"><h5>'.html($key).'</h5></td><td>'.str_replace(PHP_EOL,'<br />',html($v)).'</td></tr><tr><td colspan="2"><hr /></td></tr>' ;
					$key = '' ;
				}
				$options .= '</table>' ;
			}
			else $options .= '<table><tr><td width="20%"><h5>'.html($key).'</h5></td><td>'.html($val).'</td></tr><tr><td colspan="2"><hr /></td></tr></table>' ;
		}
		echo'  <tr'.$odd.'>
    <td width="28%"><h4>'.html(stripslashes(getColumn($option['service_id'],'service','title'))).'</h4></td>
    <td>'.str_replace(PHP_EOL,'<br />', $options ).'</td>
  </tr>' ;
  		if( empty($odd)) $odd = ' class="cms-row-odd"'; else $odd = '' ;
	}
  ?>
</table>
</div>
</div>
<?php
} else {
	echo '<div style="text-align:center; padding:50px;">لا يوجد</div>' ;
}
echo '<div class="form-buttons'.(empty($odd)?'':' cms-row-odd').'"><input type="button" class="form-button" value="عودة" onclick="window.location = \''.urldecode($_GET['redirect_to']).'\' " /></div>' ;
?>