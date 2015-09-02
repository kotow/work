	<div class="qfHeaderWrap">
		<div class="qfHeaderNav">
			<div class="qfLogoWrap"><a href="/"><img src="/images/logo.png" alt="Trademark Tracking System" /></a></div>
<?php if ($user = $sf_user->getSubscriber()): ?>
			<div class="qfUserNav">
				<div class="qfUsetCol qfUser"><?php echo $user->getLabel(); ?></div>
				<div class="qfUsetCol qfLogInOut"><a class="qfLogOut" href="/user/logout">Log Out</a></div>
			</div>
<?php endif; ?>
		</div>
	</div>
    <div class="qfHeaderPrintWrap">
    	<img src="/images/logo.png" alt="Trademark Tracking System" />
    </div>
