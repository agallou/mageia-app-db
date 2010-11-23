<?php
class madbActions extends sfActions
{

  public function preExecute()
  {
    $this->madbcontext = $this->getMadbContext();
  }

  protected function getMadbContext()
  {
    return contextFactory::createFromRequest($this->getRequest());
  }

  protected function getCriteria($perimeter)
  {
    return criteriaFactory::createFromContext($this->getMadbContext(), $perimeter);
  }



}
