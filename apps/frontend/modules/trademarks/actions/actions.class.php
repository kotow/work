<?php
/**
 * @package    cms
 * @subpackage products
 * @author     Jordan Hristov / Ilya Popivanov
 */

class trademarksActions extends sfActions
{
	
	public function executeTracked()
	{
		$this->setLayout(false);
		if ($addPage = Document::getDocumentByExclusiveTag('website_page_add_new_brand'))
		{
			$this->addTrademarkURL = $addPage->getHref();
		}
		else
		{
			$this->addTrademarkURL = '#';
		}
		if ($detailPage = Document::getDocumentByExclusiveTag('website_page_Brand_details'))
		{
			$this->detailURL = $detailPage->getHref();
		}
		else
		{
			$this->detailURL = '#';
		}

		$brands = array();
		if ($root = Rootfolder::getRootfolderByModule('search'))
		{
			$brands = Document::getChildrenOf($root->getId(), 'Brand');
		}
		$this->brands = $brands;
		
		$ownersArr = array();
		$root = Rootfolder::getRootfolderByModule('clients');
		$owners = Document::getChildrenOf($root->getId(), 'Client');
		foreach ($owners as $ow)
		{
			$ownersArr[$ow->getId()] = $ow->getLabel();
		}
		$this->ownersArr = $ownersArr;
	}

	public function executeRemoveTracked()
	{
		$obj = Document::getDocumentInstance($this->getRequestParameter('id'));
		if ($obj && get_class($obj) == 'Brand')
		{
			// delete Image object
			if ($img = Document::getDocumentInstance($obj->getImage()))
			{
				$img->delete();
			}
			$obj->delete();
			exit('OK');
		}
		exit('NO');
	}

	public function executeLoadOwnerAddress()
	{
		$obj = Document::getDocumentInstance($this->getRequestParameter('id'));
		if ($obj && get_class($obj) == 'Client')
		{
			exit($obj->getAddress());
		}
		exit('');
	}

