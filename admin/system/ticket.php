<?php
$tid = escape($_GET['tid']) ;
if( $_POST['ticket_reply_add'] ) {
	//validation!
	if( empty( $_POST['message'] ) ) $warning = 'عذراً, لم تقم بكتابة الرسالة' ;
	/*if( is_array( $_FILES['attach'] ) ) {
		foreach( $_FILES['attach']['name'] as $attach_name ) {
			if( !empty( $attach_name ) && !isPermittedExtension( getExtension( $attach_name ) , PERMITTED_FILE_EXTENSIONS ) ) {
				$warning = 'لقد قمت بإرفاق ملف غير مصرح به, المفات المسموح بها , ملف صورة , ملف مضغوط , ملف أوفس' ;
			}
		}
	}*/
	//add ticket reply
	if(!$warning) {
		mysql_query('insert into `ticket_replies` set `ticket_id` = "'.escape($tid).'" , `user_id` = "'.escape($_SESSION['cms_user_id']).'" , `message` = "'.escape($_POST['message']).'" , `created` = "'.time().'" ;');
		$ticket_reply_id = mysql_insert_id() ;
		mysql_query( 'update `ticket` set `status` = "answered" where `id` = "'.escape($tid).'" limit 1 ;' ) ;
		if( is_array( $_FILES['attach'] ) ) {
			foreach( $_FILES['attach']['name'] as $key => $attach_name ) {
				if( !empty( $attach_name )) {
					$extension = getExtension($attach_name) ;
					$newName = getRandName( 'files/ticket' , $extension ) ;
					$path_to_file = dirname(dirname(dirname(__FILE__))).'/files/ticket/'.$newName ;
					if( move_uploaded_file( $_FILES['attach']['tmp_name'][$key] , $path_to_file) )
						mysql_query( 'insert into `file` set `pid` = "'.$ticket_reply_id.'" , `table` = "ticket_replies" , `name` = "'.$newName.'" , `real_name` = "'.escape($attach_name).'" , `folder` = "ticket" , `cat` = "ticket" ;' ) ;
						$attach[$path_to_file] = $attach_name ;
				}
			}
		}
		//mail send message to customer here
		$res = getRecord( $tid , 'ticket' ) ;
		$to = !empty( $res['email'] ) ? $res['email'] : getColumn( $res['customer_id'] , 'customer' , 'email' ) ;
		sendMail( $to , SETTINGS_EMAIL , 'الرد : '.$res ['title'] , 'هناك رد جديد بإمكانك الاضطلاع عليه من هنا<br /><br /><a href="'.DOMAIN.BASE_PATH.'ticket-view-'.$res['id'].'-'.$res['c'].'">رابط التذكرة</a>' , $attach ) ;
		///////////////////////////////
		
		$success = 'تم ارسال الرد'; 
		$_POST = array() ;
	}
}
if($_POST['close_ticket']) {
	mysql_query('update `ticket` set `status` = "closed" where id = "'.escape($_POST['close_ticket']).'" limit 1 ;');
	$success = 'تم اغلاق التذكرة.' ;
}
$res = mysql_query('select * from `ticket` where `id` = "'.$tid.'" limit 1 ;');
$ticket=mysql_fetch_assoc($res);
$customer_name = empty( $ticket['name'] ) ? html(getColumn($ticket['customer_id'],'customer','name')) : html($ticket['name']) ;

?>
<h1 class="content-title">عرض التذكرة &gt; <?php echo filter($ticket['title']) ;  ?></h1>

<div class="form-buttons">
	<input type="button" onclick="window.location = '<?php echo urldecode(  $_GET['redirect'] ) ; ?>' ;" class="form-button" value="عودة" />
	<?php if( $ticket['status'] != 'closed' ) : ?>
    <form method="post" action="" style="display:inline;"><input type="hidden" name="close_ticket" value="<?php echo $ticket['id'] ; ?>" /><input type="submit" value="اغلاق هذه التذكرة" class="form-submit" /></form>
    <?php endif ; ?>
<div class="clear" style="height:10px;"></div>
</div>

<?php include 'system/notification.php' ; ?>


<div class="ticket">
  <div class="ticket-inner">
  	<div class="ticket-header"><h2><?php echo $customer_name ; ?></h2><div class="ticket-date"><?php echo date(DATE_FORMAT,$ticket['created']) ; ?></div><div class="clear"></div></div>
    <div class="ticket-message"><?php echo filter($ticket['message']) ; ?></div>
	  <?php
          $res = mysql_query('select * from `file` where `pid` = "'.escape($ticket['id']).'" and `table` = "ticket" ;');
          if(mysql_num_rows($res)) : ?>
          <div class="ticket-attach">
              <div class="ticket-attach-title">المرفقات :</div>
              <?php while( $row = mysql_fetch_assoc( $res ) ) 	echo '<a href="../file.php?id='.$row['folder'].'/'.$row['name'].'">'.$row['real_name'].'</a>' ; ?>
            <div class="clear"></div>
        </div>
      <?php endif; ?>
  </div>
