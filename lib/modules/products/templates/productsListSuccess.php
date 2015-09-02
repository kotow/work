<h1 class="content-heading"><span>Products</span></h1>
<div class="content">
<h2><?php echo ucfirst($category->getLabel())?></h2>
	<div class="products">
		<?php
		$i=0;
		foreach ($products as $p):
		$i++;
		$id = $p->getId();
		$url = UtilsHelper::cleanURL($p);
		
		?>
	    	<div class="product">
	            <a href="<?php echo $url?>" title="#" class="product-image">
	            	<?php echo Media::displayThumb($p->getImage(), 160, 120, false);?>
	            </a>
	            <h1><?php echo $p->getLabel()?></h1>
	            <a href="<?php echo $url?>" title="More Info" class="more-info">More Info</a>
	            
	            <?php if (array_key_exists($id, $_SESSION['cart'])):?>
					 <a href="javascript:void(0)" title="Add to cart" class="add-cart" add_id='<?php echo $id?>' id="prod_<?php echo $id?>" style="color:#999999">Added to Cart</a>
				<?php else:?>
					 <a href="javascript:void(0)" title="Add to cart" class="add-cart" add_id='<?php echo $id?>' id="prod_<?php echo $id?>">Add to Cart</a>
				<?php endif;?>
	           
	            <div class="clear"></div>
	        </div>
	        
        <?php if($i%3==0):?><br class="clear" /><?php endif?>
        <?php endforeach;?>
        
        <div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>