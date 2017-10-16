<?php
$CMS['table'] = 'photo' ;
$CMS['section'] = 'all_photo' ;
$CMS['show_title'] = "جميع الصور" ;
$CMS['edit_title'] = 'تعديل' ;
$CMS['add_title'] = _CMS_ADD_VIDEO ;
$CMS['is_add'] = false ;
$CMS['show_contract'] = '`confirmed` = 1' ;
$CMS['relation'] = array( 'title' => 'القسم' , 'type' => 'one_to_many' , 'pid' => 'category_id' , 'option_table' => 'photo_category' , 'option_title' => 'name' , 'option_value' => 'id' ) ;
//show element
function video_get_url_on_show($row) {
	return DOMAIN.BASE_PATH."photo_".$row['id'] ;
}
function video_get_comment_url_on_show($row) {
	return cms_link( 'system/comment' , 'content=photo&content_id='.$row['id'].'&redirect_to='.urlencode( cms_current_link()) ) ;
}
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' , 'link' => 'return video_get_url_on_show($row) ;' , 'width' => '540px' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return "التعليقات" ;' , 'link' => 'return video_get_comment_url_on_show($row) ;' , 'self' => true , 'width' => '80px' ) ;
$CMS['show'][] = array( 'type' => 'date' , 'name' => 'created' , 'width' => '80px' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  _CMS_MENU_TITLE , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'title' =>  'القسم' , 'name' => 'category_id' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'photo_category' , 'option_title' => 'name' , 'option_value' => 'id'  ) ;
$CMS['elem'][] = array( 'title' =>  'الوصف' , 'name' => 'desc' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => true ) ;
?>