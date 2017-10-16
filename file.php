<?php
include('config.php');
list( $folder , $name ) = explode( '/' , $_GET['id'] ) ;
if( !empty( $folder ) && !empty( $name ) ) {
	$res = mysql_query( 'SELECT * FROM `file` WHERE `name` = "'.mysql_real_escape_string($name).'" AND `folder` = "'.mysql_real_escape_string($folder).'" LIMIT 1 ;' ) ;
	if( mysql_num_rows( $res ) ) {
		$row = mysql_fetch_assoc( $res ) ;
		$fileName = $row['real_name'] ;
		$file = 'files/'.$row['folder'].'/'.$row['name'] ;
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.$fileName);
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
	}
}
mysql_close($conn);
?>