<?php
//$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_FACEBOOK , 'name' => 'SETTINGS_FACEBOOK' , 'lang' => 'all' , 'type' => 'text' , 'required' => true ) ;
//$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_TWITTER , 'name' => 'SETTINGS_TWITTER' , 'lang' => 'all' , 'type' => 'text' , 'required' => true ) ;
/*$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_DEFAULT_LANG , 'name' => 'SETTINGS_DEFAULT_LANG' , 'lang' => 'all' , 'type' => 'select' , 'option_type' => 'array' , 'options' => $langs , 'dir' => 'rtl' ) ;*/
/*foreach( $langs as $title => $lang )
$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_CURRENCY.' ( '.$title.' )' , 'name' => 'SETTINGS_CURRENCY' , 'lang' => $lang , 'type' => 'text' , 'required' => true ) ;*/
/*$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_SITE_TITLE , 'name' => 'SETTINGS_SITE_TITLE' , 'lang' => 'ar' , 'type' => 'text' , 'required' => true ) ;*/
/*$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_META_DESCRIPTION , 'name' => 'SETTINGS_META_DESCRIPTION' , 'lang' => 'ar' , 'type' => 'text' , 'required' => true ) ;*/
/*$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_META_KEYWORDS , 'name' => 'SETTINGS_META_KEYWORDS' , 'lang' => 'ar' , 'type' => 'textarea' , 'required' => true ) ;*/

