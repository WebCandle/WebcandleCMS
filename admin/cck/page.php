<?php
$CMS['table'] = 'page' ;
$CMS['show_title'] = 'الصفحات الثابتة' ;
$CMS['is_arg'] = false ; //there is arg culomn in the table and have to put number in it
$CMS['is_delete'] = false ;
$CMS['is_add'] = false ;
$CMS['is_activation'] = false ;
$CMS['is_arg'] = true ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['show_contract'] = ' `menu_id` = 3 ' ;

/*function getPage($row) {
	$r = mysql_fetch_assoc( mysql_query('select * from page where id = "'.$row['pid'].'" limit 1 ;') ) ;
	return $r['title_'.LANG ] . ( !empty($r['title_'.LANG ])?' > ':'').$row['title_'.LANG ];
}
function getOptions1() {
	$r = mysql_query( 'select * from page where pid = 0 ;' ) ;
	$options['- لا يوجد -'] = '0' ;
	while( $row = mysql_fetch_assoc( $r ) ) {
		$options[$row['title_ar']] = $row['id'] ;
	}
	return $options ;
}*/
//show element

//$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return getPage($row) ;' ) ;
$CMS['show'][] = array( 'type' => 'text' , 'name' => 'title' ) ;
//elements
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
//$CMS['elem'][] = array( 'title' =>  'رابط' , 'name' => 'link' , 'type' => 'text' , 'lang' => 'en' ) ;
//$CMS['elem'][] = array( 'title' =>  'االقائمة الرئيسية' , 'name' => 'pid' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'query' , 'option_table' => 'page' , 'option_title' => 'title' , 'option_value' => 'id' ) ;
/*$CMS['elem'][] = array( 'title' => 'صورة' , 'name' => 'img' , 'folder' => 'image' , 'max' => 1 , 'extension' => PERMITTED_IMAGE_EXTENSIONS , 'type' => 'file' , 'lang' => LANG ) ;*/
$CMS['elem'][] = array( 'title' => 'نص الصفحة' , 'name' => 'body' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => true ) ;
$CMS['elem'][] = array( 'title' => 'الوصف' , 'name' => 'description' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
$CMS['elem'][] = array( 'title' => 'الكلمات المفتاحية' , 'name' => 'keywords' , 'type' => 'textarea' , 'lang' => 'ar' , 'editable' => false ) ;
?>