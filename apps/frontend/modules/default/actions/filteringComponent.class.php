<?php 
class filteringComponent extends sfComponent
{
  public function execute($request)
  {
    $this->form  = formFactory::create($this->getMadbContext());
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
