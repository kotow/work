<div class="right_column_newsletter">
	<h1>Newsletter</h1>
	
	<form action="<?php echo $resultPageHref; ?>" method="post" id="form_subscribe" name="form_subscribe">
		<p>
			<?php echo frontend_input("newsletter_email", "E-mail", array("class" => "right_column_newsletter_input", "onfocus" => "if(this.value == 'E-mail') this.value=''")); ?>
			<img align="absmiddle" style="cursor: pointer; cursor: hand;" src="images/button_buletin.gif" onclick="document.getElementById('form_subscribe').submit();" />
		</p>
	</form>
</div>