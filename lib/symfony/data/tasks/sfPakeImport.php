<?php

function _echo_cms($section)
{
	if (pakeApp::get_instance()->get_verbose())
	{
		$width = 9 + strlen(pakeColor::colorize('', 'CMS'));
		echo sprintf(' %-'.$width.'s %s', pakeColor::colorize($section, 'CMS'), pakeApp::excerpt("", null))."\n";
	}
}

function _echo_cms_line($section)
{
	if (pakeApp::get_instance()->get_verbose())
	{
		$width = 9 + strlen(pakeColor::colorize('', 'CMS'));
		echo sprintf(' %-'.$width.'s %s', pakeColor::colorize($section, 'CMS'), pakeApp::excerpt("", null));
	}
}

function _echo_cms_error($section)
{
	if (pakeApp::get_instance()->get_verbose())
	{
		$width = 9 + strlen(pakeColor::colorize('', 'ERROR'));
		echo sprintf(' %-'.$width.'s %s', pakeColor::colorize($section, 'ERROR'), pakeApp::excerpt("", null))."\n";
	}
}

function _echo_cms_title($section)
{
	if (pakeApp::get_instance()->get_verbose())
	{
		$width = 9 + strlen(pakeColor::colorize('', 'CMSTITLE'));
		echo sprintf(' %-'.$width.'s %s', pakeColor::colorize($section, 'CMSTITLE'), pakeApp::excerpt("", null))."\n";
	}
}

function _echo_cms_sep()
{
	if (pakeApp::get_instance()->get_verbose())
	{
		$width = 9 + strlen(pakeColor::colorize('', 'SEP'));
		echo sprintf(' %-'.$width.'s %s', pakeColor::colorize("", 'SEP'), pakeApp::excerpt("", null))."\n";
	}
}

pake_task('import-wipo', 'project_exists');
pake_task('import-oami', 'project_exists');
pake_task('import-session', 'project_exists');
pake_task('index-session', 'project_exists');
pake_task('session-search', 'project_exists');
pake_task('create-session', 'project_exists');

