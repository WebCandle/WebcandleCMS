<h1 class="content-title"><?php echo html(getColumn( $_GET['customer_id'] , 'customer' , 'fname').' '.getColumn( $_GET['customer_id'] , 'customer' , 'lname') ) ; ?></h1><br />
<div style="text-align:center; line-height: 30px;">

<table cellpadding="0" cellspacing="3" border="0" style="width:100%; margin: 0 auto;">
<tr>
	<th class="content-title">اسم الخدمة</th>
    <th class="content-title">عدد الزيارات</th>
</tr>
<?php
$q  = 'SELECT `service_id` , COUNT(`service_id`) AS `c` FROM `customer_visits` where `customer_id` = "'.escape($_GET['customer_id']).'" group by `service_id` ;' ;
$res = mysql_query( $q );
while( $row = mysql_fetch_assoc( $res ) ) {
	echo '<tr><td><a href="../service_'.$row['service_id'].'" target="_blank"><h2>'.html(getColumn( $row['service_id'] , 'service' , 'title') ).'</h2></a></td><td style="direction:ltr"><a>('.$row['c'].')</a></td></tr>';
}
?>
</table>
<div class="form-buttons">
<input type="button" class="form-button" value="عودة" onClick="window.location = '<?php echo urldecode( $_GET['redirect_to'] ) ; ?>' ;" />
</div>
<br />
</div>