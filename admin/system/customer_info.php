<h1 class="content-title">معلومات المستخدم</h1>
<div style="padding:15px;">
<?php
$q = 'select * from `customer` where `id` = "'.escape($_GET['customer_id']).'" limit 1;' ;
$res = mysql_query( $q ) ;
if( mysql_num_rows( $res ) )  {
	$row = mysql_fetch_assoc( $res ) ;
?>
<table width="100%" border="0" cellpadding="0" style="font-size:14px; line-height:35px; text-align:center">
  <tr>
    <td>الأسم</td>
    <td><?php echo $row['name'] ?></td>
  </tr>
  <tr class="cms-row-odd">
    <td>البريد اللاكتروني</td>
    <td><a href="mailto:<?php echo $row['email'] ?>"><?php echo $row['email'] ?></a></td>
  </tr>
  <tr>
    <td>رقم الهاتف</td>
    <td><?php echo $row['phone'] ?></td>
  </tr>
  <tr class="cms-row-odd">
    <td>فيسبوك</td>
    <td><a target="_blank" href="<?php echo stripslashes($row['facebook']) ?>"><?php echo stripslashes($row['facebook']) ?></a></td>
  </tr>
  <tr>
    <td>تويتر</td>
    <td><a target="_blank" href="<?php echo stripslashes($row['twitter']) ?>"><?php echo stripslashes($row['twitter']) ?></a></td>
  </tr>
  <tr class="cms-row-odd">
    <td>الجنس</td>
    <td><?php if( $row['gender'] == 1 ) echo 'ذكر' ; else echo 'أنثى' ?></td>
  </tr>
  <tr>
    <td>الصورة</td>
    <td><?php  echo '<img style="margin: 3px 0;" src="'.(($row['photo']) ? src( $row['photo'] , CUSTOMER_PHOTO_WIDTH , CUSTOMER_PHOTO_HEIGHT , 'user' ) : BASE_PATH.'images/person.png' ).'" />' ; ?></td>
  </tr>
</table>
<?php
} else {
	echo '<div style="text-align:center; padding:50px;">لا يوجد</div>' ;
}
echo '<div class="form-buttons cms-row-odd"><input type="button" class="form-button" value="عودة" onclick="window.location = \''.urldecode($_GET['redirect_to']).'\' " /></div>' ;
?>
</div>