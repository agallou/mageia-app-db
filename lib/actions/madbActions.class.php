<?php
class madbActions extends sfActions
{

  public function preExecute()
  {
    $this->madbcontext = $this->getMadbContext();
    $this->madburl     = $this->getMadbUrl();
    $this->redirectToDefaultParameters();
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

  protected function redirectToDefaultParameters()
  {
    $getParameters   = $this->getRequest()->getParameterHolder()->getAll();
    $addedParameters = array();
    foreach ($this->getDefaultParameters() as $name => $value)
    {
      if (!in_array($name, array_keys($getParameters)))
      {
        $addedParameters[$name] = $value;
      }
    }
    if (count($addedParameters))
    {
      $parameters = array_merge($getParameters, $addedParameters);
      $url = sprintf('%s/%s?%s', $this->getModuleName(), $this->getActionName(), http_build_query($parameters));
      $this->redirect($url);
    }
  }

  protected function getDefaultParameters()
  {
    $filtersIteratorFactory = new filtersIteratorFactory();
    $filterIterator        = $filtersIteratorFactory->create();
    $defaultParameters     = array();
    foreach ($filterIterator as $filter)
    {
      if ($filter->hasDefault())
      {
        $defaultParameters[$filter->getCode()] = $filter->getDefault();
      }
    }
    return $defaultParameters;
  }

}
