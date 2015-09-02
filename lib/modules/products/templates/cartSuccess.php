<div class="right-box" id="cart">
	<h3 class="right-heading"><span class="cart"><?php echo UtilsHelper::Localize("website.frontend.Cart_title")?></span></h3>
    <div class="box-cont">
    
    <span id="haveItems" <?php if ($count == 0):?>style="display:none"<?php endif;?>>
    <p>You have <strong><a href="#" title="#" class="cart-trigger"><span id="count"><?php echo $count;?></span> products</a></strong> in the cart</p>
    	<ul class="cart-list" id="items">
        	<?php foreach ($products as $product):
        	$id = $product->getId();
        	?>
    		<li id='cart_<?php echo $id?>'><span class="cart-name"><?php echo $product->getLabel()?></span><a href="#" del_id="<?php echo $id?>" class="cart-del">x</a><br class="clear" /></li>
            <?php endforeach;?>
        </ul>
    	<p class="no-border">
    		<a href="<?php echo $orderPageUrl?>" title="Order" class="button-r" >
    			<span>Continue</span>
    		</a>
    	</p>
    	
    </span>
    
    <p id="noItems" <?php if ($count > 0):?>style="display:none"<?php endif;?>>There are no products in the Cart</p>
    </div>
    <div class="clear"></div>
</div>