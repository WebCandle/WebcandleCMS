<h1 class="content-title">التعليقات</h1>
<div style="padding:15px;">
<form  accept-charset="UTF-8" method="post" action="">
<?php
if( $_POST['submit'] ) {
	if( is_array($_POST['comment'] ) ) {
		foreach( $_POST['comment'] as $comment_id => $comment ) {
			mysql_query( 'UPDATE `comment` SET `comment` = "'.escapeComment($comment).'" WHERE `id` = "'.escape($comment_id).'" LIMIT 1;' ) ;
		}
	}
	if( is_array( $_POST['d'] ) ) {
		foreach( $_POST['d']  as $key => $comment_id ) {
			mysql_query( 'DELETE FROM `comment` WHERE `id` = "'.escape($comment_id).'" LIMIT 1;');
		}
	}
}
$q = 'select * from `comment` where `content` = "'.escape($_GET['content']).'" and `content_id` = "'.escape($_GET['content_id']).'"  AND `confirmed` = 1 ;' ;
$res = mysql_query( $q ) ;
while( $row = mysql_fetch_assoc( $res ) ) {
	echo '<textarea class="form-textarea" name="comment['.$row['id'].']" style="width:600px; margin-bottom:5px;">'.str_replace('<br />' , "\n" , stripslashes($row['comment'])).'</textarea><label style="display:inline-block"><input type="checkbox" name="d[]" value="'.$row['id'].'" /> حذف هذا التعليق</label><br />' ;
}
if( !mysql_num_rows( $res ) ) {
	echo '<div style="text-align:center; padding:50px;">لا يوجد تعليقات</div>' ;
}
echo '<div class="form-buttons">'.((mysql_num_rows( $res ))?'<input type="submit" name="submit" value="حفظ" class="form-submit" />':'').'<input type="button" class="form-button" value="عودة" onclick="window.location = \''.urldecode($_GET['redirect_to']).'\' " /></div>' ;
?>
</form>
</div>