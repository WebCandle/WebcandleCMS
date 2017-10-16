<?php
/*Notics
1 - must include culomn like "id" , "active" , ( "arg" if $CMS['show_order_by'] = 'arg' )
*/
//filter
if( $CMS['show_filter'] ) {
	$CMS['html'] .= '<form onsubmit="return cmsFilter(\''.cms_search_link().'\')"><label for="cms_filter"><div class="label-title cms-show-label-title">بحث</div><input type="text" id="cms_filter" class="form-text" value="'.cms_inputValue( $CMS['filter'] ).'" /></label></form>' ;
}
//relation
if( $CMS['relation']['type'] == 'one_to_many' ) {
	$relation_result = mysql_query( 'SELECT * FROM `'.$CMS['relation']['option_table'].'`'.( !empty( $CMS['relation']['option_contract'] ) ? ' WHERE '.$CMS['relation']['option_contract'] : '' ) ) ;
	$options = '' ;
	while( $r = mysql_fetch_assoc( $relation_result ) ) {
		if( empty( $firstValue ) ) $firstValue = $r[$CMS['relation']['option_value']] ;
		$selected = ( $r[$CMS['relation']['option_value']] == $CMS['pid'] ) ? ' selected="selected"' : '' ;
		$options .= '<option value="'.$r[$CMS['relation']['option_value']].'"'.$selected.'>'.$r[$CMS['relation']['option_title']].'</option>' ;
	}
	if( is_numeric( $CMS['pid'] ) ) $pid = $CMS['pid'] ;
	else { $pid = $firstValue ; $CMS['pid'] = $pid ; }
	$pid_column = (!empty($CMS['relation']['pid'])) ? $CMS['relation']['pid'] : 'pid' ;
	$where = 'WHERE `'.$pid_column.'` = "'.$pid.'" '.( !empty( $CMS['show_contract'] ) ? ' AND ('.$CMS['show_contract'].' ) ' : '' ).( !empty( $CMS['filter'] ) ? ' AND ( '.cms_getFilterStatment( $CMS['show_filter'] , $CMS['filter'] ).' ) ' : '' ) ;
	$CMS['html'] .= '<div class="cms-relation-container"><label for="cms_relation_'.$CMS['relation']['type'].'"><div class="label-title cms-show-label-title">'.$CMS['relation']['title'].'</div><select onchange="window.location = \''.cms_link('cck/'.(!empty($CMS['section'])?$CMS['section']:$CMS['table']).'/show','cms_pid=').'\'+this.value" name="cms_relation_'.$CMS['relation']['type'].'" class="form-select '.LANG.'" id="cms_relation_'.$CMS['relation']['type'].'">'.$options.'</select></label></div>' ;
} elseif( $CMS['show_contract'] ) {
	if( $CMS['filter'] ) $where = 'WHERE '.$CMS['show_contract'].' AND ( '.cms_getFilterStatment( $CMS['show_filter'] , $CMS['filter'] ).' ) ' ;
	else $where = 'WHERE '.$CMS['show_contract'].' ' ;
}
elseif( $CMS['filter'] ) {
	$where = 'WHERE '.cms_getFilterStatment( $CMS['show_filter'] , $CMS['filter'] ).' ' ;
}

$CMS['html'] = '<h1 class="content-title">'.$CMS['show_title'].( ( $CMS['is_add'] ) ? '<a href="'.( !empty( $CMS['url_add'] ) ? $CMS['url_add'] : cms_link( 'cck/' . (!empty($CMS['section'])?$CMS['section']:$CMS['table']) . '/add' , 'cms_pid='.$CMS['pid'] . '&redirect_to=' . urlencode( cms_current_link() ) ) ).'" class="cms-control-add"></a>' : '' ).( $CMS['show_filter'] ? '<a href="#" class="cms-control-filter"></a>' : '' ).'</h1>'.$CMS['html'] ;
////////////
if( !empty( $CMS['show_order_by'] ) ) {
	$ord = ' ORDER BY `'.$CMS['show_order_by'].'` ' ;
	if( !empty( $CMS['show_order_by_method'] ) )  $ord .= $CMS['show_order_by_method'].' ' ;
} else $ord = '' ;
//pagination
$cms_show_total = cms_getCount( $CMS['table'] , $where ) ;
//end pagination
$res = mysql_query( 'SELECT * FROM `'.$CMS['table'].'`'.$where.$ord.' LIMIT '.( ( $CMS['show_page'] - 1 ) * $CMS['show_limit'] ).','.$CMS['show_limit'].' ;' ) ; $i = 1 ;
$count = mysql_num_rows( $res ) ;
$show_width = $CMS['show_width'] -10 ;
if( $CMS['is_delete'] ) $show_width -= 22 ; if( $CMS['is_edit'] ) $show_width -= 22 ; if( $CMS['is_activation'] ) $show_width -= 22 ; if( $CMS['is_confirm'] ) $show_width -= 22 ; if( $CMS['show_order_by'] == 'arg' ) $show_width -= 44 ;
$cell_width = ceil($show_width/count($CMS['show']));
$CMS['html'] .= '<div class="cms-table"'.(($CMS['show_row_height'])?' style="height:'.($count*$CMS['show_row_height']+10).'px"':'').'>' ;

