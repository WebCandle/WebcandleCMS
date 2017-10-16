<div id="notification"></div>
<?php if( $success ) { ?>
<div class="success"><?php echo $success ?></div>
<?php } elseif( $warning ) { ?>
<div class="warning"><?php echo $warning ?></div>
<?php } elseif( $attention ) { ?>
<div class="attention"><?php echo $attention ?></div>
<?php } ?>