<?php 
ini_set("memory_limit", "256M");
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'panel');
date_default_timezone_set('Europe/Sofia');

define('SF_ENVIRONMENT', 'prod'); define('SF_DEBUG',       false);
//define('SF_ENVIRONMENT', 'dev'); define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfConfig::set("sf_use_relations_cache", false);
sfContext::getInstance()->getController()->dispatch();