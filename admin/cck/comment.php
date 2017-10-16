<?php
$CMS['table'] = 'comment' ;
$CMS['show_title'] = "التعليقات" ;
$CMS['edit_title'] = _CMS_EDIT_VIDEO ;
$CMS['add_title'] = _CMS_ADD_VIDEO ;
$CMS['is_edit'] = false ;
$CMS['is_add'] = false ;
$CMS['show_contract'] = '`confirmed` = 0' ;
$CMS['is_confirm'] = true ;
$CMS['is_activation'] = false ;
$CMS['show_row_height'] = false ;
//show element
function comment_get_url_on_show($row) {
	return DOMAIN.BASE_PATH.$row['content']."_".$row['content_id'] ;
}
function comment_get_info_on_show( $row ) {
	$customer = getColumn( $row['customer_id'] , 'customer' , 'name' ) ;
	$content_title = getColumn( $row['content_id'] , (($row['content']=='video')?'youtube_video':'photo') , 'title' ) ;
	$comment_info = "علّق <span style=\"color:green\">$customer</span> على <a target=\"_blank\" href=\"".DOMAIN.BASE_PATH.$row['content']."_".$row['content_id']."\">$content_title</a>  في <span style=\"display:inline-block; color:green; direction: rtl;\">".date(DATE_FORMAT,$row['created'])."</span><br /><div style=\"padding:10px;font-size:13px;\">".stripslashes($row['comment']).'</div>' ;
	return $comment_info;
}
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'comment' , 'value' => 'return comment_get_info_on_show( $row );' ) ;
//$CMS['show'][] = array( 'type' => 'date' , 'name' => 'created' ) ;
?>