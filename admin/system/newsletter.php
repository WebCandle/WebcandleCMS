<?php
if( $_POST['subject'] && $_POST['message'] ) {
	$i = 0 ;
	if( $_POST['to'] == 'all' ) {
		$res = mysql_query( 'SELECT * FROM `subscription` ;' ) ;
		while( $row = mysql_fetch_assoc( $res ) ) {
			$email[] = trim( $row['email'] ) ;
			$i++ ;
		}
	} elseif($_POST['to'] == 'customers') {
		$res = mysql_query( 'SELECT * FROM `subscription` where `customer` = 1 ;' ) ;
		while( $row = mysql_fetch_assoc( $res ) ) {
			$email[] = trim( $row['email'] ) ;
			$i++ ;
		}
	} else {
		$email = explode( ',',$_POST['email']);
		$i = count( $email ) ;
	}
	if( $i ) {
		$smtp = NULL ;
		if( $_POST['smtp'] ) {
			$smtp['host'] = SETTINGS_SMTP_HOST ;
			$smtp['port'] = SETTINGS_SMTP_PORT ;
			$smtp['username'] = SETTINGS_SMTP_USERNAME ;
			$smtp['password'] = SETTINGS_SMTP_PASSWORD ;
		}
		$attach = NULL ;
		sendMail( $email , $_POST['from'] , $_POST['subject'] , $_POST['message'] , $attach , $smtp ) ;
		$success = "تم ارسال القائمة البريدية بنجاح إلى $i بريد الكتروني" ;
	}
}
?>
<h1 class="content-title">ارسال القائمة البريدية</h1>
<?php include 'system/notification.php' ; ?>
<div style="padding:10px;">
<form  accept-charset="UTF-8" method="post" action="">
<label><div class="label-title">المرسل</div><input type="text" class="form-text" name="from" value="<?php echo SETTINGS_EMAIL ; ?>" /></label>
<label><div class="label-title">الموضوع</div><input type="text" class="form-text" name="subject" /></label>
<label><div class="label-title">إلى</div><select class="form-select" onChange="newsletter_change_to(this)" name="to"><option value="all">جميع المشتركين</option><option value="customers">العملاء</option><option value="one">بريد الكتروني محدد ( لاضافة أكثر من بريد الكتروني استخدم الفاصلة ",")</option></select></label>
<label id="email_container" style="display:none;"><div class="label-title">البريد الالكتروني</div><input type="text" class="form-text en" name="email" /></label>
<label><div class="label-title">استخدام SMTP</div><input type="checkbox" name="smtp" /></label>
<!--<label><div class="label-title">المضيف / Host</div><input type="text" class="form-text" name="smtp_host" value="" dir="ltr" /></label>
<label><div class="label-title">المنفذ / Port</div><input type="text" class="form-text" name="smtp_port" value="26" dir="ltr" /></label>
<label><div class="label-title">اسم المستخدم / User Name</div><input type="text" class="form-text" name="smtp_username" value="" dir="ltr" /></label>
<label><div class="label-title">كلمة المرور / Password</div><input type="text" class="form-text" name="smtp_password" value="" dir="ltr" /></label>-->
<label><div class="editor-title">نص الرسالة</div><textarea id="message_editor" name="message"></textarea></label>
<div class="form-buttons"><input type="submit" name="submit" value="أرسل القائمة البريدية" class="form-submit" /></div>
<script type="text/javascript">
CKFinder.setupCKEditor( null, '<?php echo BASE_PATH ; ?>admin/editor/ckeditor/ckfinder/' );
CKEDITOR.replace( 'message_editor', { toolbar : [ [ 'Bold', 'Italic','Underline','Strike','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' , '-' ,'BidiLtr','BidiRtl', '-', 'BulletedList','-','TextColor','BGColor', '-', 'Link', 'Unlink','-', 'Maximize' , 'Image', 'Flash' , 'Iframe' , 'Table' , 'RemoveFormat','Format','FontSize','Source'] ], width : 777 , height : 400 ,language: 'ar' , resize_enabled : false , contentsLangDirection : 'rtl' , enterMode : CKEDITOR.ENTER_BR } );
function newsletter_change_to(elem ) {
	if( $(elem).val() == 'one' ) {
		$('#email_container').slideDown(100);
	} else $('#email_container').slideUp(100);
}
</script>
</form>
</div>