<?php
/**
 * @package    cms
 * @subpackage search
 * @author     Jordan Hristov / Ilya Popivanov
 */

class searchActions extends searchCoreActions
{

	public function executeDetails()
	{
		$this->setLayout(false);

		$sm = Document::getDocumentInstance($this->getRequestParameter('SearchMatch_id'));
		$this->st = Document::getDocumentInstance($sm->getSearch());
		$this->sm = $sm;
		$this->parentBrand = Document::getParentOf($sm->getSearch(), "Brand");
		if (get_class($sm) == 'SearchMatch')
		{
			$fields =  array('Label', 'ApplicationNumber', 'RegisterNumber', 'RegistrationDate', 'ApplicationDate', 'ExpiresOn', 'ViennaClasses', 'NiceClasses', 'RightsOwner', 'RightsRepresentative', 'OfficeOfOrigin', 'DesignatedContractingParty');
			$template = Document::getDocumentInstance($sm->getSearch());
			if($template) 
			{
				$searchOf = array();
				foreach ($fields as $field)
				{
					$getter = "get".$field;
					$v = $template->$getter();
					if($v) $searchOf[] = $field;
				}
			}
			$this->searchOf = $searchOf;
			$this->brand = Document::getDocumentInstance($sm->getTrademark());
		}
		else
		{
			$this->brand = null;
		}

	}
	
	public function executeDetails2()
	{
		header("Content-type: text/html; charset=utf-8");
		$this->setLayout(false);
		
		$sm = Document::getDocumentInstance($this->getRequestParameter('SearchMatch_id'));
		$this->st = Document::getDocumentInstance($sm->getSearch());
		$this->sm = $sm;
		$this->parentBrand = Document::getParentOf($sm->getSearch(), "Brand");
		if (get_class($sm) == 'SearchMatch')
		{
			$fields =  array('Label', 'ApplicationNumber', 'RegisterNumber', 'RegistrationDate', 'ApplicationDate', 'ExpiresOn', 'ViennaClasses', 'NiceClasses', 'RightsOwner', 'RightsRepresentative', 'OfficeOfOrigin', 'DesignatedContractingParty');
			$template = Document::getDocumentInstance($sm->getSearch());
			if($template) 
			{
				$searchOf = array();
				foreach ($fields as $field)
				{
					$getter = "get".$field;
					$v = $template->$getter();
					if($v) $searchOf[] = $field;
				}
			}
			$this->searchOf = $searchOf;
			$this->brand = Document::getDocumentInstance($sm->getTrademark());
		}
		else
		{
			$this->brand = null;
		}
	}
	
	public function executeTrademarkDetails()
	{
		$this->setLayout(false);
		$trademark = Document::getDocumentInstance($this->getRequestParameter('Trademark_id'));
		if (get_class($trademark) == 'Trademark')
		{
			$this->trademark = $trademark;
		}
		else
		{
			$this->trademark = null;
		}
	}

	public function validateWebSearch()
	{
		$res = true;
		$request = $this->getRequest();
		$params = $request->getParameterHolder()->getAll();

		if ($this->getRequestParameter('submitted') == "submitted")
		{
			$res = false;
			foreach ($params as $key => $param)
			{
				$parts = explode("-", $key);

				if($parts[0] == "field" && !empty($param) && $parts[1] != "DesignatedContractingParty")
				{
					$res = true;
					break;
				}
			}
		}
		if(!$res) $request->setError('errNofield', /*UtilsHelper::Localize("website.frontend.No-".$field)*/ "Моля, попълнете най малко едно от полетата");
		return $res;
	}

