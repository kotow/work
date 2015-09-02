<?php if($pages):?>
<h3 class="serif lead"><?php echo UtilsHelper::Localize("website.frontend.Promo_menu_title")?></h3>
	<ul>
		<?php foreach ($pages as $p):
		$page = Document::getDocumentByCulture($p, null, true);
		if(!$page) continue;
		?>
			<li>
				<a title="<?php echo $page->getLabel();?>" href="<?php echo $page->getHref();?>" style="outline: medium none;">
					<?php echo $page->getLabel();?>
				</a>
			</li>
		<?php endforeach;?>
	</ul>
<?php endif;?>