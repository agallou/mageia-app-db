<?php
class getUrlAction extends madbActions
{

  public function execute($request)
  {
    $url         = $request->getParameter('baseurl');
    if ($request->hasParameter('extraParams'))
    {
      $extraParams = $request->getParameter('extraParams');
    }
    else
    {
      $extraParams = array();
    }

    $url         = base64_decode($url);
    $url         = substr($url , strpos($url, '.php') + 4);

    $parsedUrl   = $this->getContext()->getRouting()->parse($url);
    $routing     = $parsedUrl['_sf_route'];
    $parameters  = $routing->getParameters();

    unset($parameters['module']);
    unset($parameters['action']);
    unset($parameters['sf_culture']);

    $filterIteratorFactory = new filterIteratorFactory();
    $filterIterator        = $filterIteratorFactory->create();
    foreach ($filterIterator as $filter)
    {
      unset($parameters[$filter->getCode()]);
    }

    foreach ($extraParams as $name => $parameter)
    {
      if (is_array($parameter))
      {
       $parameters[$name] = implode(',', $parameter);
      }
    }

    $this->newUrl = $this->getMadbUrl()->urlFor(sprintf('%s/%s', $parsedUrl['module'], $parsedUrl['action']), null, array(
      'extra_parameters' => $parameters,
      'absolute'         => true,
    ));
    $this->getResponse()->sethttpHeader('Content-type','application/json');
  }

  public function getDefaultParameters()
  {
    return array();
  }

}