function _import_wipo(&$args, &$start, &$count)
{
	//ini_set("display_errors", 1);
	//error_reporting(E_WARNING);
	
	$result = '';
	$start = $count = 0;

	$ds = DIRECTORY_SEPARATOR;
	$root = sfConfig::get('sf_root_dir').$ds.sfConfig::get('sf_web_dir_name').$ds."uploads".$ds;

	$zipFile = $args[0];
	$source = $root."zip".$ds.$zipFile;
	$outDir = $root."files".$ds;

	$zip = new ZipArchive();
	$x = $zip->open($source); // open the zip file to extract
	//exit("\n ".$zipFile."\n");
	//exit("\n x = ".$x."\n");
	if ($x === true)
	{
		$nameParts = explode(".", $zipFile);
		$contestation = $nameParts[0];
		//$contestationDate = date("Y-m-d", strtotime(substr($contestation, 0, 4)."-".substr($contestation, 4, 2)."-".substr($contestation, 6, 2)." +3months")) ;
		//$contestationDateCompare = date("Y-m-d", strtotime(substr($contestation, 0, 4)."-".substr($contestation, 4, 2)."-".substr($contestation, 6, 2)." + 6 months")) ;
		$contestationDateCompare = date("Y-m-d", strtotime(date("Y-m-d")."+ 1 day")) ; // + 1 day

		//exit("\nContestationDate: ".$contestationDateCompare."\n");

		$extract = $zip->extractTo($outDir); // place in the directory with same name
		$zip->close();
		//unlink($source);

		_echo_cms('SUCCESS: Your ZIP file has been unziped OK.');
		_echo_cms('--------------------------------------------------------------------------------');
		$files = array();
		foreach(glob($outDir.'*.*') as $f)
		{
			$files[] = $f;
			if (substr($f, -4) == '.xml') // XML file
			{
				$fileContent = file_get_contents($f);
				if ($fileContent !== false && $fileContent > '')
				{
					_echo_cms_title("Importing XML file: ".$f);
					$cont = file_get_contents($f);
					$enc = mb_detect_encoding($cont, 'ISO-8859-1'); //var_dump($enc);
					$mainData = json_decode(json_encode((array) simplexml_load_string($cont, null, LIBXML_NOCDATA)), 1);
					$trademarks = $mainData["TradeMarkTransactionBody"]["TransactionContentDetails"]["TransactionData"]["TradeMarkDetails"]["TradeMark"];
					unset($mainData);
					$ind = 1;
					
					foreach ($trademarks as $t)
					{
						//if($t['WordMarkSpecification']['MarkVerbalElementText'] != "makazi") continue;
						
						$MarkRecords = $t['MarkRecordDetails']['MarkRecord'];
						$doImport = false;
						$doImport2 = false;
						$date_mrs = array();
						
						foreach ($MarkRecords as $mr)
						{
							$contestationDate = $mr['RecordOppositionPeriod']['RecordOppositionPeriodEndDate'];

							if($contestationDate)
							{
								if($contestationDateCompare < $contestationDate)
								{
									$date_mrs[] = $mr;
									$doImport = true;
								}
							}
						}

						if(!$doImport) continue;

						foreach ($date_mrs as $mr)
						{
							if($offCode = $mr["RecordOppositionPeriod"]["RecordInterestedOfficeCode"])
							{
								if($offCode == "EM")
								{
									$doImport2 = true;
									break;
								}
							}
						}

						if(!$doImport2) continue;

						$regNum = $t['BasicRegistrationApplicationDetails']['BasicRegistrationApplication']['BasicRegistrationDetails']['BasicRegistration']['BasicRegistrationNumber'];
						if(!$regNum) continue;
						$c = new Criteria();
						$c->add(TrademarkPeer::REGISTER_NUMBER, $regNum);
						$tmFound = TrademarkPeer::doSelectOne($c);
						if($tmFound) continue;

						if(!$t['ApplicationNumber']) continue;
						$c = new Criteria();
						$c->add(TrademarkPeer::APPLICATION_NUMBER, $t['ApplicationNumber']);
						$tmFound = TrademarkPeer::doSelectOne($c);
						if($tmFound) continue;


						//upload image
						if($t['MarkImageDetails']) {
							$imageName = str_replace('http://www.wipo.int/intreg/image/WO5', '', $t['MarkImageDetails']['MarkImage']['MarkImageFilename']);
							$imageName = ltrim($imageName, '0');
							$imageFormat = 'jpg';
							if ($t['MarkImageDetails']['MarkImage']['MarkImageFileFormat'] == 'GIF') {
								$imageFormat = 'gif';
							}
							$imgSrc = '/Applications/MAMP/trademark/www/uploads/files/' . $imageName . '.' . $imageFormat;
							$image = Media::upload($imgSrc);

						}



						$tm = new Trademark();
						$tm->setFromSystem(3);
						$tm->setApplicationNumber($t['ApplicationNumber']);
						$tm->setApplicationDate($t['ApplicationDate']);
						$tm->setRegisterNumber($regNum);
						$tm->setRegistrationDate($t['BasicRegistrationApplicationDetails']['BasicRegistrationApplication']['BasicRegistrationDetails']['BasicRegistration']['BasicRegistrationDate']);
						$tm->setExpiresOn($t['ExpiryDate']);
						$tm->setContestation($contestationDate);


						if($image) {
							$tm->setImage($image->getId());
						}


						$dc = $t['DesignatedCountryDetails']['DesignatedCountry'];
						$cc = array();
						foreach ($dc as $dd)
						{
							$cc[] = $dd['DesignatedCountryCode'];
						}
						$tm->setDesignatedContractingParty(implode(',', $cc));

						if ($t['WordMarkSpecification'] && !is_array($t['WordMarkSpecification']['MarkVerbalElementText']))
						$tm->setLabel($t['WordMarkSpecification']['MarkVerbalElementText']);
						else
						$tm->setLabel('no label trademark: '.$t['ApplicationNumber']);

						if (isset($t['MarkImageDetails']['MarkImage']))
						{
							if (isset($t['MarkImageDetails']['MarkImage']['MarkImageFilename']))
							{
								$img = $t['MarkImageDetails']['MarkImage']['MarkImageFilename'];
							}
							/*							if (isset($t['MarkImageDetails']['MarkImage']['MarkImageCategoryDetails']['MarkImageCategory']))
							{
							$codes = array();
							foreach ((array)$t['MarkImageDetails']['MarkImage']['MarkImageCategoryDetails']['MarkImageCategory'] as $ic)
							{
							foreach ((array)$ic['CategoryCodeDetails']['CategoryCode'] as $cc)
							{
							$codes[] = implode('.', str_split($cc, 2));
							}
							}

							$tm->setViennaClasses(implode(',', $codes));
							}*/
							
							$catDetailsArr = $t['MarkImageDetails']['MarkImage']['MarkImageCategoryDetails']['MarkImageCategory'];
							if(!is_array($catDetailsArr))
								$catDetailsArr = array($catDetailsArr);
								
							
							$codes = array();
							foreach ($catDetailsArr as $catDetail)
							{
								if (isset($catDetail['CategoryCodeDetails']['CategoryCode']))
								{
									$realViennaCodes = $catDetail['CategoryCodeDetails']['CategoryCode'];
									if(!is_array($realViennaCodes))
										$realViennaCodes = array($realViennaCodes);
									foreach ($realViennaCodes as $cc)
									{
										$codes[] = implode('.', str_split($cc, 2));
									}
								}
							}
							
							//var_dump($codes);
							//exit();
							
							$tm->setViennaClasses(implode(',', $codes));
								
							/*if (isset($t['MarkImageDetails']['MarkImage']['MarkImageCategoryDetails']['MarkImageCategory']['CategoryCodeDetails']['CategoryCode']))
							{
								$codes = array();
								foreach ($t['MarkImageDetails']['MarkImage']['MarkImageCategoryDetails']['MarkImageCategory']['CategoryCodeDetails']['CategoryCode'] as $cc)
								{
									$codes[] = implode('.', str_split($cc, 2));
								}
								$tm->setViennaClasses(implode(',', $codes)); //var_dump($codes);
							}*/
							
							
						}
						if (isset($t['GoodsServicesDetails']['GoodsServices']['ClassDescriptionDetails']['ClassDescription'][0]))
						{
							$codes = array();
							foreach ($t['GoodsServicesDetails']['GoodsServices']['ClassDescriptionDetails']['ClassDescription'] as $ic)
							{
								$codes[] = $ic['ClassNumber'];
							}
							$tm->setNiceClasses(implode(',', $codes)); //var_dump($codes);
						}
						else
						{
							$tm->setNiceClasses($t['GoodsServicesDetails']['GoodsServices']['ClassDescriptionDetails']['ClassDescription']['ClassNumber']);
						}
						if ($t['MarkFeature'] == 'Figurative')
						$tm->setKind('image');
						elseif ($t['MarkFeature'] == 'Word')
						$tm->setKind('text');
						else
						$tm->setKind('mixed');

						if(is_array($t['ApplicantDetails']['Applicant']['ApplicantAddressBook']['FormattedNameAddress']['Name']['FreeFormatName']['FreeFormatNameDetails']['FreeFormatNameLine']))
						$ownerLabel = array_shift($t['ApplicantDetails']['Applicant']['ApplicantAddressBook']['FormattedNameAddress']['Name']['FreeFormatName']['FreeFormatNameDetails']['FreeFormatNameLine']);
						else
						$ownerLabel = $t['ApplicantDetails']['Applicant']['ApplicantAddressBook']['FormattedNameAddress']['Name']['FreeFormatName']['FreeFormatNameDetails']['FreeFormatNameLine'];

						$tm->setRightsOwner($ownerLabel);

						$address = array();
						$address[] = $t['ApplicantDetails']['Applicant']['ApplicantAddressBook']['FormattedNameAddress']['Address']['AddressCountryCode'];
						foreach ($t['ApplicantDetails']['Applicant']['ApplicantAddressBook']['FormattedNameAddress']['Address']['FreeFormatAddress']['FreeFormatAddressLine'] as $l)
						{
							$address[] = $l;
						}
						$tm->setRightsOwnerAddress(implode("\n", $address));

						$repArr = array();
						if (is_array($t['RepresentativeDetails']['Representative']['RepresentativeAddressBook']['FormattedNameAddress']['Name']['FreeFormatName']['FreeFormatNameDetails']['FreeFormatNameLine']))
						{
							foreach ($t['RepresentativeDetails']['Representative']['RepresentativeAddressBook']['FormattedNameAddress']['Name']['FreeFormatName']['FreeFormatNameDetails']['FreeFormatNameLine'] as $l)
							{
								$repArr[] = $l;
							}
						}
						else
						{
							$repAddress[] = $t['RepresentativeDetails']['Representative']['RepresentativeAddressBook']['FormattedNameAddress']['Name']['FreeFormatName']['FreeFormatNameDetails']['FreeFormatNameLine'];
						}
						$tm->setRightsRepresentative(implode(" ", $repArr));

						$address = array();
						$address[] = $t['RepresentativeDetails']['Representative']['RepresentativeAddressBook']['FormattedNameAddress']['Address']['AddressCountryCode'];
						foreach ($t['RepresentativeDetails']['Representative']['RepresentativeAddressBook']['FormattedNameAddress']['Address']['FreeFormatAddress']['FreeFormatAddressLine'] as $l)
						{
							$address[] = $l;
						}
						$tm->setRightsRepresentativeAddress(implode("\n", $address));

						$tm->setOfficeOfOrigin($t['ReceivingOfficeCode']);
						$last = null;
						$rec = $t['MarkRecordDetails']['MarkRecord'];
						$last = array_pop($rec);
						$tm->setStatus($last['BasicRecord']['BasicRecordKind']);
						if (isset($last['BasicRecord']['RecordPublicationDetails']['RecordPublication']['PublicationDate']))
						{
							$tm->setPublications($last['BasicRecord']['RecordPublicationDetails']['RecordPublication']['PublicationDate'].' | '.$last['BasicRecord']['RecordPublicationDetails']['RecordPublication']['PublicationIdentifier']);
						}
						else
						{
							$recs = array();
							foreach ($last['BasicRecord']['RecordPublicationDetails']['RecordPublication'] as $pp)
							{
								$recs[] = $pp['PublicationDate'] .' | '.$pp['PublicationIdentifier'];
							}
							$tm->setPublications(implode("\n", $recs));
						}
						$tm->save();
						if ($start == 0)
						{
							$start = $tm->getId();
						}
						_echo_cms("$ind: ".$t['WordMarkSpecification']['MarkVerbalElementText']);
						$ind++; $count++;

					}
				}
				echo "*** XML import done! ***\n";
				unset($fileContent);
				$result = 'imported';
			}
		}
		unlink($source);
		//var_dump($files);
		foreach ($files as $f)
		{
			@unlink($f);
		}
	}
	else
	{
		_echo_cms_error('ERROR: Error unzipping uploaded file.');
		$result = 'error';
	}

	return $result;
}