	public function handleErrorWebSearch()
	{
		$this->setLayout(false);
		$this->countries = $arr = array(
		"BG"=>"БЪЛГАРИЯ",
		"AF"=>"AFGHANISTAN",
		"OA"=>"AFRICAN INTELLECTUAL PROPERTY ORGANIZATION (OAPI)",
		"AP"=>"AFRICAN REGIONAL INDUSTRIAL PROPERTY ORGANIZATION (ARIPO)",
		"AL"=>"ALBANIA",
		"DZ"=>"ALGERIA",
		"AS"=>"AMERICAN SAMOA",
		"AD"=>"ANDORRA",
		"AO"=>"ANGOLA",
		"AI"=>"ANGUILLA",
		"AQ"=>"ANTARCTICA",
		"AG"=>"ANTIGUA AND BARBUDA",
		"AR"=>"ARGENTINA",
		"AM"=>"ARMENIA",
		"AW"=>"ARUBA",
		"AU"=>"AUSTRALIA",
		"AT"=>"AUSTRIA",
		"AZ"=>"AZERBAIJAN",
		"BS"=>"BAHAMAS",
		"BH"=>"BAHRAIN",
		"BD"=>"BANGLADESH",
		"BB"=>"BARBADOS",
		"BY"=>"BELARUS",
		"BE"=>"BELGIUM",
		"BZ"=>"BELIZE",
		"BX"=>"BENELUX",
		"BJ"=>"BENIN",
		"BM"=>"BERMUDA",
		"BT"=>"BHUTAN",
		"BO"=>"BOLIVIA",
		"BA"=>"BOSNIA AND HERZEGOVINA",
		"BW"=>"BOTSWANA",
		"BV"=>"BOUVET ISLAND",
		"BR"=>"BRAZIL",
		"BN"=>"BRUNEI DARUSSALAM",
		"BF"=>"BURKINA FASO",
		"BI"=>"BURUNDI",
		"KH"=>"CAMBODIA",
		"CM"=>"CAMEROON",
		"CA"=>"CANADA",
		"CV"=>"CAPE VERDE",
		"KY"=>"CAYMAN ISLANDS",
		"CF"=>"CENTRAL AFRICAN REPUBLIC",
		"TD"=>"CHAD",
		"CS"=>"Channel Islands",
		"CL"=>"CHILE",
		"CN"=>"CHINA",
		"CX"=>"CHRISTMAS,INSULE",
		"CC"=>"COCOS,INSULE",
		"CO"=>"COLOMBIA",
		"KM"=>"COMOROS",
		"CG"=>"CONGO",
		"CK"=>"COOK ISLANDS",
		"CR"=>"COSTA RICA",
		"CI"=>"COTE D'IVOIRE",
		"HR"=>"CROATIA",
		"CU"=>"CUBA",
		"CW"=>"CURACAO",
		"CY"=>"CYPRUS",
		"CZ"=>"CZECH REPUBLIC",
		"KP"=>"DEMOCRATIC PEOPLE'S REPUBLIC OF KOREA",
		"DK"=>"DENMARK",
		"DJ"=>"DJIBOUTI",
		"DM"=>"DOMINICA",
		"DO"=>"DOMINICAN REPUBLIC",
		"TP"=>"EAST TIMOR",
		"EC"=>"ECUADOR",
		"EG"=>"EGYPT",
		"SV"=>"EL SALVADOR",
		"GQ"=>"EQUATORIAL GUINEA",
		"ER"=>"ERITREA",
		"EE"=>"ESTONIA",
		"ET"=>"ETHIOPIA",
		"EA"=>"EURASIAN PATENT ORGANIZATION (EAPO)",
		"EP"=>"EUROPEAN PATENT OFFICE (EPO)",
		"FK"=>"FALKLAND ISLANDS (MALVINAS)",
		"FO"=>"FAROE ISLANDS",
		"FJ"=>"FIJI",
		"FI"=>"FINLAND",
		"FR"=>"FRANCE",
		"GA"=>"GABON",
		"GM"=>"GAMBIA",
		"GE"=>"GEORGIA",
		"DE"=>"GERMANY",
		"GH"=>"GHANA",
		"GI"=>"GIBRALTAR",
		"GR"=>"GREECE",
		"GL"=>"GREENLAND",
		"GD"=>"GRENADA",
		"GP"=>"GUADELUPA",
		"GU"=>"GUAM",
		"GT"=>"GUATEMALA",
		"GN"=>"GUINEA",
		"GW"=>"GUINEA-BISSAU",
		"GY"=>"GUYANA",
		"GF"=>"GUYANA FRANCEZA",
		"HT"=>"HAITI",
		"VA"=>"HOLY SEE",
		"HN"=>"HONDURAS",
		"HK"=>"HONG KONG",
		"HU"=>"HUNGARY",
		"IS"=>"ICELAND",
		"IN"=>"INDIA",
		"ID"=>"INDONESIA",
		"UM"=>"INSULELE MINORE INDEPARTATE ALE STATELOR UNITE",
		"IB"=>"INTERNATIONAL BUREAU OF THE WORLD INTELLECTUAL PROPERTY ORGANIZATION (WIPO)",
		"IR"=>"IRAN (ISLAMIC REPUBLIC OF)",
		"IQ"=>"IRAQ",
		"IE"=>"IRELAND",
		"IM"=>"ISLE OF MAN",
		"IL"=>"ISRAEL",
		"IT"=>"ITALY",
		"JM"=>"JAMAICA",
		"JP"=>"JAPAN",
		"JO"=>"JORDAN",
		"KZ"=>"KAZAKSTAN",
		"KE"=>"KENYA",
		"KI"=>"KIRIBATI",
		"KW"=>"KUWAIT",
		"KG"=>"KYRGYZSTAN",
		"LA"=>"LAOS",
		"LV"=>"LATVIA",
		"LB"=>"LEBANON",
		"LS"=>"LESOTHO",
		"LR"=>"LIBERIA",
		"LY"=>"LIBYA",
		"LI"=>"LIECHTENSTEIN",
		"LT"=>"LITHUANIA",
		"LU"=>"LUXEMBOURG",
		"MO"=>"MACAU",
		"MG"=>"MADAGASCAR",
		"MW"=>"MALAWI",
		"MY"=>"MALAYSIA",
		"MV"=>"MALDIVES",
		"ML"=>"MALI",
		"MT"=>"MALTA",
		"MH"=>"MARCHALL ISLANDS",
		"MQ"=>"MARTINICA",
		"MR"=>"MAURITANIA",
		"MU"=>"MAURITIUS",
		"MX"=>"MEXICO",
		"FM"=>"MICRONESIA (FEDERATED STATES OF)",
		"MC"=>"MONACO",
		"MN"=>"MONGOLIA",
		"ME"=>"MONTENEGRO",
		"MS"=>"MONTSERRAT",
		"MA"=>"MOROCCO",
		"MZ"=>"MOZAMBIQUE",
		"MM"=>"MYANMAR",
		"NA"=>"NAMIBIA",
		"NR"=>"NAURU",
		"NP"=>"NEPAL",
		"NL"=>"NETHERLANDS",
		"AN"=>"NETHERLANDS ANTILLES",
		"NZ"=>"NEW ZEALAND",
		"NI"=>"NICARAGUA",
		"NE"=>"NIGER",
		"NG"=>"NIGERIA",
		"NU"=>"NIOUE",
		"NF"=>"NORFOLK,INSULE",
		"MP"=>"NORTHERN MARIANA ISLANDS",
		"NO"=>"NORWAY",
		"NC"=>"NOUA CALEDONIE",
		"EM"=>"OFFICE FOR HARMONIZATION IN THE INTERNAL MARKET (TRADEMARKS AND DESIGNS)",
		"OM"=>"OMAN",
		"PK"=>"PAKISTAN",
		"PW"=>"PALAU",
		"PA"=>"PANAMA",
		"PG"=>"PAPUA NEW GUINEA",
		"PY"=>"PARAGUAY",
		"PE"=>"PERU",
		"PH"=>"PHILIPPINES",
		"PN"=>"PITCAIRN",
		"PL"=>"POLAND",
		"PF"=>"POLINEZIA FRANCEZA",
		"PT"=>"PORTUGAL",
		"PR"=>"PUERTO RICO",
		"QA"=>"QATAR",
		"KR"=>"REPUBLIC OF KOREA",
		"MD"=>"REPUBLIC OF MOLDOVA",
		"RE"=>"REUNION",
		"RO"=>"ROMANIA",
		"RU"=>"RUSSIAN FEDERATION",
		"RW"=>"RWANDA",
		"SH"=>"SAINT HELENA",
		"KN"=>"SAINT KITTS AND NEVIS",
		"LC"=>"SAINT LUCIA",
		"VC"=>"SAINT VINCENT AND THE GRENADINES",
		"WS"=>"SAMOA",
		"SM"=>"SAN MARINO",
		"ST"=>"SAO TOME AND PRINCIPE",
		"SA"=>"SAUDI ARABIA",
		"SN"=>"SENEGAL",
		"RS"=>"SERBIA",
		"SC"=>"SEYCHELLES",
		"PM"=>"SF.PETRE SI MIQUELON",
		"SL"=>"SIERRA LEONE",
		"SG"=>"SINGAPORE",
		"SK"=>"SLOVAKIA",
		"SI"=>"SLOVENIA",
		"SB"=>"SOLOMON ISLANDS",
		"SO"=>"SOMALIA",
		"ZA"=>"SOUTH AFRICA",
		"GS"=>"SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS",
		"ES"=>"SPAIN",
		"LK"=>"SRI LANKA",
		"SD"=>"SUDAN",
		"SR"=>"SURINAME",
		"SJ"=>"SVALBARD SI INSULA JAN MAYEN",
		"SZ"=>"SWAZILAND",
		"SE"=>"SWEDEN",
		"CH"=>"SWITZERLAND",
		"SY"=>"SYRIA",
		"TW"=>"TAIWAN, PROVINCE OF CHINA",
		"TJ"=>"TAJIKISTAN",
		"TF"=>"TERITORIILE AUSTRALE FRANCEZE",
		"TH"=>"THAILAND",
		"MK"=>"THE FORMER YUGOSLAV REPUBLIC OF MACEDONIA",
		"TG"=>"TOGO",
		"TK"=>"TOKELAU",
		"TO"=>"TONGA",
		"TT"=>"TRINIDAD AND TOBAGO",
		"TN"=>"TUNISIA",
		"TR"=>"TURKEY",
		"TM"=>"TURKMENISTAN",
		"TC"=>"TURKS AND CAICOS ISLANDS",
		"TV"=>"TUVALU",
		"UG"=>"UGANDA",
		"UA"=>"UKRAINE",
		"AE"=>"UNITED ARAB EMIRATES",
		"GB"=>"UNITED KINGDOM",
		"TZ"=>"UNITED REPUBLIC OF TANZANIA",
		"US"=>"UNITED STATES OF AMERICA",
		"UY"=>"URUGUAY",
		"UZ"=>"UZBEKISTAN",
		"VU"=>"VANUATU",
		"VE"=>"VENEZUELA",
		"VN"=>"VIET NAM",
		"VG"=>"VIRGIN ISLANDS (BRITISH)",
		"VI"=>"VIRGIN ISLANDS OF THE UNITED STATES",
		"WF"=>"WALLIS SI FUTUNA,INSULE",
		"EH"=>"WESTERN SAHARA",
		"WO"=>"WIPO",
		"YE"=>"YEMEN",
		"YU"=>"YUGOSLAVIA",
		"ZR"=>"ZAIRE",
		"ZM"=>"ZAMBIA",
		"ZW"=>"ZIMBABWE",
		"NT"=>"ZONA NEUTRA"
		);
		$request = $this->getRequest();
		$this->errors = $request->getErrors();
		UtilsHelper::setFlashMsg('', UtilsHelper::MSG_ERROR);
		return "Success";
	}

