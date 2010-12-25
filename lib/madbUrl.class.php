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
    $absolute = isset($options['absolute']) && $options['absolute'];
    //TODO get context parameters
    $parameters = array();
    if (isset($options['extra_parameters']) && is_array($options['extra_parameters']))
    {
      $parameters = array_merge($parameters, $options['extra_parameters']);
    }
    if (null !== $madbContext)
    {
      $parameters = array_merge($parameters, $madbContext->getFiltersParameters());
    }
    $uri = $internalUri . '?' . http_build_query($parameters);
    return $this->controller->genUrl($uri, $absolute);
  }

}
