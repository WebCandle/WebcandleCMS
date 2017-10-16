<?php
$CMS['table'] = 'youtube_video' ;
$CMS['section'] = 'video' ;
$CMS['show_title'] = "جديد الفيديو" ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = _CMS_ADD_VIDEO ;
//$CMS['is_edit'] = false ;
$CMS['is_add'] = false ;
$CMS['show_contract'] = '`confirmed` = 0' ;
$CMS['is_confirm'] = true ;
$CMS['is_activation'] = false ;

//show element
function video_get_url_on_show($row) {
	return DOMAIN.BASE_PATH."video_".$row['id'] ;
}
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' , 'link' => 'return video_get_url_on_show($row) ;' ) ;
$CMS['show'][] = array( 'type' => 'date' , 'name' => 'created' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  _CMS_MENU_TITLE , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' ) ;
$CMS['elem'][] = array( 'title' =>  'القسم' , 'name' => 'category_id' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'category' , 'option_title' => 'name' , 'option_value' => 'id'  ) ;
?>