</div>

<?php
$replies = mysql_query('select * from `ticket_replies` where `ticket_id` = "'.escape($ticket['id']).'" order by `created` ;') ;
while( $reply = mysql_fetch_assoc($replies) ) { ?>


<div class="ticket<?php if( $reply['user_id'] ) echo ' ticket-answer' ; ?>">
  <div class="ticket-inner">
  	<div class="ticket-header"><h2><?php if( $reply['user_id'] ) echo html( getColumn($reply['user_id'],'user','display_name') ) ; else echo $customer_name ; ?></h2><div class="ticket-date"><?php echo date(DATE_FORMAT,$reply['created']) ; ?></div><div class="clear"></div></div>
    <div class="ticket-message"><?php echo filter($reply['message']) ; ?></div>
	  <?php
          $res = mysql_query('select * from `file` where `pid` = "'.$reply['id'].'" and `table` = "ticket_replies" ;');
          if(mysql_num_rows($res)) : ?>
          <div class="ticket-attach">
              <div class="ticket-attach-title">المرفقات :</div>
              <?php while( $row = mysql_fetch_assoc( $res ) ) 	echo '<a href="../file.php?id='.$row['folder'].'/'.$row['name'].'">'.$row['real_name'].'</a>' ; ?>
            <div class="clear"></div>
        </div>
      <?php endif; ?>
  </div>
</div>

<?php } ?>

    <form method="post" action="" enctype="multipart/form-data" accept-charset="UTF-8">
        <table width="100%" border="0" cellpadding="0">
          <tr>
            <td><label class="label-title" for="message">الرد</label></td>
            <td><textarea id="message" name="message" class="form-textarea"><?php echo $_POST['message'] ; ?></textarea></td>
          </tr>
		   <tr>
            <td><label class="label-title">ارفاق ملف</label></td>
            <td>
            <div style="padding: 10px 0;">
                <div id="filesContainer" style="width: 447px; float:right;">
                    <div><div class="choosefile" onclick="choosefile(this);">اختيار ملف</div><div class="choosefilename"></div><input type="file" name="attach[]" style="display:none;"></div>
                </div>
                <a style="line-height:23px; float:right;" id="addfile" href="#">إضافة المزيد</a>
            </div>
             </td>
          </tr>
        </table><input type="hidden" name="ticket_reply_add" value="1" />
        <div class="form-buttons"><input type="submit" value="متابعة" class="button1 form-button" /></div>
    </form>
<script type="text/javascript">
$(document).ready(function(){
	$('#addfile').click(function(){
		$('#filesContainer').append('<div><div class="choosefile" onclick="choosefile(this);">اختيار ملف</div><div class="choosefilename"></div><input type="file" name="attach[]" style="display:none;"></div>') ;
		return false ;
	});
});
function choosefile(elem) {
	$(elem).parent().find('input[type="file"]').change(function(){
		$(this).parent().find('.choosefilename').text($(this).val());
	}).click();
}
</script>
<style type="text/css">
/***************************** ticket ********************************/
.ticket { margin: 5px; border: solid 1px #CCC; background:#F5F5F5; line-height:30px; }
.ticket-header { border-bottom: solid 1px #CCC; background:#EBEBEB; }
.ticket-answer { background: #EEF6FF; border: solid 1px #CAE6FF; }
.ticket-answer .ticket-header {  background: #CFE6FF; border-bottom: solid 1px #CAE6FF; }
.ticket-header h2 { float:right; padding-right: 20px; }
.ticket-date { float:left; padding-left:20px; padding-top:5px; }
.ticket-message { margin: 5px 10px; }
.ticket-attach { margin: 20px; margin-top:10px; }
.ticket-attach a { display: block; float:right; clear:both; padding-right: 20px; background: url(../images/attach.gif) no-repeat center right; }
#filesContainer > div { border: solid 1px #808084; height: 30px; line-height: 30px; width:400px; padding-left:10px; margin-bottom:10px;
	-moz-border-radius: 				.6em /*{global-radii-blocks}*/;
	-webkit-border-radius: 				.6em /*{global-radii-blocks}*/;
	border-radius: 						.6em /*{global-radii-blocks}*/; }
.choosefile { display: inline-block; cursor: pointer; margin-left: 20px; padding: 0 10px; background: #EBEBEB; }
.choosefilename { display: inline-block; }
</style>