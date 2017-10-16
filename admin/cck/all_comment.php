<?php
$CMS['table'] = 'comment' ;
$CMS['section'] = 'all_comment' ;
$CMS['show_title'] = "التعليقات" ;
$CMS['edit_title'] = _CMS_EDIT_VIDEO ;
$CMS['add_title'] = _CMS_ADD_VIDEO ;
$CMS['is_edit'] = false ;
$CMS['is_add'] = false ;
$CMS['show_contract'] = '`confirmed` = 1' ;
$CMS['is_activation'] = true ;
$CMS['show_row_height'] = 150 ;
$CMS['show_row_line_height'] = 25 ;
$CMS['relation'] = array( 'title' => 'القسم' , 'type' => 'one_to_many' , 'pid' => 'content_id' , 'option_table' => 'youtube_video' , 'option_title' => 'name' , 'option_value' => 'id' ) ;
//show element
function comment_get_url_on_show($row) {
	return DOMAIN.BASE_PATH.$row['content']."_".$row['content_id'] ;
}

$CMS['show'][] = array( 'type' => 'text' , 'name' => 'comment' , 'link' => 'return comment_get_url_on_show($row) ;' ) ;
//$CMS['show'][] = array( 'type' => 'date' , 'name' => 'created' ) ;
?>