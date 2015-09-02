<?php if(!$result):
$errcard = "";
$errexp = "";
if($response_text == 'Credit card number is required.') $errcard = "error";
if($response_text == 'Expiration date is required.') $errexp = "error";
?>

<h1 class="content-heading"><span><?php echo UtilsHelper::Localize("website.frontend.Process_sale")?></span></h1>
<div class="content">
	<p class="authorize">
		<!-- (c) 2005, 2011. Authorize.Net is a registered trademark of CyberSource Corporation -->
		<script type="text/javascript" language="javascript">var ANS_customer_id="238ec66c-d744-4bcf-88f7-270b153147ad";</script>
		<script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script>
		<img src="/images/card.gif"> All Major Credit Cards Accepted!
	</p>
	<h3>Payment</h3>
	<div id="flashMsg"></div>
	<form id="payment_form" method="POST"> 
		<div class="form-holder">
			<input type="hidden" name="submitted" value="submitted">
			<div class="field">
				<label>First Name<span class="obligated">*</span></label>
				<?php echo frontend_input("x_first_name", null, array('class'=>'large'))?>
			</div>
			<div class="field">
				<label>Last Name<span class="obligated">*</span></label>
				<?php echo frontend_input("x_last_name", null, array('class'=>'large'))?>
			</div>                  
			<div class="field">
				<label>Address <span class="obligated">*</span></label>
				<?php echo frontend_input("x_address", null, array('class'=>'large'))?>
			</div>
			<div class="field">
				<label>E-mail <span class="obligated">*</span></label>
				<?php echo frontend_input("x_email", null, array('class'=>'large'))?>
			</div>     
			<div class="field">
				<label>Phone <span class="obligated">*</span></label>
				<?php echo frontend_input("x_phone", null, array('class'=>'large'))?>
			</div>  
			<div class="field">
				<label>Delivery Address</label>
				<?php echo frontend_input("x_delivery_address", null, array('class'=>'large'))?>
				<p class="extra inform">If different from the billing address</p>
			</div>                   
			<div class="field">
				<label>Zip<span class="obligated">*</span></label>
				<?php echo frontend_input("x_zip", null, array('class'=>'medium'))?>
			</div>                   
			<div class="field">
				<label>City<span class="obligated">*</span></label>
				<?php echo frontend_input("x_city", null, array('class'=>'medium'))?>
			</div>                              
			<div class="field">
				<label>State<span class="obligated">*</span></label>
				<?php echo frontend_input("x_state", null, array('class'=>'medium'))?>
			</div>                    
			<div class="field">
				<label>Card Type<span class="obligated">*</span></label>
				<?php echo frontend_select("x_card_type", null,
				array(
				""=>"Select",
				"A"=>"American Express",
				"V"=>"Visa",
				"M"=>"MasterCard",
				"D"=>"Discover",
				"C"=>"Diner's Club",
				"E"=>"EnRoute",
				"H"=>"eCheck.Net",
				"J"=>"JCB"
				),
				array("style"=>"width: 13.5em;","id"=>"creditCardType"))
				?>
			</div>             
			<div class="field">
				<label>Card Number<span class="obligated">*</span></label>
				<?php echo frontend_input("x_card_num", null, array("class"=>"medium $errcard"))?>
			</div>               
			<div class="field">
				<label>Exp date<span class="obligated">*</span></label>
				<?php 
				$current_year = date("Y");
				$years = array(""=>"---- Year ----");
				for ($i=0; $i <12; $i++)
					$years[$current_year+$i] = $current_year+$i;
				
				echo frontend_select("exp_month", null,
				array(
				""=>"---- Month ----",
				"01"=>"Jan",
				"02"=>"Feb",
				"03"=>"Mar",
				"04"=>"Apr",
				"05"=>"May",
				"06"=>"Jun",
				"07"=>"Jul",
				"09"=>"Aug",
				"10"=>"Sept",
				"11"=>"Oct",
				"12"=>"Dec"
				));
				
				echo frontend_select("exp_year", null, $years);
				?>
			</div>                   
			<div class="field">
				<label>CCV<span class="obligated">*</span></label>
				<?php echo frontend_input("x_card_code", null, array('class'=>'medium'))?>
				<p class="extra inform">Look for a three-digit, non-embossed number printed on the signature panel on the back of your card.It immediately follows your account number</p>
			</div>                  
			<div class="field">    
				<div class="terms">
					<div>
						<h1>Terms of use</h1>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
						Why do we use it?</p>
						<p>
						It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
						<p>Where does it come from?
						Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
						</p>
					</div>
				</div> 
			</div>
			<div class="field">
				<label>I accept<span class="obligated">*</span></label>
				<input type="checkbox" name="terms" value="1" <?php if($sf_params->get('terms')) echo "checked"?>>
			</div>                 
		</div>
		<p><?php echo UtilsHelper::Localize("website.frontend.order_text")?></p>
		<p class="no-border"><a class="button-cont" title="#" href="#" onclick="$('#payment_form').submit();"><span>Submit Order</span></a></p>
	</form>	
	<div class="clear"></div>          
</div>
<?php else:?>
	<h1 class="content-heading"><span><?php echo UtilsHelper::Localize("website.frontend.Process_sale_success")?></span></h1>
<div class="content">
	<h3>
	<?php echo UtilsHelper::Localize("website.frontend.Process_sale_success_text")?>
	</h3>
</div>
<?php endif;?>
