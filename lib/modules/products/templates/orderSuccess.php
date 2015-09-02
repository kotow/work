<h1 class="content-heading"><span><?php echo UtilsHelper::Localize("website.frontend.Purchase")?></span></h1>
<div class="content">
	<p class="authorize">
		<!-- (c) 2005, 2011. Authorize.Net is a registered trademark of CyberSource Corporation -->
		<script type="text/javascript" language="javascript">var ANS_customer_id="238ec66c-d744-4bcf-88f7-270b153147ad";</script>
		<script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script>
		<img src="/images/card.gif"> All Major Credit Cards Accepted!
	</p>
	<h3>Summary</h3>
	<div class="form-holder">
		<div class="row">
			<div class="grid_4"><strong>Product Name</strong></div>
			<div class="grid_1">Remove</div>
			<div class="grid_1">Quantity</div>
			<div class="grid_1">Price</div>
			<div class="clear"></div> 
		</div>
		<?php foreach ($products as $p):
			$currency = "$";
			$price = $p->getPrice();
			$id = $p->getId();
			if($_SESSION["num"][$id]) $price = $price*$_SESSION["num"][$id];
			$sub_total += $price;
		?>
		<div class="row">
			<div class="grid_4"><?php echo $p->getLabel();?></div>
			<div class="grid_1"><a href="" del_id="<?php echo $id?>" class="remove">Remove</a></div>
			<div class="grid_1">
				<input type="text" id="<?php echo $id?>" value="<?php if($_SESSION["num"][$id]) echo $_SESSION["num"][$id]; else echo "1"?>" class="small num_products"/>
			</div>
			<div class="grid_1"><strong id="price_<?php echo $id?>">&#36;<?php echo $price;?></strong></div>
			<div class="clear"></div> 
		</div>
		
		<?php endforeach;
			$total_taxes = round($sub_total*(UtilsHelper::Settings("taxes")/100), 2);
			$total = $sub_total+$total_taxes;
		?>
		          
		<br />
		
		<div class="row">
			<div class="grid_1 right"><strong id="sub_total">&#36;<?php echo $sub_total;?></strong></div><div class="grid_2 right">Merchandise Total:</div>
			<div class="clear"></div>
			<div class="grid_1 right"><strong id="taxes_total">&#36;<?php echo $total_taxes;?></strong></div><div class="grid_2 right">Estimated Taxes:</div>
			<div class="clear"></div>
			<div class="grid_1 right"><strong id="total">&#36;<?php echo $total;?></strong></div><div class="grid_2 right">Total:</div>
			<div class="clear"></div>
		</div>                  
		<br />
		<p class="extra"></p>
	</div>
	<p><?php echo UtilsHelper::Localize("website.frontend.checkout_text")?></p>
	<p class="no-border"><a class="button-cont" title="#" href="<?php echo $processPageUrl?>"><span>Check out</span></a></p>  
	<div class="clear"></div>          
</div>