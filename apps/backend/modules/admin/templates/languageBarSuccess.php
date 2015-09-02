<?php if(count($children) > 0):?>
	<ul class="languages">
		<?php foreach ($children as $child): ?>
			<li  onclick="editDocument('<?php echo $child['type'] ?>', <?php echo $child['id'] ?>)">
				<span id="<?php echo $child['id'] ?>" style="width:180px;<?php echo $child['style'] ?>" class="<?php echo $child['class'] ?>" >
					<?php echo $child['culture']->getLabel() ?>
				</span>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
