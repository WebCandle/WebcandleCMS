<h1 class="content-title">صفحتي الشخصية</h1>
<?php
$profile = getRecord( $_SESSION['cms_user_id'] , 'user' ) ;
if( $_POST['profile'] ) {
	if( md5($_POST['pass']) == $profile['pass'] ) {
		if( !empty( $_POST['new_pass'] ) ) {
			if( $_POST['new_pass'] != $_POST['confirm_new_pass'] ) $warning = 'تأكيد كلمة المرور التي أدخلتها غير صحيحة, الرجاء التأكد من كلمة المرور' ;
			else $ps = ' , `pass` = "'.pass($_POST['pass']).'" ' ;
		}
		if( !$warning ) {
			mysql_query('update `user` set `display_name` = "'.escape($_POST['display_name']).'" , `mail`= "'.escape($_POST['mail']).'" '.($ps?$ps:'').' where `id` = "'.escape($_SESSION['cms_user_id']).'" limit 1;') ;
			$success = 'تم حفظ المعلومات بنجاح'.($ps?', كما تم تعديل كلمة المرور':'') ;
		}
	} else $warning = 'كلمة المرور التي أدخلتها غير صحيحة' ;
}


include 'system/notification.php' ;
?>


<form method="post" accept-charset="UTF-8" onsubmit="return true;" action="">

<label for="cms_elem1"><div class="label-title">الأسم الثلاثي</div><input type="text" value="<?php echo html( $profile['display_name'] ) ; ?>" name="display_name" class="form-text ar" id="cms_elem1"></label>

<label for="cms_elem2"><div class="label-title">البريد الالكتروني</div><input type="text" value="<?php echo html( $profile['mail'] ) ; ?>" name="mail" class="form-text en" id="cms_elem2"></label>

<label for="cms_elem3"><div class="label-title">كلمة المرور الجديدة</div><input type="password" value="" name="new_pass" class="form-text en" style="text-align:center" id="cms_elem3"></label>

<label for="cms_elem4"><div class="label-title">تأكيد كلمة المرور الجديدة</div><input type="password" value="" name="confirm_new_pass" style="text-align:center" class="form-text en" id="cms_elem4"></label>

<label for="cms_elem5"><div class="label-title">يجب ادخال كلمة المرور الحالية</div><input type="password" value="" name="pass" class="form-text en" style="text-align:center" id="cms_elem5"></label>
<input type="hidden" name="profile" value="1" />

<div class="form-buttons"><input type="submit" class="form-submit" value="حفظ" name="submit" id="cmsFormSubmit" />&nbsp;&nbsp;&nbsp;<input type="reset" class="form-button" value="الغاء الأمر" /></div>
</form>