function run_import_wipo($task, $args)
{
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       true);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();

	$ds = DIRECTORY_SEPARATOR;
	$root = sfConfig::get('sf_root_dir').$ds.sfConfig::get('sf_web_dir_name').$ds."uploads".$ds;

	sfConfig::set('sf_cache_objects', false);
	sfConfig::set('sf_cache_relations', false);
	sfConfig::set('sf_use_relations_cache', false);

	if (isset($args[0]))
	{
		$zipFile = $args[0];
	}
	else
	{
		_echo_cms_error("IMPORT-WIPO: No ZIP file specified!"); die();
	}

	$start = $count = 0;
	$result = _import_wipo($args, $start, $count);

	_echo_cms('--------------------------------------------------------------------------------');
	_echo_cms("IMPORT-WIPO: Done!");
	_echo_cms("Done!");
}

function _import_oami(&$args, &$start, &$count)
{
	$result = '';
	$start = $count = 0;

	$ds = DIRECTORY_SEPARATOR;
	$root = sfConfig::get('sf_root_dir').$ds.sfConfig::get('sf_web_dir_name').$ds."uploads".$ds;

	$zipFile = $args[0];
	$source = $root."zip".$ds.$zipFile;
	$outDir = $root."files".$ds;

	$zip = new ZipArchive();
	$x = $zip->open($source); // open the zip file to extract

	if ($x == true)
	{
		// 20140502

		$nameParts = explode("_", $zipFile);
		$contestation = $nameParts[2];
		$contestationDate = date("Y-m-d", strtotime(substr($contestation, 0, 4)."-".substr($contestation, 4, 2)."-".substr($contestation, 6, 2)." +3months")) ;

		//exit("\nContestationDate: ".$contestationDate."\n");

		$extract = $zip->extractTo($outDir); // place in the directory with same name
		$zip->close();
		//unlink($source);

		_echo_cms('SUCCESS: ZIP file has been unziped.');
		_echo_cms('--------------------------------------------------------------------------------');
		$files = array();
		$ind = 0;
		foreach(glob($outDir.'*.*') as $f)
		{
			$files[] = $f; //var_dump($f);
			$parts = pathinfo($f);
			if (substr($parts['basename'], 0, 10) == 'DIFF_CTMS_') // XML file
			{
				//					$c = new Criteria();
				//					$c->add(EmailTemplatePeer::ID, 7206, '>');
				//					EmailTemplatePeer::doDelete($c);
				//echo "*** done delete *** | ";
				$fileContent = file_get_contents($f);
				if ($fileContent !== false && $fileContent > '')
				{
					_echo_cms_title("Importing XML file: ".$f);
					$enc = mb_detect_encoding($fileContent, 'ISO-8859-1'); //var_dump($enc);
					$mainData = json_decode(json_encode((array) simplexml_load_string($fileContent, null, LIBXML_NOCDATA)), 1);
					//var_dump($mainData); //exit();

					$trademarks = $mainData["TradeMarkTransactionBody"]["TransactionContentDetails"]["TransactionData"]["TradeMarkDetails"]["TradeMark"];
					echo "cnt=".count($trademarks)."\n";
					unset($mainData);
					//var_dump($trademarks[0]); //die("\n-------------------\n");
					foreach ($trademarks as $t)
					{
						$dc = $t['DesignatedCountryDetails']['DesignatedCountry'];
						$cc = array();
						foreach ($dc as $dd)
						{
							$cc[] = $dd['DesignatedCountryCode'];
						}
						//if(!in_array(array("EM","BG"),$cc)) continue;

						if ($t['@attributes']['operationCode'] != 'Insert') continue; // only INSERT
						//var_dump($t); //_echo_cms('--------------------------------------------------------------------------------'); continue;
						$c = new Criteria();
						$c->add(TrademarkPeer::APPLICATION_NUMBER, $t['ApplicationNumber']);
						$tm = TrademarkPeer::doSelectOne($c);
						if (!$tm)
						{
							$tm = new Trademark();
						}
						$tm->setFromSystem(2); // OAMI
						$tm->setApplicationNumber($t['ApplicationNumber']);
						//if ($t['ApplicationNumber'] == '012438404') var_dump($t);
						$tm->setApplicationDate($t['ApplicationDate']);
						$tm->setRegisterNumber($t['BasicRegistrationApplicationDetails']['BasicRegistrationApplication']['BasicRegistrationDetails']['BasicRegistration']['BasicRegistrationNumber']);
						$tm->setRegistrationDate($t['BasicRegistrationApplicationDetails']['BasicRegistrationApplication']['BasicRegistrationDetails']['BasicRegistration']['BasicRegistrationDate']);
						$tm->setExpiresOn($t['ExpiryDate']);
						//						$tm->setContestation($contestationDate);
						$tm->setDesignatedContractingParty(implode(',', $cc));

						if ($t['WordMarkSpecification']['MarkVerbalElementText'])
						$tm->setLabel($t['WordMarkSpecification']['MarkVerbalElementText']);
						else
						$tm->setLabel('no label trademark: '.$t['ApplicationNumber']);

						if (isset($t['MarkImageDetails']['MarkImage']))
						{
							if (isset($t['MarkImageDetails']['MarkImage']['MarkImageFilename']))
							{
								$img = $t['MarkImageDetails']['MarkImage']['MarkImageFilename'];
							}
							if (isset($t['MarkImageDetails']['MarkImage']['MarkImageCategory']['CategoryCodeDetails']['CategoryCode']))
							{
								if (is_array($t['MarkImageDetails']['MarkImage']['MarkImageCategory']['CategoryCodeDetails']['CategoryCode']))
								{
									$tm->setViennaClasses(implode(',', $t['MarkImageDetails']['MarkImage']['MarkImageCategory']['CategoryCodeDetails']['CategoryCode']));
								}
								else
								{
									$tm->setViennaClasses($t['MarkImageDetails']['MarkImage']['MarkImageCategory']['CategoryCodeDetails']['CategoryCode']);
								}
							}
						}
						if (isset($t['GoodsServicesDetails']['GoodsServices']['ClassDescriptionDetails']['ClassDescription'][0]))
						{
							$codes = array();
							foreach ($t['GoodsServicesDetails']['GoodsServices']['ClassDescriptionDetails']['ClassDescription'] as $ic)
							{
								$codes[] = $ic['ClassNumber'];
							}
							$tm->setNiceClasses(implode(',', $codes));
						}
						else
						{
							$tm->setNiceClasses( $t['GoodsServicesDetails']['GoodsServices']['ClassDescriptionDetails']['ClassDescription']['ClassNumber']);
						}
						if ($t['MarkFeature'] == 'Figurative')
						$tm->setKind('image');
						elseif ($t['MarkFeature'] == 'Word')
						$tm->setKind('text');
						elseif ($t['MarkFeature'] == 'Sound')
						$tm->setKind('sound');
						else
						$tm->setKind('mixed');

						if (isset($t['ApplicantDetails']['ApplicantKey'][0]))
						{
							$recs = array();
							foreach ($t['ApplicantDetails']['ApplicantKey'] as $rr)
							{
								$recs[] = $rr['Identifier'];
							}
							$tm->setRightsOwner(implode(',', $recs));
							$tm->setRightsOwnerId(implode(',', $recs));
						}
						else
						{
							$tm->setRightsOwner($t['ApplicantDetails']['ApplicantKey']['Identifier']);
							$tm->setRightsOwnerId($t['ApplicantDetails']['ApplicantKey']['Identifier']);
						}
						$tm->setRightsOwnerAddress('');

						$tm->setRightsRepresentative($t['RepresentativeDetails']['RepresentativeKey']['Identifier']);
						$tm->setRightsRepresentativeId($t['RepresentativeDetails']['RepresentativeKey']['Identifier']);
						$tm->setRightsRepresentativeAddress('');

						$tm->setOfficeOfOrigin($t['RegistrationOfficeCode']);

						$tm->setStatus($t['MarkCurrentStatusCode']);

						$pDate = '-'; $pub = '-'; $contestation = '-';
						if (isset($t['PublicationDetails']['Publication']))
						{
							//							_echo_cms("* checking #$ind: ".$tm->getLabel());
							// if we have multiple publications
							if (isset($t['PublicationDetails']['Publication'][0]))
							{
								//_echo_cms("A) checking #$ind: ".$tm->getLabel());
								/*								$recs = array();
								foreach ($t['PublicationDetails']['Publication'] as $pp)
								{
								$recs[] = $pp['PublicationDate'].' | '.$pp['PublicationIdentifier'].' | '.$pp['PublicationSection'];
								}
								$tm->setPublications(implode("\n", $recs));*/

								$recs = ''; $found = false;
								foreach ($t['PublicationDetails']['Publication'] as $pp)
								{
									$recs = $pp['PublicationDate'].' | '.$pp['PublicationIdentifier'].' | '.$pp['PublicationSection'];
									$pDate = $pp['PublicationDate'];
									$pub = $pp['PublicationSection'];
									$today = date('Y-m-d');
									if ($pp['PublicationSection'] == 'M.1')
									{
										$contestation = date('Y-m-d', strtotime("+10 months", strtotime($pp['PublicationDate'])));
										if ($today > $contestation)
										{
											//echo "SKIP M1: $today > $contestation | ";
											continue;
										}
										//echo "FOUND M1: $today  < $contestation \n";
										$contestation = date('Y-m-d', strtotime("+9 months", strtotime($pp['PublicationDate'])));
										$tm->setContestation($contestation);
										$found = true;
									}
									else if ($pp['PublicationSection'] == 'A.1')
									{
										$contestation = date('Y-m-d', strtotime("+4 months", strtotime($pp['PublicationDate'])));
										if ($today > $contestation)
										{
											//echo "SKIP A1: $today > $contestation | ";
											continue;
										}
										//echo "FOUND A1: $today  < $contestation \n";
										$contestation = date('Y-m-d', strtotime("+3 months", strtotime($pp['PublicationDate'])));
										$tm->setContestation($contestation);
										$found = true;
									}
								}
								if (!$found)
								{
									//echo " > Not Found\n";
									continue;
								}
								$tm->setPublications($recs);
							}
							else // single publication
							{
								//_echo_cms("B) checking #$ind: ".$tm->getLabel());
								$pDate = $t['PublicationDetails']['Publication']['PublicationDate'];
								$pub = $t['PublicationDetails']['Publication']['PublicationSection'];
								$today = date('Y-m-d');
								if ($pub == 'M.1')
								{
									$contestation = date('Y-m-d', strtotime("+10 months", strtotime($pDate)));
									if ($today > $contestation)
									{
										//echo "SKIP M1: $today > $contestation \n";
										continue;
									}
									//echo "FOUND M1: $today  < $contestation \n";
									$contestation = date('Y-m-d', strtotime("+9 months", strtotime($pDate)));
									$tm->setContestation($contestation);
								}
								else if ($pub == 'A.1')
								{
									$contestation = date('Y-m-d', strtotime("+4 months", strtotime($pDate)));
									if ($today > $contestation)
									{
										//echo "SKIP A1: $today > $contestation \n";
										continue;
									}
									//echo "FOUND A1: $today  < $contestation \n";
									$contestation = date('Y-m-d', strtotime("+3 months", strtotime($pDate)));
									$tm->setContestation($contestation);
								}
								else
								{
									//echo " > Not Found A1 or M1\n";
									continue; // skip OTHER Publications except A.1 and M.1
								}
								$tm->setPublications($t['PublicationDetails']['Publication']['PublicationDate'].' | '.$t['PublicationDetails']['Publication']['PublicationIdentifier'].' | '.$t['PublicationDetails']['Publication']['PublicationSection']);
							}
						}
						else
						{
							//echo "SKIP: #$ind: ".$tm->getLabel()." : NO PUBLICATION\n";
							continue;
						}
						$tm->save();
						if ($start == 0)
						{
							$start = $tm->getId();
						}
						$ind++; $count++;
						_echo_cms("$ind: ".$tm->getLabel()." | pub=$pub, contestation=$contestation");
					}
					unset($trademarks);
				}
				echo "*** XML import done! ***\n";
				unset($fileContent);
				$result = 'imported';
			}
		}

		//var_dump($files);
		foreach ($files as $f)
		{
			@unlink($f);
		}
	}
	else
	{
		_echo_cms_error('ERROR: Error unzipping uploaded file.');
		$result = 'error';
	}

	return $result;
}