	public function executeWebSearch()
	{

		$this->setLayout(false);
		$request = $this->getRequest();
		$params = $request->getParameterHolder()->getAll();

		if($this->getRequestParameter('submitted') == "submitted")
		{
			try
			{
				$searchOf= array();
				foreach ($params as $key => $param)
				{
					$parts = explode("-", $key);
					if($parts[0] == "field" && !empty($param))
					{
						$param = str_replace(
						array('+','-','&&','||','!','(',')','{','}','[',']','^','"','~',':','\\','.','/'),
						array('\+','\-','\&&','\||','\!','\(','\)','\{','\}','\[','\]','\^','\"','\~','\:','\\\\','\.','\/'),
						$param
						);
						$searchOf[$parts[1]] = trim($param);
					}
				}

				$this->searchOf = $searchOf;
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

				//echo "QUERY: ".$query;
				$q = Zend_Search_Lucene_Search_QueryParser::parse($query);

				//////////////////////// SEARCH EXECUTION ////////////////////
				$searchIndex = Zend_Search_Lucene::open(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'search/');
				//Zend_Search_Lucene::setResultSetLimit(100);
				$searchResults  = $searchIndex->find($q);
				
				//var_dump(get_class_methods($searchResults));
				//exit();
				//$this->count = count($searchResults);
				//$this->results = $searchResults;
				$this->pager = UtilsHelper::pager("Trademark", $searchResults, 1000);
				$this->count = $this->pager->getNbResults();
				$this->paging = $this->pager->paging();

				if($this->count)
					return "Results";
				else
					UtilsHelper::setFlashMsg("Няма намерени резултати", UtilsHelper::MSG_SUCCESS);
			}
			catch (Exception $e)
			{
				$this->error = $e->getMessage();
				UtilsHelper::setFlashMsg($e->getMessage(), UtilsHelper::MSG_ERROR);
			}
		}

		$this->countries = $arr = array(
		"BG"=>"БЪЛГАРИЯ",
		"AF"=>"AFGHANISTAN",
		"OA"=>"AFRICAN INTELLECTUAL PROPERTY ORGANIZATION (OAPI)",
		"AP"=>"AFRICAN REGIONAL INDUSTRIAL PROPERTY ORGANIZATION (ARIPO)",
		"AL"=>"ALBANIA",
		"DZ"=>"ALGERIA",
		"AS"=>"AMERICAN SAMOA",
		"AD"=>"ANDORRA",
		"AO"=>"ANGOLA",
		"AI"=>"ANGUILLA",
		"AQ"=>"ANTARCTICA",
		"AG"=>"ANTIGUA AND BARBUDA",
		"AR"=>"ARGENTINA",
		"AM"=>"ARMENIA",
		"AW"=>"ARUBA",
		"AU"=>"AUSTRALIA",
		"AT"=>"AUSTRIA",
		"AZ"=>"AZERBAIJAN",
		"BS"=>"BAHAMAS",
		"BH"=>"BAHRAIN",
		"BD"=>"BANGLADESH",
		"BB"=>"BARBADOS",
		"BY"=>"BELARUS",
		"BE"=>"BELGIUM",
		"BZ"=>"BELIZE",
		"BX"=>"BENELUX",
		"BJ"=>"BENIN",
		"BM"=>"BERMUDA",
		"BT"=>"BHUTAN",
		"BO"=>"BOLIVIA",
		"BA"=>"BOSNIA AND HERZEGOVINA",
		"BW"=>"BOTSWANA",
		"BV"=>"BOUVET ISLAND",
		"BR"=>"BRAZIL",
		"BN"=>"BRUNEI DARUSSALAM",
		"BF"=>"BURKINA FASO",
		"BI"=>"BURUNDI",
		"KH"=>"CAMBODIA",
		"CM"=>"CAMEROON",
		"CA"=>"CANADA",
		"CV"=>"CAPE VERDE",
		"KY"=>"CAYMAN ISLANDS",
		"CF"=>"CENTRAL AFRICAN REPUBLIC",
		"TD"=>"CHAD",
		"CS"=>"Channel Islands",
		"CL"=>"CHILE",
		"CN"=>"CHINA",
		"CX"=>"CHRISTMAS,INSULE",
		"CC"=>"COCOS,INSULE",
		"CO"=>"COLOMBIA",
		"KM"=>"COMOROS",
		"CG"=>"CONGO",
		"CK"=>"COOK ISLANDS",
		"CR"=>"COSTA RICA",
		"CI"=>"COTE D'IVOIRE",
		"HR"=>"CROATIA",
		"CU"=>"CUBA",
		"CW"=>"CURACAO",
		"CY"=>"CYPRUS",
		"CZ"=>"CZECH REPUBLIC",
		"KP"=>"DEMOCRATIC PEOPLE'S REPUBLIC OF KOREA",
		"DK"=>"DENMARK",
		"DJ"=>"DJIBOUTI",
		"DM"=>"DOMINICA",
		"DO"=>"DOMINICAN REPUBLIC",
		"TP"=>"EAST TIMOR",
		"EC"=>"ECUADOR",
		"EG"=>"EGYPT",
		"SV"=>"EL SALVADOR",
		"GQ"=>"EQUATORIAL GUINEA",
		"ER"=>"ERITREA",
		"EE"=>"ESTONIA",
		"ET"=>"ETHIOPIA",
		"EA"=>"EURASIAN PATENT ORGANIZATION (EAPO)",
		"EP"=>"EUROPEAN PATENT OFFICE (EPO)",
		"FK"=>"FALKLAND ISLANDS (MALVINAS)",
		"FO"=>"FAROE ISLANDS",
		"FJ"=>"FIJI",
		"FI"=>"FINLAND",
		"FR"=>"FRANCE",
		"GA"=>"GABON",
		"GM"=>"GAMBIA",
		"GE"=>"GEORGIA",
		"DE"=>"GERMANY",
		"GH"=>"GHANA",
		"GI"=>"GIBRALTAR",
		"GR"=>"GREECE",
		"GL"=>"GREENLAND",
		"GD"=>"GRENADA",
		"GP"=>"GUADELUPA",
		"GU"=>"GUAM",
		"GT"=>"GUATEMALA",
		"GN"=>"GUINEA",
		"GW"=>"GUINEA-BISSAU",
		"GY"=>"GUYANA",
		"GF"=>"GUYANA FRANCEZA",
		"HT"=>"HAITI",
		"VA"=>"HOLY SEE",
		"HN"=>"HONDURAS",
		"HK"=>"HONG KONG",
		"HU"=>"HUNGARY",
		"IS"=>"ICELAND",
		"IN"=>"INDIA",
		"ID"=>"INDONESIA",
		"UM"=>"INSULELE MINORE INDEPARTATE ALE STATELOR UNITE",
		"IB"=>"INTERNATIONAL BUREAU OF THE WORLD INTELLECTUAL PROPERTY ORGANIZATION (WIPO)",
		"IR"=>"IRAN (ISLAMIC REPUBLIC OF)",
		"IQ"=>"IRAQ",
		"IE"=>"IRELAND",
		"IM"=>"ISLE OF MAN",
		"IL"=>"ISRAEL",
		"IT"=>"ITALY",
		"JM"=>"JAMAICA",
		"JP"=>"JAPAN",
		"JO"=>"JORDAN",
		"KZ"=>"KAZAKSTAN",
		"KE"=>"KENYA",
		"KI"=>"KIRIBATI",
		"KW"=>"KUWAIT",
		"KG"=>"KYRGYZSTAN",
		"LA"=>"LAOS",
		"LV"=>"LATVIA",
		"LB"=>"LEBANON",
		"LS"=>"LESOTHO",
		"LR"=>"LIBERIA",
		"LY"=>"LIBYA",
		"LI"=>"LIECHTENSTEIN",
		"LT"=>"LITHUANIA",
		"LU"=>"LUXEMBOURG",
		"MO"=>"MACAU",
		"MG"=>"MADAGASCAR",
		"MW"=>"MALAWI",
		"MY"=>"MALAYSIA",
		"MV"=>"MALDIVES",
		"ML"=>"MALI",
		"MT"=>"MALTA",
		"MH"=>"MARCHALL ISLANDS",
		"MQ"=>"MARTINICA",
		"MR"=>"MAURITANIA",
		"MU"=>"MAURITIUS",
		"MX"=>"MEXICO",
		"FM"=>"MICRONESIA (FEDERATED STATES OF)",
		"MC"=>"MONACO",
		"MN"=>"MONGOLIA",
		"ME"=>"MONTENEGRO",
		"MS"=>"MONTSERRAT",
		"MA"=>"MOROCCO",
		"MZ"=>"MOZAMBIQUE",
		"MM"=>"MYANMAR",
		"NA"=>"NAMIBIA",
		"NR"=>"NAURU",
		"NP"=>"NEPAL",
		"NL"=>"NETHERLANDS",
		"AN"=>"NETHERLANDS ANTILLES",
		"NZ"=>"NEW ZEALAND",
		"NI"=>"NICARAGUA",
		"NE"=>"NIGER",
		"NG"=>"NIGERIA",
		"NU"=>"NIOUE",
		"NF"=>"NORFOLK,INSULE",
		"MP"=>"NORTHERN MARIANA ISLANDS",
		"NO"=>"NORWAY",
		"NC"=>"NOUA CALEDONIE",
		"EM"=>"OFFICE FOR HARMONIZATION IN THE INTERNAL MARKET (TRADEMARKS AND DESIGNS)",
		"OM"=>"OMAN",
		"PK"=>"PAKISTAN",
		"PW"=>"PALAU",
		"PA"=>"PANAMA",
		"PG"=>"PAPUA NEW GUINEA",
		"PY"=>"PARAGUAY",
		"PE"=>"PERU",
		"PH"=>"PHILIPPINES",
		"PN"=>"PITCAIRN",
		"PL"=>"POLAND",
		"PF"=>"POLINEZIA FRANCEZA",
		"PT"=>"PORTUGAL",
		"PR"=>"PUERTO RICO",
		"QA"=>"QATAR",
		"KR"=>"REPUBLIC OF KOREA",
		"MD"=>"REPUBLIC OF MOLDOVA",
		"RE"=>"REUNION",
		"RO"=>"ROMANIA",
		"RU"=>"RUSSIAN FEDERATION",
		"RW"=>"RWANDA",
		"SH"=>"SAINT HELENA",
		"KN"=>"SAINT KITTS AND NEVIS",
		"LC"=>"SAINT LUCIA",
		"VC"=>"SAINT VINCENT AND THE GRENADINES",
		"WS"=>"SAMOA",
		"SM"=>"SAN MARINO",
		"ST"=>"SAO TOME AND PRINCIPE",
		"SA"=>"SAUDI ARABIA",
		"SN"=>"SENEGAL",
		"RS"=>"SERBIA",
		"SC"=>"SEYCHELLES",
		"PM"=>"SF.PETRE SI MIQUELON",
		"SL"=>"SIERRA LEONE",
		"SG"=>"SINGAPORE",
		"SK"=>"SLOVAKIA",
		"SI"=>"SLOVENIA",
		"SB"=>"SOLOMON ISLANDS",
		"SO"=>"SOMALIA",
		"ZA"=>"SOUTH AFRICA",
		"GS"=>"SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS",
		"ES"=>"SPAIN",
		"LK"=>"SRI LANKA",
		"SD"=>"SUDAN",
		"SR"=>"SURINAME",
		"SJ"=>"SVALBARD SI INSULA JAN MAYEN",
		"SZ"=>"SWAZILAND",
		"SE"=>"SWEDEN",
		"CH"=>"SWITZERLAND",
		"SY"=>"SYRIA",
		"TW"=>"TAIWAN, PROVINCE OF CHINA",
		"TJ"=>"TAJIKISTAN",
		"TF"=>"TERITORIILE AUSTRALE FRANCEZE",
		"TH"=>"THAILAND",
		"MK"=>"THE FORMER YUGOSLAV REPUBLIC OF MACEDONIA",
		"TG"=>"TOGO",
		"TK"=>"TOKELAU",
		"TO"=>"TONGA",
		"TT"=>"TRINIDAD AND TOBAGO",
		"TN"=>"TUNISIA",
		"TR"=>"TURKEY",
		"TM"=>"TURKMENISTAN",
		"TC"=>"TURKS AND CAICOS ISLANDS",
		"TV"=>"TUVALU",
		"UG"=>"UGANDA",
		"UA"=>"UKRAINE",
		"AE"=>"UNITED ARAB EMIRATES",
		"GB"=>"UNITED KINGDOM",
		"TZ"=>"UNITED REPUBLIC OF TANZANIA",
		"US"=>"UNITED STATES OF AMERICA",
		"UY"=>"URUGUAY",
		"UZ"=>"UZBEKISTAN",
		"VU"=>"VANUATU",
		"VE"=>"VENEZUELA",
		"VN"=>"VIET NAM",
		"VG"=>"VIRGIN ISLANDS (BRITISH)",
		"VI"=>"VIRGIN ISLANDS OF THE UNITED STATES",
		"WF"=>"WALLIS SI FUTUNA,INSULE",
		"EH"=>"WESTERN SAHARA",
		"WO"=>"WIPO",
		"YE"=>"YEMEN",
		"YU"=>"YUGOSLAVIA",
		"ZR"=>"ZAIRE",
		"ZM"=>"ZAMBIA",
		"ZW"=>"ZIMBABWE",
		"NT"=>"ZONA NEUTRA"
		);

	}

