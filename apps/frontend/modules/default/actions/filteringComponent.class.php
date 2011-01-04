<?php 
class filteringComponent extends sfComponent
{
  public function execute($request)
  {
    $this->form    = formFactory::create($this->getMadbContext());
    $filters       = array();
    $filterFactory = new filterFactory();
    $this->unremoveableFilters = array();
    foreach ($this->form as $field)
    {
      if (!count($field->getValue()))
      {
        continue;
      }
      $filter          = $filterFactory->create($field->getName());
      $filterValues    = $filter->getValues();
      $displayedValues = array();
      foreach ($field->getValue() as $value)
      {
        $displayedValues[] = $filterValues[$value];
      }
      $filters[$field->getName()] = $displayedValues;

      if ($filter->hasDefault() && (array)$filter->getDefault() == $field->getValue())
      {
        $this->unremoveableFilters[] = $field->getName();
      }
    }
    $this->filters      = $filters;
    $this->madburl      = $this->getMadbUrl();
    $this->moduleaction = $request->getUrlParameter('module') . '/' . $request->getUrlParameter('action');
    $this->madbcontext  = $this->getMadbContext();

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

}
