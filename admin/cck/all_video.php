<?php
$CMS['table'] = 'youtube_video' ;
$CMS['section'] = 'all_video' ;
$CMS['show_title'] = _VIDEO ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = _CMS_ADD_VIDEO ;
$CMS['show_contract'] = '`confirmed` = 1' ;
$CMS['relation'] = array( 'title' => 'القسم' , 'type' => 'one_to_many' , 'pid' => 'category_id' , 'option_table' => 'category' , 'option_title' => 'name' , 'option_value' => 'id' ) ;

//show element
function video_get_url_on_show($row) {
	return DOMAIN.BASE_PATH."video_".$row['id'] ;
}
function video_get_comment_url_on_show($row) {
	return cms_link( 'system/comment' , 'content=video&content_id='.$row['id'].'&redirect_to='.urlencode( cms_current_link()) ) ;
}
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' , 'link' => 'return video_get_url_on_show($row) ;' , 'width' => '540px' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return "التعليقات" ;' , 'link' => 'return video_get_comment_url_on_show($row) ;' , 'self' => true , 'width' => '80px' ) ;
$CMS['show'][] = array( 'type' => 'date' , 'name' => 'created' , 'width' => '80px' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  _CMS_MENU_TITLE , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'title' =>  'القسم' , 'name' => 'category_id' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'category' , 'option_title' => 'name' , 'option_value' => 'id'  ) ;
?>