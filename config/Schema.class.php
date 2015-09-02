<?php
 class Schema
{

	public static function getDocumentTrees()
	{
		return array('');
	}

	public static function getDocumentProperties()
	{
		return array('Id', 'DocumentModel', 'DocumentAuthor', 'CreatedAt', 'UpdatedAt');
	}

	public static function getRelationTrees()
	{
		return array('');
	}

	public static function getRelationProperties()
	{
		return array('Id1', 'Id2', 'DocumentModel1', 'DocumentModel2', 'SortOrder');
	}

	public static function getTagTrees()
	{
		return array('admin');
	}

	public static function getTagProperties()
	{
		return array('Id', 'Label', 'TagId', 'Module', 'DocumentModel', 'Exclusive');
	}

	public static function getTagrelationTrees()
	{
		return array('');
	}

	public static function getTagrelationProperties()
	{
		return array('Id', 'TagId');
	}

	public static function getRootfolderTrees()
	{
		return array('');
	}

	public static function getRootfolderProperties()
	{
		return array('Id', 'Label');
	}

	public static function getFolderTrees()
	{
		return array('admin', 'user', 'media', 'news');
	}

	public static function getFolderProperties()
	{
		return array('Id', 'Label', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getWebsiteTrees()
	{
		return array('website');
	}

	public static function getWebsiteProperties()
	{
		return array('Id', 'Label', 'Url', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getMenuTrees()
	{
		return array('website');
	}

	public static function getMenuProperties()
	{
		return array('Id', 'Label', 'PublicationStatus');
	}

	public static function getTopicTrees()
	{
		return array('website');
	}

	public static function getTopicProperties()
	{
		return array('Id', 'Label', 'NavigationTitle', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getPageTrees()
	{
		return array('website');
	}

	public static function getPageProperties()
	{
		return array('Id', 'Label', 'PageType', 'NavigationTitle', 'MetaDescription', 'MetaKeywords', 'Image', 'Template', 'Content', 'PageId', 'Url', 'Description', 'IsSecure', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getUrlrewriteTrees()
	{
		return array('');
	}

	public static function getUrlrewriteProperties()
	{
		return array('Label', 'Id', 'PageId');
	}

	public static function getKeywordTrees()
	{
		return array('');
	}

	public static function getKeywordProperties()
	{
		return array('Id', 'Label', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getListsTrees()
	{
		return array('lists');
	}

	public static function getListsProperties()
	{
		return array('Id', 'Label', 'ListId', 'ListType', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getListitemTrees()
	{
		return array('');
	}

	public static function getListitemProperties()
	{
		return array('Id', 'Label', 'Value', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getMediaTrees()
	{
		return array('media');
	}

	public static function getMediaProperties()
	{
		return array('Id', 'Label', 'Description', 'Filename', 'Filedirpath', 'Filetype', 'Filesize', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getNewsTrees()
	{
		return array('news');
	}

	public static function getNewsProperties()
	{
		return array('Id', 'Label', 'ShortDescription', 'Image', 'Download', 'Content', 'StartDate', 'EndDate', 'Rds', 'Keywords', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getNewsletterTrees()
	{
		return array('newsletter');
	}

	public static function getNewsletterProperties()
	{
		return array('Id', 'Label', 'Content', 'Period', 'Email', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getMailinglistTrees()
	{
		return array('newsletter');
	}

	public static function getMailinglistProperties()
	{
		return array('Id', 'Label', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getSubscriberTrees()
	{
		return array('newsletter');
	}

	public static function getSubscriberProperties()
	{
		return array('Id', 'Label', 'Email', 'Code', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getUserTrees()
	{
		return array('user');
	}

	public static function getUserProperties()
	{
		return array('Id', 'Label', 'Login', 'Backend', 'Type', 'Sha1Password', 'Salt', 'FirstName', 'LastName', 'Email', 'Phone', 'City', 'Address', 'Zip', 'State', 'Address2', 'MobilePhone', 'WorkPhone', 'ContactName', 'ContactNumber', 'ActivationCode', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getSliderTrees()
	{
		return array('slider');
	}

	public static function getSliderProperties()
	{
		return array('Id', 'Label', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getSlideTrees()
	{
		return array('slider');
	}

	public static function getSlideProperties()
	{
		return array('Id', 'Label', 'Image', 'Description', 'Link', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getCategoryTrees()
	{
		return array('products');
	}

	public static function getCategoryProperties()
	{
		return array('Id', 'Label', 'Icon', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getProductTrees()
	{
		return array('products');
	}

	public static function getProductProperties()
	{
		return array('Id', 'Label', 'Image', 'ShortDescription', 'Description', 'Price', 'Currency', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getGalleryTrees()
	{
		return array('galleries');
	}

	public static function getGalleryProperties()
	{
		return array('Id', 'Label', 'Image', 'Description', 'Rds', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getImportTrees()
	{
		return array('trademarks');
	}

	public static function getImportProperties()
	{
		return array('Id', 'Label', 'System', 'Size', 'User', 'Status', 'UploadedAt', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getImportSessionTrees()
	{
		return array('trademarks');
	}

	public static function getImportSessionProperties()
	{
		return array('Id', 'Label', 'ImportId', 'StartId', 'TmCount', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getClientTrees()
	{
		return array('clients');
	}

	public static function getClientProperties()
	{
		return array('Id', 'Label', 'Address', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getBrandTrees()
	{
		return array('search');
	}

	public static function getBrandProperties()
	{
		return array('Id', 'Label', 'ClientId', 'ApplicationNumber', 'ApplicationDate', 'Status', 'RegisterNumber', 'RegistrationDate', 'Kind', 'ExpiresOn', 'ViennaClasses', 'Colors', 'NiceClasses', 'RightsOwner', 'RightsOwnerId', 'RightsOwnerAddress', 'RightsRepresentative', 'RightsRepresentativeId', 'RightsRepresentativeAddress', 'OfficeOfOrigin', 'DesignatedContractingParty', 'Image', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getTrademarkTrees()
	{
		return array('trademarks');
	}

	public static function getTrademarkProperties()
	{
		return array('Id', 'Label', 'ApplicationNumber', 'RegisterNumber', 'RegistrationDate', 'FromSystem', 'Kind', 'ApplicationDate', 'Status', 'ExpiresOn', 'Publications', 'ViennaClasses', 'Colors', 'NiceClasses', 'RightsOwner', 'RightsOwnerId', 'RightsOwnerAddress', 'RightsRepresentative', 'RightsRepresentativeId', 'RightsRepresentativeAddress', 'OfficeOfOrigin', 'DesignatedContractingParty', 'Image', 'Contestation', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getSearchTrees()
	{
		return array('search');
	}

	public static function getSearchProperties()
	{
		return array('Id', 'Label', 'ApplicationNumber', 'RegisterNumber', 'RegistrationDate', 'ApplicationDate', 'ExpiresOn', 'ViennaClasses', 'NiceClasses', 'RightsOwner', 'RightsRepresentative', 'OfficeOfOrigin', 'DesignatedContractingParty', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}

	public static function getSearchMatchTrees()
	{
		return array('search');
	}

	public static function getSearchMatchProperties()
	{
		return array('Id', 'Label', 'ImportSession', 'Search', 'Trademark', 'Matches', 'CreatedAt', 'UpdatedAt', 'PublicationStatus');
	}


}