<div id="logo">
	<a href="/"><img src="/images/logo.png" alt="" /></a>
</div>

<!--<ul id="menu">
	<li class="current"><a href="index.html">ЗА НАС</a></li>
	<li><a href="blog-1.html">BLOG</a>
		<ul>
			<li><a href="blog-1.html">BLOG STYLE #1</a></li>
			<li><a href="blog-2.html">BLOG STYLE #2</a></li>
		</ul>
	</li>
	<li><a href="portfolio-3c.html">PORTFOLIO</a>
		<ul>
			<li><a href="portfolio-3c.html">PORTFOLIO &#8211; 3 COLUMNS</a></li>
			<li><a href="portfolio-2c.html">PORTFOLIO &#8211; 2 COLUMNS</a></li>							
		</ul>
	</li>
	<li><a href="gallery.html">GALLERY</a></li>
	<li><a href="#">STYLINGS</a>
		<ul>
			<li><a href="stylings-texts.html">TEXTS</a></li>
			<li><a href="stylings-table_columns.html">TABLE &#038; COLUMNS</a></li>
			<li><a href="stylings-tabs_toggles.html">TABS, TOGGLES &#038; CAROUSEL</a></li>
				<li><a href="stylings-images_videos.html">IMAGES &#038; VIDEOS</a></li>
			<li><a href="stylings-contact_buttons.html">CONTACT FORM &#038; BUTTONS</a></li>
		</ul>
	</li>
</ul>-->


<?php
	echo MenuHelper::get_menu_by_tag("website_menu_main",
		array(
			'depth' => 2,
			'mainMasterId' => 'menu',
			'currentItemClass' => 'current',
			'inPath' => true
		)
	);
?>