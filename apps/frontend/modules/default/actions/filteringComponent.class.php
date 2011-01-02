<?php 
class filteringComponent extends sfComponent
{
  public function execute($request)
  {
    $this->form    = formFactory::create($this->getMadbContext());
    $filters       = array();
    $filterFactory = new filterFactory();
    foreach ($this->form as $field)
    {
      if (!count($field->getValue()))
      {
        continue;
      }
      $filter       = $filterFactory->create($field->getName());
      $filterValues = $filter->getValues();
      $displayedValues = array();
      foreach ($field->getValue() as $value)
      {
         $displayedValues[] = $filterValues[$value];
      }
      $filters[$field->getName()] = $displayedValues;
    }
    $this->filters = $filters;
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
