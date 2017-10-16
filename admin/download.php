<?php
ob_start() ; include 'functions.php' ;
if( $_SESSION['cms_logged_in'] ) {
	$payment_method = array( 'paypal' => 'PayPal' , 'bank_transfer' => 'تحويل بنكي' , 'credit_card' => 'بطاقة الائتمان' ) ;
	$customer_info = array( 'name' => 'الاسم الثلاثي' , 'email' => 'البريد الالكتروني' , 'mobile' => 'رقم الجوال' , 'phone' => 'رقم المكتب' , 'company' => 'اسم الشركة' , 'country' => 'البلد' , 'address' => 'المنطقة' , 'created' => 'تاريخ التسجيل' );
	/** Include PHPExcel */
	require_once 'class/excel.php';
	$excel = array() ;
	// Add some data
	if(isset($_POST['exoprt_orders'])) {
		$excel[] = array( 'رقم الطلب' , 'الخدمات المطلوبة', 'السعر','اسم العميل', 'البريد الالكتروني' , 'رقم الجوال' , 'الشركة' , 'البلد' , 'المنطقة' , 'طريقة الدفع' , 'تاريخ الطلب', 'حالة الطلب');
		$fileName = date(DATE_FORMAT) ;
		$time = '' ;
		if($_POST['from']) {
			$time .= 'and `created` >= "'.strtotime($_POST['from']).'" ' ;
		}
		if($_POST['to']) {
			$time .= 'and `created` <= "'.strtotime($_POST['to']).'" ' ;
		}
		switch($_POST['status']) {
			case 'pending':
				$fileName = 'الطلبات قيد الانتظار '.$fileName ;
				$where = ' where `status` = "pending" '.$time ;
				break;
			case 'active':
				$fileName = 'الطلبات جاري المتابعة '.$fileName ;
				$where = ' where `status` = "active" '.$time ;
				break;
			case 'saved':
				$fileName = 'الطلبات بانتظار الدفع '.$fileName ;
				$where = ' where `status` = "saved" '.$time ;
				break;
			case 'complete':
				$fileName = 'الطلبات المكتملة '.$fileName ;
				$where = ' where `status` = "complete" '.$time ;
				break;
			case 'canceled':
				$fileName = 'الطلبات الملغاة '.$fileName ;
				$where = ' where `status` = "canceled" '.$time ;
				break;
			default:
				$fileName = 'جميع الطلبات '.$fileName ;
				if( empty($time) ) $where = '';
				else $where = 'where '.substr($time,3);
		}
		$res = mysql_query('select * from `order` '.$where.' order by `created` desc ;');
		while($row=mysql_fetch_assoc($res)){
			$customer = getRecord( $row['customer_id'] , 'customer' ) ;
			$res1 = mysql_query( 'select * from `order_service` where `order_id` = "'.escape($row['id']).'" ;' );
			$c = mysql_num_rows( $res1 ) - 1 ;
			while( $row1 = mysql_fetch_assoc( $res1 ) ) { $services .= getColumn($row1['service_id'],'service','title').' ('.$row1['price'].'$) '.($c?' + ':''); $c--; }
			$excel[] = array( $row['id'] , stripslashes($services), '$'.stripslashes($row['total_price']), stripslashes($row['customer_fname'].' '.$row['customer_lname']), stripslashes($row['customer_email']), stripslashes($customer['calling_code'].'-'.$customer['mobile']), stripslashes($customer['company']), stripslashes($country[$customer['country']]), stripslashes($customer['address']), $payment_method[$row['payment_method']], date(DATE_FORMAT,$row['created']),($row['status']=='saved'?'بانتظار الدفع':$order_status[$row['status']]));
			$services = '' ;
		}
	}
	elseif(isset($_POST['exoprt_customers'])) {
		$fileName = 'معلومات العملاء '.date(DATE_FORMAT) ;
		$res = mysql_query('select * from `customer` where `active` = 1 order by `created` desc ;');
		$excel[] = array('اسم العميل', 'البريد الالكتروني', 'رقم الجوال' , 'الشركة', 'البلد', 'المنطقة', 'تاريخ التسجيل','ملاحظات عن العميل');
		while( $row = mysql_fetch_assoc( $res ) ) {
			$excel[] = array( stripslashes($row['fname'].' '.$row['lname']) , stripslashes($row['email']) , stripslashes($row['calling_code'].'-'.$row['mobile']) , stripslashes($row['company']) , stripslashes($country[$row['country']]) , stripslashes($row['address']) , date(DATE_FORMAT,$row['created']),str_replace(PHP_EOL,' ',stripslashes($row['note'])));
		}
	}
	if( count($excel) == 1 ) {
		$_SESSION['export_no_result'] = 1 ;
		redirect($_POST['current_link']);
	} else {
		// generate excel file
		$xls = new Excel_XML;
		$xls->addArray ( $excel );
		$xls->generateXML ($fileName);
	}
} else echo 'you do not have permissions!' ;
mysql_close($conn);
ob_end_flush() ;
?>