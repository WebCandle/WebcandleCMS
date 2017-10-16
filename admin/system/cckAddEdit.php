<?php
/*Notics 
1 - the submit button has id is "cmsFormSubmit"
2 - the file input is hidden with this syantex "filename|filename|filename"
3 - the file element has attribute is "folder" takes value of image|doc|video , and it is the folder name into files folder of the site
4 - the url LANG/TOKEN/FOLDER/<tableName>/add is add object
5 - the url LANG/TOKEN/FOLDER/<tableName>/edit&cms_id=<id> is edit object has id is <id> and its table is <tableName>
*/


/*if( $CMS['relation']['type'] == 'one_to_many' ) {
	//$CMS['elem'][] = array( 'name' => ( !empty($CMS['relation']['pid'] ) ? $CMS['relation']['pid'] : 'pid' ) , 'type' => 'hidden' , 'value' => $CMS['pid'] ) ;
}*/
if( $_POST['submit'] ) {
	$q = '' ;
	$elements = cms_getTextElements( $CMS['elem'] ) ;
	$len = count( $elements ) ;$i = 1 ;
	foreach( $elements as $elem ) {
		$comma = ( $len > $i ) ? ' , ' : ' ' ;$i++ ;
		switch( $elem['type'] ) {
			case 'text':
				if( $elem['password'] ) {
					if( $CMS['action'] == 'add' ) $q .= '`'.$elem['name'].'` = "'.pass($_POST[$elem['name']]).'"'.$comma ;
					elseif( $CMS['action'] == 'edit' ) {
						$v = (empty($_POST[$elem['name']])) ? getColumn( $CMS['id'] , $CMS['table'] , $elem['name'] ) : pass($_POST[$elem['name']]) ;
						$q .= '`'.$elem['name'].'` = "'.$v.'"'.$comma ;
					}
				} else $q .= '`'.$elem['name'].'` = "'.escape($_POST[$elem['name']]).'"'.$comma ;
				break;
			case 'hidden':
				if( $elem['created'] ) {
					if( $CMS['action'] == 'add' ) $q .= '`'.$elem['name'].'` = "'.escape($_POST[$elem['name']]).'"'.$comma ;
					else { $v = getColumn( $CMS['id'] , $CMS['table'] , $elem['name'] ) ; $q .= '`'.$elem['name'].'` = "'.$v.'"'.$comma ; }
				} else $q .= '`'.$elem['name'].'` = "'.escape($_POST[$elem['name']]).'"'.$comma ;
				break;
			case 'date':
				$this_date = $_POST[$elem['name']] ? strtotime($_POST[$elem['name']]) : 0 ;
				$q .= '`'.$elem['name'].'` = "'.$this_date.'"'.$comma ;
				break;
			case 'textarea':
				$q .= '`'.$elem['name'].'` = "'.escape($_POST[$elem['name']]).'"'.$comma ;
				break;
			case 'select':
				$q .= '`'.$elem['name'].'` = "'.escape($_POST[$elem['name']]).'"'.$comma ;
				break;
			case 'radio':
				$q .= '`'.$elem['name'].'` = "'.escape($_POST[$elem['name']]).'"'.$comma ;
				break;
		}
			
	}
	
	if( $CMS['action'] == 'add' )	$q = 'INSERT INTO `'.$CMS['table'].'` SET '.$q.';' ;
	elseif( $CMS['action'] == 'edit' ) 	$q = 'UPDATE `'.$CMS['table'].'` SET '.$q.' WHERE `id` = "'.$CMS['id'].'" LIMIT 1 ;' ;
	if( mysql_query( $q ) ) {
		//adding the images in the form to the "files" folder and the "file" table
		if( $CMS['action'] == 'add' ) {
			$CMS['id'] = mysql_insert_id() ;
			if( $CMS['is_arg'] ) mysql_query( 'UPDATE  `'.$CMS['table'].'` SET `arg` = '.$CMS['id'].' WHERE `id` = '.$CMS['id'].' LIMIT 1 ;' ) ;
		}
		foreach( $CMS['elem'] as $elem ) {
			if( $elem['type'] == 'file' && !empty( $_POST[$elem['name']] ) ) {
				$ary = explode( '|' , $_POST[$elem['name']] ) ;
				foreach( $ary as $a ) {
					$extension = getExtension( $a ) ;
					if( isPermittedExtension( $extension , $elem['extension'] ) ) {
						$newName = getRandName( $CMS['dir_path'].$elem['folder'] , $extension ) ;
						if( copy( 'tmp/'.$a , $CMS['dir_path'].$elem['folder'].'/'.$newName ) ) {
							$q = 'INSERT INTO `file` SET `pid` = "'.$CMS['id'].'" , `name` = "'.$newName.'" , `table` = "'.$CMS['table'].'" , `folder` = "'.$elem['folder'].'" , `cat` = "'.$elem['name'].'" , `real_name` = "'.$_SESSION['cms_uploaded_files'][$a].'" ;' ;
							if( !mysql_query( $q ) ) cms_error(mysql_error() , $q );
						}
					}
				}
			} elseif( $elem['type'] == 'checkbox' ) {
				if( $elem['relation_json'] ) {
					mysql_query( 'UPDATE  `'.$CMS['table'].'` SET `'.$elem['name'].'` = "'.escape(stripslashes(json_encode($_POST[$elem['name']]))).'" WHERE `id` = '.$CMS['id'].' LIMIT 1 ;' ) ;
				} elseif( $elem['relation_table'] ) {
					mysql_query( 'DELETE FROM `'.$elem['relation_table'].'` WHERE `'.$CMS['table'].'_id` = "'.$CMS['id'].'" ;' ) ;
					if( is_array( $_POST[$elem['name']] ) ) {
						foreach( $_POST[$elem['name']] as $option_value ) {
							mysql_query( 'INSERT INTO `'.$elem['relation_table'].'`SET `'.$CMS['table'].'_id` = "'.$CMS['id'].'" , `'.$elem['option_table'].'_id` = "'.$option_value.'" ;' ) ;
						}
					}
				}
			} elseif( $elem['type'] == 'module' && $elem['php'] ) {
				if( is_file(dirname($_SERVER['SCRIPT_FILENAME']).'/module/'.$elem['php']) ) include dirname($_SERVER['SCRIPT_FILENAME']).'/module/'.$elem['php'] ;
			}
		}
	} else cms_error( mysql_error() , $q ) ;
	//redirect to the url after action without continue the script
	if( $CMS['action'] == 'add' ) { $url = ( !empty( $CMS['url_after_add'] ) ) ? $CMS['url_after_add'] : urldecode($_GET['redirect_to']) ; redirect( $url ) ; }
	elseif( $CMS['action'] == 'edit' ) { $url = ( !empty( $CMS['url_after_edit'] ) ) ? $CMS['url_after_edit'] : urldecode($_GET['redirect_to']) ; redirect( $url ) ; }
}
if( $CMS['action'] == 'edit' && is_numeric( $CMS['id'] ) ) {
	//means edit the record has id is CMS_EDIT_ID
	if( $res = mysql_query( 'SELECT * FROM `'.$CMS['table'].'` WHERE `id` = "'.$CMS['id'].'" LIMIT 1 ;' ) ) {
		$CMS['values'] = mysql_fetch_assoc( $res ) ;
	}
	$cancel_button = '&nbsp;&nbsp;&nbsp;<input type="button" value="'._CMS_CANCEL.'" class="form-button" onclick="window.location = \''.( ( !empty( $CMS['url_after_edit'] ) ) ? $CMS['url_after_edit'] : urldecode($_GET['redirect_to']) ).'\'" />' ;
} else $cancel_button = '&nbsp;&nbsp;&nbsp;<input type="button" value="'._CMS_CANCEL.'" class="form-button" onclick="window.location = \''.( ( !empty( $CMS['url_after_add'] ) ) ? $CMS['url_after_add'] : urldecode($_GET['redirect_to']) ).'\'" />' ;

