<?php
class madbActions extends sfActions
{

  public function preExecute()
  {
    $this->madbcontext = $this->getMadbContext();
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



}
