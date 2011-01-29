<?php
abstract class madbComponent extends sfComponent
{

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

}
