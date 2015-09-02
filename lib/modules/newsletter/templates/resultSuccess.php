<?php $errors = $sf_request->getErrors(); ?>
<?php if($errors):?>
	<span class="error_msg">
		<?php foreach($errors as $er)
		{
			echo $er."<br>";
		}
		?>
	</span>
	<div class="left_column_newsletter">
		<p></p>
		<form action="<?php echo $resultPageHref; ?>" method="post" id="form_subscribe_result" name="form_subscribe_result">
			<table>
				<tr>
					<td>
						<input type="text" value="<?php echo $sf_params->get("newsletter_email"); ?>" class="left_column_newsletter_input" name="newsletter_email"/>&nbsp;&nbsp;
					</td>
					<td>
						&nbsp;<img style="cursor: pointer; cursor: hand;" src="images/button_buletin.gif" onclick="document.getElementById('form_subscribe_result').submit();" />
					</td>
				</tr>
			</table>
		</form>
	</div>
<?php else:?>
	<b><?php echo $msg?></b>
<?php endif;?>
