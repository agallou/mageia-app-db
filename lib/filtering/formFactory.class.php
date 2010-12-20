<?php
class formFactory
{

  public static function create(madbContext $context= null)
  {
    $form = new sfForm();

    $filterList = filterCollection::getAll();
    foreach ($filterList as $filterName)
    {
      $filter = new $filterName;
      $form = $filter->configureForm($form);
    }
    if (null !== $context)
    {
      $bindParams = array();
      foreach ($filterList as $filter)
      {
        $key    = $filter->getCode();
        $bindParams[$key] = $filter->getValueFromContext($context);
      }
      $form->bind($bindParams);
    }
    return $form;
  }

}
