<style type="text/css">
.lbl11 { display:inline; }
.lbl22 { display: inline-block; width: 180px; }
.form-text { width: 100px; }
.left-side-11 { float: left; width: 500px; }
.date { text-align:center; }

.attention {
	padding: 5px 10px;
    padding-right: 33px;
	color: #555555;
	-webkit-border-radius: 5px 5px 5px 5px;
	-moz-border-radius: 5px 5px 5px 5px;
	-khtml-border-radius: 5px 5px 5px 5px;
	border-radius: 5px 5px 5px 5px;
	 font-size:12px;
	background: #FFF5CC url('../images/attention.png') right center no-repeat;
	border: 1px solid #F2DD8C;
	-webkit-border-radius: 5px 5px 5px 5px;
	-moz-border-radius: 5px 5px 5px 5px;
	-khtml-border-radius: 5px 5px 5px 5px;
	border-radius: 5px 5px 5px 5px;
	width: 90%;
	margin: 10px auto;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$( ".date" ).datepicker({ dateFormat : "yy-mm-dd"});
});
function submitForm(){
	$('.attention').remove();
	return true ;
}
</script>
<h1 class="content-title">تصدير إلى اكسل</h1>
<?php if( $_SESSION['export_no_result'] ) { unset($_SESSION['export_no_result']); ?>
<p class="attention">لا يوجد أي معلومات لتصديرها</p>
<?php } ?>
<form action="download.php" method="post" onsubmit="return submitForm()">
<input type="hidden" name="exoprt_orders" value="1" />
<input type="hidden" name="current_link" value="<?php echo cms_current_link() ; ?>" />
<div style="padding:20px;">
<div class="label-title">تصدير الطلبات</div>
<div class="left-side-11">
<label class="lbl11"><input type="radio" name="status" value="all" checked="checked" /> الجميع</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label class="lbl11"><input type="radio" name="status" value="pending" /> قيد الانتظار</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label class="lbl11"><input type="radio" name="status" value="active" /> قيد التنفيذ</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label class="lbl11"><input type="radio" name="status" value="complete" /> المكتملة</label><br /><br />
<label class="lbl11"><input type="radio" name="status" value="saved" />بانتظار الدفع</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label class="lbl11"><input type="radio" name="status" value="canceled" /> تم إلغاؤها</label>
<br /><br />
&nbsp;&nbsp;من تاريخ &nbsp;&nbsp;<input type="text" class="form-text date" name="from" />&nbsp;&nbsp;&nbsp;&nbsp; إلى تاريخ&nbsp;&nbsp;<input type="text" name="to" class="form-text date" /><br />

</div>
<div class="clear"></div>
</div>
<div class="form-buttons"><input type="submit" class="form-submit" value="تصدير" /></div>
</form>
<br />
<div class="editor-title">تصدير معلومات العملاء</div>
<form action="download.php" method="post">
<input type="hidden" name="exoprt_customers" value="1" />
<div class="form-buttons"><input type="submit" class="form-submit" value="تصدير" /></div><br />
</form>