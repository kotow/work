<div class="left_column_newsletter">
	<h1>Newsletter</h1>
	
	<form action="<?php echo $resultPageHref; ?>" method="post" id="form_subscribe_home" name="form_subscribe_home">
		<table>
			<tr>
				<td>
					<?php echo frontend_input("newsletter_email", "E-mail", array("class" => "right_column_newsletter_input", "onfocus" => "if(this.value == 'E-mail') this.value=''")); ?>
				</td>
				<td>
					<img style="cursor: pointer; cursor: hand;" src="images/button_buletin.gif" onclick="document.getElementById('form_subscribe_home').submit();" />
				</td>
			</tr>
		</table>
	</form>
</div>