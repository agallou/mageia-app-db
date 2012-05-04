<?php
class madbUrl
{

  protected $controller = null;
  protected $routing    = null;
  
  //TODO only controller ??
  public function __construct(sfContext $context)
  {
    $this->initialize($context);
  }

  protected function initialize(sfContext $context)
  {
    $this->controller = $context->getController();
  }

  /**
   *
   * Options : 
   *  absolute
   *  extra_parameters
   */
  public function urlFor($internalUri, madbContext $madbContext = null, $options = array())
  {
    $absolute   = isset($options['absolute']) && $options['absolute'];
    $madbConfig = new madbConfig();
    $clean_urls = $madbConfig->get('clean-urls');
    // remove default filters from URL if needed
    $clear_defaults = $clean_urls && (!isset($options['clear_defaults']) || $options['clear_defaults']);
    $parameters = array();
    if (isset($options['extra_parameters']) && is_array($options['extra_parameters']))
    {
      $parameters = array_merge($parameters, $options['extra_parameters']);
    }
    if (null !== $madbContext)
    {
      $myMadbContext = clone $madbContext;
      if ($clear_defaults)
      {
        $myMadbContext->removeDefaultFilters();
      }
      // Keep only filters vs all parameters from context
      if (isset($options['keep_all_parameters']) && $options['keep_all_parameters'])
      {
        // merge order is important : $parameters last in order to make extra_parameters win in case of conflict
        $parameters = array_merge(
          $myMadbContext->getParameterHolder()->getAll(),
          $parameters
        );
      }
      else
      {
        // merge order is important : $parameters last in order to make extra_parameters win in case of conflict
        $parameters = array_merge(
          $myMadbContext->getFiltersParameters(),
          $parameters
        );
      }
    }
    if (isset($options['ignored_parameters']) && is_array($options['ignored_parameters']))
    {
      foreach ($options['ignored_parameters'] as $ignoredparameter)
      {
        unset($parameters[$ignoredparameter]);
      }
    }
    $uri = $internalUri . '?' . http_build_query($parameters);
    return $this->controller->genUrl($uri, $absolute);
  }

  
  public function urlForRpm(Rpm $rpm, madbContext $madbContext = null, $options = array())
  {
    return $this->urlFor(
      'rpm/show', 
      $madbContext, 
      sfToolkit::arrayDeepMerge(
        $options,
        array(
          'extra_parameters' => array(
            'name'        => $rpm->getName(),
            'source'      => $rpm->getIsSource(),
            'release'     => $rpm->getDistrelease()->getName(),
            'arch'        => $rpm->getArch()->getName(),
            't_media' => $rpm->getMediaId()
          ),
          'clear_defaults' => false  
        )
      )
    );
  }
}
