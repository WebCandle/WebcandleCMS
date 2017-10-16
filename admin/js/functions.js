/*
	Maher Alabassi <maher.alabassi@gmail.com>
*/
/* cms functions */
function cmsFilter( current_url ) {
	var filter = $('#cms_filter').val() ;
	if( filter != '' ) {
		window.location = current_url+encodeURIComponent(filter) ;
	}
	return false ;
}
function cmsCheckboxSelectAll( elem ) {
	$(elem).parent().parent().find('input[type="checkbox"]').attr( 'checked' , true ) ;
}
function cmsCheckboxDisselectAll( elem ) {
	$(elem).parent().parent().find('input[type="checkbox"]').attr( 'checked' , false ) ;
}
function cmsArrangeUp( a , table, id ) {
	if( !js_vars['ajax_is_working_now'] ) {
		var row = $(a).parent().parent() ;
		var index = parseInt(row.attr('title'));
		if( index != 1 ) {
			js_vars['ajax_is_working_now'] = true ;
			$.get( 'ajax.php?token='+TOKEN+'&a=arrangeUp&id='+id+'&table='+table , function( response ) {
				if( response == '1' ) {
					var prevRow = $('.cms-row[title="'+(index-1)+'"]').attr('title',index) ;
					row.attr('title',index-1);
					row.toggleClass('cms-row-odd').animate( { top : (parseInt(row.css('top')) - js_vars['cms_row_height'] )+'px' } , 500 ) ;
					prevRow.toggleClass('cms-row-odd').animate( { top : (parseInt(prevRow.css('top')) + js_vars['cms_row_height'] )+'px' } , 500 , function(){ js_vars['ajax_is_working_now'] = false ; } ) ;
				}
				else { alert( js_vars['message_arrange_error'] ) ; js_vars['ajax_is_working_now'] = false ; }
			});
		}
	}
}
function cmsArrangeDown( a , table, id ) {
	if( !js_vars['ajax_is_working_now'] ) {
		var last = parseInt($('.cms-row').size()) ;
		var row = $(a).parent().parent() ;
		var index = parseInt(row.attr('title'));
		if( last != index ) {
			js_vars['ajax_is_working_now'] = true ;
			$.get( 'ajax.php?token='+TOKEN+'&a=arrangeDown&id='+id+'&table='+table , function( response ) {
				if( response == '1' ) {
					var nextRow = $('.cms-row[title="'+(index+1)+'"]').attr('title',index) ;
					row.attr('title',index+1);
					row.toggleClass('cms-row-odd').animate( { top : (parseInt(row.css('top')) + js_vars['cms_row_height'] )+'px' } , 500 ) ;
					nextRow.toggleClass('cms-row-odd').animate( { top : (parseInt(nextRow.css('top')) - js_vars['cms_row_height'] )+'px' } , 500, function(){ js_vars['ajax_is_working_now'] = false ; } ) ;
				}
				else { alert( js_vars['message_arrange_error'] ) ; js_vars['ajax_is_working_now'] = false ; }
			});
		}
	}
}
function cmsActivation( a , table, id ) {
	$.get( 'ajax.php?token='+TOKEN+'&a=activation&id='+id+'&table='+table , function( response ) {
		if( response == '1' ) {
			$(a).toggleClass('disactive');
		}
		else alert( js_vars['message_activation_error'] ) ;
	});
}
function cmsConfirm( a , table, id ) {
	$.get( 'ajax.php?token='+TOKEN+'&a=confirm&id='+id+'&table='+table , function( response ) {
		if( response == '1' ) cmsDeleteRow( a ) ;
		else alert( js_vars['message_confirmation_error'] ) ;
	});
}
function cmsDeleteRow( a ) {
	var row = $(a).parent().parent() ;
	var index = parseInt(row.attr('title')) ;
	row.css({display:'none'});
	var last = parseInt($('.cms-row').size()) ;
	if( index < last ) {
		var i = index +1 ;
		while( i <= last ) {
			$('.cms-row[title="'+i+'"]').animate({top: ( parseInt($('.cms-row[title="'+i+'"]').css('top'))-js_vars['cms_row_height'] )+'px'} , 300 ).attr('title',i-1) ; i++ ;
		}
	}
	row.remove();
	updateDisplay() ;
}
function updateDisplay() {
	$('.cms-row').removeClass('cms-row-odd') ;
	$('.cms-row:odd').addClass('cms-row-odd') ;
	$('.cms-table').animate({ height : parseInt($('.cms-row').size())*js_vars['cms_row_height']+10 } , 300 ) ;
}
function cmsDelete( a , table , id ) {
	if( !js_vars['ajax_is_working_now'] && confirm( js_vars['message_are_you_sure_to_delete'] ) ){
		js_vars['ajax_is_working_now'] = true ;
		$.get( 'ajax.php?token='+TOKEN+'&a=delete&id='+id+'&table='+table , function( response ) {
			if( response == '1' )	 cmsDeleteRow( a ) ;
			else alert( js_vars['message_activation_error'] ) ;
			js_vars['ajax_is_working_now'] = false ;
		});
	}
}
function cmsAddFile( type , name ) {
	var cmsFormFile = document.getElementById('cmsFormFile') ;
	cmsFormFile.onchange = function(){
		if( isPermittedExtension( getExtension( $(this).val() ) , js_vars[name+'_extension'] ) ) {
			js_vars['valid_form'] = false ;
			$('.cms-upload-button').css({ display : 'none'});
			$('#'+name+'_loader').css({display:'block'});
			//upload the file
			fileUpload( this , 'ajax.php?token='+TOKEN+'&a=addTmpFile' , name ) ;
		}
		else alert( js_vars['message_invalid_file_extension'] ) ;
	};
	cmsFormFile.click() ;
}
function cmsDeleteFile( elemId , fileId , fileName ) {
	if( confirm( js_vars['message_are_you_sure_to_delete_file']+' '+fileName ) ) {
		$.get( 'ajax.php?token='+TOKEN+'&a=deleteFile&fileId='+fileId , function( response ) {
			//after delete by ajax
			if( response == '1' ) {
				$('#cms-thumb-'+fileId).css({display : 'none'});
				js_vars[elemId+"_count"]-- ;
				$('#'+elemId+'_button').css({visibility:'visible'});
			}
			else alert( js_vars['message_delete_file_error'] ) ;
		});
	}
}
//after file upload with cmsAddFile function
function afterFileUpload( MessageFromServer , name ) {
	//when I upload the file
	if( MessageFromServer != '0' ) {
		var fileAry = MessageFromServer.split('|');
		var extension = getExtension(fileAry[0]) ;
		switch(extension) {
			case 'gif': case 'png':	case 'jpg': case 'jepg':
			thumb = '<div class="cms-thumb"><img src="tmp/_'+fileAry[0]+'" /><div class="cms-thumb-imagename">'+unExtension( fileAry[1] )+'</div></div>' ;
			break ;
			default:
			thumb = '<div class="cms-thumb cms-thumb-'+extension+'"><div class="cms-thumb-filename">'+unExtension( fileAry[1] )+'</div></div>' ;
		}
	  $('#'+name+'_container').append(thumb) ;
	  $('.cms-upload-button').css({ display : 'block'});
	  $('#'+name+'_loader').css({display:'none'});
	  js_vars[name+'_count']++ ;
	  if( js_vars[name+'_count'] == js_vars[name+'_max'] ) $('#'+name+'_button').css({visibility:'hidden'}) ;
	  //add the file name
	  var fileNames = $('#'+name).val() ;
	  if( fileNames == '' ) $('#'+name).val(fileAry[0]) ; else $('#'+name).val(fileNames+'|'+fileAry[0])
	} else alert( 'Error' ) ;
	//can submit the form now
	js_vars['valid_form'] = true ;
}
/*function deleteLangKey( keyToDelete ) {
	if( confirm( keyToDelete ) ) {
		$.post( '' , { action : 'deleteKey' , key : keyToDelete } , function(e){  } ) ;
	}
}*/
/* Public vars */

