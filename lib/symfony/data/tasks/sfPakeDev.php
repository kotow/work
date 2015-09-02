<?php

pake_task('dm', 'project_exists');
pake_task('di', 'project_exists');
pake_task('dis', 'project_exists');
pake_task('dt', 'project_exists');

function run_dm($task, $args)
{

	ini_set("memory_limit","6146M");
	ini_set("display_errors", 1);
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       true);
	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();

	sfConfig::set('sf_cache_objects', false);
	sfConfig::set('sf_cache_relations', false);
	sfConfig::set('sf_use_relations_cache', false);
	
	$c = new Criteria();
	//$c->add(ImportSessionPeer::CREATED_AT, "2014-10-12", Criteria::GREATER_THAN);
	//$c->add(ImportSessionPeer::IMPORT_ID, null, Criteria::ISNOTNULL);
	$c->addJoin(ImportSessionPeer::IMPORT_ID, ImportPeer::ID, Criteria::LEFT_JOIN);
	$c->add(ImportPeer::SYSTEM, 3);
	$c->add(ImportSessionPeer::CREATED_AT, "2014-11-21", Criteria::GREATER_EQUAL );
	$importSessions = ImportSessionPeer::doSelect($c);
	$i = 1;	
	foreach ($importSessions as $importSession)
	{
		$res = Document::getChildrenOf($importSession->getId(), "SearchMatch");
		foreach ($res as $r)
		{
			$r->delete();
			echo ".";
		}
		$importSession->delete();
		echo "+";
		$search_index_path = SF_ROOT_DIR.'/cache/search/'.$importSession->getId();
		echo "DELETING ".$search_index_path."\n";
		exec("rm -fr $search_index_path");
		
		echo $i."\n";
		$i++;
	}
	
	sfConfig::set('sf_cache_objects', true);
	sfConfig::set('sf_cache_relations', true);
	sfConfig::set('sf_use_relations_cache', true);
	
	exit("\n");
}

function run_di($task, $args)
{
	ini_set("memory_limit","1024M");
	ini_set("display_errors", 1);
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       true);
	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();
	
	$c = new Criteria();
	$c->add(ImportPeer::STATUS, "error");
	$c->add(ImportPeer::SIZE, 36511);
	$c->add(ImportPeer::SYSTEM, 3);
	$imports = ImportPeer::doSelect($c);
	
	foreach ($imports as $import)
	{
		$import->delete();
		echo ".";
	}
	exit("\n");
}

function run_dis($task, $args)
{
	
	
	ini_set("memory_limit","1024M");
	ini_set("display_errors", 1);
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       true);
	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();
	
	$c = new Criteria();
	$c->add(ImportSessionPeer::CREATED_AT, "2014-10-21", Criteria::GREATER_EQUAL );
	$imports = ImportSessionPeer::doSelect($c);
	$i= 0;
	foreach ($imports as $import)
	{
		$i++;
		$import->delete();
		echo ".";
	}
	
	exit(">>".$i."\n");
}

function run_dt($task, $args)
{
	
	
	ini_set("memory_limit","1024M");
	ini_set("display_errors", 1);
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       true);
	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();
	
	sfConfig::set('sf_cache_objects', false);
	sfConfig::set('sf_cache_relations', false);
	sfConfig::set('sf_use_relations_cache', false);
	
	$c = new Criteria();
	$c->add(TrademarkPeer::FROM_SYSTEM, 3);
	$imports = TrademarkPeer::doSelect($c);
	$i= 0;
	foreach ($imports as $import)
	{
		$i++;
		$import->delete();
		echo ".";
	}
	
	sfConfig::set('sf_cache_objects', true);
	sfConfig::set('sf_cache_relations', true);
	sfConfig::set('sf_use_relations_cache', true);
	
	exit(">>".$i."\n");
}
?>