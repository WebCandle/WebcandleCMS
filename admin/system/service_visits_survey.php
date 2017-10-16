<h1 class="content-title">أكثر الخدمات زيارة</h1><br />
<div style="text-align:center; line-height: 30px;">

<table cellpadding="0" cellspacing="3" border="0" style="width:100%; margin: 0 auto;">
<tr>
	<th class="content-title">الخدمة</th>
    <th class="content-title">عدد الزيارات</th>
</tr>
<?php
$res = mysql_query( 'SELECT * FROM `service` where `visits` != 0 order by `visits` DESC ;');
while( $row = mysql_fetch_assoc( $res ) ) {
	echo '<tr><td><a href="../service_'.$row['service_id'].'" target="_blank"><h2>'.stripslashes($row['title']).'</h2></a></td><td style="direction:ltr"><a href="'.cms_link( 'system/service_visits_survey_by_customer' , 'service_id='.$row['id'].'&redirect_to='.urlencode(cms_current_link()) ).'">('.$row['visits'].')</a></td></tr>';
}
?>
</table>
<br />
</div>