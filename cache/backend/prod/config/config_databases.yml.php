<?php
// auto-generated by sfDatabaseConfigHandler
// date: 2015/09/01 13:56:04

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'host' => '127.0.0.1',
  'database' => 'tm_marks',
  'username' => 'root',
  'password' => 'root',
  'encoding' => 'utf8',
), 'propel');
$this->databases['propel'] = $database;

$database = new sfPropelDatabase();
$database->initialize(array (
  'phptype' => 'mysql',
  'host' => '127.0.0.1',
  'database' => 'tm_marks',
  'username' => 'root',
  'password' => 'root',
  'encoding' => 'utf8',
), 'tm_marks');
$this->databases['tm_marks'] = $database;