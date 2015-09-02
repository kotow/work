<?php if ($news):
$url = UtilsHelper::cleanURL($news, true);
$label = $news->getLabel();;
?>
<h2><?php echo $label;?></h2>
<br />
<?php echo UtilsHelper::Date($news->getStartDate(),"H:i | d.m.Y"); ?> | Прочетена: <strong><?php echo $news->getRds(); ?> пъти</strong>
<?php 
$img = $news->getImage();
if($image = Document::getDocumentInstance($img)):
?>
<img width="528" src="/media/upload/<?php echo $img?>" class="news_im" title="<?php echo $image->getDescription();?>"/>
<?php endif;?>
<br /><br />
<?php echo $news->getContent();?>

		<div class="clearfix"></div>
		<div class="related">
			<?php
			$related = explode(';', $news->getRelated());
			$relatedArr = array();
			foreach ($related as $id)
			{
				if ($user = Document::getDocumentInstance($id))
				$relatedArr[] = '<a href="'.UtilsHelper::cleanURL($user).'">'.$user->getLabel().'</a>';
			}
			echo implode(', ', $relatedArr);
			?>
		</div>
<?php endif;?>