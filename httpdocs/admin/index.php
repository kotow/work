<?php
ini_set("memory_limit","64M");
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'backend');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfConfig::set("sf_use_relations_cache", false);
sfContext::getInstance()->getController()->dispatch();