	public function executeAddNewBrand()
	{
		$this->setLayout(false);
		$this->trademarkTypes = UtilsHelper::loadTrademarkTypes();

		if ($brand = Document::getDocumentInstance($this->getRequestParameter('brand_id')))
		{
			if (get_class($brand) != 'Brand')
			{
				$brand = null;
			}
		}
		if (!$brand)
		{
			$brand = new Brand();
		}
		
		$ownersArr = array();
		$root = Rootfolder::getRootfolderByModule('clients');
		$owners = Document::getChildrenOf($root->getId(), 'Client');
		foreach ($owners as $ow)
		{
			$ownersArr[$ow->getId()] = $ow->getLabel();
		}
		$this->ownersArr = $ownersArr;
		
		$success = false;
		if ($this->getRequestParameter('submit') > '')
		{
			// check input data
			$request = $this->getRequest();
			$params = $request->getParameterHolder()->getAll(); //var_dump($params);
			
			$errors = false;
			$fields = array(
				"label" => 'Наименование',
				"application_number" => 'Заявка номер',
				"register_number" => 'Регистров номер',
				"registration_date" => 'Дата на регистриране',
				"kind" => 'Тип',
				"application_date" => 'Дата на заявяване',
//				"status" => 'Статус', // Pending, Registered, Rejected, Deleted
				"expires_on" => 'Срок',
//				"vienna_classes" => 'Класове по Виенската класификация',
				"nice_classes" => 'Класове по Ницска класификация',
				"rights_owner" => 'Притежател',
//				"rights_owner_address" => 'Притежател адрес',
				"rights_representative" => 'Представител',
//				"rights_representative_address" => 'Представител адрес',
				"office_of_origin" => 'Държава на регистрация', // country code: BG, EN, UK, etc... only one!
				"designated_contracting_party" => 'Държави в които е в сила', // country code: BG, EN, UK, GR, RO, etc... many!
			);
			foreach ($fields as $fl => $label)
			{
				$val = trim($params[$fl]);
				if ($val == '')
				{
					if ($fl == 'rights_owner')
					{
						if ($params['owner'] == '')
						{
							$errors = true;
							$request->setError('err'.$fl, '- '.$label);
						}
					}
					else
					{
						$errors = true;
						$request->setError('err'.$fl, '- '.$label);
					}
				}
			}
			$image = null;
			if ($errors)
			{
				UtilsHelper::setFlashMsg('Моля, въведете необходимите данни:<br>', UtilsHelper::MSG_ERROR);
			}
			else
			{
				if ($request->getFileName('image'))
				{
					try
					{
						$image = Media::upload('image', 'upload', array('image/gif', 'image/jpeg', 'image/jpg', 'image/png'));
						//var_dump($image);
						list($w, $h) = getimagesize($image->getServerAbsoluteUrl());
						if ($w > $h)
						{
							$image->resizeImage("thumbs", null, 105);
						}
						else
						{
							$image->resizeImage("thumbs", 95);
						}
					}
					catch (Exception $e)
					{
						$errors = true;
						$request->setError( 'errImage', '- '.UtilsHelper::Localize('media.'.$e->getMessage()) );
					}
				}
				if ($errors)
				{
					// remove uploaded image
					if ($image)
					{
						$image->delete();
					}
					UtilsHelper::setFlashMsg('Моля, коригирайте:<br>', UtilsHelper::MSG_ERROR);
				}
			}
			// if everithing is OK
			if (!$errors)
			{
				//$brand = new Brand();
				$brand->setLabel($params['label']);
				
				if ($params['owner'] > '')
				{
					$brand->setClientId($params['owner']);
					$client = Document::getDocumentInstance($params['owner']);
					$brand->setRightsOwner($client->getLabel());
				}
				else
				{
					$val = trim($params['rights_owner']);
					$client = new Client();
					$client->setLabel($val);
					$client->save();
					$brand->setClientId($client->getId());
					$this->client = $client;
					$brand->setRightsOwner($val);
				}
				$brand->setApplicationNumber($params['application_number']);
				$brand->setRegisterNumber($params['register_number']);
				$brand->setRegistrationDate ($params['registration_date']);
				$brand->setKind($params['kind']);
				$brand->setApplicationDate($params['application_date']);
				$brand->setStatus($params['status']); 
				$brand->setExpiresOn($params['expires_on']);
				$brand->setViennaClasses(str_replace(' ', '', $params['vienna_classes']));
				$brand->setColors($params['colors']);
				$brand->setNiceClasses(str_replace(' ', '', $params['nice_classes']));
				$brand->setRightsOwnerAddress($params['rights_owner_address']);
				$brand->setRightsRepresentative($params['rights_representative']); 
				$brand->setRightsRepresentativeAddress($params['rights_representative_address']);
				$brand->setOfficeOfOrigin($params['office_of_origin']);
				$brand->setDesignatedContractingParty($params['designated_contracting_party']);
				if ($image)
				{
					$brand->setImage($image->getId());
				}
				$brand->save();
				$success = true;
			}
		}
		$this->brand = $brand;
		$this->success = $success;
	}

	public function executeDetails()
	{
		$this->setLayout(false);
		if ($editPage = Document::getDocumentByExclusiveTag('website_page_add_new_brand'))
		{
			$this->editURL = $editPage->getHref();
		}
		else
		{
			$this->editURL = '#';
		}
		$brand = Document::getDocumentInstance($this->getRequestParameter('brand_id'));
		if (get_class($brand) == 'Brand')
		{
			$this->brand = $brand;
		}
		else
		{
			$this->brand = null;
		}
	}

//	Upload Trademarks =============================================================================================

	public function executeUploadTrademarks()
	{
		$this->setLayout(false);

		if ($addPage = Document::getDocumentByExclusiveTag('website_page_add_new_trademark'))
		{
			$this->addTrademarkURL = $addPage->getHref();
		}
		else
		{
			$this->addTrademarkURL = '#';
		}

		$c = new Criteria();
		$c->addDescendingOrderByColumn(TrademarkPeer::ID);
		$cr1 = $c->getNewCriterion(TrademarkPeer::FROM_SYSTEM, 1);
		$cr2 = $c->getNewCriterion(TrademarkPeer::FROM_SYSTEM, 11);
		$cr1->addOr($cr2);
		$c->add($cr1);
		
		$importsArr[1] = TrademarkPeer::doSelect($c);
		
		$c = new Criteria();
		$c->addDescendingOrderByColumn(ImportPeer::ID);
		$c->add(ImportPeer::SYSTEM, 2);
		$importsArr[2] = ImportPeer::doSelect($c);

		$c = new Criteria();
		$c->addDescendingOrderByColumn(ImportPeer::ID);
		$c->add(ImportPeer::SYSTEM, 3);
		$importsArr[3] = ImportPeer::doSelect($c);

		$this->importsArr = $importsArr;
		$this->statusColors = array(
			'new' => '#202080',
			'imported' => '#208010',
			'error' => '#802020',
		);
		
		$this->reload = 0;
		if ($reload = $this->getRequestParameter('reload'))
		{
			$this->reload = $reload;
		}
	}

