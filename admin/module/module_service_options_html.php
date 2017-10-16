<?php
//$CMS['action'] && $CMS['id']
?>
        <style type="text/css">
			.module1_elem { clear:both; }
            .module1_select_options a { cursor: pointer;}
			.module1_elem a { display: inline-block ; width:16px; height:16px; background: url(images/delete.png) no-repeat center center; margin-top:5px; margin-right:5px; cursor:pointer; }
			.module1_elem select { width:150px; }
			.module1_add_elem { display: inline-block; cursor:pointer; margin-right:200px; }
			a.module1_add_option { width:auto; height:auto; background:none; margin-bottom:10px; }
			.module1_elem_control { width:570px; float: right; }
			.module1_text { width:370px; margin-bottom:5px; }
			.module1_elem .form-select { margin: 0 3px; padding: 4px 5px; }
			.module1_elem select.module1_select_perfix { width: 50px; }
			.module1_text_price { width: 87px; direction: ltr; }
			.options-title { width: 70%; float:right; margin-bottom: 5px; }
			.options-price { width: 30%; float:left; margin-bottom: 5px; }
        </style>
            <div style="padding:10px 0;">
            <?php
				$res = mysql_query('select * from `service_option` where `id` = "'.$CMS['id'].'" order by `ord` ;');
				$module1_index = 0 ;
				if( !mysql_num_rows( $res ) ) {
					$module1_index = 1 ;
			?>
                <div class="module1_elem">
                		<div class="label-title">عنصر ادخال</div>
                        <div class="module1_elem_control">
                        		<input type="text" class="form-text module1_text" name="v[1][title]" /><select name="v[1][type]" class="form-select" onChange="module1_type_changed(this)"><option value="text" selected>مربع نص صغير</option><option value="textarea">مربع نص كبير</option><option value="select">اختيار من متعدد</option><option value="checkbox">اختيارات متعددة</option></select><a onClick="module1_delete(this)"></a>
                                <div class="module1_select_options" style="display:none;">
                                		<div class="options-title">الخيارات</div><div class="options-price">تأثر السعر</div>
                                		<div><input type="text" name="v[1][option][]" class="form-text module1_text" /><select name="v[1][perfix][]" class="form-select module1_select_perfix"><option value="+">+</option><option value="-">-</option></select><input class="form-text module1_text_price" type="text" name="v[1][price][]" value="0" /><a onClick="module1_delete_option(this)"></a></div>
                                        <div><input type="text" name="v[1][option][]" class="form-text module1_text" /><select name="v[1][perfix][]" class="form-select module1_select_perfix"><option value="+">+</option><option value="-">-</option></select><input class="form-text module1_text_price" type="text" name="v[1][price][]" value="0" /><a onClick="module1_delete_option(this)"></a></div>
                                        <a onClick="module1_add_option(this,1)" class="module1_add_option">اضافة خيار</a>
                                </div>
                        </div>
                </div>
	<?php
				} else {
					while( $row = mysql_fetch_assoc( $res ) ) {
						$module1_index++ ;
						if( $row['type']=='select' || $row['type']=='checkbox' ) {
							$value = '<div class="module1_select_options" style="display:block;">';
							$a = explode( PHP_EOL , stripslashes($row['value'])) ;
							$perfix = explode( PHP_EOL , stripslashes($row['perfix'])) ;
							$price = explode( PHP_EOL , stripslashes($row['price'])) ;
							foreach( $a as $k => $val ) 	$value .= '<div><input type="text" value="'.cms_inputValue($val).'" name="v['.$module1_index.'][option][]" class="form-text module1_text" /><select name="v['.$module1_index.'][perfix][]" class="form-select module1_select_perfix"><option value="+"'.($perfix[$k]=='+'?' selected="selected"':'').'>+</option><option value="-"'.($perfix[$k]=='-'?' selected="selected"':'').'>-</option></select><input class="form-text module1_text_price" type="text" name="v['.$module1_index.'][price][]" value="'.$price[$k].'" /><a onClick="module1_delete_option(this)"></a></div>' ;
						} else $value = '<div class="module1_select_options" style="display:none;"><div class="options-title">الخيارات</div><div class="options-price">تأثر السعر</div><div><input type="text" name="v['.$module1_index.'][option][]" class="form-text module1_text" /><select name="v['.$module1_index.'][perfix][]" class="form-select module1_select_perfix"><option value="+">+</option><option value="-">-</option></select><input class="form-text module1_text_price" type="text" name="v['.$module1_index.'][price][]" value="0" /><a onClick="module1_delete_option(this)"></a></div><div><input type="text" name="v['.$module1_index.'][option][]" class="form-text module1_text" /><select name="v['.$module1_index.'][perfix][]" class="form-select module1_select_perfix"><option value="+">+</option><option value="-">-</option></select><input class="form-text module1_text_price" type="text" name="v['.$module1_index.'][price][]" value="0" /><a onClick="module1_delete_option(this)"></a></div>' ;
						echo '<div class="module1_elem"><div class="label-title">عنصر ادخال</div><div class="module1_elem_control"><input type="text" class="form-text module1_text" name="v['.$module1_index.'][title]" value="'.cms_inputValue( $row['title'] ).'" />&nbsp;&nbsp;<select name="v['.$module1_index.'][type]" class="form-select" onChange="module1_type_changed(this)"><option value="text"'.($row['type'] =='text'?' selected':'').'>مربع نص صغير</option><option value="textarea"'.($row['type'] =='textarea'?' selected':'').'>مربع نص كبير</option><option value="select"'.($row['type'] =='select'?' selected':'').'>اختيار من متعدد</option><option value="checkbox"'.($row['type'] =='checkbox'?' selected':'').'>اختيارات متعددة</option></select><a onClick="module1_delete(this)"></a>'.$value.'<a onClick="module1_add_option(this,'.$module1_index.')" class="module1_add_option">اضافة خيار</a></div></div></div>' ;
					}
			 } ?>
                <a onClick="module1_add(this)" class="module1_add_elem">اضافة عنصر ادخال</a>
            </div>
        <script type=text/javascript>
            var module1_index = <?php echo $module1_index ; ?> ;
            function module1_type_changed(elem){
                var slt = $(elem) ;
                if( slt.val() == 'select' || slt.val() == 'checkbox' ) {
                    slt.parent().find('div.module1_select_options').css({ display : 'block' });
                } else slt.parent().find('div.module1_select_options').css({ display : 'none' });
            }
            function module1_delete_option(elem) {
                $(elem).parent().remove() ;
            }
            function module1_add_option(elem,i) {
                //$(elem).before('<div><input type="text" name="v['+i+'][option][]" class="form-text module1_text" /><a onClick="module1_delete_option(this)"></a></div>');
				$(elem).before('<div><input type="text" name="v['+i+'][option][]" class="form-text module1_text" /><select name="v['+i+'][perfix][]" class="form-select module1_select_perfix"><option value="+">+</option><option value="-">-</option></select><input class="form-text module1_text_price" type="text" name="v['+i+'][price][]" value="0" /><a onClick="module1_delete_option(this)"></a></div>');
            }
            function module1_add(elem){
                module1_index++ ;
                $(elem).before('<div class="module1_elem"><div class="label-title">عنصر ادخال</div><div class="module1_elem_control"><input type="text" class="form-text module1_text" name="v['+module1_index+'][title]" /><select name="v['+module1_index+'][type]" class="form-select" onChange="module1_type_changed(this)"><option value="text" selected>مربع نص صغير</option><option value="textarea">مربع نص كبير</option><option value="select">اختيار من متعدد</option><option value="checkbox">اختيارات متعددة</option></select><a onClick="module1_delete(this)"></a><div class="module1_select_options" style="display:none;"><div class="options-title">الخيارات</div><div class="options-price">تأثر السعر</div><div><input type="text" name="v['+module1_index+'][option][]" class="form-text module1_text" /><select name="v['+module1_index+'][perfix][]" class="form-select module1_select_perfix"><option value="+">+</option><option value="-">-</option></select><input class="form-text module1_text_price" type="text" name="v['+module1_index+'][price][]" value="0" /><a onClick="module1_delete_option(this)"></a></div><div><input type="text" name="v['+module1_index+'][option][]" class="form-text module1_text" /><select name="v['+module1_index+'][perfix][]" class="form-select module1_select_perfix"><option value="+">+</option><option value="-">-</option></select><input class="form-text module1_text_price" type="text" name="v['+module1_index+'][price][]" value="0" /><a onClick="module1_delete_option(this)"></a></div><a onClick="module1_add_option(this,'+module1_index+')" class="module1_add_option">اضافة خيار</a></div></div></div>') ;
            }
            function module1_delete(elem) {
                $(elem).parent().parent().remove();
            }
			$(document).ready(function(e) {
                $('#content form').submit(function(){
					$('.module1_text_price').each(function() {
							if( isNaN(parseFloat($(this).val()))) $(this).val(0);
                    });
					
				});
            });
        </script>