<?php if($page):?>
<div class="indent-top2">
    <div class="content indent-bottom1">
        <div class="sixteen columns">
            <div class="indent-left1 indent-right1">
                <h2 class="indent-top3"><?php echo $page->getLabel()?></h2>
            </div>
        </div>
        <?php echo $page->getDescription()?>
		<div class="sixteen columns">
            <div class="indent-left1 indent-right1">
                <div class="border-bottom"></div>
                <div class="indent-top4">
                    <div class="portfolio-gallery">
                        <div class="fourteen columns">
                            <ul id="gallery">
                            <?php foreach ($images as $img):?>
                                <li><img src="/media/display/id/<?php echo $img?>" alt="" /></li>
                            <?php endforeach;?>
                            </ul>
                        </div>
                        <a href="#" class="next" id="next"></a>
                        <a href="#" class="prev" id="prev"></a>
                    </div>
                </div>
                <br class="clear">
                <div class="indent-top4 indent-bottom1 align-center">
                    <a href="#" class="indent-left1 indent-right1">flike</a>
                    <a href="#" class="indent-left1 indent-right1">tweet</a>
                    <a href="#" class="indent-left1 indent-right1">inshare</a>
                    <a href="#" class="indent-left1 indent-right1">gshare</a>
                </div>
                <div class="border-bottom"></div>
                <div class="indent-top1">
                    <?php echo $page->getDescription2()?>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>

<?php endif;?>