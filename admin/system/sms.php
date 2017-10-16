<?php if($_SESSION['cms_logged_in']) : ?>
<?php
if( $_POST['message'] && is_array( $_POST['sms']) ) {
	$numbers = '' ;
	foreach( $_POST['sms'] as $number ) {
		$numbers .= $number.',' ;
	}
	$code_result = sendSMS($numbers, $_POST['message'] ) ;
	if( $code_result == '100' ) $success = 'تم ارسالة الرسالة إلى العملاء بنجاح' ;
	else $warning = 'عذراً حصل خطأ أثناء ارسالة الرسالة , رقم الخطأ هو '.$code_result ;
}
?>
<h1 class="content-title">SMS</h1>
<?php include 'system/notification.php' ; ?>
<div style="padding:10px;">
<form method="post" action="" accept-charset="UTF-8">
<label>
<div class="label-title">نص الرسالة</div>
<textarea name="message" class="form-textarea"></textarea>
</label>
<div>
<div class="label-title">ارسال إلى العملاء</div>
<?php
$res  = mysql_query( 'select * from `customer` where `active` = 1 order by `fname`,`lname` ;');
while( $row = mysql_fetch_assoc( $res ) ) {
	$options .= '<label class="form-checkbox-option"><input class="form-checkbox" type="checkbox"'.$checked.' name="sms[]" value="'.$row['calling_code'].$row['mobile'].'" />&nbsp;&nbsp;'.html($row['fname'].' '.$row['lname']).'</label>' ;
}
echo '<div class="form-checkbox-options">'.$options.'<div class="clear"></div><div class="form-checkbox-options-control"><a href="javascript:void(0)" onclick="cmsCheckboxSelectAll(this)">تحديد الكل</a>&nbsp;|&nbsp;<a href="javascript:void(0)" onclick="cmsCheckboxDisselectAll(this)">إلغاء تحديد الكل</a></div></div><div class="clear"></div></label>' ;
?>
</div>
<div class="form-buttons"><input type="submit" class="form-submit" value="أرسل" /></div>
</form>
</div>
<?php endif ; ?>