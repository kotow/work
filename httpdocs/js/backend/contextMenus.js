function initBindings()
{

/*------------- MODULE newsletter ----------------*/

	$('span.newsletter_rootfolder').contextMenu('newsletter_rootfolder', {
		bindings: {
			'createNewsletter': function(t) {createDocument('Newsletter', t.id);},
			'createFolder': function(t) {createDocument('Folder', t.id);}
		}
	});

	$('span.newsletter_folder').contextMenu('newsletter_folder', {
		bindings: {
			'createMailinglist': function(t) {createDocument('Mailinglist', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Folder', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.newsletter_mailinglist').contextMenu('newsletter_mailinglist', {
		bindings: {
			'createSubscriber': function(t) {createDocument('Subscriber', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Mailinglist', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.newsletter_newsletter').contextMenu('newsletter_newsletter', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Newsletter', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.newsletter_subscriber').contextMenu('newsletter_subscriber', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Subscriber', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});


/*------------- MODULE website ----------------*/

	$('span.website_rootfolder').contextMenu('website_rootfolder', {
		bindings: {
			'createWebsite': function(t) {createDocument('Website', t.id);}
		}
	});

	$('span.website_website').contextMenu('website_website', {
		bindings: {
			'createMenu': function(t) {createDocument('Menu', t.id);},
			'createTopic': function(t) {createDocument('Topic', t.id);},
			'createPage': function(t) {createDocument('Page', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Website', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.website_menu').contextMenu('website_menu', {
		bindings: {
			'createTopic': function(t) {createDocument('Topic', t.id);},
			'createPage': function(t) {createDocument('Page', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Menu', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.website_topic').contextMenu('website_topic', {
		bindings: {
			'createTopicI18n': function(t) {createDocument('TopicI18n', t.id);},
			'createTopic': function(t) {createDocument('Topic', t.id);},
			'createPage': function(t) {createDocument('Page', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Topic', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.website_page').contextMenu('website_page', {
		bindings: {
			'createPageI18n': function(t) {createDocument('PageI18n', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Page', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.website_pagei18n').contextMenu('website_pagei18n', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('PageI18n', t.id);}
		}
	});

	$('span.website_folder').contextMenu('website_folder', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Folder', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});


/*------------- MODULE tag ----------------*/

	$('span.tag_rootfolder').contextMenu('tag_rootfolder', {
		bindings: {
			'createFolder': function(t) {createDocument('Folder', t.id);},
			'createTag': function(t) {createDocument('Tag', t.id);}
		}
	});

	$('span.tag_folder').contextMenu('tag_folder', {
		bindings: {
			'createFolder': function(t) {createDocument('Folder', t.id);},
			'createTag': function(t) {createDocument('Tag', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Folder', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.tag_tag').contextMenu('tag_tag', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Tag', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.tag_user').contextMenu('tag_user', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('User', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});


/*------------- MODULE products ----------------*/

	$('span.products_rootfolder').contextMenu('products_rootfolder', {
		bindings: {
			'createCategory': function(t) {createDocument('Category', t.id);}
		}
	});

	$('span.products_category').contextMenu('products_category', {
		bindings: {
			'createProduct': function(t) {createDocument('Product', t.id);},
			'createCategoryI18n': function(t) {createDocument('CategoryI18n', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Category', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.products_product').contextMenu('products_product', {
		bindings: {
			'createProductI18n': function(t) {createDocument('ProductI18n', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Product', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});


/*------------- MODULE services ----------------*/

	$('span.services_rootfolder').contextMenu('services_rootfolder', {
		bindings: {
			'createServiceCategory': function(t) {createDocument('ServiceCategory', t.id);}
		}
	});

	$('span.services_servicecategory').contextMenu('services_servicecategory', {
		bindings: {
			'createService': function(t) {createDocument('Service', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('ServiceCategory', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.services_service').contextMenu('services_service', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Service', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});


/*------------- MODULE keywords ----------------*/

	$('span.keywords_rootfolder').contextMenu('keywords_rootfolder', {
		bindings: {
			'createKeyword': function(t) {createDocument('Keyword', t.id);}
		}
	});

	$('span.keywords_keyword').contextMenu('keywords_keyword', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Keyword', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});


/*------------- MODULE user ----------------*/

	$('span.user_rootfolder').contextMenu('user_rootfolder', {
		bindings: {
			'createFolder': function(t) {createDocument('Folder', t.id);},
			'createUser': function(t) {createDocument('User', t.id);}
		}
	});

	$('span.user_folder').contextMenu('user_folder', {
		bindings: {
			'createFolder': function(t) {createDocument('Folder', t.id);},
			'createUser': function(t) {createDocument('User', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Folder', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.user_user').contextMenu('user_user', {
		bindings: {
			'createWishList': function(t) {createDocument('WishList', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('User', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.user_wishlist').contextMenu('user_wishlist', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('WishList', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});


/*------------- MODULE media ----------------*/

	$('span.media_rootfolder').contextMenu('media_rootfolder', {
		bindings: {
			'createFolder': function(t) {createDocument('Folder', t.id);},
			'createMedia': function(t) {createDocument('Media', t.id);}
		}
	});

	$('span.media_folder').contextMenu('media_folder', {
		bindings: {
			'createFolder': function(t) {createDocument('Folder', t.id);},
			'createMedia': function(t) {createDocument('Media', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Folder', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.media_media').contextMenu('media_media', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Media', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});


/*------------- MODULE news ----------------*/

	$('span.news_rootfolder').contextMenu('news_rootfolder', {
		bindings: {
			'createFolder': function(t) {createDocument('Folder', t.id);},
			'createNews': function(t) {createDocument('News', t.id);}
		}
	});

	$('span.news_folder').contextMenu('news_folder', {
		bindings: {
			'createFolder': function(t) {createDocument('Folder', t.id);},
			'createNews': function(t) {createDocument('News', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Folder', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.news_news').contextMenu('news_news', {
		bindings: {
			'createNewsI18n': function(t) {createDocument('NewsI18n', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('News', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});


/*------------- MODULE lists ----------------*/

	$('span.lists_rootfolder').contextMenu('lists_rootfolder', {
		bindings: {
			'createLists': function(t) {createDocument('Lists', t.id);}
		}
	});

	$('span.lists_lists').contextMenu('lists_lists', {
		bindings: {
			'createListitem': function(t) {createDocument('Listitem', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Lists', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.lists_listitem').contextMenu('lists_listitem', {
		bindings: {
			'createListitemI18n': function(t) {createDocument('ListitemI18n', t.id);},
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('Listitem', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

	$('span.lists_listitemi18n').contextMenu('lists_listitemi18n', {
		bindings: {
			'deleteDocument': function(t) {deleteDocument(t.id);},
			'editDocument': function(t) {editDocument('ListitemI18n', t.id);},
			'orderDocumentUp': function(t) {orderDocument(t.id,true);},
			'orderDocumentDown': function(t) {orderDocument(t.id,false);}
		}
	});

}