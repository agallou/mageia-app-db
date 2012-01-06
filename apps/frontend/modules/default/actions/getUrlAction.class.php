<?php
class getUrlAction extends madbActions
{

  public function execute($request)
  {
    $madbConfig = new madbConfig();
    $clean_urls = $madbConfig->get('clean-urls');
    
    $url         = $request->getParameter('baseurl');
    if ($request->hasParameter('extraParams'))
    {
      $extraParams = $request->getParameter('extraParams');
    }
    else
    {
      $extraParams = array();
    }

    $url   = base64_decode($url);

    
    // If httpd configuration uses an alias, get it's name
    $matches = array();
    preg_match('#^(.*)/.+\.php#', $_SERVER['PHP_SELF'], $matches);
    $alias = $matches[1] ? $matches[1] : '';
    
    $matches = array();
    preg_match('#^' . $alias . '(/.+\.php)?(/.*)#', $url, $matches);
    $url = $matches[2];
    
    $parsedUrl   = $this->getContext()->getRouting()->parse($url);
    $routing     = $parsedUrl['_sf_route'];
    $parameters  = $routing->getParameters();

    unset($parameters['module']);
    unset($parameters['action']);
    unset($parameters['sf_culture']);

    $baseParams  = $parameters;

    $filtersIteratorFactory = new filtersIteratorFactory();
    $filterIterator        = $filtersIteratorFactory->create();
    foreach ($filterIterator as $filter)
    {
      unset($parameters[$filter->getCode()]);
      if ($clean_urls && isset($extraParams[$filter->getCode()]))
      { 
        if (array($filter->getDefault()) == $extraParams[$filter->getCode()])
        {
          unset($extraParams[$filter->getCode()]);
        }
      }
    }

    foreach ($extraParams as $name => $parameter)
    {
      if (is_array($parameter))
      {
       $parameters[$name] = implode(',', $parameter);
      }
    }
    $this->newUrl = $this->getMadbUrl()->urlFor(sprintf('%s/%s', $parsedUrl['module'], $parsedUrl['action']), null, array(
      'extra_parameters'   => $parameters,
      'absolute'           => true,
      'ignored_parameters' => array('page'),
    ));
    $this->changed = (int)(bool)(count(array_diff_assoc($baseParams, $parameters)) + count(array_diff_assoc($parameters, $baseParams)));
    $this->getResponse()->sethttpHeader('Content-type','application/json');
  }

  public function getDefaultParameters()
  {
    return array();
  }

}