function run_import_oami($task, $args)
{
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       true);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();

	//$request = sfContext::getInstance()->getRequest();
	$ds = DIRECTORY_SEPARATOR;
	$root = sfConfig::get('sf_root_dir').$ds.sfConfig::get('sf_web_dir_name').$ds."uploads".$ds;

	_echo_cms_title('IMPORT OAMI');

	// faster save!!!
	sfConfig::set('sf_cache_objects', false);
	sfConfig::set('sf_cache_relations', false);
	sfConfig::set('sf_use_relations_cache', false);

	if (isset($args[0]))
	{
		$zipFile = $args[0];
	}
	else
	{
		_echo_cms_error("IMPORT-OAMI: No ZIP file specified!"); die();
	}

	$start = $count = 0;
	_import_oami($args, $start, $count);

	_echo_cms('--------------------------------------------------------------------------------');
	_echo_cms("IMPORT-OAMI: Done!");
}

function run_index_session($task, $args)
{
	try
	{
		ini_set("memory_limit", "4096M");
		ini_set("display_errors", 1);
		error_reporting(E_ALL);

		define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
		define('SF_APP',         'frontend');
		define('SF_ENVIRONMENT', 'prod');
		define('SF_DEBUG',       true);

		require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		if($sessionId = $args[0])
		{
			$session = Document::getDocumentInstance($sessionId);
			if(!$session)
			{
				echo_cms_error("Session does not exist");
				exit();
			}
			$sessions = array($session);
		}
		else
		{
			$c = new Criteria();
			$sessions = ImportSessionPeer::doSelect($c);
		}

		foreach ($sessions as $session)
		{
			$sessionId = $session->getId();
			if($session->getStartId()== 0) continue;

			$import = Document::getDocumentInstance($session->getImportId());

			$search_config_file = SF_ROOT_DIR.'/config/search.xml';
			$documents = simplexml_load_file($search_config_file);
			$all = 0;

			$search_index_path = SF_ROOT_DIR.'/cache/search/'.$sessionId.'/';

			if (is_dir($search_index_path))
			{
				continue;
				/*$index_files = glob($search_index_path.'/*');
				foreach ($index_files as $index_file)
				{
				if (is_file($index_file))
				{
				unlink($index_file);
				}
				}*/
			}


			echo ">>> indexing session:". $sessionId."\n";

			$search_index = Zend_Search_Lucene::create($search_index_path);
			$search_index->setMaxBufferedDocs(10000);
			Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive());
			$ndoc = 0;

			foreach ($documents as $document)
			{
				$document_name = $document->attributes();

				echo "Indexing ".$document_name."\n";

				$classPeer = $document_name.'Peer';
				$c = new Criteria();
				$c->add(TrademarkPeer::ID, $session->getStartId(), Criteria::GREATER_EQUAL);
				if($import)
					$c->add(TrademarkPeer::FROM_SYSTEM, $import->getSystem());
				else
					$c->add(TrademarkPeer::FROM_SYSTEM, 11);

				$c->setLimit($session->getTmCount());
				$document_instances = TrademarkPeer::doSelect($c);

				foreach ($document_instances as $document_instance)
				{
					$common_field_val = "";

					$id = $document_instance->getId();
					$search_doc = new Zend_Search_Lucene_Document();
					$date = $document_instance->getCreatedAt();

					$search_doc->addField(Zend_Search_Lucene_Field::UnIndexed('did', $id,'utf-8'));
					$search_doc->addField(Zend_Search_Lucene_Field::UnIndexed('ddate', $date,'utf-8'));
					$search_doc->addField(Zend_Search_Lucene_Field::UnIndexed('dtype', $document_name,'utf-8'));
					$search_doc->addField(Zend_Search_Lucene_Field::UnIndexed('dstatus', $document_instance->getPublicationStatus(),'utf-8'));

					foreach ($document as $field_name)
					{
						$attr = get_object_vars($field_name);
						$attributes = $attr['@attributes'];
						$getFunction = 'get'.$attributes['name'];
						$fieldContent = "";

						$fieldContent = $document_instance->$getFunction();

						if($attributes['name'] == "Label" AND substr($fieldContent, 0, 8) == "no label")
						$fieldContent = "";

						if($attributes['name'] == "ViennaClasses" || $attributes['name'] == "NiceClasses")
						{
							$parts = explode(",", $fieldContent);
							$nbr = count($parts);
							//echo "============>".$nbr."\n";
							$search_doc->addField(Zend_Search_Lucene_Field::UnIndexed($attributes['name']."_cnt", $nbr, 'utf-8'));
							//$e = 1;
							for ($e = 0 ; $e < 15 ; $e++)
							{
								if(empty($parts[$e])) $parts[$e] = "---";
								$search_doc->addField(Zend_Search_Lucene_Field::keyword($attributes['name'].$e, trim($parts[$e]), 'utf-8'));
								$e++;
							}
						}
						elseif($attributes['name'] == "ApplicationNumber" || $attributes['name'] == "RegisterNumber")
						{
							$search_doc->addField(Zend_Search_Lucene_Field::keyword($attributes['name'], $fieldContent, 'utf-8'));
						}
						else
						{
							$search_doc->addField(Zend_Search_Lucene_Field::text($attributes['name'], UtilsHelper::cyrillicConvert($fieldContent), 'utf-8'));
						}

					}

					$search_index->addDocument($search_doc);
					$ndoc++;
					echo $ndoc."\t\t\r";
				}
			}

			echo echo_cms_line(" ".$ndoc." documents indexed\n");
			$search_index->commit();
			$search_index->optimize();
		}
	}
	catch (Exception $e)
	{
		echo_cms_error("ERROR ADD_DOCUMENT : ".$e->getMessage());
	}
	exit();
}

