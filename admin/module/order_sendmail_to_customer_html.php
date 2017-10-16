<h2 class="editor-title"><label><input type="checkbox" name="sendmail_to_customer" />&nbsp;&nbsp;ارسال رسالة بريد الكتروني للعميل</label></h2>
<label for="cms_elem10"><div class="label-title">الموضوع</div><input type="text" value="<?php echo cms_inputValue(stripslashes( SETTINGS_SITE_TITLE )).' : طلب رقم #' . $CMS['values']['id']; ?>" name="subject" class="form-text ar" id="cms_elem10"></label>
<label for="cms_elem40"><textarea name="message" class="form-textarea ar" id="cms_elem40"><?php echo 'السيد '.cms_inputValue(stripslashes($CMS['values']['customer_fname'].' '.$CMS['values']['customer_lname'])).' المحترم, تحية طيبة و بعد..' ; ?></textarea></label>
<input type="hidden" name="mail_to" value="<?php echo $CMS['values']['customer_email'] ; ?>" />
<script type="text/javascript">
CKFinder.setupCKEditor( null, '<?php echo BASE_PATH ; ?>admin/editor/ckeditor/ckfinder/' );
CKEDITOR.replace( 'cms_elem40', { toolbar : [ [ 'Bold', 'Italic','Underline','Strike','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' , '-' ,'BidiLtr','BidiRtl', '-', 'BulletedList','-','TextColor','BGColor', '-', 'Link', 'Unlink','-', 'Maximize' , 'Image', 'Flash' , 'Iframe' , 'Table' , 'RemoveFormat','Format','FontSize','Source'] ], width : 777 , height : 400 ,language: 'ar' , resize_enabled : false , contentsLangDirection : 'rtl' , enterMode : CKEDITOR.ENTER_BR } );
</script>