	public function executeSearchResults()
	{

	}

	public function executeImportSessions()
	{
		$this->setLayout(false);
		
		if ($page = Document::getDocumentByExclusiveTag('website_page_import_session_report'))
		{
			$this->reportHref = $page->getHref();
		}
		else
		{
			$this->reportHref = '#';
		}

		$c = new Criteria();
		$importsArr = ImportSessionPeer::doSelect($c);
		$this->importsArr = array_reverse($importsArr);
	}

	public function executeImportSessionReports()
	{
		$this->setLayout(false);
		
		if($dids = $this->getRequestParameter("del"))
		{

			if($this->getUser()->isAuthenticated())
			{
				foreach ($dids as $did)
				{
					$doc = Document::getDocumentInstance($did);
					if($doc) $doc->delete();
				}
			}
		}
		$this->is = Document::getDocumentInstance($this->getRequestParameter("is"));
		$matches = Document::getChildrenOf($this->getRequestParameter("is"), "SearchMatch");
		$this->pager = UtilsHelper::pager("SearchMatch", $matches, 10000);
		$this->count = $this->pager->getNbResults();
		$this->paging = $this->pager->paging();
	}

	public function executeSearchTemplates()
	{
		$this->setLayout(false);

		if ($page = Document::getDocumentByExclusiveTag('website_page_add_search_template'))
		{
			$this->addHref = $page->getHref();
		}
		else
		{
			$this->addHref = '#';
		}
		$root = Rootfolder::getRootfolderByModule('search');
		$brands = Document::getChildrenOf($root->getId(), 'Brand');
		foreach ($brands as $b)
		{
			if ($items = Document::getChildrenOf($b->getId(), 'Search'))
			{
				$searchTemplates[$b->getId()] = $items;
			}
		}
		$this->brands = $brands;
		$this->searchTemplates = $searchTemplates;
	}

