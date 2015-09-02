<?php

function InitData($project_name)
{
	$listPageType = 'list_types';
	$c = new Criteria();
	$c->add(ListsPeer::LIST_ID, $listPageType);
	$listExist = ListsPeer::doSelectOne($c);

	if (!$listExist)
	{
		echo "Creating list 'list_type'...\n";
		$newList = new Lists();
		$newList->setLabel('List Types');
		$newList->setListid($listPageType);
		$newList->setListtype('system');
		$newList->save();

		$newItem = new Listitem();
		$newItem->setLabel('System list');
		$newItem->setValue('system');
		$newItem->save(null, $newList);

		$newItem = new Listitem();
		$newItem->setLabel('Static list');
		$newItem->setValue('static');
		$newItem->save(null, $newList);

		$newItem = new Listitem();
		$newItem->setLabel('Editable list');
		$newItem->setValue('editable');
		$newItem->save(null, $newList);
	}

	$listPageType = 'page_types';
	$c = new Criteria();
	$c->add(ListsPeer::LIST_ID, $listPageType);
	$listExist = ListsPeer::doSelectOne($c);

	if (!$listExist)
	{
		echo "Creating list 'page_types'...\n";
		$newList = new Lists();
		$newList->setLabel('Page Types');
		$newList->setListid($listPageType);
		$newList->setListtype('system');
		$newList->save();

		$newItem = new Listitem();
		$newItem->setLabel('Content page');
		$newItem->setValue('CONTENT');
		$newItem->save(null, $newList);

		$newItem = new Listitem();
		$newItem->setLabel('Page reference');
		$newItem->setValue('REFERENCE');
		$newItem->save(null, $newList);

		$newItem = new Listitem();
		$newItem->setLabel('External page');
		$newItem->setValue('EXTERNAL');
		$newItem->save(null, $newList);
	}

	$cultureType = 'culture';
	$c = new Criteria();
	$c->add(ListsPeer::LIST_ID, $cultureType);
	$listExist = ListsPeer::doSelectOne($c);

	if (!$listExist)
	{
		echo "Creating list 'culture'...\n";
		$newList = new Lists();
		$newList->setLabel('Culture');
		$newList->setListid($cultureType);
		$newList->setListtype('system');
		$newList->save();

		$newItem = new Listitem();
		$newItem->setLabel('english');
		$newItem->setValue('en');
		$newItem->save(null, $newList);

/*		$newItem = new Listitem();
		$newItem->setLabel('български');
		$newItem->setValue('bg');
		$newItem->save(null, $newList);*/
	}

	$userType = 'usertype';
	$c = new Criteria();
	$c->add(ListsPeer::LIST_ID, $userType);
	$listExist = ListsPeer::doSelectOne($c);

	if (!$listExist)
	{
		echo "Creating list 'user types'...\n";
		$newList = new Lists();
		$newList->setLabel('User Types');
		$newList->setListid($userType);
		$newList->setListtype('system');
		$newList->save();

		$newItem = new Listitem();
		$newItem->setLabel('Administrator (all rights)');
		$newItem->setValue('admin');
		$newItem->save(null, $newList);

		$newItem = new Listitem();
		$newItem->setLabel('Editor (no access to administration modules)');
		$newItem->setValue('editor');
		$newItem->save(null, $newList);

		$newItem = new Listitem();
		$newItem->setLabel('Editor (edit and save existing items)');
		$newItem->setValue('restricted_editor');
		$newItem->save(null, $newList);
	}

	$Mailinglist_Folder = Document::getDocumentByExclusiveTag('newsletter_folder_mailinglist');
	if (!$Mailinglist_Folder)
	{
		$Newsletter_Root = Rootfolder::getRootfolderByModule('Newsletter');
		$Mailinglist_Folder = new Folder();
		$Mailinglist_Folder->setLabel('Mailing lists');
		$Mailinglist_Folder->save(null, $Newsletter_Root);
		Document::addTag($Mailinglist_Folder, 'newsletter_folder_mailinglist');
	}

	$def_site = Document::getDocumentByExclusiveTag('website_website_default');
	if (!$def_site)
	{
		$website_root = Rootfolder::getRootfolderByModule('Website');
		$def_site = new Website();
		$def_site->setLabel(UtilsHelper::mb_ucfirst($project_name));
		$def_site->save(null, $website_root);
		Document::addTag($def_site, 'website_website_default');
	}
	
	$homePage = Document::getDocumentByExclusiveTag('website_page_home');
	if (!$homePage)
	{
		$homePage = new Page();
		$homePage->setLabel('Home');
		$homePage->setPageType('CONTENT');
		$homePage->setNavigationTitle('Home');
		$homePage->setTemplate('default');
		$homePage->save(null, $def_site);
		Document::addTag($homePage, 'website_page_home');
	}
}

?>