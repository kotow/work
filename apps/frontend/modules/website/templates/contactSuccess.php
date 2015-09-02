<h1 class="content-heading"><span><?php echo UtilsHelper::Localize("website.frontend.Contact_title")?></span></h1>
<div class="content">

 	<h3>Drop Us a Message</h3>

	<form id="contact_form" method="POST">
		<div class="form-holder">
		<?php if (!$success):?>
		
			<!--<div id="flashMsg"></div>-->
			<div class="field">
				<label>Full Name <span class="obligated">*</span></label>
				<?php echo frontend_input("full_name", null, array('class'=>'big'))?>
			</div>
	
			<div class="field">
				<label>E-mail <span class="obligated">*</span></label>
				<?php echo frontend_input("email", null, array('class'=>'medium'))?>
			</div>	
	
			<div class="field">
				<label>About <span class="obligated">*</span></label> 
				<?php echo frontend_select("service", null, Lists::getListitemsForSelect("requests", array(""=>"Quote")), array("class"=>"serv"))?>
			</div>

			<div class="field">
				<label>Message <span class="obligated">*</span></label>
				<?php echo frontend_textarea("message", null, array('class'=>'large'))?>
			</div>

			<div class="field">
				<label></label><img src="/user/captcha">
			</div>
				
			<div class="field">
				<label>Security </label>
				<?php echo frontend_input("captcha", null, array('class'=>'small'))?>
		   		<p style="margin-left:125px">Please, do smth that will prove you are not a robot</p>
			</div>			  
		
			<input type='hidden' value='submitted' name="submitted"/>
	   		<p class="no-border"><a class="button-cont" title="#" href="#" onclick="$('#contact_form').submit();"><span>Send us a message</span></a></p>
		
		<?php else:?>
		
			<h3>Thank You</h3>
		  	<p>Your message was successfully sent.</p>
		   	<p>You will recieve an answer shortly.</p><br>
		   	
		<?php endif;?>
		</div> 
	</form>
	<br class="clear" />
			  
</div>	