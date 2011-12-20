<?php
class madbContext
{

  protected $parameterHolder;

  public function __construct(contextParameterHolderInterface $parameterHolder)
  {
    $this->parameterHolder = $parameterHolder;
  }

  public function getParameter($name)
  {
    return $this->getParameterHolder()->get($name);
  }

  public function getParameterHolder()
  {
    return $this->parameterHolder;
  }

  public function hasParameter($name)
  {
    return $this->getParameterHolder()->has($name);
  }
  
  public function removeParameter($name, $default=null)
  {
    return $this->parameterHolder->remove($name, $default);
  }

  /**
   *
   * @return array associative array of filter parameters found in request (URL)
   */
  public function getFiltersParameters($get_also_temp_filters = false)
  {
    $filtersIteratorFactory = new filtersIteratorFactory();
    $filtersIterator = $filtersIteratorFactory->create();
    $allParameters = $this->getParameterHolder()->getAll();
    $filtersParameters = array();
    foreach ($filtersIterator as $filter)
    {
      $name = $filter->getCode();
      if (array_key_exists($name, $allParameters))
      {
        $filtersParameters[$name] = $allParameters[$name];
      }
      elseif ($get_also_temp_filters && array_key_exists("t_$name", $allParameters))
      {
        $filtersParameters[$name] = $allParameters[$t_name];
      }
    }
    return $filtersParameters;
  }

  /**
   *
   * @param string $filtername name of a filter
   * @return string value
   */
  public function getRealFilterValue($filtername)
  {
    $filterFactory = new filterFactory();
    $filter = $filterFactory->create($filtername);
    $filter->setMadbContext($this);
    return $filter->getValue();
  }
  
  /**
   * 
   *  Removes all filters from the parameterHolder, but not other entries
   */
  public function removeAllFilters($remove_also_temp_filters = false)
  {
    foreach ($this->getFiltersParameters($remove_also_temp_filters) as $name => $value)
    {
      $this->removeParameter($name);
    }
  }
  
  public function removeDefaultFilters()
  {
    $filterFactory = new filterFactory();
    foreach ($this->getFiltersParameters() as $name => $value)
    {
      $filter = $filterFactory->create($name);
      if ($filter->hasDefault() && $filter->getDefault() == $value)
      {
        $this->removeParameter($name);
      }
    }
  }
}
