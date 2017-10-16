<?php
if( isset( $_POST['pass'] ) && isset( $_POST['name']) )
{
	if( $token = cms_login( $_POST['name'] , $_POST['pass'] ) ) {
		define( 'TOKEN' , $token ) ;
		define( 'LANG' , $_SESSION['cms_lang'] ) ;
		redirect( cms_url('system','home') ) ;
	}
	alert( 'خطأ في اسم المستخدم أو كلمة المرور' ) ;
}
?>
<body class="body-login">
<div id="system_login">
<div id="login-box">
<div id="login-control"><form method="post" action=""><input type="text" class="login-text login-name" id="login-name" name="name" value="User Name" maxlength="50" /><input type="password" class="login-text login-pass" id="login-pass" name="pass" maxlength="50" /><input type="submit" name="submit" value="" class="login-submit" /></form>
</div>
</div>
</div>
</body>
<script type="text/javascript">
$(document).ready(function(){
	$('#login-box').animate({top:0} , 1000 ) ;
	toolTip( 'login-name' ) ;
	toolTipPass( 'login-pass' ) ;
});
</script>