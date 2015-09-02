<?php
pake_task('index-documents', 'project_exists');
pake_alias('id', 'index-documents');

function run_index_documents($task, $args)
{
	
	try
	{
		define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
		define('SF_APP',         'backend');
		define('SF_ENVIRONMENT', 'prod');
		define('SF_DEBUG',       false);

		require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

		ini_set("memory_limit","2048M");
		ini_set("display_errors", 1);
	
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		$search_config_file = SF_ROOT_DIR.'/config/search.xml';
		$documents = simplexml_load_file($search_config_file);
		$all = 0;

		$search_index_path = SF_ROOT_DIR.'/cache/search/';
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
		$search_index->setMaxBufferedDocs(20000);
		Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive());
		$ndoc = 0;

		
		foreach ($documents as $document)
		{
			$document_name = $document->attributes();
			if(array_key_exists(0, $args) && $document_name != $args[0]) continue;

			echo "Indexing ".$document_name."\n";

			$classPeer = $document_name.'Peer';
			$c = new Criteria();

			$document_instances = call_user_func(array($classPeer, 'doSelect'), $c);

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
	catch (Exception $e)
	{
		echo_cms_error("ERROR ADD_DOCUMENT : ".$e->getMessage());
	}
	echo echo_cms_sep();
	exit();
}