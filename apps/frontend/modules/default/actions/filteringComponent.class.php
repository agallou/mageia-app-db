<?php 
class filteringComponent extends madbComponent
{
  public function execute($request)
  {
    $filtersIteratorFactory = new filtersIteratorFactory();
    $this->form    = formFactory::create($filtersIteratorFactory->create(), 'filtering_', $this->getMadbContext());
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
      $values          = $field->getValue();
      if (is_array($values))
      {
        foreach ($values as $value)
        {
          $displayedValues[] = $filterValues[$value];
        }
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


}
