<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
      //-- this connects slot of rpm event to signal about event
      $this->dispatcher->connect('package.import',
      array('NotificationEvent','packageImportSlot'));
  }
}
