<?php
abstract class baseCriteriaFilterChoice extends baseCriteriaFilter
{

  abstract protected function getValues();

  public function configureForm(sfForm $form)
  {
    $values = array();
    $values = $values + $this->getValues();
    $form->setWidget($this->getCode(), new sfWidgetFormChoice(array('choices' => $values)));
    $form->setValidator($this->getCode(), new sfValidatorChoice(array('choices' => array_keys($values), 'required' => false)));
    return $form;
  }
}