	public function executeAddNewTrademark()
	{
		$this->setLayout(false);
		$this->trademarkTypes = UtilsHelper::loadTrademarkTypes();

		if ($trademark = Document::getDocumentInstance($this->getRequestParameter('trademark_id')))
		{
			if (get_class($trademark) != 'Trademark')
			{
				$trademark = null;
			}
		}
		if (!$trademark)
		{
			$trademark = new Trademark();
		}
		
		$ownersArr = array();
		$root = Rootfolder::getRootfolderByModule('clients');
		$owners = Document::getChildrenOf($root->getId(), 'Client');
		foreach ($owners as $ow)
		{
			$ownersArr[$ow->getId()] = $ow->getLabel();
		}
		$this->ownersArr = $ownersArr;
		
		$success = false;
		if ($this->getRequestParameter('submit') > '')
		{
			// check input data
			$request = $this->getRequest();
			$params = $request->getParameterHolder()->getAll(); //var_dump($params);
			
			$errors = false;
			$fields = array(
				"label" => 'Наименование',
				"application_number" => 'Заявка номер',
				//"register_number" => 'Регистров номер',
				//"registration_date" => 'Дата на регистриране',
				"kind" => 'Тип',
				"application_date" => 'Дата на заявяване',
//				"status" => 'Статус', // Pending, Registered, Rejected, Deleted
				"expires_on" => 'Срок',
				"contestation" => 'Краен срок за опозиция',
//				"vienna_classes" => 'Класове по Виенската класификация',
				"nice_classes" => 'Класове по Ницска класификация',
				"rights_owner" => 'Притежател',
//				"rights_owner_address" => 'Притежател адрес',
//				"rights_representative" => 'Представител',
//				"rights_representative_address" => 'Представител адрес',
				"office_of_origin" => 'Държава на регистрация', // country code: BG, EN, UK, etc... only one!
				"designated_contracting_party" => 'Държави в които е в сила', // country code: BG, EN, UK, GR, RO, etc... many!
			);
			foreach ($fields as $fl => $label)
			{
				$val = trim($params[$fl]);
				if ($val == '')
				{
					if ($fl == 'rights_owner')
					{
						if ($params['owner'] == '')
						{
							$errors = true;
							$request->setError('err'.$fl, '- '.$label);
						}
					}
					else
					{
						$errors = true;
						$request->setError('err'.$fl, '- '.$label);
					}
				}
			}
			$image = null;
			if ($errors)
			{
				UtilsHelper::setFlashMsg('Моля, въведете необходимите данни:<br>', UtilsHelper::MSG_ERROR);
			}
			else
			{
				if ($request->getFileName('image'))
				{
					try
					{
						$image = Media::upload('image', 'upload', array('image/gif', 'image/jpeg', 'image/jpg', 'image/png'));
						//var_dump($image);
						list($w, $h) = getimagesize($image->getServerAbsoluteUrl());
						if ($w > $h)
						{
							$image->resizeImage("thumbs", null, 105);
						}
						else
						{
							$image->resizeImage("thumbs", 95);
						}
					}
					catch (Exception $e)
					{
						$errors = true;
						$request->setError( 'errImage', '- '.UtilsHelper::Localize('media.'.$e->getMessage()) );
					}
				}
				if ($errors)
				{
					// remove uploaded image
					if ($image)
					{
						$image->delete();
					}
					UtilsHelper::setFlashMsg('Моля, коригирайте:<br>', UtilsHelper::MSG_ERROR);
				}
			}
			// if everithing is OK
			if (!$errors)
			{
				//$trademark = new Brand();
				$trademark->setLabel($params['label']);
				$trademark->setFromSystem(1);
				
				if ($params['owner'] > '')
				{
					//$trademark->setClientId($params['owner']);
					$client = Document::getDocumentInstance($params['owner']);
					$trademark->setRightsOwner($client->getLabel());
				}
				else
				{
					$val = trim($params['rights_owner']);
					$client = new Client();
					$client->setLabel($val);
					$client->save();
					//$trademark->setClientId($client->getId());
					$this->client = $client;
					$trademark->setRightsOwner($val);
				}
				$trademark->setApplicationNumber($params['application_number']);
				$trademark->setRegisterNumber($params['register_number']);
				if($params['registration_date']) $trademark->setRegistrationDate ($params['registration_date']);
				$trademark->setKind($params['kind']);
				$trademark->setApplicationDate($params['application_date']);
				$trademark->setStatus($params['status']); 
				$trademark->setExpiresOn($params['expires_on']);
				$trademark->setContestation($params['contestation']);
				$trademark->setPublications($params['publications']);
				$trademark->setViennaClasses(str_replace(' ', '', $params['vienna_classes']));
				$trademark->setColors($params['colors']);
				$trademark->setNiceClasses(str_replace(' ', '', $params['nice_classes']));
				$trademark->setRightsOwnerAddress($params['rights_owner_address']);
				$trademark->setRightsRepresentative($params['rights_representative']); 
				$trademark->setRightsRepresentativeAddress($params['rights_representative_address']);
				$trademark->setOfficeOfOrigin($params['office_of_origin']);
				$trademark->setDesignatedContractingParty($params['designated_contracting_party']);
				if ($image)
				{
					$trademark->setImage($image->getId());
				}
				$trademark->save();
				$success = true;
			}
		}
		$this->trademark = $trademark;
		$this->success = $success;
	}

