
<!-- -------------------- MODULE services -------------------- -->

<?php if($userRights['services']): ?>
	<?php if($userRights['services']['Rootfolder']): ?>
	<div class='contextMenu' id='services_rootfolder'>
	<ul>
			<?php if($userRights['services']['Rootfolder']['createServiceCategory']): ?>
				<li id='createServiceCategory'><img src='/images/icons/servicecategory.png'/>Create ServiceCategory</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['services']['ServiceCategory']): ?>
	<div class='contextMenu' id='services_servicecategory'>
	<ul>
			<?php if($userRights['services']['ServiceCategory']['createService']): ?>
				<li id='createService'><img src='/images/icons/service.png'/>Create Service</li>
			<?php endif; ?>
			<?php if($userRights['services']['ServiceCategory']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['services']['ServiceCategory']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['services']['ServiceCategory']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['services']['Service']): ?>
	<div class='contextMenu' id='services_service'>
	<ul>
			<?php if($userRights['services']['Service']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['services']['Service']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['services']['Service']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

<?php endif; ?>

<!-- -------------------- MODULE website -------------------- -->

<?php if($userRights['website']): ?>
	<?php if($userRights['website']['Rootfolder']): ?>
	<div class='contextMenu' id='website_rootfolder'>
	<ul>
			<?php if($userRights['website']['Rootfolder']['createWebsite']): ?>
				<li id='createWebsite'><img src='/images/icons/website.png'/>Create Website</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['website']['Website']): ?>
	<div class='contextMenu' id='website_website'>
	<ul>
			<?php if($userRights['website']['Website']['createMenu']): ?>
				<li id='createMenu'><img src='/images/icons/menu.png'/>Create Menu</li>
			<?php endif; ?>
			<?php if($userRights['website']['Website']['createTopic']): ?>
				<li id='createTopic'><img src='/images/icons/topic.png'/>Create Topic</li>
			<?php endif; ?>
			<?php if($userRights['website']['Website']['createPage']): ?>
				<li id='createPage'><img src='/images/icons/page.png'/>Create Page</li>
			<?php endif; ?>
			<?php if($userRights['website']['Website']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['website']['Website']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['website']['Website']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['website']['Menu']): ?>
	<div class='contextMenu' id='website_menu'>
	<ul>
			<?php if($userRights['website']['Menu']['createTopic']): ?>
				<li id='createTopic'><img src='/images/icons/topic.png'/>Create Topic</li>
			<?php endif; ?>
			<?php if($userRights['website']['Menu']['createPage']): ?>
				<li id='createPage'><img src='/images/icons/page.png'/>Create Page</li>
			<?php endif; ?>
			<?php if($userRights['website']['Menu']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['website']['Menu']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['website']['Menu']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['website']['Topic']): ?>
	<div class='contextMenu' id='website_topic'>
	<ul>
			<?php if($userRights['website']['Topic']['createTopicI18n']): ?>
				<li id='createTopicI18n'><img src='/images/icons/topici18n.png'/>Create Topic (Language version)</li>
			<?php endif; ?>
			<?php if($userRights['website']['Topic']['createTopic']): ?>
				<li id='createTopic'><img src='/images/icons/topic.png'/>Create Topic</li>
			<?php endif; ?>
			<?php if($userRights['website']['Topic']['createPage']): ?>
				<li id='createPage'><img src='/images/icons/page.png'/>Create Page</li>
			<?php endif; ?>
			<?php if($userRights['website']['Topic']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['website']['Topic']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['website']['Topic']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['website']['Page']): ?>
	<div class='contextMenu' id='website_page'>
	<ul>
			<?php if($userRights['website']['Page']['createPageI18n']): ?>
				<li id='createPageI18n'><img src='/images/icons/pagei18n.png'/>Create Page (Language version)</li>
			<?php endif; ?>
			<?php if($userRights['website']['Page']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['website']['Page']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['website']['Page']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['website']['PageI18n']): ?>
	<div class='contextMenu' id='website_pagei18n'>
	<ul>
			<?php if($userRights['website']['PageI18n']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['website']['PageI18n']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['website']['Folder']): ?>
	<div class='contextMenu' id='website_folder'>
	<ul>
			<?php if($userRights['website']['Folder']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['website']['Folder']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['website']['Folder']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

<?php endif; ?>

<!-- -------------------- MODULE user -------------------- -->

<?php if($userRights['user']): ?>
	<?php if($userRights['user']['Rootfolder']): ?>
	<div class='contextMenu' id='user_rootfolder'>
	<ul>
			<?php if($userRights['user']['Rootfolder']['createFolder']): ?>
				<li id='createFolder'><img src='/images/icons/folder.png'/>Create Folder</li>
			<?php endif; ?>
			<?php if($userRights['user']['Rootfolder']['createUser']): ?>
				<li id='createUser'><img src='/images/icons/user.png'/>Create User</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['user']['Folder']): ?>
	<div class='contextMenu' id='user_folder'>
	<ul>
			<?php if($userRights['user']['Folder']['createFolder']): ?>
				<li id='createFolder'><img src='/images/icons/folder.png'/>Create Folder</li>
			<?php endif; ?>
			<?php if($userRights['user']['Folder']['createUser']): ?>
				<li id='createUser'><img src='/images/icons/user.png'/>Create User</li>
			<?php endif; ?>
			<?php if($userRights['user']['Folder']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['user']['Folder']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['user']['Folder']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['user']['User']): ?>
	<div class='contextMenu' id='user_user'>
	<ul>
			<?php if($userRights['user']['User']['createWishList']): ?>
				<li id='createWishList'><img src='/images/icons/wishlist.png'/>Create WishList</li>
			<?php endif; ?>
			<?php if($userRights['user']['User']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['user']['User']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['user']['User']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['user']['WishList']): ?>
	<div class='contextMenu' id='user_wishlist'>
	<ul>
			<?php if($userRights['user']['WishList']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['user']['WishList']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['user']['WishList']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

<?php endif; ?>

<!-- -------------------- MODULE lists -------------------- -->

<?php if($userRights['lists']): ?>
	<?php if($userRights['lists']['Rootfolder']): ?>
	<div class='contextMenu' id='lists_rootfolder'>
	<ul>
			<?php if($userRights['lists']['Rootfolder']['createLists']): ?>
				<li id='createLists'><img src='/images/icons/lists.png'/>Create Lists</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['lists']['Lists']): ?>
	<div class='contextMenu' id='lists_lists'>
	<ul>
			<?php if($userRights['lists']['Lists']['createListitem']): ?>
				<li id='createListitem'><img src='/images/icons/listitem.png'/>Create Listitem</li>
			<?php endif; ?>
			<?php if($userRights['lists']['Lists']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['lists']['Lists']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['lists']['Lists']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['lists']['Listitem']): ?>
	<div class='contextMenu' id='lists_listitem'>
	<ul>
			<?php if($userRights['lists']['Listitem']['createListitemI18n']): ?>
				<li id='createListitemI18n'><img src='/images/icons/listitemi18n.png'/>Create Listitem (Language version)</li>
			<?php endif; ?>
			<?php if($userRights['lists']['Listitem']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['lists']['Listitem']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['lists']['Listitem']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['lists']['ListitemI18n']): ?>
	<div class='contextMenu' id='lists_listitemi18n'>
	<ul>
			<?php if($userRights['lists']['ListitemI18n']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['lists']['ListitemI18n']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['lists']['ListitemI18n']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

<?php endif; ?>

<!-- -------------------- MODULE tag -------------------- -->

<?php if($userRights['tag']): ?>
	<?php if($userRights['tag']['Rootfolder']): ?>
	<div class='contextMenu' id='tag_rootfolder'>
	<ul>
			<?php if($userRights['tag']['Rootfolder']['createFolder']): ?>
				<li id='createFolder'><img src='/images/icons/folder.png'/>Create Folder</li>
			<?php endif; ?>
			<?php if($userRights['tag']['Rootfolder']['createTag']): ?>
				<li id='createTag'><img src='/images/icons/tag.png'/>Create Tag</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['tag']['Folder']): ?>
	<div class='contextMenu' id='tag_folder'>
	<ul>
			<?php if($userRights['tag']['Folder']['createFolder']): ?>
				<li id='createFolder'><img src='/images/icons/folder.png'/>Create Folder</li>
			<?php endif; ?>
			<?php if($userRights['tag']['Folder']['createTag']): ?>
				<li id='createTag'><img src='/images/icons/tag.png'/>Create Tag</li>
			<?php endif; ?>
			<?php if($userRights['tag']['Folder']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['tag']['Folder']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['tag']['Folder']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['tag']['Tag']): ?>
	<div class='contextMenu' id='tag_tag'>
	<ul>
			<?php if($userRights['tag']['Tag']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['tag']['Tag']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['tag']['Tag']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['tag']['User']): ?>
	<div class='contextMenu' id='tag_user'>
	<ul>
			<?php if($userRights['tag']['User']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['tag']['User']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['tag']['User']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

<?php endif; ?>

<!-- -------------------- MODULE news -------------------- -->

<?php if($userRights['news']): ?>
	<?php if($userRights['news']['Rootfolder']): ?>
	<div class='contextMenu' id='news_rootfolder'>
	<ul>
			<?php if($userRights['news']['Rootfolder']['createFolder']): ?>
				<li id='createFolder'><img src='/images/icons/folder.png'/>Create Folder</li>
			<?php endif; ?>
			<?php if($userRights['news']['Rootfolder']['createNews']): ?>
				<li id='createNews'><img src='/images/icons/news.png'/>Create News</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['news']['Folder']): ?>
	<div class='contextMenu' id='news_folder'>
	<ul>
			<?php if($userRights['news']['Folder']['createFolder']): ?>
				<li id='createFolder'><img src='/images/icons/folder.png'/>Create Folder</li>
			<?php endif; ?>
			<?php if($userRights['news']['Folder']['createNews']): ?>
				<li id='createNews'><img src='/images/icons/news.png'/>Create News</li>
			<?php endif; ?>
			<?php if($userRights['news']['Folder']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['news']['Folder']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['news']['Folder']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['news']['News']): ?>
	<div class='contextMenu' id='news_news'>
	<ul>
			<?php if($userRights['news']['News']['createNewsI18n']): ?>
				<li id='createNewsI18n'><img src='/images/icons/newsi18n.png'/>Create News (Language version)</li>
			<?php endif; ?>
			<?php if($userRights['news']['News']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['news']['News']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['news']['News']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

<?php endif; ?>

<!-- -------------------- MODULE newsletter -------------------- -->

<?php if($userRights['newsletter']): ?>
	<?php if($userRights['newsletter']['Rootfolder']): ?>
	<div class='contextMenu' id='newsletter_rootfolder'>
	<ul>
			<?php if($userRights['newsletter']['Rootfolder']['createNewsletter']): ?>
				<li id='createNewsletter'><img src='/images/icons/newsletter.png'/>Create Newsletter</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Rootfolder']['createFolder']): ?>
				<li id='createFolder'><img src='/images/icons/folder.png'/>Create Folder</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['newsletter']['Folder']): ?>
	<div class='contextMenu' id='newsletter_folder'>
	<ul>
			<?php if($userRights['newsletter']['Folder']['createMailinglist']): ?>
				<li id='createMailinglist'><img src='/images/icons/mailinglist.png'/>Create Mailinglist</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Folder']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Folder']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Folder']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['newsletter']['Mailinglist']): ?>
	<div class='contextMenu' id='newsletter_mailinglist'>
	<ul>
			<?php if($userRights['newsletter']['Mailinglist']['createSubscriber']): ?>
				<li id='createSubscriber'><img src='/images/icons/subscriber.png'/>Create Subscriber</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Mailinglist']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Mailinglist']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Mailinglist']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['newsletter']['Newsletter']): ?>
	<div class='contextMenu' id='newsletter_newsletter'>
	<ul>
			<?php if($userRights['newsletter']['Newsletter']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Newsletter']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Newsletter']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['newsletter']['Subscriber']): ?>
	<div class='contextMenu' id='newsletter_subscriber'>
	<ul>
			<?php if($userRights['newsletter']['Subscriber']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Subscriber']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['newsletter']['Subscriber']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

<?php endif; ?>

<!-- -------------------- MODULE keywords -------------------- -->

<?php if($userRights['keywords']): ?>
	<?php if($userRights['keywords']['Rootfolder']): ?>
	<div class='contextMenu' id='keywords_rootfolder'>
	<ul>
			<?php if($userRights['keywords']['Rootfolder']['createKeyword']): ?>
				<li id='createKeyword'><img src='/images/icons/keyword.png'/>Create Keyword</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['keywords']['Keyword']): ?>
	<div class='contextMenu' id='keywords_keyword'>
	<ul>
			<?php if($userRights['keywords']['Keyword']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['keywords']['Keyword']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['keywords']['Keyword']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

<?php endif; ?>

<!-- -------------------- MODULE media -------------------- -->

<?php if($userRights['media']): ?>
	<?php if($userRights['media']['Rootfolder']): ?>
	<div class='contextMenu' id='media_rootfolder'>
	<ul>
			<?php if($userRights['media']['Rootfolder']['createFolder']): ?>
				<li id='createFolder'><img src='/images/icons/folder.png'/>Create Folder</li>
			<?php endif; ?>
			<?php if($userRights['media']['Rootfolder']['createMedia']): ?>
				<li id='createMedia'><img src='/images/icons/media.png'/>Create Media</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['media']['Folder']): ?>
	<div class='contextMenu' id='media_folder'>
	<ul>
			<?php if($userRights['media']['Folder']['createFolder']): ?>
				<li id='createFolder'><img src='/images/icons/folder.png'/>Create Folder</li>
			<?php endif; ?>
			<?php if($userRights['media']['Folder']['createMedia']): ?>
				<li id='createMedia'><img src='/images/icons/media.png'/>Create Media</li>
			<?php endif; ?>
			<?php if($userRights['media']['Folder']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['media']['Folder']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['media']['Folder']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['media']['Media']): ?>
	<div class='contextMenu' id='media_media'>
	<ul>
			<?php if($userRights['media']['Media']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['media']['Media']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['media']['Media']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

<?php endif; ?>

<!-- -------------------- MODULE products -------------------- -->

<?php if($userRights['products']): ?>
	<?php if($userRights['products']['Rootfolder']): ?>
	<div class='contextMenu' id='products_rootfolder'>
	<ul>
			<?php if($userRights['products']['Rootfolder']['createCategory']): ?>
				<li id='createCategory'><img src='/images/icons/category.png'/>Create Category</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['products']['Category']): ?>
	<div class='contextMenu' id='products_category'>
	<ul>
			<?php if($userRights['products']['Category']['createProduct']): ?>
				<li id='createProduct'><img src='/images/icons/product.png'/>Create Product</li>
			<?php endif; ?>
			<?php if($userRights['products']['Category']['createCategoryI18n']): ?>
				<li id='createCategoryI18n'><img src='/images/icons/categoryi18n.png'/>Create Category (Language version)</li>
			<?php endif; ?>
			<?php if($userRights['products']['Category']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['products']['Category']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['products']['Category']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if($userRights['products']['Product']): ?>
	<div class='contextMenu' id='products_product'>
	<ul>
			<?php if($userRights['products']['Product']['createProductI18n']): ?>
				<li id='createProductI18n'><img src='/images/icons/producti18n.png'/>Create Product (Language version)</li>
			<?php endif; ?>
			<?php if($userRights['products']['Product']['delete']): ?>
				<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>
			<?php endif; ?>
			<?php if($userRights['products']['Product']['edit']): ?>
				<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>
			<?php endif; ?>
			<?php if($userRights['products']['Product']['order']): ?>
				<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>
				<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php endif; ?>

<?php endif; ?>
