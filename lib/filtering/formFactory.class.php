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
  public static function create(filtersIterator $filtersIterator, $name_prefix, madbContext $context= null, $bind=true)
  {
    $form = new sfForm();
    $form->getWidgetSchema()->setNameFormat($name_prefix . "%s");
    
    foreach ($filtersIterator as $filter)
    {
      $form = $filter->configureForm($form);
    }
    if ($bind and null !== $context)
    {
      self::bind($form, $filtersIterator, $context);
    }
    return $form;
  }

  public static function bind(sfForm $form, filtersIterator $filtersIterator, madbContext $context, $extra_bind_values = array())
  {
    $bindParams = array();
    foreach ($filtersIterator as $filter)
    {
      $key              = $filter->getCode();
      $bindParams[$key] = $filter->getValueFromContext($context);
    }
    
    if (!empty($extra_bind_values))
    {
      foreach ($extra_bind_values as $key => $value)
      {
        $bindParams[$key] = $value;
      }
    }
    $form->bind($bindParams);
    return $form;
  }

}
