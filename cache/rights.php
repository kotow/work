<?php

	$allRights = array();

	/*------------- admin user rights ----------------*/

	$allRights['admin']['tag']['Rootfolder']['createFolder'] = true;
	$allRights['admin']['tag']['Rootfolder']['createTag'] = true;
	$allRights['admin']['tag']['Rootfolder']['delete'] = true;
	$allRights['admin']['tag']['Rootfolder']['edit'] = true;
	$allRights['admin']['tag']['Rootfolder']['order'] = true;
	$allRights['admin']['tag']['Folder']['createFolder'] = true;
	$allRights['admin']['tag']['Folder']['createTag'] = true;
	$allRights['admin']['tag']['Folder']['delete'] = true;
	$allRights['admin']['tag']['Folder']['edit'] = true;
	$allRights['admin']['tag']['Folder']['order'] = true;
	$allRights['admin']['tag']['Tag'][''] = true;
	$allRights['admin']['tag']['Tag']['delete'] = true;
	$allRights['admin']['tag']['Tag']['edit'] = true;
	$allRights['admin']['tag']['Tag']['order'] = true;
	$allRights['admin']['lists']['Rootfolder']['createLists'] = true;
	$allRights['admin']['lists']['Rootfolder']['delete'] = true;
	$allRights['admin']['lists']['Rootfolder']['edit'] = true;
	$allRights['admin']['lists']['Rootfolder']['order'] = true;
	$allRights['admin']['lists']['Lists']['createListitem'] = true;
	$allRights['admin']['lists']['Lists']['delete'] = true;
	$allRights['admin']['lists']['Lists']['edit'] = true;
	$allRights['admin']['lists']['Lists']['order'] = true;
	$allRights['admin']['lists']['Listitem']['createListitemI18n'] = true;
	$allRights['admin']['lists']['Listitem']['delete'] = true;
	$allRights['admin']['lists']['Listitem']['edit'] = true;
	$allRights['admin']['lists']['Listitem']['order'] = true;
	$allRights['admin']['user']['Rootfolder']['createFolder'] = true;
	$allRights['admin']['user']['Rootfolder']['createUser'] = true;
	$allRights['admin']['user']['Rootfolder']['delete'] = true;
	$allRights['admin']['user']['Rootfolder']['edit'] = true;
	$allRights['admin']['user']['Rootfolder']['order'] = true;
	$allRights['admin']['user']['Folder']['createFolder'] = true;
	$allRights['admin']['user']['Folder']['createUser'] = true;
	$allRights['admin']['user']['Folder']['delete'] = true;
	$allRights['admin']['user']['Folder']['edit'] = true;
	$allRights['admin']['user']['Folder']['order'] = true;
	$allRights['admin']['user']['User'][''] = true;
	$allRights['admin']['user']['User']['delete'] = true;
	$allRights['admin']['user']['User']['edit'] = true;
	$allRights['admin']['user']['User']['order'] = true;
	$allRights['admin']['media']['Rootfolder']['createFolder'] = true;
	$allRights['admin']['media']['Rootfolder']['createMedia'] = true;
	$allRights['admin']['media']['Rootfolder']['delete'] = true;
	$allRights['admin']['media']['Rootfolder']['edit'] = true;
	$allRights['admin']['media']['Rootfolder']['order'] = true;
	$allRights['admin']['media']['Folder']['createFolder'] = true;
	$allRights['admin']['media']['Folder']['createMedia'] = true;
	$allRights['admin']['media']['Folder']['delete'] = true;
	$allRights['admin']['media']['Folder']['edit'] = true;
	$allRights['admin']['media']['Folder']['order'] = true;
	$allRights['admin']['media']['Media'][''] = true;
	$allRights['admin']['media']['Media']['delete'] = true;
	$allRights['admin']['media']['Media']['edit'] = true;
	$allRights['admin']['media']['Media']['order'] = true;
	$allRights['admin']['news']['Rootfolder']['createFolder'] = true;
	$allRights['admin']['news']['Rootfolder']['createNews'] = true;
	$allRights['admin']['news']['Rootfolder']['delete'] = true;
	$allRights['admin']['news']['Rootfolder']['edit'] = true;
	$allRights['admin']['news']['Rootfolder']['order'] = true;
	$allRights['admin']['news']['Folder']['createFolder'] = true;
	$allRights['admin']['news']['Folder']['createNews'] = true;
	$allRights['admin']['news']['Folder']['delete'] = true;
	$allRights['admin']['news']['Folder']['edit'] = true;
	$allRights['admin']['news']['Folder']['order'] = true;
	$allRights['admin']['news']['News']['createNewsI18n'] = true;
	$allRights['admin']['news']['News']['delete'] = true;
	$allRights['admin']['news']['News']['edit'] = true;
	$allRights['admin']['news']['News']['order'] = true;
	$allRights['admin']['news']['NewsI18n'][''] = true;
	$allRights['admin']['news']['NewsI18n']['delete'] = true;
	$allRights['admin']['news']['NewsI18n']['edit'] = true;
	$allRights['admin']['news']['NewsI18n']['order'] = true;
	$allRights['admin']['products']['Rootfolder']['createCategory'] = true;
	$allRights['admin']['products']['Rootfolder']['delete'] = true;
	$allRights['admin']['products']['Rootfolder']['edit'] = true;
	$allRights['admin']['products']['Rootfolder']['order'] = true;
	$allRights['admin']['products']['Category']['createProduct'] = true;
	$allRights['admin']['products']['Category']['createCategoryI18n'] = true;
	$allRights['admin']['products']['Category']['delete'] = true;
	$allRights['admin']['products']['Category']['edit'] = true;
	$allRights['admin']['products']['Category']['order'] = true;
	$allRights['admin']['products']['Product']['createProductI18n'] = true;
	$allRights['admin']['products']['Product']['delete'] = true;
	$allRights['admin']['products']['Product']['edit'] = true;
	$allRights['admin']['products']['Product']['order'] = true;
	$allRights['admin']['products']['ProductI18n'][''] = true;
	$allRights['admin']['products']['ProductI18n']['delete'] = true;
	$allRights['admin']['products']['ProductI18n']['edit'] = true;
	$allRights['admin']['products']['ProductI18n']['order'] = true;
	$allRights['admin']['services']['Rootfolder']['createServiceCategory'] = true;
	$allRights['admin']['services']['Rootfolder']['delete'] = true;
	$allRights['admin']['services']['Rootfolder']['edit'] = true;
	$allRights['admin']['services']['Rootfolder']['order'] = true;
	$allRights['admin']['services']['ServiceCategory']['createService'] = true;
	$allRights['admin']['services']['ServiceCategory']['delete'] = true;
	$allRights['admin']['services']['ServiceCategory']['edit'] = true;
	$allRights['admin']['services']['ServiceCategory']['order'] = true;
	$allRights['admin']['services']['Service'][''] = true;
	$allRights['admin']['services']['Service']['delete'] = true;
	$allRights['admin']['services']['Service']['edit'] = true;
	$allRights['admin']['services']['Service']['order'] = true;
	$allRights['admin']['newsletter']['Rootfolder']['createNewsletter'] = true;
	$allRights['admin']['newsletter']['Rootfolder']['createFolder'] = true;
	$allRights['admin']['newsletter']['Rootfolder']['delete'] = true;
	$allRights['admin']['newsletter']['Rootfolder']['edit'] = true;
	$allRights['admin']['newsletter']['Rootfolder']['order'] = true;
	$allRights['admin']['newsletter']['Folder']['createMailinglist'] = true;
	$allRights['admin']['newsletter']['Folder']['delete'] = true;
	$allRights['admin']['newsletter']['Folder']['edit'] = true;
	$allRights['admin']['newsletter']['Folder']['order'] = true;
	$allRights['admin']['newsletter']['Mailinglist']['createSubscriber'] = true;
	$allRights['admin']['newsletter']['Mailinglist']['delete'] = true;
	$allRights['admin']['newsletter']['Mailinglist']['edit'] = true;
	$allRights['admin']['newsletter']['Mailinglist']['order'] = true;
	$allRights['admin']['newsletter']['Newsletter'][''] = true;
	$allRights['admin']['newsletter']['Newsletter']['delete'] = true;
	$allRights['admin']['newsletter']['Newsletter']['edit'] = true;
	$allRights['admin']['newsletter']['Newsletter']['order'] = true;
	$allRights['admin']['keywords']['Rootfolder']['createFolder'] = true;
	$allRights['admin']['keywords']['Rootfolder']['createKeyword'] = true;
	$allRights['admin']['keywords']['Rootfolder']['delete'] = true;
	$allRights['admin']['keywords']['Rootfolder']['edit'] = true;
	$allRights['admin']['keywords']['Rootfolder']['order'] = true;
	$allRights['admin']['keywords']['Folder']['createFolder'] = true;
	$allRights['admin']['keywords']['Folder']['createKeyword'] = true;
	$allRights['admin']['keywords']['Folder']['delete'] = true;
	$allRights['admin']['keywords']['Folder']['edit'] = true;
	$allRights['admin']['keywords']['Folder']['order'] = true;
	$allRights['admin']['keywords']['Keyword'][''] = true;
	$allRights['admin']['keywords']['Keyword']['delete'] = true;
	$allRights['admin']['keywords']['Keyword']['edit'] = true;
	$allRights['admin']['keywords']['Keyword']['order'] = true;
	$allRights['admin']['website']['Rootfolder']['createWebsite'] = true;
	$allRights['admin']['website']['Rootfolder']['delete'] = true;
	$allRights['admin']['website']['Rootfolder']['edit'] = true;
	$allRights['admin']['website']['Rootfolder']['order'] = true;
	$allRights['admin']['website']['Website']['createMenu'] = true;
	$allRights['admin']['website']['Website']['createTopic'] = true;
	$allRights['admin']['website']['Website']['createPage'] = true;
	$allRights['admin']['website']['Website']['delete'] = true;
	$allRights['admin']['website']['Website']['edit'] = true;
	$allRights['admin']['website']['Website']['order'] = true;
	$allRights['admin']['website']['Menu']['createTopic'] = true;
	$allRights['admin']['website']['Menu']['createPage'] = true;
	$allRights['admin']['website']['Menu']['delete'] = true;
	$allRights['admin']['website']['Menu']['edit'] = true;
	$allRights['admin']['website']['Menu']['order'] = true;
	$allRights['admin']['website']['Topic']['createTopicI18n'] = true;
	$allRights['admin']['website']['Topic']['createTopic'] = true;
	$allRights['admin']['website']['Topic']['createPage'] = true;
	$allRights['admin']['website']['Topic']['delete'] = true;
	$allRights['admin']['website']['Topic']['edit'] = true;
	$allRights['admin']['website']['Topic']['order'] = true;
	$allRights['admin']['website']['Page']['createPageI18n'] = true;
	$allRights['admin']['website']['Page']['delete'] = true;
	$allRights['admin']['website']['Page']['edit'] = true;
	$allRights['admin']['website']['Page']['order'] = true;
	$allRights['admin']['website']['PageI18n'][''] = true;
	$allRights['admin']['website']['PageI18n']['delete'] = true;
	$allRights['admin']['website']['PageI18n']['edit'] = true;
	$allRights['admin']['website']['PageI18n']['order'] = true;

	/*------------- site_admin user rights ----------------*/

	$allRights['site_admin']['lists']['Rootfolder']['createLists'] = true;
	$allRights['site_admin']['lists']['Rootfolder']['delete'] = true;
	$allRights['site_admin']['lists']['Rootfolder']['edit'] = true;
	$allRights['site_admin']['lists']['Rootfolder']['order'] = true;
	$allRights['site_admin']['lists']['Lists']['createListitem'] = true;
	$allRights['site_admin']['lists']['Lists']['delete'] = true;
	$allRights['site_admin']['lists']['Lists']['edit'] = true;
	$allRights['site_admin']['lists']['Lists']['order'] = true;
	$allRights['site_admin']['lists']['Listitem']['createListitemI18n'] = true;
	$allRights['site_admin']['lists']['Listitem']['delete'] = true;
	$allRights['site_admin']['lists']['Listitem']['edit'] = true;
	$allRights['site_admin']['lists']['Listitem']['order'] = true;
	$allRights['site_admin']['user']['Rootfolder']['createFolder'] = true;
	$allRights['site_admin']['user']['Rootfolder']['createUser'] = true;
	$allRights['site_admin']['user']['Rootfolder']['delete'] = true;
	$allRights['site_admin']['user']['Rootfolder']['edit'] = true;
	$allRights['site_admin']['user']['Rootfolder']['order'] = true;
	$allRights['site_admin']['user']['Folder']['createFolder'] = true;
	$allRights['site_admin']['user']['Folder']['createUser'] = true;
	$allRights['site_admin']['user']['Folder']['delete'] = true;
	$allRights['site_admin']['user']['Folder']['edit'] = true;
	$allRights['site_admin']['user']['Folder']['order'] = true;
	$allRights['site_admin']['user']['User'][''] = true;
	$allRights['site_admin']['user']['User']['delete'] = true;
	$allRights['site_admin']['user']['User']['edit'] = true;
	$allRights['site_admin']['user']['User']['order'] = true;
	$allRights['site_admin']['media']['Rootfolder']['createFolder'] = true;
	$allRights['site_admin']['media']['Rootfolder']['createMedia'] = true;
	$allRights['site_admin']['media']['Rootfolder']['delete'] = true;
	$allRights['site_admin']['media']['Rootfolder']['edit'] = true;
	$allRights['site_admin']['media']['Rootfolder']['order'] = true;
	$allRights['site_admin']['media']['Folder']['createFolder'] = true;
	$allRights['site_admin']['media']['Folder']['createMedia'] = true;
	$allRights['site_admin']['media']['Folder']['delete'] = true;
	$allRights['site_admin']['media']['Folder']['edit'] = true;
	$allRights['site_admin']['media']['Folder']['order'] = true;
	$allRights['site_admin']['media']['Media'][''] = true;
	$allRights['site_admin']['media']['Media']['delete'] = true;
	$allRights['site_admin']['media']['Media']['edit'] = true;
	$allRights['site_admin']['media']['Media']['order'] = true;
	$allRights['site_admin']['news']['Rootfolder']['createFolder'] = true;
	$allRights['site_admin']['news']['Rootfolder']['createNews'] = true;
	$allRights['site_admin']['news']['Rootfolder']['delete'] = true;
	$allRights['site_admin']['news']['Rootfolder']['edit'] = true;
	$allRights['site_admin']['news']['Rootfolder']['order'] = true;
	$allRights['site_admin']['news']['Folder']['createFolder'] = true;
	$allRights['site_admin']['news']['Folder']['createNews'] = true;
	$allRights['site_admin']['news']['Folder']['delete'] = true;
	$allRights['site_admin']['news']['Folder']['edit'] = true;
	$allRights['site_admin']['news']['Folder']['order'] = true;
	$allRights['site_admin']['news']['News']['createNewsI18n'] = true;
	$allRights['site_admin']['news']['News']['delete'] = true;
	$allRights['site_admin']['news']['News']['edit'] = true;
	$allRights['site_admin']['news']['News']['order'] = true;
	$allRights['site_admin']['news']['NewsI18n'][''] = true;
	$allRights['site_admin']['news']['NewsI18n']['delete'] = true;
	$allRights['site_admin']['news']['NewsI18n']['edit'] = true;
	$allRights['site_admin']['news']['NewsI18n']['order'] = true;
	$allRights['site_admin']['products']['Rootfolder']['createCategory'] = true;
	$allRights['site_admin']['products']['Rootfolder']['delete'] = true;
	$allRights['site_admin']['products']['Rootfolder']['edit'] = true;
	$allRights['site_admin']['products']['Rootfolder']['order'] = true;
	$allRights['site_admin']['products']['Category']['createProduct'] = true;
	$allRights['site_admin']['products']['Category']['createCategoryI18n'] = true;
	$allRights['site_admin']['products']['Category']['delete'] = true;
	$allRights['site_admin']['products']['Category']['edit'] = true;
	$allRights['site_admin']['products']['Category']['order'] = true;
	$allRights['site_admin']['products']['Product']['createProductI18n'] = true;
	$allRights['site_admin']['products']['Product']['delete'] = true;
	$allRights['site_admin']['products']['Product']['edit'] = true;
	$allRights['site_admin']['products']['Product']['order'] = true;
	$allRights['site_admin']['products']['ProductI18n'][''] = true;
	$allRights['site_admin']['products']['ProductI18n']['delete'] = true;
	$allRights['site_admin']['products']['ProductI18n']['edit'] = true;
	$allRights['site_admin']['products']['ProductI18n']['order'] = true;
	$allRights['site_admin']['newsletter']['Rootfolder']['createNewsletter'] = true;
	$allRights['site_admin']['newsletter']['Rootfolder']['createFolder'] = true;
	$allRights['site_admin']['newsletter']['Rootfolder']['delete'] = true;
	$allRights['site_admin']['newsletter']['Rootfolder']['edit'] = true;
	$allRights['site_admin']['newsletter']['Rootfolder']['order'] = true;
	$allRights['site_admin']['newsletter']['Folder']['createMailinglist'] = true;
	$allRights['site_admin']['newsletter']['Folder']['delete'] = true;
	$allRights['site_admin']['newsletter']['Folder']['edit'] = true;
	$allRights['site_admin']['newsletter']['Folder']['order'] = true;
	$allRights['site_admin']['newsletter']['Mailinglist']['createSubscriber'] = true;
	$allRights['site_admin']['newsletter']['Mailinglist']['delete'] = true;
	$allRights['site_admin']['newsletter']['Mailinglist']['edit'] = true;
	$allRights['site_admin']['newsletter']['Mailinglist']['order'] = true;
	$allRights['site_admin']['newsletter']['Newsletter'][''] = true;
	$allRights['site_admin']['newsletter']['Newsletter']['delete'] = true;
	$allRights['site_admin']['newsletter']['Newsletter']['edit'] = true;
	$allRights['site_admin']['newsletter']['Newsletter']['order'] = true;
	$allRights['site_admin']['keywords']['Rootfolder']['createFolder'] = true;
	$allRights['site_admin']['keywords']['Rootfolder']['createKeyword'] = true;
	$allRights['site_admin']['keywords']['Rootfolder']['delete'] = true;
	$allRights['site_admin']['keywords']['Rootfolder']['edit'] = true;
	$allRights['site_admin']['keywords']['Rootfolder']['order'] = true;
	$allRights['site_admin']['keywords']['Folder']['createFolder'] = true;
	$allRights['site_admin']['keywords']['Folder']['createKeyword'] = true;
	$allRights['site_admin']['keywords']['Folder']['delete'] = true;
	$allRights['site_admin']['keywords']['Folder']['edit'] = true;
	$allRights['site_admin']['keywords']['Folder']['order'] = true;
	$allRights['site_admin']['keywords']['Keyword'][''] = true;
	$allRights['site_admin']['keywords']['Keyword']['delete'] = true;
	$allRights['site_admin']['keywords']['Keyword']['edit'] = true;
	$allRights['site_admin']['keywords']['Keyword']['order'] = true;
	$allRights['site_admin']['website']['Rootfolder']['createWebsite'] = true;
	$allRights['site_admin']['website']['Rootfolder']['delete'] = true;
	$allRights['site_admin']['website']['Rootfolder']['edit'] = true;
	$allRights['site_admin']['website']['Rootfolder']['order'] = true;
	$allRights['site_admin']['website']['Website']['createMenu'] = true;
	$allRights['site_admin']['website']['Website']['createTopic'] = true;
	$allRights['site_admin']['website']['Website']['createPage'] = true;
	$allRights['site_admin']['website']['Website']['delete'] = true;
	$allRights['site_admin']['website']['Website']['edit'] = true;
	$allRights['site_admin']['website']['Website']['order'] = true;
	$allRights['site_admin']['website']['Menu']['createTopic'] = true;
	$allRights['site_admin']['website']['Menu']['createPage'] = true;
	$allRights['site_admin']['website']['Menu']['delete'] = true;
	$allRights['site_admin']['website']['Menu']['edit'] = true;
	$allRights['site_admin']['website']['Menu']['order'] = true;
	$allRights['site_admin']['website']['Topic']['createTopicI18n'] = true;
	$allRights['site_admin']['website']['Topic']['createTopic'] = true;
	$allRights['site_admin']['website']['Topic']['createPage'] = true;
	$allRights['site_admin']['website']['Topic']['delete'] = true;
	$allRights['site_admin']['website']['Topic']['edit'] = true;
	$allRights['site_admin']['website']['Topic']['order'] = true;
	$allRights['site_admin']['website']['Page']['createPageI18n'] = true;
	$allRights['site_admin']['website']['Page']['delete'] = true;
	$allRights['site_admin']['website']['Page']['edit'] = true;
	$allRights['site_admin']['website']['Page']['order'] = true;
	$allRights['site_admin']['website']['PageI18n'][''] = true;
	$allRights['site_admin']['website']['PageI18n']['delete'] = true;
	$allRights['site_admin']['website']['PageI18n']['edit'] = true;
	$allRights['site_admin']['website']['PageI18n']['order'] = true;

?>