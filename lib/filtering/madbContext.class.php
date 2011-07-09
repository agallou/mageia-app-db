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
  
  public function getFiltersParameters()
  {
    $filtersIteratorFactory = new filtersIteratorFactory();
    $filtersIterator = $filtersIteratorFactory->create();
    $allParameters = $this->getParameterHolder()->getAll();
    $filtersNames  = array();
    foreach ($filtersIterator as $filter)
    {
      $filtersNames[] = $filter->getCode();
    }
    $filtersParameters = array();
    foreach ($allParameters as $name => $parameter)
    {
      if (in_array($name, $filtersNames))
      {
        $filtersParameters[$name] = $parameter;
      }
    }
    return $filtersParameters;
  }

}