function isEmail( strEmail ) {
  validRegExp = /^[^@]+@[^@]+.[a-z]{2,}$/i ;
   if ( strEmail.search(validRegExp) == -1 ) return false;
   return true;
}
function toolTip( element_id )
{
	var elem = $('#'+element_id).addClass( 'tooltip' ) ;
	var text = elem.val() ;
	elem.focus(function(){
		if( $(this).val() == text ){
			$(this).val('').removeClass( 'tooltip' );
		}
	});
	
	elem.blur(function(){
		if( $(this).val() == '' ){
			$(this).val(text).addClass( 'tooltip' );
		}
	});
}
function toolTipPass( element_id )
{
	var elem = $('#'+element_id) ;
	var text = elem.val() ;
	elem.focus(function(){
		if( $(this).val() == text ){
			$(this).css( { backgroundPosition : 'center bottom' } ) ;
		}
	});
	
	elem.blur(function(){
		if( $(this).val() == '' ){
			$(this).css( { backgroundPosition : 'center top' } ) ;
		}
	});
}
//this function needs to afterFileUpload( MessageFromServer ) function build it in the same page you build
function fileUpload( inputFileDom , action_url , div_id ) {
	var form = inputFileDom.form ;
	// Create the iframe...
	var iframeId = 'upload_iframe'+Math.random() ; var iframeName = iframeId ;
	var iframe = document.createElement("iframe"); iframe.setAttribute("id",iframeId); iframe.setAttribute("name",iframeId);iframe.setAttribute("width","0"); iframe.setAttribute("height","0"); iframe.setAttribute("border","0"); iframe.setAttribute("style","width: 0; height: 0; border: none;"); 
	// Add to document...
	form.parentNode.appendChild(iframe);
	window.frames[iframeId].name=iframeId;
	iframeId = document.getElementById(iframeId);
	// Add event...
	var eventHandler = function() {
	   //remove event handler
	  if( iframeId.detachEvent ) iframeId.detachEvent("onload", eventHandler); else iframeId.removeEventListener("load", eventHandler, false);
	  // Message from server...
	  if (iframeId.contentDocument) MessageFromServer = iframeId.contentDocument.body.innerHTML; else if (iframeId.contentWindow) MessageFromServer = iframeId.contentWindow.document.body.innerHTML; else if (iframeId.document) MessageFromServer = iframeId.document.body.innerHTML;
	   afterFileUpload( MessageFromServer , div_id ) ;
	  // Delete the iframe...
	  setTimeout('iframeId.parentNode.removeChild(iframeId)', 250 );
	} ;
	 //add event handler
	if( iframeId.addEventListener ) iframeId.addEventListener("load", eventHandler, true); if(iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);
	// Set properties of form...
	form.setAttribute("target", iframeName ); form.setAttribute("action", action_url); form.setAttribute("method","post"); form.setAttribute("enctype","multipart/form-data"); form.setAttribute("encoding","multipart/form-data");
	// Submit the form...
	form.submit();
}
function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}
function getExtension( fileName ) {
	var a = fileName.split('.'); 
	return a[a.length-1].toLowerCase() ;
}
function unExtension ( fileName ) {
	var a = fileName.split('.'); 
	return a[0] ;
}
function isPermittedExtension( extension , permittedExtensions ) {
	var ary = permittedExtensions.split(' ');
	if( inArray(extension, ary ) ) return true ;
	return false ;
}
//On all the documents Ready
$(document).ready(function () {
});