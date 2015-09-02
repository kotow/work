<?php $errors = $sf_request->getErrors(); ?>
<br/>
<br/>
<br/>
<?php if($err): ?>
	<span class="error_msg">
		<b><?php echo $err; ?></b>
	</span>
<?php else: ?>
	<b><?php echo $msg; ?></b>
<?php endif; ?>
	