	public function executeUploadFile1()
	{
		$this->setLayout(false);
		$ds = DIRECTORY_SEPARATOR;
		$root = sfConfig::get('sf_root_dir').$ds.sfConfig::get('sf_web_dir_name').$ds."uploads".$ds;

		if ($file = $_FILES['filesToUpload'])
		{
			if (strpos($file['type'], 'zip') === false)
			{
				exit('Грешен тип файл! Не е ZIP');
			}
			
			if (substr($file['name'], 0, 10) != 'DIFF_CTMS_')
			{
				exit('Грешен тип файл (позволени: DIFF_CTMS_*.ZIP)');
			}
			$src = $file['tmp_name'];
			$dest = $root."zip".$ds.$file['name'];
			if (move_uploaded_file($src, $dest))
			{
				$import = new Import();
				$import->setLabel($file['name']);
				$import->setSystem(2); // OAMI system
				$import->setSize($file['size']);
				$import->setStatus('new');
				$import->setUser($this->getUser()->getSubscriberId());
				//$import->setUploadedAt(date('Y-m-d H:i:s'));
				$import->save();
				exit('OK');
			}
		}
		exit('Грешка при качване на файла');
	}

	public function executeUploadFile2()
	{
		$this->setLayout(false);
		//var_dump($_FILES);
		
		$ds = DIRECTORY_SEPARATOR;
		$root = sfConfig::get('sf_root_dir').$ds.sfConfig::get('sf_web_dir_name').$ds."uploads".$ds;

		if ($file = $_FILES['filesToUpload'])
		{
			if (strpos($file['type'], 'zip') === false)
			{
				exit('Грешен тип файл! Не е ZIP');
			}
			
			$src = $file['tmp_name'];
			$dest = $root."zip".$ds.$file['name'];
			if (move_uploaded_file($src, $dest))
			{
				$import = new Import();
				$import->setLabel($file['name']);
				$import->setSystem(3); // WIPO system
				$import->setSize($file['size']);
				$import->setStatus('new');
				$import->setUser($this->getUser()->getSubscriberId());
				$import->setUploadedAt(date('Y-m-d H:i:s'));
				$import->save();
				exit('OK');
			}
		}
		exit('Грешка при качване на файла!');
	}

}