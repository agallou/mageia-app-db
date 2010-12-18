<?php
class myValidatorChoice extends sfValidatorChoice
{
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
    $this->addOption('multiple', true);
  }


  public function clean($value)
  {
    //TODO coma in configure
    if (strpos($value, ','))
    {
      $value = explode(',', $value);
    }
    return parent::clean($value);
  }

}
