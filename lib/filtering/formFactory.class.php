<?php
class formFactory
{

  public static function create(madbContext $context= null)
  {
    $form                  = new sfForm();
    $filterIteratorFactory = new filterIteratorFactory();
    $filterIterator        = $filterIteratorFactory->create();

    foreach ($filterIterator as $filter)
    {
      $form = $filter->configureForm($form);
    }
    if (null !== $context)
    {
      $bindParams = array();
      foreach ($filterIterator as $filter)
      {
        $key              = $filter->getCode();
        $bindParams[$key] = $filter->getValueFromContext($context);
      }
      $form->bind($bindParams);
    }
    return $form;
  }

}
