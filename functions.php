<?php
require_once('config.php');
require_once('utf8.php');
ini() ;
//CMS functions
function ini() {
	session_start() ;
	$lang = 'ar' ;
	//Settings keys
	$keys = mysql_query( 'SELECT * FROM `settings` WHERE `lang` IN ( "all" , "'.$lang.'" ) ;' ) ;
	while( $row = mysql_fetch_assoc( $keys ) )
	define( $row['key'] , $row['value'] ) ;
	//Language keys
	$keys = mysql_query( 'SELECT * FROM `lang_key_value` WHERE `lang` = "'.escape( $lang ).'" ;' ) ;
	while( $row = mysql_fetch_assoc( $keys ) )
	  define( $row['key'] , $row['value'] ) ;
}
function current_link() {
	return $_SERVER['REQUEST_URI'] ;
}
function sendMail( $to , $from , $subject , $message  , $attach = NULL , $smtp = NULL ) {
	require_once( dirname(__FILE__).'/class/phpmailer.php' ) ;
	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
	//smtp
	if( is_array( $smtp ) ) {
		$mail->IsSMTP();
		$mail->Host = $smtp['host'];
		$mail->SMTPAuth = true;
		$mail->Port = $smtp['port'] ? $smtp['port'] :26;
		$mail->Username   = $smtp['username'];
		$mail->Password   = $smtp['password']; 
	}
	$mail->CharSet = 'UTF-8';
	//$to  = array of emails or one email
	if( is_array( $to ) ) {
		foreach( $to as $t ) {
			if( !isset( $the_first_email ) ) { $mail->AddAddress( $t ); $the_first_email = 'done' ; }
			else $mail->AddBCC( $t ) ;
		}
	} else $mail->AddAddress( $to );
	$mail->SetFrom( $from , $from );
	$mail->AddReplyTo( $from , $from);
	//$attach = array( path => name ....
	if( is_array( $attach ) ) {
		foreach( $attach as $path => $name ) $mail->AddAttachment($path,$name);
	}
	$mail->Subject = $subject ;
	$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
	//rtl
	$message  = '<div dir="rtl">'.$message .'</div>' ;
	$mail->MsgHTML( $message ) ;
	return $mail->Send() ;
}
function resizeImage( $path , $newpath , $new_width , $new_height , $constrain_aspect_ratio ) {
   if (!extension_loaded('gd') && !extension_loaded('gd2')) {
	trigger_error("GD is not loaded", E_USER_WARNING);
	return false;
   }   
   //Get Image size info
   $pathInfo = getimagesize($path);
   switch ($pathInfo[2]) {
	case 1: $im = imagecreatefromgif($path); break;
	case 2: $im = imagecreatefromjpeg($path);  break;
	case 3: $im = imagecreatefrompng($path); break;
	default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;
   }
   if( $constrain_aspect_ratio ) {
	   //If image dimension is smaller, do not resize
	   if ($pathInfo[0] <= $new_width && $pathInfo[1] <= $new_height) {
		$nHeight = $pathInfo[1];
		$nWidth = $pathInfo[0];
	   }else{
		//yeah, resize it, but keep it proportional
		if ($new_width/$pathInfo[0] > $new_height/$pathInfo[1]) {
		 $nWidth = $new_width;
		 $nHeight = $pathInfo[1]*($new_width/$pathInfo[0]);
		}else{
		 $nWidth = $pathInfo[0]*($new_height/$pathInfo[1]);
		 $nHeight = $new_height;
		}
	   }
	   $nWidth = round($nWidth);
	   $nHeight = round($nHeight);   
   }
   else {
	   $nWidth = round($new_width);
	   $nHeight = round($new_height); 
   }
   $newImg = imagecreatetruecolor($nWidth, $nHeight); 
   /* Check if this image is PNG or GIF, then set if Transparent*/  
   if(($pathInfo[2] == 1) OR ($pathInfo[2]==3)){
	imagealphablending($newImg, false);
	imagesavealpha($newImg,true);
	$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
	imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
   }
   imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $pathInfo[0], $pathInfo[1]);
   //Generate the file, and rename it to $newpath
   switch ($pathInfo[2]) {
	case 1: imagegif($newImg,$newpath); break;
	case 2: imagejpeg($newImg,$newpath);  break;
	case 3: imagepng($newImg,$newpath); break;
	default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
   }
	 return $newpath;		
}
function pagination( $total = 0 , $page = 1 , $limit = 20 ) {
	//public vars
	$num_links = 10;
	$url = 'index.php?' ;
	foreach( $_GET as $var => $value ) {
		if( $var != 'cms_page' ) $url .= $var.'='.$value.'&';
	}
	$url .= 'cms_page={page}';
	if( LANG == 'ar' ) $text = 'عرض {start} إلى {end} من {total} ( {pages} صفحة )';
	else $text = 'Showing {start} to {end} of {total} ({pages} Pages)';
	$text_first = '|&lt;';
	$text_last = '&gt;|';
	$text_next = '&gt;';
	$text_prev = '&lt;';
	$style_links = 'cms-pagination-links';
	$style_results = 'cms-pagination-results';
	//start function
	if ($page < 1) {
		$page = 1;
	}
	
	if (!(int)$limit) {
		$limit = 10;
	}
	
	$num_pages = ceil($total / $limit);
	
	$output = '';
	
	if ($page > 1) {
		$output .= ' <a href="' . str_replace('{page}', 1, $url) . '">' . $text_first . '</a> <a href="' . str_replace('{page}', $page - 1, $url) . '">' . $text_prev . '</a> ';
	}
	
	if ($num_pages > 1) {
		if ($num_pages <= $num_links) {
			$start = 1;
			$end = $num_pages;
		} else {
			$start = $page - floor($num_links / 2);
			$end = $page + floor($num_links / 2);
		
			if ($start < 1) {
				$end += abs($start) + 1;
				$start = 1;
			}
					
			if ($end > $num_pages) {
				$start -= ($end - $num_pages);
				$end = $num_pages;
			}
		}
	
		if ($start > 1) {
			$output .= ' .... ';
		}
	
		for ($i = $start; $i <= $end; $i++) {
			if ($page == $i) {
				$output .= ' <b>' . $i . '</b> ';
			} else {
				$output .= ' <a href="' . str_replace('{page}', $i, $url) . '">' . $i . '</a> ';
			}	
		}
						
		if ($end < $num_pages) {
			$output .= ' .... ';
		}
	}
	
	if ($page < $num_pages) {
		$output .= ' <a href="' . str_replace('{page}', $page + 1, $url) . '">' . $text_next . '</a> <a href="' . str_replace('{page}', $num_pages, $url) . '">' . $text_last . '</a> ';
	}
	
	$find = array(
		'{start}',
		'{end}',
		'{total}',
		'{pages}'
	);
	
	$replace = array(
		($total) ? (($page - 1) * $limit) + 1 : 0,
		((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
		$total, 
		$num_pages
	);
	
	return ($output ? '<div class="' . $style_links . '">' . $output . '</div>' : '') . '<div class="' . $style_results . '">' . str_replace($find, $replace, $text) . '</div>';
}
function getRandIds( $table , $limit , $contract = NULL ) {
	$result1 = mysql_query('SELECT `id` FROM `'.$table.'` '.($contract?' where '.$contract:'').' ;');
	$ids = array() ;
	while( $row = mysql_fetch_assoc( $result1 ) ) {
		$ids[] = $row['id'] ;
	}
	$count = count( $ids ) ;
	$ids1 = '' ;
	$ids2 = array() ;
	if( $limit > $count ) $limit = $count ;
	while( $limit ) {
		$comma = ( $limit == 1 ) ? '' : ' , ' ;
		$id  = $ids[ rand( 0 ,  $count - 1 )] ;
		if( !in_array( $id , $ids2 ) ) {
		  $ids2[] = $id ;
		  $ids1 .= $id.$comma ;
		  $limit-- ;
		}
	}
	return $ids1 ;
	//$even = mysql_query( 'SELECT * FROM `products` WHERE `id` IN ( '.$ids1.' ) ;' ) ;
}
function getRecord( $id , $table ) {
	$result = mysql_query( 'SELECT * FROM `'.escape($table).'` WHERE `id` = "'.escape($id).'" LIMIT 1 ;' ) ;
	$row = mysql_fetch_array( $result ) ;
	return $row ;
}
function deleteRecord( $id , $table ) {
	return mysql_query( "DELETE FROM `$table` WHERE `id` = $id LIMIT 1 ;" ) ;
}
function getColumn( $id , $table , $column ) {
	$row = getRecord( $id , $table ) ; return $row[$column] ;
}
function getTitle( $id , $table , $lang = '' ) {
	if( empty( $lang ) ) $lang = LANG ;
	return stripslashes( getColumn( $id , $table , 'title_'.$lang ) ) ;
}
function getBody( $id , $table , $lang = '' ) {
	if( empty( $lang ) ) $lang = LANG ;
	return stripslashes( getColumn( $id , $table , 'body_'.$lang ) ) ;
}
function getSettings( $key , $lang ) {
	$q = 'SELECT `value` FROM `settings` WHERE `key` = "'.escape($key).'" AND `lang` = "'.escape($lang).'" LIMIT 1 ;' ;
	$res = mysql_query( $q ) or die( mysql_error()) ;
	$row = mysql_fetch_assoc( $res ) ;
	return $row['value'] ;
}
function getExtension( $name ) {
	$a = explode( '.' , basename( $name ) ) ;
	return strtolower( $a[ count($a) - 1 ] ) ;
}
function unExtension( $fileName ) { //return file name without extension
	$fileName = basename( $fileName ) ;
	$ary = explode( '.' , $fileName ) ;
	return $ary[0] ;
}
function getRandName( $dir , $extension ) {
	$randName = random().'.'.$extension ;
	$files = scandir( $dir ) ;
	while( in_array( $randName , $files ) ) $randName = random().'.'.$extension ;
	return $randName ;
}
function random() {
	return substr(md5(time().microtime()) , 0 , 15) ;
}
function isPermittedExtension( $extension , $extensions = PERMITTED_IMAGE_EXTENSIONS ) {
	$permittedExtensiton = explode( ' ' , strtolower($extensions) ) ;
	return in_array( $extension , $permittedExtensiton ) ;
}
function escape( $str ) { //To store in DB
	return addslashes( trim( $str ) ) ;
}
function filter( $str , $allowable_tags = '' ) { //To show in the site HTML
	$result = trim( str_replace( PHP_EOL , '<br />', strip_tags( stripslashes( $str ) , $allowable_tags ) ) ) ;
	$result = preg_replace('%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s','<a href="$1">$1</a>',$result);
	return $result;
}
function pass( $str ) {
	return md5(trim($str)) ;
}
function redirect( $location ) { //this function needs to ob_start() from the beginning of the script
	ob_end_clean() ;
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' ;
	echo "<meta http-equiv=\"refresh\" content=\"0; URL=$location\" />" ;
	echo '<title>Redirection ..</title></head><body></body></html>' ;
	exit() ;
}
function html( $value ) {
	return htmlentities( stripslashes( trim( $value ) ) , ENT_QUOTES , 'UTF-8' ) ;
}
function src( $name , $w , $h = 'auto' , $folder = 'image' ) { //needs to timthumb class
	if( $h == 'auto' ) $src = BASE_PATH.'image.php?src='.BASE_PATH.'files/'.$folder.'/'.$name.'&w='.$w ;
	else $src = BASE_PATH.'image.php?src='.BASE_PATH.'files/'.$folder.'/'.$name.'&w='.$w.'&h='.$h ;
	return $src ;
}
function isFound( $table , $column , $value ) {
	$q = 'SELECT `'.$column.'` FROM `'.$table.'` WHERE `'.$column.'` = "'.escape( $value ).'" LIMIT 1 ;' ;
	$res = mysql_query( $q ) ;
	if( mysql_num_rows( $res ) ) return true ;
	else return false ;
}
function alert( $msg ) {
  echo '<script type="text/javascript">$(document).ready(function(){alert("'.addslashes( $msg ).'") ; });</script>';	
}
function getAlias( $title ) {
	$chars = array( ' ' , '/' , '?' , '=' , '.' , ',' , ':' , ';' , '_' , '&' ) ;
	$title = str_replace( $chars , '-' , trim( $title ) ) ;
	while( strpos( $title , '--' ) )
		$title = str_replace( '--' , '-' , $title ) ;
	return urldecode( $title ) ;
}
function limit( $string , $limit) {
	$string = fixString( strip_tags( $string ) ) ;
	if( LANG == 'ar' ) $limit = $limit*2  ;
	$string = $novaString = fixString( $string ) ;
	$numCaracteres = strlen( $string ) ;
	if( $numCaracteres > $limit ){
		$novaString = substr( $string , 0 , $limit ) ;
		$novoNumPalavras = count( explode( ' ' , $novaString ) ) ;
		$pedacosStringOriginal = explode( ' ', $string ) ;
		@$tamUltimaPalavraCortada = strlen( end( explode( ' ' , $novaString ) ) ) ;
		$tamUltimaPalavraOriginal = strlen( $pedacosStringOriginal[$novoNumPalavras-1] ) ;
		if( $tamUltimaPalavraCortada < $tamUltimaPalavraOriginal ) {
			$novaString = explode( ' ' , $novaString ) ;
			array_pop( $novaString ) ;
			$novaString = implode( ' ' , $novaString ).' &hellip;' ;
		}
	}
	return $novaString;
}
function fixString( $string ) {
	$string = str_replace( '&nbsp;' , ' ' , $string ) ;
	return trim( preg_replace( '/ +/' , ' ' , $string ) ) ;
}
function isEmail($email) {
    return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$|i', $email);
}
function getCount( $table , $contract = '' ) {
	$q = 'SELECT COUNT(*) AS c FROM `'.$table.'` '.$contract.';' ;
	$result = mysql_query( $q ) ;
	$row = mysql_fetch_assoc( $result ) ;
	return $row['c'] ;
}
function getImg( $table , $pid , $cat = NULL ) {
	$q = 'SELECT * FROM `file` WHERE `pid` = "'.escape($pid).'" AND `table` = "'.escape($table).'" AND `folder` = "image" '.($cat? 'AND `cat` = "'.escape($cat).'" ' : '').' LIMIT 1 ;' ;
	$row = mysql_fetch_assoc( mysql_query( $q ) ) ;
	return $row['name'] ;
}
function login( $name , $pass ) {
  $name = escape( $name ) ;
  $password = pass( $pass ) ;
  $q = "SELECT * FROM `customer` WHERE `active` = 1 AND `confirmed` = 1 AND `email` = '$name' AND `pass` = '$password' LIMIT 1 ;" ;
  $result = mysql_query( $q ) ;
  if( mysql_num_rows( $result ) > 0 ) {
		  $row = mysql_fetch_assoc( $result ) ;
		  $_SESSION['customer_id'] = $row['id'] ;
		  $_SESSION['customer_fname'] = $row['fname'] ;
		  $_SESSION['customer_lname'] = $row['lname'] ;
		  $_SESSION['customer_email'] = $row['email'] ;
		  $_SESSION['customer_phone'] = $row['phone'] ;
		  $_SESSION['customer_mobile'] = $row['mobile'] ;
		  $_SESSION['customer_calling_code'] = $row['calling_code'] ;
		  $_SESSION['customer_company'] = $row['company'] ;
		  $_SESSION['customer_country'] = $row['country'] ;
		  $_SESSION['customer_address'] = $row['address'] ;
		  $_SESSION['customer_hash'] = $row['pass'] ;
		  $_SESSION['customer'] =  true ;
		  return true ;
	  }
	  else return false ;
}
function isAuth() {
  if( $_SESSION['customer'] ) return true ; else return false ;
}
function logout() {
	unset( $_SESSION['cart'] ) ;
	if( is_array( $_SESSION ) ) {
		foreach( $_SESSION as $key => $value ) {
			if( substr( $key , 0 , 8 ) == 'customer' ) unset( $_SESSION[$key] ) ;
		}
	}
}
function signup(&$json) {
	if( empty( $_POST['fname'] ) ) { $json['warning'] = 'الرجاء ادخال الاسم الاول' ; return false ; }
	if( empty( $_POST['lname'] ) ) { $json['warning'] = 'الرجاء ادخال الاسم الاخير' ; return false ; }
	if( empty( $_POST['email'] ) ) { $json['warning'] = 'الرجاء ادخال البريد الالكتروني' ; return false ; }
	if( !isEmail( $_POST['email'] ) ) { $json['warning'] = 'البريد الالكتروني الذي أدخلته خاطئ' ; return false ; }
	if( getCount( 'customer' , $contract = 'WHERE `email` = "'.escape( $_POST['email'] ).'" LIMIT 1' )) {$json['warning'] = 'عذراً , البريد الالكتروني الذي أدخلته مسجل مسبقاً!'; return false ; }
	if( empty( $_POST['password'] ) ) { $json['warning'] = 'الرجاء ادخال كلمة المرور' ; return false ; }
	if( empty( $_POST['mobile'] ) ) { $json['warning'] = 'الرجاء ادخال رقم الجوال' ; return false ; }
	if( !checkMobileNumber( $_POST['mobile'] , $_POST['calling_code'] ) ) { $json['warning'] = 'عذراً, رقم الجوال الذي أدخلته خاطئ' ; return false ; }
	if( !$_POST['accept'] )  { $json['warning'] = 'عذرأ, يجب الموافقة على شروط الاستخدام' ; return false ; }
	if( USE_VERIFYIMAGE_ON_SIGNUP && $_SESSION['verify_image_value'] != trim( $_POST['code']  ) ) { $json['warning'] = 'عذراً, رمز التحقق الذي أدخلته خاطئ' ; return false ; }
	//validation done successfully
	mysql_query( 'INSERT INTO `customer` SET `fname` = "'.escape( $_POST['fname'] ).'" , `lname` = "'.escape( $_POST['lname'] ).'" , `email` = "'.escape( $_POST['email'] ).'" , `pass` = "'.md5( trim( $_POST['password'] ) ).'" , `created` = "'.time().'" , `calling_code` = "'.escape( $_POST['calling_code'] ).'" , `mobile` = "'.escape( $_POST['mobile'] ).'" , `country` = "'.escape( $_POST['country'] ).'" , `company` = "'.escape( $_POST['company'] ).'" , `address` = "'.escape( $_POST['address'] ).'" , `confirmed` = 0 ;' ) ;
	$id =  mysql_insert_id();
	sendConfirmMsg( $_POST['email'] , md5($id) ) ;
	//subscription
	if( $_POST['newsletter'] ) @mysql_query('insert into `subscription` set `email` = "'.escape( $_POST['email'] ).'" ;') ;
	//message
	$json['attention'] = 'عزيزي الزائر الكريم, تم ارسال رسالة إلى بريدك الالكتروني, الرجاء الضغط على الرابط المرفق لاتمام عملية التسجيل,<br />ملاحظة &nbsp;&nbsp;:&nbsp;&nbsp; في حال لم تصل الرسالة الرجاء التأكد من قراءة صندوق البريد الغير هام أو Junk Mail .' ;
	$_POST  = array() ;
	return true ;
}
function checkMobileNumber( $mobile , $calling_code ) {
	if( is_numeric( $mobile ) && strlen( $mobile ) > 3 ) return true ;
	return false ;
}
function update_account(&$json) {
	if( empty( $_POST['fname'] ) ) { $json['warning'] = 'الرجاء ادخال الاسم الاول' ; return false ; }
	if( empty( $_POST['lname'] ) ) { $json['warning'] = 'الرجاء ادخال الاسم الاخير' ; return false ; }
	if( empty( $_POST['mobile'] ) ) { $json['warning'] = 'الرجاء ادخال رقم الجوال' ; return false ; }
	if( !checkMobileNumber( $_POST['mobile'] , $_POST['calling_code'] ) ) { $json['warning'] = 'عذراً, رقم الجوال الذي أدخلته خاطئ' ; return false ; }
	//////////////////////
	mysql_query( 'update `customer` set `fname` = "'.escape(html( $_POST['fname'] )).'" , `lname` = "'.escape(html( $_POST['lname'] )).'" , `company` = "'.escape(html( $_POST['company'] )).'" , `address` = "'.escape(html( $_POST['address'] )).'" , `country` = "'.escape(html( $_POST['country'] )).'" , `mobile` = "'.escape(html( $_POST['mobile'] )).'" , `phone` = "'.escape(html( $_POST['phone'] )).'" where `id` = "'.escape($_SESSION['customer_id']).'" limit 1 ;' ) ;
	$_SESSION['customer_fname'] = html( $_POST['fname'] ) ;
	$_SESSION['customer_lname'] = html( $_POST['lname'] ) ;
	$_SESSION['customer_calling_code'] = html( $_POST['calling_code'] ) ;
	$_SESSION['customer_phone'] = html( $_POST['phone'] ) ;
	$_SESSION['customer_mobile'] = html( $_POST['mobile'] ) ;
	$_SESSION['customer_company'] = html( $_POST['company'] ) ;
	$_SESSION['customer_country'] = html( $_POST['country'] ) ;
	$_SESSION['customer_address'] = html( $_POST['address'] ) ;
	return true;
}
function update_pass() {
	mysql_query( 'update `customer` set `pass` = "'.escape(pass( $_POST['password'] )).'" where `id` = "'.escape($_SESSION['customer_id']).'" limit 1 ;' ) ;
	$_SESSION['customer_hash'] = pass( $_POST['password'] ) ;
	$_POST = array() ;
}
function facebookSignup( &$json ) {
	if( empty( $_POST['fname'] ) ) { $json['warning'] = 'الرجاء ادخال الاسم الاول' ; return false ; }
	if( empty( $_POST['lname'] ) ) { $json['warning'] = 'الرجاء ادخال الاسم الاخير' ; return false ; }
	if( empty( $_POST['email'] ) ) { $json['warning'] = 'الرجاء ادخال البريد الالكتروني' ; return false ; }
	if( !isEmail( $_POST['email'] ) ) { $json['warning'] = 'البريد الالكتروني الذي أدخلته خاطئ' ; return false ; }
	if( getCount( 'customer' , $contract = 'WHERE `email` = "'.escape( $_POST['email'] ).'" LIMIT 1' )) {$json['warning'] = 'عذراً , البريد الالكتروني الذي أدخلته مسجل مسبقاً!'; return false ; }
	if( empty( $_POST['password'] ) ) { $json['warning'] = 'الرجاء ادخال كلمة المرور' ; return false ; }
	if( empty( $_POST['mobile'] ) ) { $json['warning'] = 'الرجاء ادخال رقم الجوال' ; return false ; }
	if( !checkMobileNumber( $_POST['mobile'] , $_POST['calling_code'] ) ) { $json['warning'] = 'عذراً, رقم الجوال الذي أدخلته خاطئ' ; return false ; }
	if( !$_POST['accept'] )  { $json['warning'] = 'عذرأ, يجب الموافقة على شروط الاستخدام' ; return false ; }
	mysql_query( 'INSERT INTO `customer` SET `fname` = "'.escape( html($_POST['fname']) ).'" , `lname` = "'.escape( html($_POST['lname']) ).'" , `email` = "'.escape( trim($_SESSION['facebook_profile']['email']) ).'" , `pass` = "'.md5( trim( $_POST['password'] ) ).'" , `created` = "'.time().'" , `calling_code` = "'.escape( $_POST['calling_code'] ).'" , `active` = 1 , `company` = "'.escape(html( $_POST['company'] )).'" , `address` = "'.escape(html( $_POST['address'] )).'" , `country` = "'.escape(html( $_POST['country'] )).'" , `mobile` = "'.escape(html( $_POST['mobile'] )).'" , `phone` = "'.escape(html( $_POST['phone'] )).'" ;' ) ;
	$_id = mysql_insert_id();
	mysql_query('insert into `facebook_profile` set `id` = "'.escape( trim($_SESSION['facebook_profile']['id']) ).'" , `customer_id` = "'.$_id.'" , `profile` = "'.escape(json_encode($_SESSION['facebook_profile'])).'" ;');
	$_SESSION['customer_id'] = $_id ;
	$_SESSION['customer_fname'] = html($_POST['fname']) ;
	$_SESSION['customer_lname'] = html($_POST['lname']) ;
	$_SESSION['customer_email'] = trim($_SESSION['facebook_profile']['email']) ;
	$_SESSION['customer_phone'] = html( $_POST['phone'] ) ;
	$_SESSION['customer_mobile'] = html( $_POST['mobile'] ) ;
	$_SESSION['customer_calling_code'] = html( $_POST['calling_code'] ) ;
	$_SESSION['customer_company'] = html( $_POST['company'] ) ;
	$_SESSION['customer_country'] = html( $_POST['country'] ) ;
	$_SESSION['customer_address'] = html( $_POST['address'] ) ;
	$_SESSION['customer_hash'] = md5( trim( $_POST['password'] ) ) ;
	$_SESSION['customer'] =  true ;
	unset( $_SESSION['facebook_profile'] ) ;
	//send welcome sms
	sendWelcomeSMS( $_SESSION['customer_calling_code'].$_SESSION['customer_mobile'] ) ;
	return true ;
}
function twitterSignup( &$json ) {
	if( empty( $_POST['fname'] ) ) { $json['warning'] = 'الرجاء ادخال الاسم الاول' ; return false ; }
	if( empty( $_POST['lname'] ) ) { $json['warning'] = 'الرجاء ادخال الاسم الاخير' ; return false ; }
	if( empty( $_POST['email'] ) ) { $json['warning'] = 'الرجاء ادخال البريد الالكتروني' ; return false ; }
	if( !isEmail( $_POST['email'] ) ) { $json['warning'] = 'البريد الالكتروني الذي أدخلته خاطئ' ; return false ; }
	if( getCount( 'customer' , $contract = 'WHERE `email` = "'.escape( $_POST['email'] ).'" LIMIT 1' )) {$json['warning'] = 'عذراً , البريد الالكتروني الذي أدخلته مسجل مسبقاً!'; return false ; }
	if( empty( $_POST['password'] ) ) { $json['warning'] = 'الرجاء ادخال كلمة المرور' ; return false ; }
	if( empty( $_POST['mobile'] ) ) { $json['warning'] = 'الرجاء ادخال رقم الجوال' ; return false ; }
	if( !checkMobileNumber( $_POST['mobile'] , $_POST['calling_code'] ) ) { $json['warning'] = 'عذراً, رقم الجوال الذي أدخلته خاطئ' ; return false ; }
	if( !$_POST['accept'] )  { $json['warning'] = 'عذرأ, يجب الموافقة على شروط الاستخدام' ; return false ; }
	mysql_query( 'INSERT INTO `customer` SET `fname` = "'.escape( html($_POST['fname']) ).'" , `lname` = "'.escape( html($_POST['lname']) ).'" , `email` = "'.escape( trim($_POST['email']) ).'" , `pass` = "'.md5( trim( $_POST['password'] ) ).'" , `created` = "'.time().'" , `calling_code` = "'.escape( $_POST['calling_code'] ).'" , `active` = 1 , `company` = "'.escape(html( $_POST['company'] )).'" , `address` = "'.escape(html( $_POST['address'] )).'" , `country` = "'.escape(html( $_POST['country'] )).'" , `mobile` = "'.escape(html( $_POST['mobile'] )).'" , `phone` = "'.escape(html( $_POST['phone'] )).'" ;' ) ;
	$_id = mysql_insert_id();
	mysql_query('insert into `twitter_profile` set `id` = "'.escape( trim($_SESSION['twitter_profile']->id) ).'" , `customer_id` = "'.$_id.'" , `profile` = "'.escape(json_encode($_SESSION['twitter_profile'])).'" ;');
	$_SESSION['customer_id'] = $_id ;
	$_SESSION['customer_fname'] = html($_POST['fname']) ;
	$_SESSION['customer_lname'] = html($_POST['lname']) ;
	$_SESSION['customer_email'] = trim($_POST['email'])  ;
	$_SESSION['customer_phone'] = html( $_POST['phone'] ) ;
	$_SESSION['customer_mobile'] = html( $_POST['mobile'] ) ;
	$_SESSION['customer_calling_code'] = html( $_POST['calling_code'] ) ;
	$_SESSION['customer_company'] = html( $_POST['company'] ) ;
	$_SESSION['customer_country'] = html( $_POST['country'] ) ;
	$_SESSION['customer_address'] = html( $_POST['address'] ) ;
	$_SESSION['customer_hash'] = md5( trim( $_POST['password'] ) ) ;
	$_SESSION['customer'] =  true ;
	unset( $_SESSION['twitter_profile'] ) ; 
	//send welcome sms
	sendWelcomeSMS( $_SESSION['customer_calling_code'].$_SESSION['customer_mobile'] ) ;
	return true ;
}
function facebookLogin($profile) {
  $row = mysql_fetch_assoc( mysql_query('SELECT * FROM `customer` WHERE  `id` = "'.$profile['customer_id'].'" LIMIT 1 ;') ) ;
  $_SESSION['customer_id'] = $row['id'] ;
  $_SESSION['customer_fname'] = $row['fname'] ;
  $_SESSION['customer_lname'] = $row['lname'] ;
  $_SESSION['customer_email'] = $row['email'] ;
  $_SESSION['customer_phone'] = $row['phone'] ;
  $_SESSION['customer_mobile'] = $row['mobile'] ;
  $_SESSION['customer_calling_code'] = $row['calling_code'] ;
  $_SESSION['customer_company'] = $row['company'] ;
  $_SESSION['customer_country'] = $row['country'] ;
  $_SESSION['customer_address'] = $row['address'] ;
  $_SESSION['customer_hash'] = $row['pass'] ;
  $_SESSION['customer'] =  true ;
}
function twitterLogin($profile) {
  $row = mysql_fetch_assoc( mysql_query('SELECT * FROM `customer` WHERE  `id` = "'.$profile['customer_id'].'" LIMIT 1 ;') ) ;
  $_SESSION['customer_id'] = $row['id'] ;
  $_SESSION['customer_fname'] = $row['fname'] ;
  $_SESSION['customer_lname'] = $row['lname'] ;
  $_SESSION['customer_email'] = $row['email'] ;
  $_SESSION['customer_phone'] = $row['phone'] ;
  $_SESSION['customer_mobile'] = $row['mobile'] ;
  $_SESSION['customer_calling_code'] = $row['calling_code'] ;
  $_SESSION['customer_company'] = $row['company'] ;
  $_SESSION['customer_country'] = $row['country'] ;
  $_SESSION['customer_address'] = $row['address'] ;
  $_SESSION['customer_hash'] = $row['pass'] ;
  $_SESSION['customer'] =  true ;
}
function saveFacebookProfile() {
	mysql_query('insert into `facebook_profile` set `id` = "'.escape( $_SESSION['facebook_profile']['id'] ).'" , `customer_id` = "'.$_SESSION['customer_id'].'" , `profile` = "'.escape(json_encode($_SESSION['facebook_profile'])).'" ;');
}
function isRegisteredEmail( $email ) {
	return isFound( 'customer' , 'email' , trim($email) ) ;
}
function confirmCustomer( $get ) {
	$email = escape(urldecode($get['email'])) ;
	$res = mysql_query( 'select * from `customer` where `email` = "'.$email.'" and `confirmed` = 0 limit 1 ;') ;
	if( mysql_num_rows( $res ) ) {
		$row = mysql_fetch_assoc( $res ) ;
		if( $get['code'] != md5($row['id']) ) return false;
		else {
			if( mysql_query( 'UPDATE `customer` SET `confirmed` = 1 WHERE `email` = "'.$email.'" LIMIT 1;' ) ) return true ;
			sendWelcomeSMS( $row['calling_code'].$row['mobile'] ) ;
			return false ;
		}
	} else return false ;
}
function getRSS1( $lang ) {
	$q = 'SELECT * FROM `service` WHERE `active` = 1 ORDER BY `arg` ;' ;
	$result1 = mysql_query( $q ) ;
	$news = array() ;
	$i = 0 ;
	while( $row1 = mysql_fetch_assoc( $result1 ) ) {
		$news[$i]['id'] = $row1['id'] ;
		$news[$i]['title'] = stripslashes($row1['title']) ;
		$news[$i]['body'] = stripslashes($row1['description']) ;
		$news[$i]['link'] = DOMAIN.BASE_PATH.'service_'.$row1['id'] ;
		$news[$i]['date'] = date( DATE_FORMAT , time() ) ;
		$i++ ;
	}
	$result2 = mysql_query( 'select * from `portfolio_category` where `active` = 1 order by `arg`;' ) ;
	while(  $row1 = mysql_fetch_assoc( $result2 ) ) {
		$news[$i]['id'] = $row1['id'] ;
		$news[$i]['title'] = stripslashes($row1['title']) ;
		$news[$i]['body'] = stripslashes($row1['title']) ;
		$news[$i]['link'] = DOMAIN.BASE_PATH.'portfolio_'.$row1['id'] ;
		$news[$i]['date'] = date( DATE_FORMAT , time() ) ;
		$i++ ;
	}
	return $news ;
}
function uploadFile($file , $dir , $permittedExtensions) {
	  $extension = getExtension( $file['name'] ) ;
	  if( isPermittedExtension( $extension , $permittedExtensions ) ) {
		  $newName = getRandName( $dir , $extension ) ;
		  if( move_uploaded_file( $file['tmp_name'] ,$dir.'/'.$newName ) ) {
			  return $newName ;
		  }
	  }
	  return '' ;
}
function sendConfirmMsg( $to , $code ) {
	  $from = SETTINGS_EMAIL ;
	  $message  = str_replace( '[CONFIRM]' , '<a href="'.DOMAIN.BASE_PATH.'confirm.php?code='.$code.'&email='.urlencode(trim($to)).(!empty($_POST['redirect'])? '&redirect='.urlencode($_POST['redirect']) : '' ).'">اتمام عملية التسجيل</a>' , SETTINGS_CONFIRM_EMAIL_MESSAGE ) ;
	  $message = '<div dir="rtl">'.$message.'</div>' ;
	  //file_put_contents('msg.html',$message);
	  require_once( 'class/phpmailer.php' ) ;
	  $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
	  $mail->CharSet = 'UTF-8';
	  $mail->AddAddress( $to );
	  $mail->SetFrom( $from , SETTINGS_SITE_TITLE );
	  $mail->AddReplyTo( $from , SETTINGS_SITE_TITLE );
	  $mail->Subject = SETTINGS_SITE_TITLE ;
	  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
	  $mail->MsgHTML( $message ) ;
	  return $mail->Send() ;
}
function is_mobile() {
	if ( isset($is_mobile) )
		return $is_mobile;

	if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
		$is_mobile = false;
	} elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
		|| strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
			$is_mobile = true;
	} else {
		$is_mobile = false;
	}

	return $is_mobile;
}
function sendWelcomeSMS( $numbers ) {
	return sendSMS( $numbers , SETTINGS_WELCOME_SMS_MESSAGE ) ;
}
function sendPaidMessage($order_id ) {
	$customer_name = $_SESSION['customer_fname'].' '.$_SESSION['customer_lname'] ;
	//send message to admins
	$res = mysql_query( 'select mail from user where `active` = 1 ' ) ;
	while( $row = mysql_fetch_assoc( $res ) ) $mails[] = $row['mail'] ;
	$message = 'السادة مشرفي '.SETTINGS_SITE_TITLE.'<br />نعلمكم بأنه تم استقبال طلب جديد من قبل السيد(ة) '.$customer_name ;
	sendMail( $mails , SETTINGS_EMAIL  , 'طلب جديد' , $message ) ;
	//send message to customer
	$message = 'السيد(ة) '.$customer_name.' المحترم<b />نود اعلامكم بأنه تم استقبال طلبكم و جاري متابعة الطلب<br />رقم الطلب : #'.$order_id ;
	sendMail( $_SESSION['customer_email'] , SETTINGS_EMAIL  , SETTINGS_SITE_TITLE , $message ) ;
}
function p( $page ) {
	return substr( $_GET['_route_'] , 0 , strlen($page) ) == $page ;
}
function p_id() {
	$a = explode( '_' , $_GET['_route_'] ) ; $id = doubleval($a[1]) ;
	if( is_numeric( $id ) ) return $id ;
	return 0 ;
}
function inCart( $service_id ) {
	if( is_array( $_SESSION['cart']) ) {
		return array_key_exists ( $service_id , $_SESSION['cart'] ) ;
	} else return false ;
}
function storeCart( $order_id ) {
	  foreach( $_SESSION['cart'] as $service_id => $options ) {
		  mysql_query('insert into `order_service` set `order_id` = "'.escape($order_id).'" , `service_id` = "'.escape($service_id).'" , `price` = "'.escape(cart_service_price( $service_id , $options )).'" , `options` = "'.escape( json_encode($options ) ).'" ; ');
	  }
}
function price( $service_id , &$discount = 0 ) {
	$service = getRecord($service_id , 'service' ) ;
	$discount = discount( $service ) ;
	if( $discount )
		$actual_price = $service['price_discount'] ;
	else
		$actual_price = $service['price'] ;
	$res = mysql_query( 'select * from `service_option` where `id` = "'.escape($service_id).'" and `type` = "select" ;' ) ;
	while( $row = mysql_fetch_assoc( $res ) ) {
		$perfix = explode( PHP_EOL , trim($row['perfix']) ) ;
		$prc = explode( PHP_EOL , trim($row['price']) ) ;
		if( $perfix[0] == '+' ) $actual_price += $prc[0];
		else $actual_price -= $prc[0];
	}
	return $actual_price ;
}
function cart_service_price( $service_id , $cart_item ) {
	$service = getRecord($service_id , 'service' ) ;
	$discount = discount( $service ) ;
	if( $discount )
		$actual_price = $service['price_discount'] ;
	else
		$actual_price = $service['price'] ;
	foreach( $cart_item as $title => $v ) {
		$res = mysql_query( 'select * from `service_option` where `id` = "'.escape($service_id).'" and `title` = "'.escape(stripslashes($title)).'" and  `type` in ( "select" , "checkbox" ) ;' ) ;
		if( mysql_num_rows) {
			$row = mysql_fetch_assoc( $res ) ;
			$perfix = explode( PHP_EOL , trim($row['perfix']) ) ;
			$prc = explode( PHP_EOL , trim($row['price']) ) ;
			$values = explode( PHP_EOL , trim($row['value']) ) ;
			if( $row['type'] == "select" ) {
				$k = array_search( $v , $values ) ;
				if( $perfix[$k] == '+' ) $actual_price += $prc[$k];
				else $actual_price -= $prc[$k];
			} else { //checkbox
				  if( is_array($v) ) {
					   foreach( $v as $c ) {
						   $k = array_search( $c , $values ) ;
							if( $perfix[$k] == '+' ) $actual_price += $prc[$k];
							else $actual_price -= $prc[$k];
					   }
				  }
			}
		}
	}
	return $actual_price ;
}
function priceWithoutDiscount( $service ) {
	$actual_price = $service['price'] ;
	$res = mysql_query( 'select * from `service_option` where `id` = "'.escape($service_id).'" and `type` = "select" ;' ) ;
	while( $row = mysql_fetch_assoc( $res ) ) {
		$perfix = explode( PHP_EOL , trim($row['perfix']) ) ;
		$prc = explode( PHP_EOL , trim($row['price']) ) ;
		if( $perfix[0] == '+' ) $actual_price += $prc[0];
		else $actual_price -= $prc[0];
	}
	return $actual_price ;
}
//returns discount from 0 to 100 %
function discount( $service ) {
	if( $service['price'] && $service['price_discount'] && $service['date_start'] && $service['date_end'] ) {
		$time = time() ;
		if( $time > $service['date_start'] && $time < $service['date_end'] ) {
			return round( 100 - $service['price_discount']/$service['price']*100) ;
		}
	}
	return 0 ;
}
function viewServiceThumb( $row ) {
	$discount = discount( $row ) ;
	$discount_div = $discount ? '<div class="offer1">%'.$discount.' حسم</div>' : '' ;
	$img = getImg( 'service' , $row['id'] , 'img' ) ;
	$img_path = $img ? BASE_PATH.'files/image/'.$img : BASE_PATH.'images/service_special.png' ;
	$service_link = 'href="service_'.$row['id'].'"' ;
	if( $row['front'] == 1 ) $service_link .= ' onClick="popupService(\'ajax.php?action=service&id='.$row['id'].'\'); return false;"' ;
	$desc = $row['description'] ? '<div class="service-thumb-desc"><div>'.limit( stripslashes($row['description']) , 640 ).'</div></div>' : '' ;
	$price = price($row['id']) ;
	$price_span = $price ? '<span><span>$</span>'.$price.'</span>' : '' ;
	echo '
	<a '.$service_link.' class="service-thumb">
		'.$discount_div.'
		'.$desc.'
		<div class="detail">
			<h2>'.stripslashes($row['title']).'</h2>
			'.$price_span.'
		</div>
		<img src="'.$img_path.'" />
	</a>' ;
}
function getRandomServiceThumb( $row ) {
	$discount = discount( $row ) ;
	$discount_div = $discount ? '<div class="offer1">%'.$discount.' حسم</div>' : '' ;
	$img = getImg( 'service' , $row['id'] , 'img' ) ;
	$img_path = $img ? BASE_PATH.'files/image/'.$img : BASE_PATH.'images/service_special.png' ;
	$service_link = 'href="service_'.$row['id'].'"' ;
	if( $row['front'] == 1 ) $service_link .= ' onClick="popupService(\'ajax.php?action=service&id='.$row['id'].'\'); return false;"' ;
	$desc = $row['description'] ? '<div class="service-thumb-desc"><div>'.limit( stripslashes($row['description']) , 200 ).'</div></div>' :'';
	$price = price($row['id']) ;
	$price_span = $price ? '<span><span>$</span>'.$price.'</span>' : '' ;
	return '
	<a '.$service_link.' class="service-thumb" style="width:100%; height:230px;">
		'.$discount_div.'
		'.$desc.'
		<div class="detail">
			<h2>'.stripslashes($row['title']).'</h2>
			'.$price_span.'
		</div>
		<img src="'.$img_path.'" />
	</a>' ;
}
function viewSpecialServiceThumb( $row , $i ) {
	$discount = discount( $row ) ;
	$discount_div = $discount ? '<div class="offer1">%'.$discount.' حسم</div>' : '' ;
	$img = getImg( 'service' , $row['id'] , 'img' ) ;
	$img_path = $img ? BASE_PATH.'files/image/'.$img : BASE_PATH.'images/service_special.png' ;
	$float = $i == 3 ? 'left' : 'right' ;
	$margin = $i == 2 ? 'margin-right: 2%': '' ;
	$service_link = 'href="service_'.$row['id'].'"' ;
	if( $row['front'] == 1 ) $service_link .= ' onClick="popupService(\'ajax.php?action=service&id='.$row['id'].'\'); return false;"' ;
	$desc = $row['description'] ? '<div class="service-thumb-desc"><div>'.limit( stripslashes($row['description']) , 400 ).'</div></div>' : '' ;
	$price = price($row['id']) ;
	$price_span = $price ? '<span><span>$</span>'.$price.'</span>' : '' ;
	echo '
	<a '.$service_link.' class="service-thumb service-special-thumb" style="float:'.$float.'; '.$margin.'">
		'.$discount_div.'
		'.$desc.'
		<div class="detail">
			<h2>'.stripslashes($row['title']).'</h2>
			'.$price_span.'
		</div>
		<img src="'.$img_path.'" />
	</a>' ;
}
function menu($pid) {
	$res = mysql_query( 'select * from `service_category` where `pid` = "'.escape($pid).'" order by `arg` ;' ) ;
	if( mysql_num_rows( $res ) ) $menu .= '<ul>' ;
	while( $row = mysql_fetch_assoc( $res ) ) {
		$c = getCount( 'service' , 'where `active` = 1 and `category_id` = "'.$row['id'].'" and `just_in_offer_page` = 0 ' ) ;
		if( getCount( 'service_category' , 'where `pid` = "'.$row['id'] .'"' ) ) $submenu = menu($row['id']) ; else $submenu = '' ;
		$menu .= '<li><a href="category_'.$row['id'].'">'.stripslashes($row['title']).''.($c?' ('.$c.')':'').'</a>'.$submenu.'</li>' ;
	}
	if( mysql_num_rows( $res ) ) $menu .= '</ul>' ;
	return $menu ;
}
function primary_menu($pid) {
	$res = mysql_query( 'select * from `page` where `pid` = "'.escape($pid).'" and `menu_id` = 0 order by `arg` ;' ) ;
	if( mysql_num_rows( $res ) ) $menu .= '<ul'.($pid == 0 ? ' class="header-menu sf-menu" id="headerMenu"':'').'>' ;
	while( $row = mysql_fetch_assoc( $res ) ) {
		if( getCount( 'page' , 'where `pid` = "'.$row['id'] .'" and `menu_id` = 0' ) ) {
			$submenu = primary_menu($row['id']) ;
		} elseif( substr($row['link'],0,20) == '#ServiceCategoryMenu' ) {
			$a = explode( '_' , $row['link'] ) ;
			$submenu = menu($a[1]) ;
		} else $submenu = '' ;
		$link = (empty($row['link'])) ? ( !empty($row['body']) ? 'page_'.$row['id'] : 'javascript:void(0)' ) : ( substr($row['link'],0,1) == '#' ? 'javascript:void(0)' : $row['link'] ) ;
		$menu .= '<li><a href="'.$link.'">'.stripslashes($row['title']).'</a>'.$submenu.'</li>' ;
	}
	if( mysql_num_rows( $res ) ) $menu .= '</ul>' ;
	return $menu ;
}
function orderNumber( $order_id ) {
	return '<span class="order-number">#'.$order_id.'</span>' ;
}
function service_visits( $service_id ) {
	mysql_query('update `service` set `visits` = `visits` + 1 where `id` = "'.escape($service_id).'" limit 1;') ;
}
function service_options( $service_id ) {
	$res = mysql_query('select * from `service_option` where `id` = "'.escape($service_id).'" order by `ord` ;'); $i = 1 ;
	while( $row=mysql_fetch_assoc($res) ) {
		echo '<label class="label2" for="elem'.$row['ord'].'">'.$row['title'].'</label>' ;
		switch( $row['type'] ) {
			case 'text':
				echo '<input class="textbox2" type="text" id="elem'.$row['ord'].'" name="v['.$i.']" />' ; break ;
			case 'textarea':
				echo '<textarea class="textarea2" id="elem'.$row['ord'].'" name="v['.$i.']"></textarea>' ; break ;
			case 'select':
				echo '<select class="select2" id="elem'.$row['ord'].'" name="v['.$i.']">' ;
				$a = explode( PHP_EOL , trim($row['value']) ) ;
				$perfix = explode( PHP_EOL , trim($row['perfix']) ) ;
				$price = explode( PHP_EOL , trim($row['price']) ) ;
				foreach( $a as $k => $v ) echo '<option value="'.$v.'" data-perfix="'.$perfix[$k].'" data-price="'.$price[$k].'">'.$v.'</option>' ;
				echo '</select>' ; break ;
			case 'checkbox':
				$perfix = explode( PHP_EOL , trim($row['perfix']) ) ;
				$price = explode( PHP_EOL , trim($row['price']) ) ;
				$a = explode( PHP_EOL , trim($row['value']) ) ; echo '<div style="height:5px;"></div>' ;
				foreach( $a as $k => $v ) echo '<label class="stl8"><input type="checkbox" name="v['.$i.'][]" value="'.$v.'" data-perfix="'.$perfix[$k].'" data-price="'.$price[$k].'" />&nbsp;'.$v.'</label>' ;
				 break ;
		}
		echo '<input type="hidden" name="t['.$i.']" value="'.$row['title'].'" />' ; $i++;
	}
}
function customer_visits( $customer_id ,$service_id ) {
	return mysql_query( 'insert into `customer_visits` set `customer_id` = "'.escape($customer_id).'" , `service_id` = "'.escape($service_id).'" , `created` = "'.time().'" ;' ) ;
}
function offerCount() {
	$time = time() ;
	$r = mysql_fetch_assoc(mysql_query( 'SELECT COUNT(*) AS `c` FROM `service` where `active` = 1 AND `price_discount` > 0 AND `date_start` < '.$time.' AND `date_end` > '.$time.' ;' )) ;
	return $r['c'] ;
}
function BBCode( $body ) {
	if( $_SESSION['customer'] ) {
		$replace = 'هذا العرض مخصص لك سيد '.$_SESSION['customer_fname'].' '.$_SESSION['customer_lname']  ;
	} else {
		$replace = 'هذا لعرض مخصص لك عزيزي الزائر, اطلبه الآن' ;
	}
	return str_replace( '[U]' , $replace , $body ) ;
}
function subscription() {
	if( !isEmail($_POST['email'])  ) return '0';
	if( isFound( 'subscription' , 'email' , $_POST['email'] ) ) return '0' ;
	if( $_SESSION['subscription_done'] >3 ) return '0' ;
	if( $_SESSION['customer'] ) $customer = 1 ;
	else $customer = 0 ;
	mysql_query( 'insert into `subscription` set `email` = "'.escape($_POST['email']).'" , `customer` = "'.escape($customer).'" ;' ) ;
	if( !isset($_SESSION['subscription_done']) ) $_SESSION['subscription_done'] = 1 ;
	else $_SESSION['subscription_done'] += 1 ;
	return '1';
}
?>