	public function executeRemoveTemplate()
	{
		$obj = Document::getDocumentInstance($this->getRequestParameter('id'));
		if ($obj && get_class($obj) == 'Search')
		{
			$obj->delete();
			exit('OK');
		}
		exit('NO');
	}

	public function executeAddSearchTemplate()
	{
		$this->setLayout(false);

		$root = Rootfolder::getRootfolderByModule('search');
		$brands = Document::getChildrenOf($root->getId(), 'Brand');
		foreach ($brands as $b)
		{
			$brandsArr[$b->getId()] = $b->getLabel();
		}
		$this->brands = $brandsArr;

		$success = false;
		if ($objId = $this->getRequestParameter('obj_id'))
		{
			$search = Document::getDocumentInstance($objId); //var_dump($search);
		}
		else
		{
			$search = new Search();
		}
		if ($this->getRequestParameter('submit') > '')
		{
			// check input data
			$request = $this->getRequest();
			$params = $request->getParameterHolder()->getAll(); //var_dump($params);

			$brandId = $params['brand'];
			$brand = Document::getDocumentInstance($brandId); //var_dump($brand);
			$fields = array(
			'label',
			'application_number',
			'register_number',
			'registration_date',
			'application_date',
			'expires_on',
			'vienna_classes',
			'nice_classes',
			'rights_owner',
			'rights_representative',
			'office_of_origin',
			'designated_contracting_party'
			);
			/*
			$search->setLabel($params['label']);
			$search->setRightsOwner($params['rights_owner']);
			$search->setApplicationNumber($params['application_number']);
			$search->setRegisterNumber($params['register_number']);
			$search->setRegistrationDate ($params['registration_date']);
			$search->setApplicationDate($params['application_date']);
			$search->setStatus($params['status']);
			$search->setExpiresOn($params['expires_on']);
			$search->setViennaClasses($params['vienna_classes']);
			$search->setNiceClasses($params['nice_classes']);
			//$search->setrightsOwnerAddress($params['rights_owner_address']);
			$search->setRightsRepresentative($params['rights_representative']);
			//$search->setRightsRepresentativeAddress($params['rights_representative_address']);
			$search->setOfficeOfOrigin($params['office_of_origin']);
			$search->setDesignatedContractingParty($params['designated_contracting_party']);
			*/
			$notEmpty = 0;
			foreach ($fields as $fl)
			{
				$setter = 'set'.UtilsHelper::convertFieldName($fl);
				if (isset($params[$fl]))
				{
					$v = trim($params[$fl]);
					if ($v)
					{
						$notEmpty++;
					}
					$search->{$setter}($v);
				}
				else
				{
					$search->{$setter}(null);
				}
			}
			if ($notEmpty > 0)
			{
				$search->save(null, $brand);
				$success = true;
			}
			else
			{
				UtilsHelper::setFlashMsg('Моля, въведете критерии за търсене!', UtilsHelper::MSG_ERROR);
			}
			//var_dump($search);
		}
		$this->success = $success;
		$this->obj = $search;
	}

}
