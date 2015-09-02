<h1 class="content-heading"><span>Products / <?php if($category) echo $category->getLabel()?></span></h1>
<div class="content">
	<div class="product-gallery">
		<a href="<?php if($mainImg) echo $mainImg->getRelativeUrl()?>" title="" class="big-image" rel="example_group">
		<img src="/media/display/id/<?php if($product) echo $product->getImage()?>" alt=""/>
		</a>
		<ul class="product-thumbs">
			<?php foreach ($images as $image):?>
			<li>
				<a rel="example_group" href="<?php echo $image->getRelativeUrl()?>" title="">
					<img src="/media/display/thumb/thumbs/id/<?php echo $image->getId()?>" alt=""/>
				</a>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="product-description">
		<?php if($product): $id = $product->getId()?>
			<h2><?php echo $product->getLabel()?></h2>
			<?php echo $product->getDescription()?>
			<p class="price"> Price: <span>$<?php echo $product->getPrice()?></span></p><br>
			<p>
			<?php if (array_key_exists($id, $_SESSION['cart'])):?>
				<a href="javascript:void(0)" title="Add to cart" class="button-cont add-cart-detail" add_id='<?php echo $id?>' style="color:#999999"><span id="prod_detail_<?php echo $id?>">Added to Cart</span></a>
			<?php else:?>
				<a href="javascript:void(0)" title="Add to cart" class="button-cont add-cart-detail" add_id='<?php echo $id?>'><span id="prod_detail_<?php echo $id?>">Add to Cart</span></a>
			<?php endif;?>
			</p>
			
		<?php endif;?>
	</div>
	<div class="clear"></div>   
</div>