<?php
if( !empty( $_POST['department_id'] ) && !empty( $_POST['subject'] ) && !empty( $_POST['message'] ) ) {
	$group_id = getColumn( $_POST['department_id'] , 'ticket_department' , 'group_id' ) ;
	$res = mysql_query('select * from `user` where `group_id` = "'.escape($group_id).'" ;');
	while( $row = mysql_fetch_assoc( $res ) ) {
		sendMail( $row['mail'] , SETTINGS_EMAIL , $_POST['subject'] , str_replace(PHP_EOL,'<br />',$_POST['message'] ) );
	}
}
?>