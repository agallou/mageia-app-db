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

  public function getValueFromContext(madbContext $context)
  {
    $value = $context->getParameter($this->getCode());
    if ( null !== $value)
    {
      $value = explode(',', $value);
    }
    else
    {
      $value = array();
    }
    return $value;
  }
}