//output
if( $CMS['action'] == 'add' ) $CMS['title'] = $CMS['add_title'] ;  elseif( $CMS['action'] == 'edit' ) $CMS['title'] = $CMS['edit_title'] ;
echo '<h1 class="content-title">'.$CMS['title'].'</h1>' ;
echo '<form action="" onsubmit="return cmsFormValidation()" accept-charset="UTF-8" method="post">'.PHP_EOL ;
$i = 0 ;
foreach( $CMS['elem'] as $elem ) {
	$value = ( empty( $elem['value'] ) ) ? cms_inputValue(stripslashes($CMS['values'][$elem['name']])) : $elem['value'] ;
	$elemId = ( empty( $elem['id'] ) ) ? 'cms_elem'.$i++ : $elem['id'] ;
	switch( $elem['type'] ) {
		//////////////////text Input
		case 'text':
			if( $elem['rule_required'] && !( $CMS['action'] == 'edit' && $elem['password'] ) ) $CMS['js_function_form_validation'] .= 'if( $("#'.$elemId.'").val() == "" ) { $("#'.$elemId.'").addClass("form-text-required") ; isGood = false ; } else { $("#'.$elemId.'").removeClass("form-text-required") ; }'.PHP_EOL ;
			if( $elem['rule_number'] ) $CMS['js_function_form_validation'] .= 'var num = $("#'.$elemId.'").val() ; if( num != "" && isNaN(num) ) { $("#'.$elemId.'").addClass("form-text-number") ; isGood = false ; } else { $("#'.$elemId.'").removeClass("form-text-number") ; } '.PHP_EOL ;
			if( $elem['rule_mail'] ) $CMS['js_function_form_validation'] .= 'if( $("#'.$elemId.'").val() != "" && !isEmail( $("#'.$elemId.'").val() ) ) { $("#'.$elemId.'").addClass("form-text-mail") ; isGood = false ; } else { $("#'.$elemId.'").removeClass("form-text-mail") ; }'.PHP_EOL ;
			if( $elem['rule_not_in'] ) {
				$checker = '<div class="cmsFormChecker" id="'.$elemId.'_checker"><div class="checker-icon checker-loader"></div><div class="checker-icon checker-ok"></div><div class="checker-icon checker-no"></div></div>' ;
				$CMS['js'] .= 'function validate_'.$elemId.'(e){ $("#'.$elemId.'_checker div").css({visibility:"hidden"}) ; $("#'.$elemId.'_checker .checker-loader").css({visibility:"visible"}) ; $.get("ajax.php?token="+TOKEN+"&a=isFound&table='.$elem['rule_not_in_table'].'&column='.$elem['rule_not_in_column'].'&value="+$("#'.$elemId.'").val(), function( response ) { $("#'.$elemId.'_checker div").css({visibility:"hidden"}) ; if( response == 0 || js_vars["'.$elemId.'_value"] == $("#'.$elemId.'").val() ) { $("#'.$elemId.'_checker .checker-ok").css({visibility:"visible"}) ; js_vars["'.$elemId.'_rule_not_in"] = true ; } else { $("#'.$elemId.'_checker .checker-no").css({visibility:"visible"}) ; js_vars["'.$elemId.'_rule_not_in"] = false ; } }) ; }'.PHP_EOL ;
				$CMS['js'] .= '$("#'.$elemId.'").keyup(function(e){ validate_'.$elemId.'(e);}); $("#'.$elemId.'").blur(function(e){ validate_'.$elemId.'(e);});'.PHP_EOL ;
				$CMS['js_vars'] .= 'js_vars["'.$elemId.'_value"] = "'.$value.'" ; js_vars["'.$elemId.'_rule_not_in"] = true ;'.PHP_EOL ;
				$CMS['js_function_form_validation'] .= 'if( !js_vars["'.$elemId.'_rule_not_in"] ) { $("#'.$elemId.'").addClass("form-text-found") ; isGood = false ; } else { $("#'.$elemId.'").removeClass("form-text-found") ; }'.PHP_EOL ;
			} else $checker = '' ;
			if( $elem['password'] && $CMS['action'] == 'edit' ) $value = '' ;
			echo '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div><input id="'.$elemId.'" type="text" class="form-text '.$elem['lang'].'" name="'.$elem['name'].'" value="'.$value.'" />'.$checker.'</label>' ;
			break;
			
		//////////////////hidden Input
		case 'hidden':
			echo '<input id="'.$elemId.'" type="hidden" name="'.$elem['name'].'" value="'.$value.'" />' ;
			break;
			
		//////////////////Date Input
		case 'date':
			$value = $value ? date( 'Y-m-d' , $value ) : '0' ;
			echo '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div><input id="'.$elemId.'" type="text" class="form-date '.$elem['lang'].'" name="'.$elem['name'].'" maxlength="10" value="'.$value.'" /></label>' ;
			break;
		
		//////////////////Textarea Input
		case 'textarea':
			if( $elem['editable'] ) {
				$CMS['js'] .= "CKEDITOR.replace( '".$elemId."', { toolbar : [ [ 'Bold', 'Italic','Underline','Strike','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' , '-' ,'BidiLtr','BidiRtl', '-', 'BulletedList','-','TextColor','BGColor', '-', 'Link', 'Unlink','-', 'Maximize' , 'Image', 'Flash' , 'Iframe' , 'Table' , 'RemoveFormat','Format','FontSize','Source'] ], width : 777 , height : 400 ,language: '".LANG."' , resize_enabled : false , contentsLangDirection : '".( ($elem['lang'] == 'ar' ) ? 'rtl' : 'ltr' )."' , enterMode : CKEDITOR.ENTER_BR } );".PHP_EOL ;
				echo '<label for="'.$elemId.'"><div class="editor-title">'.$elem['title'].'</div><textarea id="'.$elemId.'" class="form-textarea '.$elem['lang'].'" name="'.$elem['name'].'">'.$value.'</textarea></label>' ;
			} else {
				echo '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div><textarea id="'.$elemId.'" class="form-textarea '.$elem['lang'].'" name="'.$elem['name'].'">'.$value.'</textarea></label>' ;
			}
			break ;
			
		//////////////////Select Input
		case 'select':
			if( $elem['option_type'] == 'range' ) {
				$options = cms_getRangeOptions( $elem['option_first'] , $elem['option_last'] , $value ) ;
			} elseif( $elem['option_type'] == 'query' ) {
				$options = '' ;
				$q = 'SELECT * FROM `'.$elem['option_table'].'`' ;
				if( $elem['option_contract'] ) $q .= ' WHERE '.$elem['option_contract'] ;
				$res = mysql_query( $q ) ;
				while( $row = mysql_fetch_assoc( $res ) ) {
					$selectd = ( $row[$elem['option_value']] == $value ) ? ' selected="selected"' : '' ;
					$options .= '<option value="'.$row[$elem['option_value']].'"'.$selectd.'>'.$row[$elem['option_title']].'</option>' ;
				}
			} elseif( $elem['option_type'] == 'array' ) {
				$options = cms_getSelectOptions( $elem['options'] , $value ) ;
			}
			echo '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div><select name="'.$elem['name'].'" class="form-select '.$elem['lang'].'" id="'.$elemId.'">'.$options.'</select></label>' ;
			break ;	
			
			
		//////////////////Radio Input
		case 'radio':
			if( $elem['option_type'] == 'query' ) {
				/*$options = '' ;
				$q = 'SELECT * FROM `'.$elem['option_table'].'`' ;
				if( $elem['option_contract'] ) $q .= ' WHERE '.$elem['option_contract'] ;
				$res = mysql_query( $q ) ;
				while( $row = mysql_fetch_assoc( $res ) ) {
					$selectd = ( $row[$elem['option_value']] == $value ) ? ' selected="selected"' : '' ;
					$options .= '<option value="'.$row[$elem['option_value']].'"'.$selectd.'>'.$row[$elem['option_title']].'</option>' ;
				*/
			} elseif( $elem['option_type'] == 'array' ) {
				$options = '' ;
				foreach( $elem['options'] as $title => $v ) {
					$checked = ( $v == $value ) ? ' checked="checked"' : '' ;
					$options .= '<label class="form-radio-option"><input type="radio" name="'.$elem['name'].'" value="'.$v.'"'.$checked.'>&nbsp;&nbsp;'.$title.'</label>'.PHP_EOL ;
				}
			}
			echo '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div><div class="form-radio-options">'.$options.'</div><div class="clear"></div></label>' ;
			break ;	
			
			
		//////////////////Checkbox Input
		case 'checkbox':
			echo '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div>' ;
			//this is many_to_many relation
			$value_array = array() ;
			if( $CMS['action'] == 'edit' ) {
				if( $elem['relation_table'] ) {
					$res = mysql_query( 'SELECT * FROM `'.$elem['relation_table'].'` WHERE `'.$CMS['table'].'_id` = "'.$CMS['id'].'" ;' ) ;
					while( $row = mysql_fetch_assoc( $res ) ) $value_array[] = $row[$elem['option_table'].'_id'] ;
				} elseif( $elem['relation_json'] ) {
					$value_array = json_decode( stripslashes($CMS['values'][$elem['name']]) ) ;
					if( empty( $value_array ) ) $value_array = array() ;
				}
			}
			$options = '' ;
			$q = 'SELECT * FROM `'.$elem['option_table'].'`' ;
			if( $elem['option_contract'] ) $q .= ' WHERE '.$elem['option_contract'] ;
			$res = mysql_query( $q ) ;
			while( $row = mysql_fetch_assoc( $res ) ) {
				$checked = in_array( $row[$elem['option_value']] ,  $value_array ) ? '  checked="checked"' : '' ;
				$options .= '<label class="form-checkbox-option"><input class="form-checkbox" type="checkbox"'.$checked.' name="'.$elem['name'].'[]" value="'.$row[$elem['option_value']].'" />&nbsp;&nbsp;'.$row[$elem['option_title']].'</label>' ;
			}
			echo '<div class="form-checkbox-options">'.$options.'<div class="clear"></div><div class="form-checkbox-options-control"><a href="javascript:void(0)" onclick="cmsCheckboxSelectAll(this)">تحديد الكل</a>&nbsp;|&nbsp;<a href="javascript:void(0)" onclick="cmsCheckboxDisselectAll(this)">إلغاء تحديد الكل</a></div></div><div class="clear"></div></label>' ;
			break ;	
			
		//////////////////file Input
		case 'file':
			$count_files = 0 ;
			$value = ( is_numeric( $CMS['values']['id'] ) ) ? cms_getFormFiles( $elemId , $CMS['values']['id'] , $CMS['table'] , $elem['folder'] , $elem['name'] , $CMS['dir_path'] , $count_files ) : '' ;
			echo '<label for="'.$elemId.'"><div class="label-title">'.$elem['title'].'</div><div class="cms-image-container"><div id="'.$elemId.'_container">'.$value.'</div><div class="clear"></div><a class="cms-upload-button" id="'.$elemId.'_button"'.( ( $elem['max'] == $count_files ) ? ' style="visibility:hidden"' : '').' href="javascript:cmsAddFile(\'image\',\''.$elemId.'\')">'._CMS_FILE_BROWSE.'</a><div class="cmsFormLoaderGif" id="'.$elemId.'_loader"></div></div><input type="hidden" class="form-hidden" id="'.$elemId.'" name="'.$elem['name'].'" /><div class="clear"></div></label>' ;
			$CMS['js_vars'] .= 'js_vars["'.$elemId.'_max"] = '.$elem['max'].' ; js_vars["'.$elemId.'_count"] = '.$count_files.' ; js_vars["'.$elemId.'_extension"] = "'.$elem['extension'].'" ;'.	PHP_EOL ;
            break;
		
		//////////////////Module
		case 'module':
			echo '<div>'.(!empty($elem['title'])?'<div class="editor-title">'.$elem['title'].'</div>':'');
			if( $elem['html'] && is_file( dirname($_SERVER['SCRIPT_FILENAME']).'/module/'.$elem['html'] ) ) include dirname($_SERVER['SCRIPT_FILENAME']).'/module/'.$elem['html'] ;
			echo '</div>' ;
			break ;
			
	}
}
echo '<div class="clear"></div><div class="form-buttons"><input id="cmsFormSubmit" type="submit" name="submit" value="'._CMS_SAVE.'" class="form-submit" />'.$cancel_button.'</div>' ;
echo '</form>'.PHP_EOL ;
echo '<form><input type="file" id="cmsFormFile" name="cmsFormFile" class="form-hidden" /></form>'.PHP_EOL ;

?>
<script type="text/javascript">
CKFinder.setupCKEditor( null, '<?php echo BASE_PATH ; ?>admin/editor/ckeditor/ckfinder/' );
<?php echo $CMS['js_vars'] ; ?>
//form validation
function cmsFormValidation() {
	var isGood = true ;
	<?php echo $CMS['js_function_form_validation'] ; ?>
	if( isGood && js_vars['valid_form'] ) return true ;
	else return false ;
}
<?php echo $CMS['js'] ; ?>

$(document).ready(function(e) {
    $( ".form-date" ).datepicker({ dateFormat : "yy-mm-dd"});
});
</script>