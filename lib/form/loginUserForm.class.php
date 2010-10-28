<?php
class loginUserForm extends BaseForm
{
  public function configure()
  {
    $this->disableLocalCSRFProtection();
    $this->setWidget('login', new sfWidgetFormInputText());
    $this->setWidget('password', new sfWidgetFormInputPassword());
    $this->setValidator('login', new sfValidatorPass());
    $this->setValidator('password', new sfValidatorPass());
  }

}
