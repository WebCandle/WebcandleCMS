<?php
require_once('functions.php');
switch( $_GET['action'] ) {
	case 'addToCart' :
		  unset( $_SESSION['customer_account_pay'] ) ; //end pay for saved orders!
		  $response['success'] = 1 ;
		  storeCartValue($_GET['service_id']) ;
		  echo json_encode($response);
		break ;
	case 'login' :
		if( login( $_POST['name'] , $_POST['pass'] ) ) {
			unset( $_SESSION['facebook_profile'] ) ; unset( $_SESSION['twitter_profile'] ) ;
			$response['success'] = 1 ;
		} else {
			$response['success'] = 0 ;
			$response['warning'] = 'خطأ في البريد الالكتروني أو كلمة المرور' ;
		// }
		echo json_encode($response);
		break ;
	case 'signup' :
		$response['facebook_signed'] = 0 ;
		$response['twitter_signed'] = 0 ;
		$response['success'] = 0 ;
		//facebook and twitter signup
		if( $_SESSION['facebook_profile'] ) {
			if( facebookSignup( $response ) ) {
				$response['facebook_signed'] = 1 ;
			} else {
				$response['success'] = 0 ;
			}
		} elseif( $_SESSION['twitter_profile'] ) {
			if( twitterSignup( $response ) ) {
				$response['twitter_signed'] = 1 ;
			} else {
				$response['success'] = 0 ;
			}
		}
		//////////////////////////////
		elseif( signup($response) ) {
			$response['success'] = 1 ;
		} else {
			$response['success'] = 0 ;
		}
		echo json_encode($response);
		break ;
	case 'page' :
		$page = getRecord( $_GET['id'] , 'page') ;
		echo '<div class="popup-inner"><h1>'.stripslashes($page['title']).'</h1><div class="content-text">'.stripslashes($page['body']).'</div></div>' ;
		break;
	case 'service' :
		include 'template/service_popup.php' ;
		break;
	case 'subscription' :
		$response['success'] = subscription() ;
		echo json_encode($response);
		break ;
}
?>