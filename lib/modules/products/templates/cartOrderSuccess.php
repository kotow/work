<div class="right-box" id="cart">
	<h3 class="right-heading"><span class="cart"><?php echo UtilsHelper::Localize("website.frontend.Cart_order_title")?></span></h3>
    <div class="box-cont">
    
    <!--
	<span id="haveItems" <?php //if ($count == 0):?>style="display:none"<?php //endif;?>>
    <p>You have <strong><span id="count"><?php //echo $count;?></span> products</strong> in the cart</p>
    	<ul class="cart-list" id="items" style="display:block">
        	<?php //foreach ($products as $product):
        	//$id = $product->getId();
        	?>
    		<li id='cart_<?php //echo $id?>'>
	    		<span class="cart-name">
	    			<?php //echo $product->getLabel()?>
	    		</span>
	    		<a href="#" del_id="<?php //echo $id?>" class="cart-order-del">x</a>
	    		<br class="clear" />
    		</li>
            <?php //endforeach;?>
        </ul>
    </span>
    
    <p id="noItems" <?php //if ($count > 0):?>style="display:none"<?php //endif;?>>There are no products in the Cart</p>
    -->
        <p class="no-border">
    		<a href="<?php echo $referer;?>" title="Order" class="button-r" >
    			<span>Go back</span>
    		</a>
    	</p>
    </div>
    <div class="clear"></div>
</div>