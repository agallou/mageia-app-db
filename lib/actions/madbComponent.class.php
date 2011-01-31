<?php
abstract class madbComponent extends sfComponent
{

  public function __construct($context, $moduleName, $actionName)
  {
    parent::__construct($context, $moduleName, $actionName);
    $this->varHolder = new madbRequiredParameterHolder();
    $this->varHolder->setRequiredParameters($this->getRequiredVars());
    $this->varHolder->set('madbcontext', $this->getMadbContext());
    $this->varHolder->set('madburl', $this->getMadbUrl());
  }

  protected function getMadbContext()
  {
    $contextFactory = new contextFactory();
    return $contextFactory->createFromRequest($this->getRequest());
  }

  protected function getCriteria($perimeter)
  {
    $criteriaFactory = new criteriaFactory();
    return $criteriaFactory->createFromContext($this->getMadbContext(), $perimeter);
  }
  
  protected function getMadbUrl()
  {
    return new madbUrl($this->getContext());
  }

  protected function getRequiredVars()
  {
    return array();
  }

}
