<?php
//$CMS['action'] && $CMS['id']
if( $CMS['action'] == 'edit' ) mysql_query( 'delete from `service_option` where `id` = "'.$CMS['id'].'" ;' ) ;
if( is_array($_POST['v'])) {
	foreach( $_POST['v'] as $ord => $v ) {
		if( !empty( $v['title'])) {
			$value = '' ;
			if(( $v['type'] == 'select' || $v['type'] == 'checkbox' ) && is_array($v['option']) ) {
				$c = count($v['option']) ; $i = 0 ;
				foreach( $v['option'] as $opt ) {
					$comma = ( $i < $c ) ? PHP_EOL : '' ;
					$value .= $opt.$comma ;
				}
			}
			$perfix = '' ;
			if(( $v['type'] == 'select' || $v['type'] == 'checkbox' ) && is_array($v['perfix']) ) {
				$c = count($v['perfix']) ; $i = 0 ;
				foreach( $v['perfix'] as $opt ) {
					$comma = ( $i < $c ) ? PHP_EOL : '' ;
					$perfix .= $opt.$comma ;
				}
			}
			$price = '' ;
			if(( $v['type'] == 'select' || $v['type'] == 'checkbox' ) && is_array($v['price']) ) {
				$c = count($v['price']) ; $i = 0 ;
				foreach( $v['price'] as $opt ) {
					$comma = ( $i < $c ) ? PHP_EOL : '' ;
					$price .= $opt.$comma ;
				}
			}
			mysql_query('insert into `service_option` set `id` = "'.$CMS['id'].'" , `title` = "'.escape($v['title']).'" , `type` = "'.escape($v['type']).'" , `value` = "'.escape($value).'" , `perfix` = "'.escape($perfix).'" , `price` = "'.escape($price).'" , `ord` = "'.escape($ord).'"  ;');
			//mysql_query('insert into `service_option` set `id` = "'.$CMS['id'].'" , `title` = "'.escape($v['title']).'" , `type` = "'.escape($v['type']).'" , `value` = "'.escape(json_encode($v['option'],JSON_UNESCAPED_UNICODE)).'" , `ord` = "'.escape($ord).'"  ;');
		}
	}
}
?>