<?php cms_isAuth() ; ?>
<div id="system_lang">
<?php
if( $_POST['addKey'] && $_POST['key'] ) {
	$found = false ;
	$key = filter( $_POST['key'] ) ;
	$q = mysql_query('SELECT Count(*) as Cnt FROM `lang_key` WHERE `key` = "'.$key.'" ;');		
	if ( $q && $r = mysql_fetch_array( $q ) )
		$found = $r['Cnt'] > 0 ;	
	if ( !$found ) {
		$q = 'INSERT INTO `lang_key` SET `key` = "'.$key.'" ;' ;
		mysql_query( $q ) ;
		foreach( $langs as $title => $lang ) {
			$q = 'INSERT INTO `lang_key_value` SET `lang` = "'.$lang.'" , `key` = "'.$key.'" , `value` = "'.filter( $_POST[$lang] ).'" ;' ;
			mysql_query( $q ) ;
		}
	}
	else alert('found !') ;
}
$l = count( $langs ) ;
$width = ceil( 770/$l ) ;
?>
<?php if( /*$_SESSION['cms_user_id'] == 0*/ true ) : ?>
<?php
if( $_POST['editLangs'] ) {
	$q = 'SELECT * FROM `lang_key` ;' ;
	$res = mysql_query( $q ) ;
	while( $row = mysql_fetch_assoc( $res ) ) {
		foreach( $langs as $title => $lang ) {
			$q = 'UPDATE `lang_key_value` SET `value` = "'.filter( $_POST[$row['key'].'_'.$lang] ).'" WHERE `lang` = "'.$lang.'" AND `key` = "'.$row['key'].'" LIMIT 1 ;' ;
			mysql_query( $q ) ;
		}
	}
}
?>
<form method="post" action="" accept-charset="UTF-8">
<input type="hidden" name="addKey" value="1" />
<table border="0">
<tr>
	<th colspan="3"><h2 class="content-title"><?php echo _CMS_ADD_KEY ; ?></h2></th>
</tr>
<tr>
	<td width="200" align="center"><?php echo _CMS_KEY ; ?></td>
	<td><input type="text" name="key" class="form-text ltr" /></td>
    <td valign="middle" align="center" rowspan="<?php echo $l + 1 ; ?>"></td>
</tr>
<?php
foreach( $langs as $title => $lang ) {
	echo '<tr>
		<td align="center">'.$title.'</td>
		<td><input type="text" name="'.$lang.'" class="form-text '.$lang.'" /></td>
	</tr>' ;
}
?>
</table>
<input type="submit" value="save"/>
</form>
<?php endif ; ?>
<form action="" method="post" accept-charset="UTF-8">
<table border="0">
<tr><th colspan="<?php echo $l ; ?>"><h2 class="content-title"><?php echo _CMS_EDIT_LANGS ; ?></h2></th></tr>
<?php
	echo '<tr>' ;
	foreach( $langs as $title => $lang ) {
		echo '<th>'.$title.'</th>' ;
	}
	echo '</tr>' ;
	$q = 'SELECT * FROM `lang_key` ORDER BY `key` ;' ; $res = mysql_query( $q ) ;
	while( $row = mysql_fetch_assoc( $res ) ) {
		$q = 'SELECT * FROM `lang_key_value` WHERE `key` = "'.$row['key'].'" ;' ; $res1 = mysql_query( $q ) ;
		while( $row1 = mysql_fetch_assoc( $res1 ) ) {
			$ary1[$row1['lang']] = $row1['value'] ;
		}
		echo '<tr>' ;
		foreach( $langs as $title => $lang ) {
			echo '<td><input '.( $_SESSION['cms_user_id'] == 0 ? 'ondblclick="alert( \''.$row['key'].'\' )"' : '' ).' type="text" name="'.$row['key'].'_'.$lang.'" style="width:'.$width.'px" class="form-text '.$lang.'" value="'.$ary1[$lang].'" /></td>' ;
		}
		echo '</tr>' ;
	}
?>
</table>
<input type="hidden" name="editLangs" value="1" />
<div align="center"><input type="submit" class="form-submit" value="<?php echo _CMS_SAVE ; ?>" /></div>
</form>
</div>