$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_EMAIL , 'name' => 'SETTINGS_EMAIL' , 'lang' => 'all' , 'type' => 'text' , 'required' => true ) ;
$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_SITE_TITLE , 'name' => 'SETTINGS_SITE_TITLE' , 'lang' => 'ar' , 'type' => 'text' , 'required' => true ) ;
//$SETTINGS['elem'][] = array( 'title' => "صفحة شروط الاستخدام" , 'name' => 'SETTINGS_PRIVICY_PAGE' , 'lang' => 'ar' , 'type' => 'text' , 'required' => true ) ;
$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_META_DESCRIPTION , 'name' => 'SETTINGS_META_DESCRIPTION' , 'lang' => 'ar' , 'type' => 'text' , 'required' => true ) ;
$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_META_KEYWORDS , 'name' => 'SETTINGS_META_KEYWORDS' , 'lang' => 'ar' , 'type' => 'textarea' , 'required' => true ) ;
$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_FACEBOOK , 'name' => 'SETTINGS_FACEBOOK' , 'lang' => 'all' , 'type' => 'text' , 'required' => true ) ;
$SETTINGS['elem'][] = array( 'title' => _CMS_SETTINGS_TWITTER , 'name' => 'SETTINGS_TWITTER' , 'lang' => 'all' , 'type' => 'text' , 'required' => true ) ;
$SETTINGS['elem'][] = array( 'title' => "رابط إنستغرام" , 'name' => 'SETTINGS_INSTAGRAM' , 'lang' => 'all' , 'type' => 'text' , 'required' => true ) ;
$SETTINGS['elem'][] = array( 'title' => "رابط يوتيوب" , 'name' => 'SETTINGS_YOUTUBE' , 'lang' => 'all' , 'type' => 'text' , 'required' => true ) ;
//smtp
$SETTINGS['elem'][] = array( 'title' => 'SMTP : المضيف / Host' , 'name' => 'SETTINGS_SMTP_HOST' , 'lang' => 'en' , 'type' => 'text' , 'required' => true ) ;
$SETTINGS['elem'][] = array( 'title' => 'SMTP : المنفذ / Port' , 'name' => 'SETTINGS_SMTP_PORT' , 'lang' => 'en' , 'type' => 'text' , 'required' => true ) ;
$SETTINGS['elem'][] = array( 'title' => 'SMTP : اسم المستخدم' , 'name' => 'SETTINGS_SMTP_USERNAME' , 'lang' => 'en' , 'type' => 'text' , 'required' => true ) ;
$SETTINGS['elem'][] = array( 'title' => 'SMTP : كلمة المرور' , 'name' => 'SETTINGS_SMTP_PASSWORD' , 'lang' => 'en' , 'type' => 'password' , 'required' => true ) ;
///
$SETTINGS['elem'][] = array( 'title' => 'استخدام التحقق البشري' , 'name' => 'USE_VERIFYIMAGE_ON_SIGNUP' , 'lang' => 'all' , 'type' => 'select' , 'options' => array( 'نعم' => '1' , 'لا' => '0' ) ) ;
$SETTINGS['elem'][] = array( 'title' => 'عرض معرض الصور' , 'name' => 'DISPLAY_GALLERY_ON_HOME' , 'lang' => 'all' , 'type' => 'select' , 'options' => array( 'نعم' => '1' , 'لا' => '0' ) ) ;
$SETTINGS['elem'][] = array( 'title' => 'عرض خدمات اخترناها لكم' , 'name' => 'DISPLAY_SERVICES_ON_HOME' , 'lang' => 'all' , 'type' => 'select' , 'options' => array( 'نعم' => '1' , 'لا' => '0' ) ) ;
$SETTINGS['elem'][] = array( 'title' => 'عرض النص المتحرك' , 'name' => 'DISPLAY_BLUE_VIEW_ON_HOME' , 'lang' => 'all' , 'type' => 'select' , 'options' => array( 'نعم' => '1' , 'لا' => '0' ) ) ;
$SETTINGS['elem'][] = array( 'title' => 'عرض بعض أعمالنا' , 'name' => 'DISPLAY_PORTFOLIO_ON_HOME' , 'lang' => 'all' , 'type' => 'select' , 'options' => array( 'نعم' => '1' , 'لا' => '0' ) ) ;
$SETTINGS['elem'][] = array( 'title' => 'عرض الخطط' , 'name' => 'DISPLAY_PLANS_ON_HOME' , 'lang' => 'all' , 'type' => 'select' , 'options' => array( 'نعم' => '1' , 'لا' => '0' ) ) ;
$SETTINGS['elem'][] = array( 'title' => 'عرض مربع معلومات الاتصال' , 'name' => 'DISPLAY_CONTACT_INFO_HOME' , 'lang' => 'all' , 'type' => 'select' , 'options' => array( 'نعم' => '1' , 'لا' => '0' ) ) ;
$SETTINGS['elem'][] = array( 'title' => 'عرض آراء العملاء' , 'name' => 'DISPLAY_CLIENT_VIEWS_ON_HOME' , 'lang' => 'all' , 'type' => 'select' , 'options' => array( 'نعم' => '1' , 'لا' => '0' ) ) ;
$SETTINGS['elem'][] = array( 'title' => 'عرض شعارات العملاء' , 'name' => 'DISPLAY_CLIENT_LOGOS_ON_HOME' , 'lang' => 'all' , 'type' => 'select' , 'options' => array( 'نعم' => '1' , 'لا' => '0' ) ) ;
$SETTINGS['elem'][] = array( 'title' => 'رسالة التحقق من البريد الالكتروني' , 'name' => 'SETTINGS_CONFIRM_EMAIL_MESSAGE' , 'lang' => 'ar' , 'type' => 'textarea' , 'editable' => true ) ;
$SETTINGS['elem'][] = array( 'title' => 'رسالة الترحيب SMS' , 'name' => 'SETTINGS_WELCOME_SMS_MESSAGE' , 'lang' => 'ar' , 'type' => 'textarea' , 'editable' => false ) ;
//$SETTINGS['elem'][] = array( 'title' => 'طرق الاتصال' , 'name' => 'SETTINGS_CONTACT_METHODS' , 'lang' => 'ar' , 'type' => 'textarea' , 'editable' => true ) ;
//$SETTINGS['elem'][] = array( 'title' => 'عن الشركة' , 'name' => 'SETTINGS_ABOUT_COMPANY' , 'lang' => 'ar' , 'type' => 'textarea' , 'editable' => true ) ;
//$SETTINGS['elem'][] = array( 'title' => 'اتفاقية الاستخدام' , 'name' => 'SETTINGS_TERMS_OF_USE' , 'lang' => 'ar' , 'type' => 'textarea' , 'editable' => true ) ;

