<div class="one-third column alpha omega indent-right2 border-right">
	<div class="five columns">
		<div class="indent-left1 indent-top2">
			<h2>Find us</h2>
			<ul class="menu-social">
				<li><a href="#"><img src="images/icons/facebook.png" alt="Facebook"></a></li>
				<li><a href="#"><img src="images/icons/twitter.png" alt="Twitter"></a></li>
				<li><a href="#"><img src="images/icons/linkedin.png" alt="LinkedIn"></a></li>
				<li><a href="#"><img src="images/icons/behance.png" alt="Behance"></a></li>
				<li><a href="#"><img src="images/icons/skype.png" alt="Skype"></a></li>
			</ul>
			<br class="clear">
			<address>
				<div class="mail">
					<img src="images/icons/mail.png" alt="E-mail">
					<a href="mailto:
					<?php
						echo UtilsHelper::Settings("main_email");
					?>">
					<?php
						echo UtilsHelper::Settings("main_email");
					?>
					</a>
				</div>
				<div class="phone indent-top1">
					<img src="images/icons/phone-touch.png" alt="Phone">
					<?php
						echo UtilsHelper::Settings("telephone");
					?>
				</div>
			</address>
		</div>
	</div>
</div>
<div class="one-third column alpha omega indent-right2 border-right">
	<div class="five columns">
		<div class="indent-left1 indent-top2">
			<nav>
<?php
	echo MenuHelper::get_menu_by_tag("website_menu_main",
		array(
			'depth' => 1,
			'mainMasterClass' => 'menu-bottom',
			'currentAClass' => 'selected',
			'splitElements' => 4
		)
	);
?>
<?php /*
				<ul class="menu-bottom">
					<li><a class="selected" href="/">home</a></li>
					<li><a href="web_services">web services</a></li>
					<li><a href="offline_services">offline services</a></li>
					<li><a href="portfolio.html">portfolio</a></li>
				</ul>
				<ul class="menu-bottom">
					<li><a href="about_us.html">about us</a></li>
					<li><a href="http://blog.donecollective.com">blog</a></li>
					<li><a href="contacts.html">contacts</a></li>
					<li><a class="last" href="get_a_quote">get a quote</a></li>
				</ul>
*/ ?>
			</nav>
		</div>
	</div>
</div>
<div class="one-third column alpha omega indent-right2">
	<div class="five columns">
		<div class="indent-left1 indent-top2">
			<h2>From our blog</h2>
			<p class="italic">
				Web design principles or how we make your website successful
			</p>
			<a href="#" class="button">Read More</a>
		</div>
	</div>
</div>
<br class="clear">
<div class="border-bottom"></div>
<div class="two-third column alpha indent-right2">
	<div class="ten columns">
		<div class="indent-left1 indent-top2">
			<a href="#" target="_blank"><img src="images/bbb-banner.png" alt="BBB"></a>
		</div>
	</div>
</div>
<div class="one-thirds column alpha omega indent-left2">
	<div class="five columns">
		<div class="indent-top2">
			<ul class="footer-links p0 font13">
				<li><a href="#">Legal</a></li>
				<li><a href="#">Clientbase login</a></li>
				<li><a href="#">PM login</a></li>
			</ul>
			<br class="clear">
			<p class="footer-rights font13">
				2012 Done collective LLC. All rights reserved. 
			</p>
		</div>
	</div>
</div>