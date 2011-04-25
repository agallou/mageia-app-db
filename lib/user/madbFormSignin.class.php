<?php

class madbFormSignin extends sfGuardFormSignin
{
  public function configure()
  {
    parent::configure();
    $this->validatorSchema->setPostValidator(new madbValidatorUser());
  }
}
