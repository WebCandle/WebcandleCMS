<?php
require_once(dirname(dirname(__FILE__)).'/config.php');
require_once('utf8.php');
ini() ;
$langs = getLangs() ;
//CMS functions
function cms_getRangeOptions( $f , $e , $sw = '' ) {
	$s = '' ;
	for( $i = $f ; $i <= $e ; $i++ ) {
		$w = '';
		if( $i == $sw ) {
			$w = ' selected="selected"' ;
		}
		$s .= '<option value="'.$i.'"'.$w.'>'.$i.'</option>'.PHP_EOL ;
	}
	return $s ;
}
function cms_isAuth() {
  if( $_SESSION['cms_logged_in'] && $_SESSION['cms_user_agent'] == $_SERVER['HTTP_USER_AGENT'] && $_SESSION['cms_token'] == TOKEN )
	  return true ;
	else return false ;
}
function cms_hasPermission( $permission ) {
	$permission_array = json_decode(getColumn( $_SESSION['cms_group_id'] , 'user_group' , 'permission'));
	return in_array( $permission , $permission_array ) ;
}
function cms_login( $name , $pass ) {
  $name = escape( $name ) ;
  $password = pass( $pass ) ;
  $result = mysql_query( "SELECT * FROM `user` WHERE `active` = 1 AND `name` = '$name' AND `pass` = '$password' ;" ) ;
  if( mysql_num_rows( $result ) > 0 ) {
		  $row = mysql_fetch_assoc( $result ) ;
		  $_SESSION['cms_user_id'] = $row['id'] ;
		  $_SESSION['cms_group_id'] = $row['group_id'] ; 
		  $_SESSION['cms_logged_in'] =  true ;
		  $_SESSION['cms_ip'] = $_SERVER['REMOTE_ADDR'] ;
		  $_SESSION['cms_user_agent'] = $_SERVER['HTTP_USER_AGENT'] ;
		  $_SESSION['cms_lang'] = $row['lang'] ;
		  $token = cms_getToken() ;
		  $_SESSION['cms_token'] = $token ;
		  $_SESSION['cms_token_time'] = time() ;
		  $_SESSION['cms_base_url'] = DOMAIN.BASE_PATH ; //for editor
		  return $token ;
	  }
	  else return 0 ;
}
function cms_logout() {
	if( is_array( $_SESSION ) ) {
		foreach( $_SESSION as $key => $value ) {
			if( substr( $key , 0 , 4 ) == 'cms_' ) unset( $_SESSION[$key] ) ;
		}
	}
}
function ini() {
	session_start() ;
	//cms keys
	define( 'CMS_THUMB_W' , 100 ) ;
	define( 'CMS_THUMB_H' , 100 ) ;
	define( 'TMP_FILE_TIME' , 86400*1 ) ;
	//url keys
	if( $_GET['q'] && $_SESSION['cms_logged_in'] ) {
		//admin
		$url = explode( '/' , $_GET['q'] ) ;
		$lang = filterLang( $url[0] ) ;
		define( 'TOKEN' , $url[1] ) ;
		define( 'FOLDER' , $url[2] ) ;
		define( 'ACTION' , $url[3] ) ;
		define( 'URL_A' , $url[4] ) ;
		define( 'URL_B' , $url[5] ) ;
		define( 'URL_C' , $url[6] ) ;
		define( 'URL_D' , $url[7] ) ;
		cms_emptyTmpDir( 'tmp' , TMP_FILE_TIME ) ;
	}
	elseif( $_GET['page'] && $_GET['lang'] ) {
		//user
		define( 'PAGE' , $_GET['page'] ) ;
		$id = ( !is_numeric( $_GET['id'] ) ) ? 0 : $_GET['id'] ;
		define( 'ID' , $id ) ;
		$beg = ( !is_numeric( $_GET['beg'] ) ) ? 0 : $_GET['beg'] ;
		define( 'BEG' , $beg ) ;
		$lang = filterLang( $_GET['lang'] ) ;
	}elseif($_POST['langs']){
		
		$lang = $_POST['langs'];
		define( 'PAGE' , 'home' ) ;
	}elseif($_GET['lang']){
		$lang = $_GET['lang'];
	}elseif($_SESSION['lang']){
		$lang = $_SESSION['lang'];
	}else {
		$lang = getSettings( 'SETTINGS_DEFAULT_LANG' , 'all' ) ;
		define( 'PAGE' , 'home' ) ;
	}
	//$lang = 'ar' ;
	define( 'LANG' , $lang ) ;
	//Settings keys
	$keys = mysql_query( 'SELECT * FROM `settings` WHERE `lang` IN ( "all" , "'.$lang.'" ) ;' ) ;
	while( $row = mysql_fetch_assoc( $keys ) )
	define( $row['key'] , $row['value'] ) ;
	//Language keys
	$keys = mysql_query( 'SELECT * FROM `lang_key_value` WHERE `lang` = "'.escape( $lang ).'" ;' ) ;
	while( $row = mysql_fetch_assoc( $keys ) )
	  define( $row['key'] , $row['value'] ) ;
}
function cms_arrangeUp( $id , $table , $contract = '' ) {
	$arg = mysql_fetch_assoc( mysql_query( 'SELECT * FROM `'.$table.'` WHERE `id` = '.$id.' ;' ) ) ;
	$arg = $arg['arg'] ;
	if ( $contract ) $q = 'SELECT * FROM `'.$table.'`  WHERE '.$contract.' AND `arg` < '.$arg.' ORDER BY `arg` DESC LIMIT 1 ;' ;
	else $q = 'SELECT * FROM `'.$table.'` WHERE `arg` < '.$arg.' ORDER BY `arg` DESC LIMIT 1 ;' ;
	$previous = mysql_query( $q ) ;
	if(  mysql_num_rows( $previous ) )
	{
		$previous = mysql_fetch_assoc( $previous ) ;
		mysql_query( 'UPDATE `'.$table.'` SET `arg` = '.$previous['arg'].' WHERE `id` = '.$id.' ;' ) ;
		mysql_query( 'UPDATE `'.$table.'` SET `arg` = '.$arg.' WHERE `id` = '.$previous['id'].' ;' ) ;
	}
}
function cms_arrangeDown( $id , $table , $contract = '' ) {
	$arg = mysql_fetch_assoc( mysql_query( 'SELECT * FROM `'.$table.'` WHERE `id` = '.$id.' ;' ) ) ;
	$arg = $arg['arg'] ;
	if ( $contract ) $q = 'SELECT * FROM `'.$table.'`  WHERE '.$contract.' AND `arg` > '.$arg.' ORDER BY `arg` ASC LIMIT 1 ;' ;
	else $q = 'SELECT * FROM `'.$table.'` WHERE `arg` > '.$arg.' ORDER BY `arg` ASC LIMIT 1 ;' ;
	$next = mysql_query( $q ) ;
	if(  mysql_num_rows( $next ) )
	{
		$next = mysql_fetch_assoc( $next ) ;
		mysql_query( 'UPDATE `'.$table.'` SET `arg` = '.$next['arg'].' WHERE `id` = '.$id.' ;' ) ;
		mysql_query( 'UPDATE `'.$table.'` SET `arg` = '.$arg.' WHERE `id` = '.$next['id'].' ;' ) ;
	}
}
function cms_url( $folder = '' , $action = '' , $a = '' , $b = '' , $c = '' ) {
	$url = 'index.php?q='.LANG.'/'.TOKEN ;
	if( $c ) $url .= '/'.$folder.'/'.$action.'/'.$a.'/'.$b.'/'.$c  ;
	elseif( $b ) $url .= '/'.$folder.'/'.$action.'/'.$a.'/'.$b ;
	else if( $a ) $url .= '/'.$folder.'/'.$action.'/'.$a ;
	else if( $action ) $url .= '/'.$folder.'/'.$action ;
	return $url ;
}
function cms_link( $q , $args = '') {	
	$url = 'index.php?q='.LANG.'/'.TOKEN ;
	if( $q ) $url .= '/'.$q ;
	if ($args) {
		$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&')); 
	}	
	return $url;
}
function cms_current_link() {
	return $_SERVER['REQUEST_URI'] ;
}
function cms_search_link() {
	$url = 'index.php?q='.$_GET['q'] ;
	if( $_GET['cms_pid'] ) $url .= '&cms_pid='.$_GET['cms_pid'] ;
	$url .= '&cms_filter=' ;
	return $url ;
}
function cms_error( $msg , $q = '' ) {
	die( '<div style="height:150px; background-color:yellow; direction:ltr"><strong>'.$msg.'</strong><div style="color:red; background-color:green;">'.$q.'</div></div>' ) ;
}
function cms_inputValue( $value ) {
	return htmlentities($value , ENT_QUOTES , 'UTF-8' ) ;
}
function cms_getFormFiles( $elemId , $pid , $table , $folder , $cat , $dir_path , &$count ) {
	$q = 'SELECT * FROM `file` WHERE `pid` = "'.$pid.'" AND `table` = "'.$table.'" AND `folder` = "'.$folder.'" AND `cat` = "'.$cat.'" ;' ;
	$res = mysql_query( $q ) ;
	$count = mysql_num_rows( $res ) ;
	$files = '' ;
	while( $row = mysql_fetch_assoc( $res ) ) {
		$extension = getExtension($row['name']) ;
		$real_name = unExtension( $row['real_name'] ) ;
		switch($extension) {
			case 'gif': case 'png':	case 'jpg': case 'jepg':
			//$thumb = '<div id="cms-thumb-'.$row['id'].'" class="cms-thumb"><a href="javascript:cmsDeleteFile( \''.$elemId.'\' ,'.$row['id'].' , \''.$row['real_name'].'\')" class="cms-delete-file"></a><img src="'.$dir_path.$folder.'/'.$row['name'].'" /><div class="cms-thumb-imagename">'.unExtension($row['real_name']).'</div></div>' ;
			$thumb = '<div id="cms-thumb-'.$row['id'].'" class="cms-thumb"><a href="javascript:cmsDeleteFile( \''.$elemId.'\' ,'.$row['id'].' , \''.$row['real_name'].'\')" class="cms-delete-file"></a><img src="'.src( $row['name'] , CMS_THUMB_W , CMS_THUMB_H , $row['folder'] ).'" /><div class="cms-thumb-imagename">'.$real_name.'</div></div>' ;
			break ;
			default:
			$thumb = '<div id="cms-thumb-'.$row['id'].'" class="cms-thumb cms-thumb-'.$extension.'"><a href="javascript:cmsDeleteFile( \''.$elemId.'\' ,'.$row['id'].' , \''.$row['real_name'].'\')" class="cms-delete-file"></a><div class="cms-thumb-filename">'.$real_name.'</div></div>' ;
		}
	  $files .= $thumb ;	
	}
	return $files ;
}
function cms_getTextElements( $elems ) {
	$textElems = array() ;
	foreach( $elems as $elem ) if( $elem['type'] != 'file' && $elem['type'] != 'checkbox' && $elem['type'] != 'module' ) $textElems[] = $elem ;
	return $textElems ;
}
function cms_getFilterStatment( $columns , $filter_to_search ) {
	$f = escape( $filter_to_search ) ;
	$c = count( $columns ) ; $i = 1 ;
	foreach( $columns as $column ) {
		$comma = ( $c > $i) ? ' OR ' : '' ;
		$filter .= ' `'.$column.'` LIKE "'.$f.'%" OR `'.$column.'` LIKE "%'.$f.'%" OR `'.$column.'` LIKE "%'.$f.'"'.$comma ;
		$i ++ ;
	}
	return $filter ;
}
function cms_deleteFile($fileId ) {
	$file = getRecord( $fileId , 'file' ) ;
	unlink( '../files/'.$file['folder'].'/'.$file['name'] ) ;
	deleteRecord( $fileId , 'file' ) ;
}
function cms_emptyTmpDir( $dirPath , $time ) {
  $dir = opendir( $dirPath ) ;
  while( $file = readdir( $dir ) ) {
	$filePath = $dirPath.'/'.$file ;
	if( is_file( $filePath ) )
		if( filectime( $filePath ) < ( time() - $time ) )
			unlink( $filePath ) ;
  }
  closedir( $dir ) ;
}
function cms_activation( $table , $id ) {
	$row = getRecord( $id , $table ) ;
	$activation = ( $row['active'] == '1' ) ? 0 : 1 ;
	return mysql_query( "UPDATE `$table` SET `active` = $activation WHERE `id` = $id LIMIT 1 ;" ) ;
}
function cms_confirm( $table , $id ) {
	return mysql_query( "UPDATE `$table` SET `confirmed` = 1 WHERE `id` = $id LIMIT 1 ;" ) ;
}
function cms_delete( $table , $id ) {
	//delete files
	$q = 'SELECT * FROM `file` WHERE `pid` = "'.$id.'" AND `table` = "'.$table.'" ;' ;
	$res = mysql_query( $q ) ;
	while( $row = mysql_fetch_assoc( $res ) ) {
		unlink( '../files/'.$row['folder'].'/'.$row['name'] ) ;
	}
	mysql_query( "DELETE FROM `file` WHERE `table` = '$table' AND `pid` = $id ;" ) ;
	return mysql_query( "DELETE FROM `$table` WHERE `id` = $id LIMIT 1 ;" ) ;
}
function cms_getToken() {
	$token = substr( md5( $_SERVER['HTTP_USER_AGENT'].cms_getRandomPass().$_SERVER['REMOTE_ADDR'].md5( cms_getRandomPass() ) ) , 1 , 10 ) ;
	return $token ;
}
function cms_getRandomPass() {
	$pass = substr( md5( rand( 0 , 99999 ).time().microtime() ) , 15 , 8 ) ;
	return $pass ;
}
function cms_getSelectOptions( $ary , $value = '' ) {
	$options = '' ;
	foreach( $ary as $title => $v ) {
		$selected = ( $v == $value ) ? ' selected="selected"' : '' ;
		$options .= '<option value="'.$v.'"'.$selected.'>'.$title.'</option>'.PHP_EOL ;
	}
	return $options ;
}
function cms_getImg( $table , $pid , $limit = 1 , $cat = NULL ) {
	$q = 'SELECT * FROM `file` WHERE `pid` = "'.$pid.'" AND `table` = "'.$table.'" AND `folder` = "image" '.($cat? 'AND `cat` = "'.escape($cat).'" ' : '').' LIMIT '.$limit.' ;' ;
	$res = mysql_query( $q ) ;
	$ary = array();
	while( $row = mysql_fetch_assoc( $res ) ) $ary[] = $row['name'] ;
	return $ary ;
}
function cms_getYoutubeId( $str ) {
	$a = explode( 'youtu.be/' , $str ) ;
	return $a[1] ;
}
function cms_pagination( $total = 0 , $page = 1 , $limit = 20 ) {
	//public vars
	$num_links = 10;
	$url = 'index.php?' ;
	foreach( $_GET as $var => $value ) {
		if( $var != 'cms_page' ) $url .= $var.'='.$value.'&';
	}
	$url .= 'cms_page={page}';
	if( LANG == 'ar' ) $text = _WIEW.' {start} '._TO.' {end} '._FROM.' {total} ( {pages} '._PAGE.' )';
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
function cms_getCount( $table , $contract = '' ) {
	return getCount( $table , $contract ) ;
}
//Public functions
function filterLang( $lang ) {
	$langs = getLangs() ;
	if( in_array( $lang , $langs ) ) return $lang ;
	else return getSettings( 'SETTINGS_DEFAULT_LANG' , 'all' ) ;
}
function getRecord( $id , $table ) {
	$result = mysql_query( 'SELECT * FROM `'.$table.'` WHERE `id` = "'.escape($id).'" LIMIT 1 ;' ) ;
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
			//die($q);
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
function createEditor($lang , $name , $value = '' ) {
	include_once 'editor/ckeditor/ckeditor.php' ;
	include_once 'editor/ckeditor/ckfinder/ckfinder.php' ;
	$CKEditor = new CKEditor() ;
	$CKEditor->basePath = 'editor/ckeditor/' ;
	$CKEditor->config['height'] = 330 ;
	$CKEditor->config['width'] = 729 ;
	$CKEditor->config['language'] = $lang ;
	CKFinder::SetupCKEditor( $CKEditor , 'cms/editor/ckeditor/ckfinder/' ) ;
	return $CKEditor->editor( $name , stripslashes( $value ) ) ;
}
function escape( $str ) {
	return trim( addslashes( trim( $str ) ) ) ;
}
function filter( $str , $allowable_tags = '' ) { //To show in the site HTML
	$result = trim( str_replace( PHP_EOL , '<br />', strip_tags( stripslashes( $str ) , $allowable_tags ) ) ) ;
	$result = preg_replace('%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s','<a href="$1">$1</a>',$result);
	return $result;
}
function pass( $str ) {
	return md5(trim($str)) ;
}
function getLangs() {
	$result = mysql_query( 'SELECT * FROM `lang` ;' ) ;
	$langs = array() ;
	while( $row = mysql_fetch_assoc( $result ) ) {
		$langs[$row['title']] = $row['lang'] ;
	}
	return $langs ;
}
function redirect( $location ) { //this function needs to ob_start() from the beginning of the script
	ob_end_clean() ;
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' ;
	echo "<meta http-equiv=\"refresh\" content=\"0; URL=$location\" />" ;
	echo '<title>Redirection ..</title></head><body></body></html>' ;
	exit() ;
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
function url(  $page , $id = '' , $beg = '' ) {
	$path = BASE_PATH.$page ;
	if( !empty( $beg ) ) $path .= '/'.$id.'/'.$beg ;
	elseif( !empty( $id ) ) $path .= '/'.$id ;
	return $path ;
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
		$tamUltimaPalavraCortada = strlen( end( explode( ' ' , $novaString ) ) ) ;
		$tamUltimaPalavraOriginal = strlen( $pedacosStringOriginal[$novoNumPalavras-1] ) ;
		if( $tamUltimaPalavraCortada < $tamUltimaPalavraOriginal ) {
			$novaString = explode( ' ' , $novaString ) ;
			array_pop( $novaString ) ;
			$novaString = implode( ' ' , $novaString ).' .. ' ;
		}
	}
	return $novaString;
}
function fixString( $string ) {
	$string = str_replace( '&nbsp;' , ' ' , $string ) ;
	return trim( preg_replace( '/ +/' , ' ' , $string ) ) ;
}
function beg( $topicCount , $limit , $nowPage , &$pageCount , &$start ) { //multi paging
	$pageCount = ceil( $topicCount / $limit) ;
	if( $nowPage >= $pageCount ) $start = 0 ;
	else {
		$start = $limit * $nowPage ;
	}
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
function getImg( $table , $pid , $folder = 'image' ) {
	$q = 'SELECT * FROM `file` WHERE `pid` = "'.$pid.'" AND `table` = "'.$table.'" AND `folder` = "'.$folder.'" LIMIT 1 ;' ;
	$row = mysql_fetch_assoc( mysql_query( $q ) ) ;
	return $row['name'] ;
}
function html( $value ) {
	return htmlentities( trim( stripslashes($value) ) , ENT_QUOTES , 'UTF-8' ) ;
}
//private functions
function show_order($row) {
	global $order_status ;
	$payment_method = array( 'paypal' => 'PayPal' , 'bank_transfer' => 'تحويل بنكي' , 'credit_card' => 'بطاقة الائتمان' ) ;
	$customer_name = filter( $row['customer_fname'].' '.$row['customer_lname'] ) ;
	if( $row['customer_id'] ) {
		$cusomter_url = cms_link( 'cck/customer/edit' , 'cms_id='.$row['customer_id'] . '&redirect_to=' . urlencode( cms_current_link() ) ) ;
	} else {
		$cusomter_url = 'mailto:'.$row['customer_email'] ;
	}
	
	$response = '<div>رقم الطلب : #'.$row['id'].' , العميل : <a href="'.$cusomter_url.'">'.$customer_name.'</a> , السعر : '.$row['total_price'].' $ , تاريخ الطلب : <span style="color:green;" dir="ltr">'.date(DATE_FORMAT, $row['created']).'</span><br /> طريقة الدفع : '.$payment_method[$row['payment_method']].', حالة الطلب : '.$order_status[$row['status']].'</div>' ;
	return $response ;
}
function show_order_link($row) {
	return '<a href="'.cms_link( 'system/show_order' , 'order_id='.$row['id'].'&redirect_to=' . urlencode(cms_current_link())).'">معلومات الطلب</a>' ;
}
function cms_table($array){
	$table = '' ;
	if( is_array( $array ) && count( $array ) ) {
		$table .= '<table>' ;
		$table .= '</table>' ;
	}
}
function customer_total_order_paid( $customer_id ) {
	$r = mysql_fetch_assoc(mysql_query('select SUM(`total_price`) AS sm from `order` where `customer_id` = "'.escape($customer_id).'" and `status` in ( "complete","active") ;')) ;
	return $r['sm'] ;
}
function customer_order_count( $customer_id ) {
	$r = mysql_fetch_assoc(mysql_query('select COUNT(`total_price`) AS sm from `order` where `customer_id` = "'.escape($customer_id).'" and `status` in ( "complete","active") ;')) ;
	return $r['sm'] ;
}
?>