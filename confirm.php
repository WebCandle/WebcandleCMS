<?php
require('functions.php');
if( confirmCustomer( $_GET ) ) {
	$_SESSION['signup_message'] = 'عزيزي المشترك, تم تأكيد حسابك بنجاح, بإمكانك تسجيل الدخول الآن' ;
	if( !empty($_GET['redirect']) ) redirect( urldecode($_GET['redirect']) );
	else redirect( 'home' );
}
else redirect('index.php');
?>