while( $row = mysql_fetch_assoc( $res ) ) {
	$tr = '' ;
	if( $CMS['is_delete'] ) $tr .= '<div class="cms-control-cell"><a onclick="cmsDelete( this , \''.$CMS['table'].'\' , \''.$row['id'].'\' )" href="javascript:void(0)" class="cms-control-delete"></a></div>' ;
	if( $CMS['is_edit'] ) $tr .= '<div class="cms-control-cell"><a href="'.cms_link( 'cck/'.(!empty($CMS['section'])?$CMS['section']:$CMS['table']).'/edit' , 'cms_id=' . $row['id'] . '&redirect_to=' . urlencode(cms_current_link()) ).'" class="cms-control-edit"></a></div>' ;
	if( $CMS['is_activation'] ) $tr .= '<div class="cms-control-cell"><a onclick="cmsActivation( this , \''.$CMS['table'].'\' , \''.$row['id'].'\' )" href="javascript:void(0)" class="cms-control-active'.(( $row['active'] == 0 ) ? ' disactive' : '' ).'"></a></div>' ;
	if( $CMS['show_order_by'] == 'arg' ) {
		$tr .= '<div class="cms-control-cell"><a onclick="cmsArrangeUp( this , \''.$CMS['table'].'\' , \''.$row['id'].'\' )" href="javascript:void(0)" class="cms-control-up"></a></div>' ;
		$tr .= '<div class="cms-control-cell"><a onclick="cmsArrangeDown( this , \''.$CMS['table'].'\' , \''.$row['id'].'\' )" href="javascript:void(0)" class="cms-control-down"></a></div>' ;
	}
	if( $CMS['is_confirm'] ) $tr .= '<div class="cms-control-cell"><a onclick="cmsConfirm( this , \''.$CMS['table'].'\' , \''.$row['id'].'\' )" href="javascript:void(0)" class="cms-control-active"></a></div>' ;
	$tr .= '<div class="cms-cells" style="width:'.$show_width.'px">' ;
	foreach( $CMS['show'] as $elem ) {
		switch( $elem['type'] ) {
			case 'text' :
				$cell = ( !empty($elem['value']) ) ? eval($elem['value']) : strip_tags(stripslashes($row[$elem['name']])) ;
				if( $elem['link'] ) $cell = '<a href="'.eval($elem['link']).'"'.( ($elem['self']) ? '' : ' target="_blank"' ).'>'.$cell.'</a>' ;
				$cell = '<div class="cms-cell-text">'.$cell.'</div>' ;
				break ;
			case 'date' :
				$cell = '<div class="cms-cell-date">'.date($CMS['date_format'],$row[$elem['name']]).'</div>' ;
				break ;
			case 'image' :
				$cell = '' ;
				$images = cms_getImg( $CMS['table'] , $row['id'] , $elem['max'] , $elem['name'] ) ;
				foreach( $images as $imgName ) $cell .= '<img src="'.src($imgName,50,50).'" width="50" height="50" />' ;
				$cell = '<div class="cms-cell-image">'.$cell.'</div>' ;
				break ;
		}
		$tr .= '<div class="cms-cell" style="width:'.((!empty($elem['width'])) ? $elem['width'] : $cell_width.'px').'; height:'.$CMS['show_row_height'].'px; line-height:'.(($CMS['show_row_line_height'])?$CMS['show_row_line_height']:$CMS['show_row_height']).'px;">'.$cell.'</div>' ;
	}
	$tr .= '</div>' ;
	$CMS['html'] .= '<div id="row'.$i.'" style="'.(($CMS['show_row_height'])?'position:absolute; top:'.(($i-1)*$CMS['show_row_height']).'px; height : '.$CMS['show_row_height'].'px;':'padding:10px 0;').'" class="cms-row'.( ( $i%2==0 ) ? ' cms-row-odd' : '' ).'" title="'.$i++.'">'.$tr.'<div class="clear"></div></div>' ;
}
$CMS['html'] .= '</div>' ;
//pagination
if( $cms_show_total > $CMS['show_limit'] ) $CMS['html'] .= '<div class="cms-pagination">'.cms_pagination( $cms_show_total , $CMS['show_page'] , $CMS['show_limit'] ).'</div>' ;

echo $CMS['html'] ;
?>
<script type="text/javascript">
<?php echo $CMS['js_vars'] ; ?>
<?php if( $CMS['show_row_height'] ) : ?>

js_vars['cms_row_height'] = <?php echo $CMS['show_row_height'] ; ?> ;

<?php endif ; ?>
$(document).ready(function(e) {
    $('.cms-control-cell').css({marginTop: (js_vars['cms_row_height'] - 16)/2 }) ;
});

</script>