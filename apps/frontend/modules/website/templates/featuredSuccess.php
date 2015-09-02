<br class="clear">
<div class="border-bottom"></div>
<div class="two-thirds column alpha omega indent-right2 border-right box box-left">
    <div class="eleven columns">
        <div class="indent-left1 indent-top2">
            <h2>Featured Projects</h2>
            <ul class="box-gallery" id="projects">
<?php foreach ($featured as $p): ?>
<?php
	$page = Document::getDocumentByCulture($p, null, true);
	$url = $page->getHref();
?>
                <li>
                    <div class="img-box">
                        <a href="<?php echo $url?>"><img src="/media/display/thumb/small/id/<?php echo $page->getImage();?>" alt="" style="margin-top: 0px;"></a>
                        <a href="<?php echo $url?>"><img src="/media/display/thumb/small/id/<?php echo $page->getImage2();?>" alt=""></a>
                    </div>
                </li>
<?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
                