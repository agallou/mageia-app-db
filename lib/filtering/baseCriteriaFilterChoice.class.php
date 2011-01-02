<?php
abstract class baseCriteriaFilterChoice extends baseCriteriaFilter
{

  /**
   * @return array
   */
  abstract protected function getValues();

  public function configureForm(sfForm $form)
  {
    $values = array();
    $values = $values + $this->getValues();
    $form->setWidget($this->getCode(), new sfWidgetFormChoice(array('choices' => $values, 'multiple' => true)));
    $form->setValidator($this->getCode(), new myValidatorChoice(array('choices' => array_keys($values), 'required' => false)));
    return $form;
  }

  /**
   * 
   * Get and format the relevant context parameters
   * Temporary filters values and persistent filter values are merged if $use_temp_filters is true
   * (e.g. t_group and group). Returns an empty array if the intersection is empty.
   * Returns null if there's no value at all
   * 
   * @param madbContext $context
   * @param bool $use_temp_filters
   */
  public function getValueFromContext(madbContext $context, $use_temp_filters=false)
  {
    if (!$context->hasParameter($this->getCode()) and (!$use_temp_filters or !$context->hasParameter("t_" . $this->getCode())))
    {
      return null;
    }
    
    $raw_value = $context->getParameter($this->getCode());
    $value = explode(',', $raw_value);

    if ($use_temp_filters)
    {
      $raw_t_value = $context->getParameter("t_" . $this->getCode());
      $t_value = explode(',', $raw_t_value);
      
      if (null === $raw_value)
      {
        $value = $t_value;
      }
      elseif (null !== $raw_t_value)
      {
        $value = array_intersect($value, $t_value);
      }
    }
    return $value;
  }
  
  protected function doFilter(Criteria $criteria, $value)
  {
    // empty value means empty filter intersection, so no result
    if (empty($value))
    {
      $criteria->add('nothing', 'FALSE', Criteria::CUSTOM);
    }
    else
    {
      $criteria = $this->doFilterChoice($criteria, $value);
    }
    return $criteria;
  }
  
  abstract protected function doFilterChoice(Criteria $criteria, $value);
  
}