function _index_session($sessionId)
{
	try
	{
		ini_set("memory_limit","2048M");
		ini_set("display_errors", 1);

		define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
		define('SF_APP',         'frontend');
		define('SF_ENVIRONMENT', 'prod');
		define('SF_DEBUG',       true);

		require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		//$sessionId = $args[0];
		$session = Document::getDocumentInstance($sessionId);
		if(!$session)
		{
			echo_cms_error("Session does not exist");
			exit();
		}

		$import = Document::getDocumentInstance($session->getImportId());

		$search_config_file = SF_ROOT_DIR.'/config/search.xml';
		$documents = simplexml_load_file($search_config_file);
		$all = 0;

		$search_index_path = SF_ROOT_DIR.'/cache/search/'.$sessionId.'/';
		if (is_dir($search_index_path))
		{
			$index_files = glob($search_index_path.'/*');
			foreach ($index_files as $index_file)
			{
				if (is_file($index_file))
				{
					unlink($index_file);
				}
			}
		}

		$search_index = Zend_Search_Lucene::create($search_index_path);
		$search_index->setMaxBufferedDocs(10000);
		Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive());
		$ndoc = 0;

		foreach ($documents as $document)
		{
			$document_name = $document->attributes();

			echo "Indexing ".$document_name."\n";

			$classPeer = $document_name.'Peer';
			$c = new Criteria();
			$c->add(TrademarkPeer::ID, $session->getStartId(), Criteria::GREATER_EQUAL);
			$c->add(TrademarkPeer::FROM_SYSTEM, $import->getSystem());
			//$c->setLimit($session->getTmCount());
			$document_instances = TrademarkPeer::doSelect($c);

			foreach ($document_instances as $document_instance)
			{
				$common_field_val = "";

				$id = $document_instance->getId();
				$search_doc = new Zend_Search_Lucene_Document();
				$date = $document_instance->getCreatedAt();

				$search_doc->addField(Zend_Search_Lucene_Field::UnIndexed('did', $id,'utf-8'));
				$search_doc->addField(Zend_Search_Lucene_Field::UnIndexed('ddate', $date,'utf-8'));
				$search_doc->addField(Zend_Search_Lucene_Field::UnIndexed('dtype', $document_name,'utf-8'));
				$search_doc->addField(Zend_Search_Lucene_Field::UnIndexed('dstatus', $document_instance->getPublicationStatus(),'utf-8'));

				foreach ($document as $field_name)
				{
					$attr = get_object_vars($field_name);
					$attributes = $attr['@attributes'];
					$getFunction = 'get'.$attributes['name'];
					$fieldContent = "";

					$fieldContent = $document_instance->$getFunction();

					if($attributes['name'] == "Label" AND substr($fieldContent, 0, 8) == "no label")
					$fieldContent = "";

					if($attributes['name'] == "ViennaClasses" || $attributes['name'] == "NiceClasses")
					{
						$parts = explode(",", $fieldContent);
						$nbr = count($parts);
						//echo "============>".$nbr."\n";
						$search_doc->addField(Zend_Search_Lucene_Field::UnIndexed($attributes['name']."_cnt", $nbr, 'utf-8'));
						//$e = 1;
						for ($e = 0 ; $e < 15 ; $e++)
						{
							if(empty($parts[$e])) $parts[$e] = "---";
							$search_doc->addField(Zend_Search_Lucene_Field::keyword($attributes['name'].$e, trim($parts[$e]), 'utf-8'));
							$e++;
						}
					}
					elseif($attributes['name'] == "ApplicationNumber" || $attributes['name'] == "RegisterNumber")
					{
						$search_doc->addField(Zend_Search_Lucene_Field::keyword($attributes['name'], $fieldContent, 'utf-8'));
					}
					else
					{
						$search_doc->addField(Zend_Search_Lucene_Field::text($attributes['name'], UtilsHelper::cyrillicConvert($fieldContent), 'utf-8'));
					}

				}

				$search_index->addDocument($search_doc);
				$ndoc++;
				echo $ndoc."\t\t\r";
			}
		}

		echo echo_cms_line(" ".$ndoc." documents indexed\n");
		$search_index->commit();
		$search_index->optimize();
		return true;
	}
	catch (Exception $e)
	{
		echo_cms_error("ERROR ADD_DOCUMENT : ".$e->getMessage());
		return false;
	}

}
function run_create_session($task, $args)
{
	ini_set("memory_limit","2048M");
	ini_set("display_errors", 1);

	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       true);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();
	$ds = DIRECTORY_SEPARATOR;
	$root = sfConfig::get('sf_root_dir').$ds.sfConfig::get('sf_web_dir_name').$ds."uploads".$ds;

	_echo_cms_title('CREATE-SESSION');

	sfConfig::set('sf_cache_objects', false);
	sfConfig::set('sf_cache_relations', false);
	sfConfig::set('sf_use_relations_cache', false);

	$c = new Criteria();
	$c->add(TrademarkPeer::FROM_SYSTEM, 1);
	$c->addAscendingOrderByColumn(TrademarkPeer::ID);
	$trademarks = TrademarkPeer::doSelect($c);

	//var_dump(count($trademarks));
	if($trademarks)
	{
		$start = $trademarks[0]->getId();
		$count = count($trademarks);

		foreach ($trademarks as $trademark)
		{
			$trademark->setFromSystem(11);
			$trademark->save();
		}

		$is = new ImportSession();
		$is->setLabel(date('d.m.Y H:i'));
		$is->setStartId($start);
		$is->setTmCount($count);
		$is->save();
	}
}