if( $_POST['submit'] ) {
	foreach( $SETTINGS['elem'] as $elem ) {
		$res = mysql_query('SELECT * FROM `settings` WHERE `key` = "'.$elem['name'].'" AND `lang` = "'.$elem['lang'].'" LIMIT 1 ;') ;
		if( mysql_num_rows( $res ) ) {
			mysql_query( 'UPDATE `settings` SET `value` = "'.escape($_POST[$elem['name'].'_'.$elem['lang']]).'" WHERE `key` = "'.$elem['name'].'" AND `lang` = "'.$elem['lang'].'" LIMIT 1 ;' ) ;
		}
		else {
			mysql_query( 'INSERT INTO `settings` SET `value` = "'.escape($_POST[$elem['name'].'_'.$elem['lang']]).'" , `key` = "'.$elem['name'].'" , `lang` = "'.$elem['lang'].'" ;' ) ;
		}
	}
}
$i = 0 ;
foreach( $SETTINGS['elem'] as $key => $elem ) {
	$elemId = 'settings'.$i++ ;
	$real_value = stripslashes(getSettings( $elem['name'] , $elem['lang'] )) ;
	$value = cms_inputValue($real_value) ;
	switch( $elem['type'] ) {
		case 'text' :
			$SETTINGS['html'] .= '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div><input id="'.$elemId.'" type="text" name="'.$elem['name'].'_'.$elem['lang'].'" class="form-text '.$elem['lang'].'" value="'.$value.'" /></label>' ;
			break ;
		case 'password' :
			$SETTINGS['html'] .= '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div><input id="'.$elemId.'" type="password" name="'.$elem['name'].'_'.$elem['lang'].'" class="form-text '.$elem['lang'].'" value="'.$value.'" /></label>' ;
			break ;
		case 'textarea' :
			if( $elem['editable'] ) {
				$CMS['js'] .= "CKEDITOR.replace( '".$elemId."', { toolbar : [ [ 'Bold', 'Italic','Underline','Strike','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' , '-' ,'BidiLtr','BidiRtl', '-', 'BulletedList','-','TextColor','BGColor', '-', 'Link', 'Unlink','-', 'Maximize' , 'Image', 'Flash' , 'Iframe' , 'Table' , 'RemoveFormat','Format','FontSize','Source'] ], width : 777 , height : 250 ,language: '".LANG."' , resize_enabled : false , contentsLangDirection : '".( ($elem['lang'] == 'ar' ) ? 'rtl' : 'ltr' )."' , enterMode : CKEDITOR.ENTER_BR } );".PHP_EOL ;
				$SETTINGS['html'] .= '<label for="'.$elemId.'"><div class="editor-title">'.$elem['title'].'</div><textarea id="'.$elemId.'" class="form-textarea '.$elem['lang'].'" name="'.$elem['name'].'_'.$elem['lang'].'">'.$real_value.'</textarea></label>' ;
			} else {
				$SETTINGS['html'] .= '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div><textarea id="'.$elemId.'" class="form-textarea '.$elem['lang'].'" name="'.$elem['name'].'_'.$elem['lang'].'">'.$real_value.'</textarea></label>' ;
			}
			break ;
		case 'select' :
			$SETTINGS['html'] .= '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div><select id="'.$elemId.'" class="form-select '.$elem['dir'].'" name="'.$elem['name'].'_'.$elem['lang'].'">'.cms_getSelectOptions( $elem['options'] , $value ).'</select></label>' ;
			break ;
			
	}
}
?>
<div id="system_settings">
<h1 class="content-title"><?php echo _CMS_SETTINGS_MANAGEMENT ; ?></h1>
<form method="post" action="" accept-charset="UTF-8">
<?php echo $SETTINGS['html'] ; ?>
<input type="hidden" name="submit" value="1" />
<div class="form-buttons"><input type="submit" value="<?php echo _CMS_SAVE ; ?>" class="form-submit" />&nbsp;&nbsp;&nbsp;<input type="reset" value="<?php echo _CMS_CANCEL ; ?>" class="form-button" /></div>
</form>
</div>
<?php if( $CMS['js'] ) : ?>
<script type="text/javascript">
CKFinder.setupCKEditor( null, '<?php echo BASE_PATH ; ?>admin/editor/ckeditor/ckfinder/' );

<?php echo $CMS['js'] ; ?>
</script>
<?php endif ; ?>