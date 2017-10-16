<style type="text/css">
.lbl11 { display:inline; }
.lbl22 { display: inline-block; width: 180px; }
.form-text121 { width: 100px; }
.left-side-11 { float: left; width: 500px; }
.date { text-align:center; }

</style>
<script type="text/javascript">
$(document).ready(function(){
	$( ".date" ).datepicker({ dateFormat : "yy-mm-dd"});
});
</script>
<div style="padding:20px;">

<label for="cms_elem1"><div class="label-title">السعر بعد الحسم</div><input id="cms_elem1" class="form-text ar" name="price" value="0" type="text"></label>


<div class="left-side-11">

&nbsp;&nbsp;من تاريخ &nbsp;&nbsp;<input type="text" class="form-text date" name="from" />&nbsp;&nbsp;&nbsp;&nbsp; إلى تاريخ&nbsp;&nbsp;<input type="text" name="to" class="form-text date" /><br />

</div>
<div class="clear"></div>
</div>