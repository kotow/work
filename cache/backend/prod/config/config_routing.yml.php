<?php
// auto-generated by sfRoutingConfigHandler
// date: 2015/09/01 13:56:04
$routes = sfRouting::getInstance();
$routes->setRoutes(
array (
  'homepage' => 
  array (
    0 => '/',
    1 => '/^[\\/]*$/',
    2 => 
    array (
    ),
    3 => 
    array (
    ),
    4 => 
    array (
      'module' => 'admin',
      'action' => 'index',
    ),
    5 => 
    array (
    ),
    6 => '',
  ),
  'listmodules' => 
  array (
    0 => '/listmodules',
    1 => '#^/listmodules$#',
    2 => 
    array (
    ),
    3 => 
    array (
    ),
    4 => 
    array (
      'module' => 'admin',
      'action' => 'listmodules',
    ),
    5 => 
    array (
    ),
    6 => '',
  ),
  'default_symfony' => 
  array (
    0 => '/symfony/:action/*',
    1 => '#^/symfony(?:\\/([^\\/]+))?(?:\\/(.*))?$#',
    2 => 
    array (
      0 => 'action',
    ),
    3 => 
    array (
      'action' => 1,
    ),
    4 => 
    array (
      'module' => 'default',
    ),
    5 => 
    array (
    ),
    6 => '',
  ),
  'default_index' => 
  array (
    0 => '/:module',
    1 => '#^(?:\\/([^\\/]+))?$#',
    2 => 
    array (
      0 => 'module',
    ),
    3 => 
    array (
      'module' => 1,
    ),
    4 => 
    array (
      'action' => 'index',
    ),
    5 => 
    array (
    ),
    6 => '',
  ),
  'default' => 
  array (
    0 => '/:module/:action/*',
    1 => '#^(?:\\/([^\\/]+))?(?:\\/([^\\/]+))?(?:\\/(.*))?$#',
    2 => 
    array (
      0 => 'module',
      1 => 'action',
    ),
    3 => 
    array (
      'module' => 1,
      'action' => 1,
    ),
    4 => 
    array (
    ),
    5 => 
    array (
    ),
    6 => '',
  ),
  'login' => 
  array (
    0 => '/login',
    1 => '#^/login$#',
    2 => 
    array (
    ),
    3 => 
    array (
    ),
    4 => 
    array (
      'module' => 'user',
      'action' => 'login',
    ),
    5 => 
    array (
    ),
    6 => '',
  ),
)
);
