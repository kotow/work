<?php
// auto-generated by sfViewConfigHandler
// date: 2015/09/01 17:36:52
$context  = $this->getContext();
$response = $context->getResponse();


  $templateName = $response->getParameter($this->moduleName.'_'.$this->actionName.'_template', $this->actionName, 'symfony/action/view');
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (!$context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);
  $response->addMeta('title', '', false, false);
  $response->addMeta('robots', 'index, follow', false, false);
  $response->addMeta('description', '', false, false);
  $response->addMeta('keywords', '', false, false);
  $response->addMeta('language', 'en', false, false);




