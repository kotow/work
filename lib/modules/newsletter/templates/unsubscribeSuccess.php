<?php $errors = $sf_request->getErrors();?>
<?php if(!$msg):?>
	<h1 class="title1">Unsubscribe from our newsletter</h1>
	<span class="error_msg">
	<?php foreach($errors as $er)
	{
		echo $er."<br>";
	}
	?>
	</span>
	<div class="left_column_newsletter">
		<h1></h1>
		<form action="<?php echo $resultPageHref; ?>" method="post" id="form_unsubscribe" name="form_unsubscribe">
			<p>
				<?php echo frontend_input("unsubscribeMail", "E-mail", array("class" => "left_column_newsletter_input", "onfocus" => "if(this.value == 'E-mail') this.value=''")); ?>
				&nbsp;<img align="absmiddle" style="cursor: pointer; cursor: hand;" src="images/button_unsubscribe.gif" onclick="document.getElementById('form_unsubscribe').submit();" />
			</p>
		</form>
	</div>
<?php else: ?>
	<?php echo $msg?>
<?php endif; ?>