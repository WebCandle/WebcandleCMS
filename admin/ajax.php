<?php
require_once('functions.php') ;
define( 'TOKEN' , $_GET['token'] ) ;
if( !cms_isAuth() ) die( 'You do not have the permission to access this file !' ) ;
//$_GET['a'] is action
switch( $_GET['a'] ) {
	//Add file
	case 'addTmpFile' :
		$extension = getExtension($_FILES['cmsFormFile']['name']) ;
		if( isPermittedExtension( $extension , PERMITTED_FILE_EXTENSIONS ) ) {						
			$imageName = getRandName( 'tmp' , $extension ) ;
			if( move_uploaded_file($_FILES['cmsFormFile']['tmp_name'] , 'tmp/'.$imageName ) ) {
				//the syantex id "tmpName|realName"
				echo $imageName.'|'. $_FILES['cmsFormFile']['name'];
				$_SESSION['cms_uploaded_files'][$imageName] = $_FILES['cmsFormFile']['name'] ;
				resizeImage( 'tmp/'.$imageName , 'tmp/_'.$imageName , CMS_THUMB_W , CMS_THUMB_H , false ) ;
			}
			else echo '0' ;
		}
		break ;
		
	//Delete file
	case 'deleteFile' :
		$fileId = $_GET['fileId'] ;
		cms_deleteFile($fileId ) ;
		echo '1' ;
		break ;
		
	//active and disactive
	case 'activation' :
		if( cms_activation( $_GET['table'] , $_GET['id'] ) ) echo '1' ;
		else echo '0' ;
		break ;
	//confirm content by Admin to display in the website
	case 'confirm' :
		if( cms_confirm( $_GET['table'] , $_GET['id'] ) ) echo '1' ;
		else echo '0' ;
		break ;
	//delete from table the record id
	case 'delete' :
		if( cms_delete( $_GET['table'] , $_GET['id'] ) ) echo '1' ;
		else echo '0' ;
		break ;
	//Arrange records
	case 'arrangeUp' :
		cms_arrangeUp( $_GET['id'] , $_GET['table'] , '' ) ;
		echo '1' ;
		break ;
	case 'arrangeDown' :
		cms_arrangeDown( $_GET['id'] , $_GET['table'] , '' ) ;
		echo '1' ;
		break ;
	//check is found
	case 'isFound' :
		if( isFound( $_GET['table'] , $_GET['column'] , $_GET['value'] ) ) echo '1' ;
		else echo '0' ;
		break ;
}
?>