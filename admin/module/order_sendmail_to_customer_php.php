<?php
//send mail to customer
if( $_POST['sendmail_to_customer'] == 'on' && !empty( $_POST['subject'] ) && !empty( $_POST['message'] ) ) {
	sendMail( $_POST['mail_to'] , SETTINGS_EMAIL , $_POST['subject'] , $_POST['message'] );
}
?>