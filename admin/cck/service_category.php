<?php
$CMS['table'] = 'service_category' ;
$CMS['show_title'] = 'أقسام الخدمات' ;
$CMS['edit_title'] = "تعديل" ;
$CMS['add_title'] = "اضافة" ;
$CMS['is_arg'] = true ;
$CMS['is_delete'] = true ;
$CMS['is_activation'] = false ;
$CMS['show_order_by'] = 'arg' ;
$CMS['show_limit'] = 100 ; //pagination
function _sc_get_route($row) {
	$route = stripslashes($row['title']) ;
	while( $row['pid'] ) {
		$row = getRecord( $row['pid'] , 'service_category' ) ;
		$route = stripslashes($row['title']).' &gt; '.$route ;
	}
	return  $route;
}
//show element
$CMS['show'][] = array( 'type' => 'text' , 'value' => 'return _sc_get_route($row);' ) ;
$i = 0 ;
$options[''] = 0 ;
$res = mysql_query( 'select * from `service_category` order by `arg` ;');
while( $row = mysql_fetch_assoc($res) ) $options[stripslashes($row['title'])] = $row['id'] ;
//elements
$CMS['elem'][] = array( 'title' =>  'القسم الأب' , 'name' => 'pid' , 'type' => 'select' , 'lang' => 'ar' , 'option_type' => 'array' , 'options' => $options ) ;
$CMS['elem'][] = array( 'title' =>  'العنوان' , 'name' => 'title' , 'type' => 'text' , 'lang' => 'ar' , 'rule_required' => true ) ;
$CMS['elem'][] = array( 'title' =>  "عدد الخدمات في كل سطر" , 'name' => 'c' , 'type' => 'radio' , 'lang' => 'ar' , 'option_type' => 'array' , 'options' => array( '2' => 2 , '3' => 3 ) ) ;
?>