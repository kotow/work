<table class="mainNavigation" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
		<?php if($userRights['tag']): ?>
			<a href="?refresh=modules_tag">Tags</a>
		<?php endif; ?>
		<?php if($userRights['lists']): ?>
			<a href="?refresh=modules_lists">Lists</a>
		<?php endif; ?>
		<?php if($userRights['website']): ?>
			<a href="?refresh=modules_website">Website</a>
		<?php endif; ?>
		<?php if($userRights['user']): ?>
			<a href="?refresh=modules_user">Users</a>
		<?php endif; ?>
		<?php if($userRights['media']): ?>
			<a href="?refresh=modules_media">Media</a>
		<?php endif; ?>
		<?php if($userRights['news']): ?>
			<a href="?refresh=modules_news">News</a>
		<?php endif; ?>
		<?php if($userRights['newsletter']): ?>
			<a href="?refresh=modules_newsletter">Newsletter</a>
		<?php endif; ?>
		<?php if($userRights['keywords']): ?>
			<a href="?refresh=modules_keywords">Keywords</a>
		<?php endif; ?>
		<?php if($userRights['products']): ?>
			<a href="?refresh=modules_products">Products</a>
		<?php endif; ?>
		<?php if($userRights['services']): ?>
			<a href="?refresh=modules_services">Services</a>
		<?php endif; ?>
		</td>
		<td align="center"  id="logout" style="font-size:14px;height:18px;" width="100">
			<a style="border:none;width:100px" href="user/logout" id="action_user_logout"><img align="absmiddle" src="/images/icons/logout.png" border="0"> Log out</a>
		</td>
	</tr>
</table>