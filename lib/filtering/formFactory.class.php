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
      foreach ($filterList as $filterName)
      {
        $filter = new $filterName;
        $key    = $filter->getCode();
        $bindParams[$key] = $context->getParameter($key);
      }
      $form->bind($bindParams);
    }
    return $form;
  }

}
