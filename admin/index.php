<?php ob_start() ; require_once('functions.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" charset="Maher Alabassi : maher.alabassi@gmail.com" />
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.10.3.custom.min.css"/>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-ar.js"></script>
<script type="text/javascript" src="editor/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="editor/ckeditor/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
var TOKEN = '<?php echo TOKEN ; ?>' ;
</script>
<script type="text/javascript" src="js/functions.js"></script>
<title>CMS</title>
</head>
<?php if( cms_isAuth() ) { ?>
<body>
<div class="center">
<div id="header">
<ul>
<li><a href="<?php echo cms_url( 'system' , 'home' ) ; ?>">الرئيسية</a></li>
<li><a href="<?php echo cms_url( 'system' , 'profile' ) ; ?>">صفحتي الشخصية</a></li>
<li><a href="<?php echo cms_url( 'system' , 'guid' ) ; ?>">دليل المستخدم</a></li>
<li><a href="<?php echo cms_url( 'system' , 'logout' ) ; ?>" onclick="return confirm('<?php echo _CMS_ARE_YOU_SURE_TO_LOGOUT ; ?>')">تسجيل الخروج</a></li>
</ul>
<a id="logo" href="../" target="_blank"><img src="images/logo.png" /></a>
</div>
<div id="content">
<?php
$permission = json_decode(getColumn( $_SESSION['cms_group_id'] , 'user_group' , 'permission'));
//permitted for public users
$permission[] = 'system/logout' ;
$permission[] = 'system/profile' ;
$permission[] = 'system/home' ;
$permission[] = 'system/guid' ;
$permission[] = 'system/lang' ;
$permission[] = 'system/show_order' ;
$permission[] = 'system/customer_info' ;
$permission[] = 'cck/user_permission' ;
//echo '<pre dir="ltr">'.print_r($permission).'</pre>';
if( /*in_array( FOLDER.'/'.ACTION , $permission )*/ true ) {
	if( FOLDER == 'cck' ) { include 'system/cck.php' ; }
	else @include FOLDER.'/'.ACTION.'.php' ;
} else {
	echo '<h1 class="content-title">تحذير</h1><div style="padding:150px 0; text-align: center;">عذراً ليس لديك الصلاحيات للدخول إلى هذا القسم</div>';
}
?>
</div>
<div id="sideNav">
	<ul>
    <li>
        <a href="<?php echo cms_url( 'cck' , 'order_pending' , 'show' ) ; $c = '('.getCount( 'order' , 'where `status` = "pending" ').')' ; ?>">الطلبات&nbsp;&nbsp;&nbsp;<?php echo $c ; ?></a>
        <ul class="sub-menu">
            <li><a href="<?php echo cms_url( 'cck' , 'order_pending' , 'show' ) ;  ?>">طلبات جديدة&nbsp;&nbsp;&nbsp;<?php echo $c ; ?></a></li>
            <li><a href="<?php echo cms_url( 'cck' , 'order_active' , 'show' ) ; $c = '('.getCount( 'order' , 'where `status` = "active" ').')' ;?>">طلبات قيد التنفيذ&nbsp;&nbsp;&nbsp;<?php echo $c ; ?></a></li>
            <li><a href="<?php echo cms_url( 'cck' , 'order_complete' , 'show' ) ; $c = '('.getCount( 'order' , 'where `status` = "complete" ').')' ; ?>">طلبات مكتملة&nbsp;&nbsp;&nbsp;<?php echo $c ; ?></a></li>
            <li><a href="<?php echo cms_url( 'cck' , 'order_canceled' , 'show' ) ; $c = '('.getCount( 'order' , 'where `status` = "canceled" ').')' ;  ?>">طلبات تم إلغاؤها&nbsp;&nbsp;&nbsp;<?php echo $c ; ?></a></li>
        </ul>
    </li>
    <li><a href="<?php echo cms_url( 'cck' , 'service' , 'show' ) ;  ?>">الخدمات</a></li>
    <li>
        <a href="javascript:void(0);">تذاكر الدعم الفني</a>
        <ul class="sub-menu">
        <?php
            $res = mysql_query( 'select * from `ticket_department` ;' ) ;
            while( $row = mysql_fetch_assoc( $res ) ) {
                echo '<li><a href="'.cms_link( 'cck/ticket' , 'department_id='.$row['id'] ).'">'.$row['name'].'&nbsp;&nbsp;&nbsp;('.getCount( 'ticket' , 'where `department_id` = "'.escape($row['id']).'" ').')</a></li>' ;
            }
        ?>
        </ul>
    </li>
    <li><a href="<?php echo cms_url( 'cck' , 'ticket_department' , 'show' ) ;  ?>">أقسام التذاكر</a></li>
    <li><a href="<?php echo cms_url( 'cck' , 'service_category' , 'show' ) ;  ?>">أقسام الخدمات</a></li>
    <li><a href="<?php echo cms_url( 'cck' , 'customer' , 'show' ) ;  ?>">الزبائن</a></li>
    <li>
        <a href="<?php echo cms_url( 'cck' , 'service_show' , 'show' ) ;  ?>">الباقات</a>
        <ul class="sub-menu">
            <li><a href="<?php echo cms_url( 'cck' , 'service_show' , 'show' ) ;  ?>">الباقات</a></li>
            <li><a href="<?php echo cms_url( 'cck' , 'service_type' , 'show' ) ;  ?>">أنواع الباقات</a></li>
        </ul>
    </li>
    <li><a href="<?php echo cms_url( 'cck' , 'portfolio' , 'show' ) ;  ?>">أعمالنا</a></li>
    <li><a href="<?php echo cms_url( 'cck' , 'portfolio_category' , 'show' ) ;  ?>">أقسام الأعمال</a></li>
    <li><a href="<?php echo cms_url( 'cck' , 'page' , 'show' ) ;  ?>">الصفحات الثابتة</a></li>
    <li>
        <a href="javascript:void(0);">القوائم</a>
        <ul class="sub-menu">
                <li><a href="<?php echo cms_url( 'cck' , 'primary_section' , 'show' ) ;  ?>">الروابط الرئيسية في القائمة الرئيسية</a></li>
                <li><a href="<?php echo cms_url( 'cck' , 'secondary_section' , 'show' ) ;  ?>">الروابط الفرعية في القائمة الرئيسية</a></li>
            <li><a href="<?php echo cms_url( 'cck' , 'menu1' , 'show' ) ;  ?>">روابط تهمك</a></li>
            <li><a href="<?php echo cms_url( 'cck' , 'menu2' , 'show' ) ;  ?>">طرق التواصل</a></li>
        </ul>
    </li>
    <li><a href="<?php echo cms_url( 'cck' , 'client' , 'show' ) ;  ?>">عملاؤنا</a></li>
    <li><a href="<?php echo cms_url( 'cck' , 'gallery' , 'show' ) ;  ?>">معرض الصور المتحرك</a></li>
    <li><a href="<?php echo cms_url( 'cck' , 'square' , 'show' ) ;  ?>">الاعلانات</a></li>
    <li><a href="<?php echo cms_url( 'cck' , 'client_view' , 'show' ) ;  ?>">آراء العملاء</a></li>
    <li>
        <a href="javascript:void(0);">القائمة البريدية</a>
        <ul class="sub-menu">
            <li><a href="<?php echo cms_url( 'system' , 'newsletter' ) ;  ?>">ارسال القائمة البريدية</a></li>
            <li><a href="<?php echo cms_url( 'cck' , 'subscription' , 'show' ) ;  ?>">المشتركون&nbsp;&nbsp;&nbsp;(<?php echo getCount( 'subscription') ; ?>)</a></li>
        </ul>
    </li>
    <li><a href="<?php echo cms_url( 'system' , 'sms' ) ;  ?>">SMS</a></li>
    <li>
        <a href="javascript:void(0);">الاحصائيات</a>
        <ul class="sub-menu">
            <li><a href="<?php echo cms_url( 'system' , 'order_survey' , 'show' ) ;  ?>">احصائيات الطلبات</a></li>
            <li><a href="<?php echo cms_url( 'system' , 'customer_survey' , 'show' ) ;  ?>">احصائيات العملاء</a></li>
            <li><a href="<?php echo cms_url( 'system' , 'service_visits_survey' ) ;  ?>">أكثر الخدمات زيارة</a></li>
        </ul>
    </li>
    <li><a href="<?php echo cms_url( 'system' , 'export' ) ; ?>">تصدير إلى اكسل</a></li>
    <li><a href="<?php echo cms_url( 'cck' , 'country' ) ; ?>">جميع الدول</a></li>
    <li><a href="<?php echo cms_url( 'system' , 'settings' ) ; ?>">الاعدادات</a></li>
    <!--
    	<li>
        	<a href="<?php echo cms_url( 'cck' , 'ticket' , 'show' ) ; ?>">تذاكر الدعم الفني</a>
            <ul class="sub-menu">
                <li><a href="<?php echo cms_url( 'cck' , 'ticket' , 'show' ) ; ?>">التذاكر الجديدة</a></li>
                <li><a href="<?php echo cms_url( 'cck' , 'ticket_answered' , 'show' ) ; ?>">التذاكر المجابة</a></li>
                <li><a href="<?php echo cms_url( 'cck' , 'ticket_closed' , 'show' ) ;  ?>">التذاكر المغلقة</a></li>
            </ul>
        </li>
        <li><a href="<?php echo cms_url( 'cck' , 'ticket_department' , 'show' ) ;  ?>">أقسام التذاكر</a></li>
		<li><a href="<?php echo cms_url( 'cck' , 'customer' , 'show' ) ;  ?>">العملاء</a></li>
		<li><a href="<?php echo cms_url( 'cck' , 'service' , 'show' ) ;  ?>">الخدمات</a></li>
    	<li>
        	<a href="<?php echo cms_url( 'cck' , 'service_show' , 'show' ) ;  ?>">الباقات</a>
            <ul class="sub-menu">
            	<li><a href="<?php echo cms_url( 'cck' , 'service_show' , 'show' ) ;  ?>">الباقات</a></li>
                <li><a href="<?php echo cms_url( 'cck' , 'service_type' , 'show' ) ;  ?>">أنواع الباقات</a></li>
            </ul>
        </li>
		<li><a href="<?php echo cms_url( 'cck' , 'news' , 'show' ) ;  ?>">أخبار الشركة</a></li>
    	<li>
        	<a href="#">القوائم</a>
            <ul class="sub-menu">
                <li><a href="<?php echo cms_url( 'cck' , 'primary_section' , 'show' ) ;  ?>">الروابط الرئيسية في القائمة الرئيسية</a></li>
                <li><a href="<?php echo cms_url( 'cck' , 'secondary_section' , 'show' ) ;  ?>">الروابط الفرعية في القائمة الرئيسية</a></li>
                <li><a href="<?php echo cms_url( 'cck' , 'menu1' , 'show' ) ;  ?>">الروابط السريعة</a></li>
                <li><a href="<?php echo cms_url( 'cck' , 'menu2' , 'show' ) ;  ?>">قائمة الخدمات</a></li>
            </ul>
        </li>-->


       <!-- <li><a href="<?php echo cms_url( 'cck' , 'gallery' , 'show' ) ;  ?>">معرض الصور المتحرك</a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'choosen' , 'show' ) ;  ?>">اخترنا لكم</a></li>
		<li><a href="<?php echo cms_url( 'cck' , 'square' , 'show' ) ;  ?>">المربعات بالخلفية المتحركة</a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'client' , 'show' ) ;  ?>">عملاؤنا</a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'marketer' , 'show' ) ;  ?>">المسوقون</a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'user' , 'show' ) ; ?>">المدراء</a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'user_group') ; ?>">الصلاحيات</a></li>-->

       <!-- <li><a href="<?php //$c = getCount( 'order' ,  ' where `confirmed` = 0 ') ; if( $c ) echo cms_url( 'cck' , 'order' , 'show' ) ; else echo '#' ;  ?>"> جديد الفواتير <?php if( $c ) echo '( '.$c.' )' ; ?></a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'customer' , 'show' ) ;  ?>">الزبائن</a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'city' , 'show' ) ;  ?>">المناطق</a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'menu' , 'show' ) ;  ?>">القائمة</a></li>
        <!--<li><a href="<?php echo cms_url( 'cck' , 'slider' , 'show' ) ;  ?>">معرض الصور</a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'banner' , 'show' ) ;  ?>">الاعلانات</a></li>
        <li><a href="<?php echo cms_url( 'system' , 'newsletter' ) ;  ?>">القائمة البريدية</a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'news' , 'show' ) ;  ?>">المركز الاعلامي</a></li>
        <li><a href="<?php echo cms_url( 'cck' , 'page' , 'show' ) ;  ?>">الصفحات الثابتة</a></li>
        <li><a href="<?php echo cms_url( 'system' , 'lang' ) ; ?>">اللغات</a></li>
        -->
    </ul>
</div>
</div>
</body>
<?php } else include 'system/login.php' ; ?>
</html>
<?php mysql_close($conn) ; ob_end_flush() ; ?>