function run_import_session($task, $args)
{
	ini_set("memory_limit","6048M");

	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       true);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();

	//$request = sfContext::getInstance()->getRequest();
	$ds = DIRECTORY_SEPARATOR;
	$root = sfConfig::get('sf_root_dir').$ds.sfConfig::get('sf_web_dir_name').$ds."uploads".$ds;

	_echo_cms_title('IMPORT-SESSION: Check for new imports');

	// faster save!!!
	//sfConfig::set('sf_cache_objects', false);
	//sfConfig::set('sf_cache_relations', false);
	//sfConfig::set('sf_use_relations_cache', false);

	// check Imports status='new'
	$c = new Criteria();
	//$c->add(ImportPeer::SYSTEM, 3);
	$c->add(ImportPeer::STATUS, 'new');
	$newImports = ImportPeer::doSelect($c);
	
	//$newImport1 = Document::getDocumentInstance(548884);
	//$newImports = array($newImport1);
	
	foreach ($newImports as $newImport)
	{
		$zipFile = $newImport->getLabel();
		_echo_cms("Importing file: $zipFile...");
		$system = $newImport->getSystem();
		if ($system == 2) // OAMI
		{
			$start = $count = 0;
			$params = array($zipFile);
			try
			{
				$status = _import_oami($params, $start, $count);
				_echo_cms('Import #'.$newImport->getId().', status='.$status);
			}
			catch (Exception $e)
			{
				$status = 'error';
			}
			if ($status)
			{
				$newImport->setStatus($status);
				$newImport->save();
				if ($status == 'imported')
				{
					// save Import Session object
					$is = new ImportSession();
					$is->setLabel('Импорт сесия '.date('d.m.Y'));
					$is->setImportId($newImport->getId());
					$is->setStartId($start);
					$is->setTmCount($count);
					$is->save();
					//_index_session($is->getId());
				}
			}
		}
		else if ($system == 3) // WIPO
		{
			$start = $count = 0;
			$params = array($zipFile);
			try
			{
				$status = _import_wipo($params, $start, $count);
				_echo_cms('Import #'.$newImport->getId().', status='.$status);
			}
			catch (Exception $e)
			{
				$status = 'error';
			}
			if ($status)
			{
				$newImport->setStatus($status);
				$newImport->save();
				if ($status == 'imported')
				{
					// save Import Session object
					$is = new ImportSession();
					$is->setLabel('Импорт сесия '.date('d.m.Y'));
					$is->setImportId($newImport->getId());
					$is->setStartId($start);
					$is->setTmCount($count);
					$is->save();
					//_index_session($is->getId());
				}
			}
		}
	}
	_echo_cms('--------------------------------------------------------------------------------');
	_echo_cms("IMPORT-SESSION: Done!");
}

