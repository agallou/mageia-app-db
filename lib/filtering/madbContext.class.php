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
    return $this->parameterHolder->get($name);
  }

}
