<?php 

function remote_pager($options = array(), $pager = null)
{
  if($pager && ($pager->getNextPage() == $pager->getPage() || $pager->getPage()!= 1))
  {
    return; 
  } 
  
  // name of the page request parameter (default 'page')
  $options['page_name'] = isset($options['page_name']) ? $options['page_name'] : 'page';
  
  // frequency of the scroll check (default 1 second)
  $options['frequency'] = isset($options['frequency']) ? $options['frequency'] : 1; 
  
  // scroll offset (in pixels, from the bottom) triggering the remote call (default 30px)
  $options['trigger']   = isset($options['trigger']) ? $options['trigger'] : '30';

  $options['position']  = isset($options['position']) ? $options['position']  : 'before';
  
  use_helper('Javascript');
  
  sfContext::getInstance()->getResponse()->addJavascript('/sf/js/prototype/prototype');
  
  $javascript_callback = 'ajax_pager_semaphore = 0; ajax_pager_page++;';  
  if($pager)
  {
    // build in the stop of the PeriodicalExecuter when the pager reaches the last page
    $javascript_callback .= 'if(ajax_pager_page>'.$pager->getLastPage().') { pager_watch.callback = function () {}; };';
  }
  $options['success']   = isset($options['success']) ? $options['success'].$javascript_callback : $javascript_callback;
  
  return javascript_tag("
  var ajax_pager_semaphore = 0;
  var ajax_pager_page = 2;

  function sf_ajax_next_page()
  {
    if (ajax_pager_semaphore == 0)
    {
      ajax_pager_semaphore = 1;
      new Ajax.Updater(
        '".$options['update']."', 
        '".url_for($options['url']).'?'.$options['page_name']."='+ajax_pager_page,
        "._options_for_ajax($options)."
      );
    }
  } 

  pager_watch = new PeriodicalExecuter(function() 
  {
     var scrollpos = window.pageYOffset || document.body.scrollTop || document.documentElement.scrollTop;
     var windowsize = window.innerHeight || document.documentElement.clientHeight;
     var testend = document.body.clientHeight - (windowsize + scrollpos);
     
     if ( (testend < ".$options['trigger'].") )
     {
       sf_ajax_next_page();
     }
  }, ".$options['frequency'].");");
  
}

function stop_remote_pager()
{
  use_helper('Javascript');
  
  // until prototype implements a stop() method for the PeriodicalExecuter,
  // the following (almost a hack) is the only simple way to stop it
  
  return javascript_tag("pager_watch.callback = function () {};"); 
}

function pager_navigation($pager, $uri)
{
  $navigation = '';
 
  if ($pager->haveToPaginate())
  {  
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';
 
    // First and previous page
    if ($pager->getPage() != 1)
    {
      $navigation .= link_to(image_tag('/sf/images/sf_admin/first.png', 'align=absmiddle'), $uri.'1');
      $navigation .= link_to(image_tag('/sf/images/sf_admin/previous.png', 'align=absmiddle'), $uri.$pager->getPreviousPage()).'&nbsp;';
    }
 
    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page)
    {
      $links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page);
    }
    $navigation .= join('&nbsp;&nbsp;', $links);
 
    // Next and last page
    if ($pager->getPage() != $pager->getLastPage())
    {
      $navigation .= '&nbsp;'.link_to(image_tag('/sf/images/sf_admin/next.png', 'align=absmiddle'), $uri.$pager->getNextPage());
      $navigation .= link_to(image_tag('/sf/images/sf_admin/last.png', 'align=absmiddle'), $uri.$pager->getLastPage());
    }
 
  }
 
  return $navigation;
}

 ?>