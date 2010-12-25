<?php
class getUrlAction extends madbActions
{

  public function execute($request)
  {
    $url         = $request->getParameter('baseurl');
    $extraParams = $request->getParameter('extraParams');

    $url         = base64_decode($url);
    $url         = substr($url , strpos($url, '.php') + 4);
    $parsedUrl   = $this->getContext()->getRouting()->parse($url);
    $routing     = $parsedUrl['_sf_route'];
    $parameters  = $routing->getParameters();

    unset($parameters['module']);
    unset($parameters['action']);
    unset($parameters['sf_culture']);

    foreach ($extraParams as $name => $parameter)
    {
      if (is_array($parameter))
      {
       $parameters[$name] = implode(',', $parameter);
      }
    }

    $newUrl = sprintf('%s/%s?%s', $parsedUrl['module'], $parsedUrl['action'], http_build_query($parameters));
    $this->getContext()->getConfiguration()->loadHelpers('Url');
    $this->newUrl = url_for($newUrl, true);
    $this->getResponse()->sethttpHeader('Content-type','application/json');

  }

}
