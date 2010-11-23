<?php
abstract class baseCriteriaFilterChoice extends baseCriteriaFilter
{

  abstract protected function getValues();

  public function configureForm(sfForm $form)
  {
    $values = array();
    $values['_no_'] = 'Choice...';
//    $values = array_merge($values, $this->getValues());
    $values = $values + $this->getValues();
    $form->setWidget($this->getCode(), new sfWidgetFormChoice(array('choices' => $values)));
    return $form;
  }
}
