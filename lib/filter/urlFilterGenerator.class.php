<?php
class urlFilterGenerator
{

  protected $patternRouting;
  protected $madbUrl;

  public function __construct(sfPatternRouting $patternRouting, madbUrl $madbUrl)
  {
    $this->patternRouting = $patternRouting;
    $this->madbUrl        = $madbUrl;
  }

  /**
   *  
   **/
  public function generate($cleanUrls, $phpSelf, $url, array $extraParams = array())
  {
//var_export(func_get_args());
    // If httpd configuration uses an alias, get it's name
    $matches = array();
    preg_match('#^(.*)/.+\.php#', $phpSelf, $matches);
    $alias = $matches[1] ? $matches[1] : '';

    $matches = array();
    preg_match('#^' . $alias . '(/.+\.php)?(/.*)#', $url, $matches);
    $url = $matches[2];
    
    $parsedUrl   = $this->patternRouting->parse($url);
    $routing     = $parsedUrl['_sf_route'];
    $parameters  = $routing->getParameters();

    unset($parameters['module']);
    unset($parameters['action']);
    unset($parameters['sf_culture']);

    $baseParams  = $parameters;

    $filtersIteratorFactory = new filtersIteratorFactory();
    $filterIterator         = $filtersIteratorFactory->create();
    foreach ($filterIterator as $filter)
    {
      unset($parameters[$filter->getCode()]);
      if ($cleanUrls && isset($extraParams[$filter->getCode()]))
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

    $newUrl  = $this->getMadbUrl()->urlFor(sprintf('%s/%s', $parsedUrl['module'], $parsedUrl['action']), null, array(
      'extra_parameters'    => $parameters,
      'absolute'            => true,
      'keep_all_parameters' => true,
      'ignored_parameters'  => array('page')
    ));
    $changed = (int)(bool)(count(array_diff_assoc($baseParams, $parameters)) + count(array_diff_assoc($parameters, $baseParams)));

    return array(
      'new_url' => $newUrl,
      'changed' => $changed,
    );
  }

  public function getMadbUrl()
  {
    return $this->madbUrl;
  }

}
