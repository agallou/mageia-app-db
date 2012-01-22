<?php
class formFactory
{
  /**
   * 
   * Creates a form containing the filter widgets for each filter given in $filtersIterator
   * 
   * Selected values are set using values defined in $context (each filters knows how to extract values from it)
   * or using default values defined by each filter.
   * 
   * @param madbContext $context
   * @param array $only_those if not empty, only the filters whose code is in this array are added to the form
   */
  public static function create(filtersIterator $filtersIterator, $name_prefix, madbContext $context= null, $bind=true, $filters_use_default_values=true)
  {
    $form = new sfForm();
    $form->getWidgetSchema()->setNameFormat($name_prefix . "%s");
    
    foreach ($filtersIterator as $filter)
    {
      $form = $filter->configureForm($form);
    }
    if ($bind and null !== $context)
    {
      self::bind($form, $filtersIterator, $context, array(), $filters_use_default_values);
    }
    return $form;
  }

  public static function bind(sfForm $form, filtersIterator $filtersIterator, madbContext $context, $extra_bind_values = array(), $filters_use_default_values=true)
  {
    $bindParams = array();
    foreach ($filtersIterator as $filter)
    {
      $filter->setMadbContext($context);
      $key              = $filter->getCode();
      $bindParams[$key] = $filter->getValue(false, $filters_use_default_values);
    }
    
    foreach ($extra_bind_values as $key => $value)
    {
      $bindParams[$key] = $value;
    }
    $form->bind($bindParams);
    return $form;
  }

}