function run_session_search($task, $args)
{

	ini_set("memory_limit", "8192M");
	ini_set("display_errors", 1);

	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       true);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();

	//sfConfig::set('sf_cache_objects', false);
	//sfConfig::set('sf_cache_relations', false);
	//sfConfig::set('sf_use_relations_cache', false);
	
	//get all serch templates
	$c = new Criteria();
	$searcheTemplates = SearchPeer::doSelect($c);
	//$searcheTemplates = array($st);
	$fields =  array('Label', 'ApplicationNumber', 'RegisterNumber', 'RegistrationDate', 'ApplicationDate', 'ExpiresOn', 'ViennaClasses', 'NiceClasses', 'RightsOwner', 'RightsRepresentative', 'OfficeOfOrigin', 'DesignatedContractingParty');

	/*if($args[0] && $args[0] != "-d")
	{
	$importSession = Document::getDocumentInstance($args[0]);
	$importSessions = array($importSession);

	}
	else*/
	{
		$c = new Criteria();
		//$c->add(ImportSessionPeer::CREATED_AT, "2014-11-03", Criteria::GREATER_EQUAL );
		$importSessions = ImportSessionPeer::doSelect($c);
	}

	/*if($args[0] == "-d")
	{
	foreach ($importSessions as $importSession)
	{
	$res = Document::getChildrenOf($importSession->getId(), "SearchMatch");
	foreach ($res as $r)
	{
	$r->delete();
	echo ".";
	}
	}
	exit();
	}*/

	$ind = 0;
	foreach ($importSessions as $importSession)
	{
		$found = false;
		if($importSession->getTmCount() == 0) continue;
		$searchMatches = Document::getChildrenOf($importSession->getId(), "SearchMatch", false);

		//if($importSession->getId() == 552172) continue;
		
		if(count($searchMatches) > 0) continue;

		echo ">>> searching session: ". $importSession->getId()."\n";

		try
		{
			$sti = 1;
			foreach ($searcheTemplates as $searcheTemplate)
			{
				$searchOf = array();
				foreach ($fields as $field)
				{
					$getter = "get".$field;
					$param = $searcheTemplate->$getter();
					if($param)
					{
						$param = str_replace(
						array('+','-','&&','||','!','(',')','{','}','[',']','^','"','~',':','\\','.','/'),
						array('\+','\-','\&&','\||','\!','\(','\)','\{','\}','\[','\]','\^','\"','\~','\:','\\\\','\.','\/'),
						$param
						);
						$searchOf[$field] = trim($param);
					}
				}

				/////////////////////// QUERY BUILDING //////////////////////////
				$q = new Zend_Search_Lucene_Search_Query_Boolean();
				$queryTerms = explode(" ", strtolower($query));

				$i = 0;
				$query = "";
				foreach ($searchOf as $field => $term)
				{
					if($i > 0) $query .= ' AND ';

					if($field == "NiceClasses" || $field == "ViennaClasses")
					{

						$query .= '(';
						$parts = explode(",", $term);
						foreach ($parts as  $el)
						{
							for ($e = 1 ; $e < 15 ; $e++)
							{
								$query .= $field.$e.':"'.trim($el).'" OR ';
							}
						}
						$query = substr($query, 0, -4).')';
					}
					elseif($field == "ApplicationNumber" || $field == "RegisterNumber")
					{
						$query .= $field.':';
						$query .= trim($term);
					}
					else
					{
						$query .= $field.':';
						if(strpos($term,"*") !== false || strpos($term,"?") !== false)
						$query .= trim(UtilsHelper::cyrillicConvert($term));
						else
						$query .= trim(UtilsHelper::cyrillicConvert($term)).'~0.7';
					}

					$i++;
				}

				$q = Zend_Search_Lucene_Search_QueryParser::parse($query);
				//////////////////////// SEARCH EXECUTION ////////////////////
				echo " | ".$sti." > ".$searcheTemplate->getId();
				$searchIndex = Zend_Search_Lucene::open(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'search/'.$importSession->getId()."/");
				$searchResults  = $searchIndex->find($q);

				$brandId = Document::getParentOf($searcheTemplate->getId(), "Brand", false);

				foreach ($searchResults as $searchResult)
				{
					if($foundEls[$searchResult->did] == $brandId) continue;
					$foundEls[$searchResult->did] = $brandId;
					$found = true;

					$sm = new SearchMatch();
					$sm->setLabel("Match");
					$sm->setImportSession($importSession->getId());
					$sm->setSearch($searcheTemplate->getId());
					$sm->setTrademark($searchResult->did);
					$sm->save(null, $importSession);
				}
				$sti++;

			}

			if($found)
			{
				UtilsHelper::sendEmail(UtilsHelper::Settings('main_email'), "Matches have been found, click below to see them <br> <a href='http://www.tm-smart.com/import-session-report.html?is=".$importSession->getId()."'>http://www.tm-smart.com/import-session-report.html?is=".$importSession->getId()."</a>","TM Smart - Matches foud");
				$ind++;
			}
			else
			{
//				UtilsHelper::sendEmail(UtilsHelper::Settings('main_email'), "No matches have been found", "TM Smart - No matches foud");
			}
		}
		catch (Exception $e)
		{
			echo ">>>>>>>>>> Error on Session ".$importSession->getId()."\n".$e->getMessage();
			continue;
			//echo_cms_error("ERROR: ".$e->getMessage());
		}

		if ($ind > 10) break;
	}

	//sfConfig::set('sf_cache_objects', true);
	//sfConfig::set('sf_cache_relations', true);
	//sfConfig::set('sf_use_relations_cache', true);


}

?>