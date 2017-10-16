<h1 class="content-title"><?php echo getColumn( $_GET['service_id'] , 'service' , 'title') ; ?></h1><br />
<div style="text-align:center; line-height: 30px;">

<table cellpadding="0" cellspacing="3" border="0" style="width:100%; margin: 0 auto;">
<tr>
	<th class="content-title">العميل</th>
    <th class="content-title">عدد الزيارات</th>
</tr>
<?php
$res = mysql_query( 'SELECT `customer_id` , COUNT(`service_id`) AS `c` FROM `customer_visits` where `service_id` = "'.escape($_GET['service_id']).'" group by `customer_id` ;');
while( $row = mysql_fetch_assoc( $res ) ) {
	echo '<tr><td><h2>'.html(getColumn( $row['customer_id'] , 'customer' , 'fname').' '.getColumn( $row['customer_id'] , 'customer' , 'lname')).'</h2></td><td style="direction:ltr"><a>('.$row['c'].')</a></td></tr>';
}
?>
</table>
<div class="form-buttons">
<input type="button" class="form-button" value="عودة" onClick="window.location = '<?php echo urldecode( $_GET['redirect_to'] ) ; ?>' ;" />
</div>
<br />
</div>