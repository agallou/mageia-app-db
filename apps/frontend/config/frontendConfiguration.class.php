<?php


require_once(dirname(__FILE__) . '/../../../lib/event/notificationEvent.class.php');


class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    $notificationEvent = new NotificationEvent();
    if (sfConfig::get('app_notifications_display_notice', "false"))
    {
//      $notificationEvent->setLogger(new sfLoggerToSfLoggerInterface(new sfConsoleLogger($this->getEventDispatcher())));
    }
    $this->dispatcher->connect('rpm.import', array($notificationEvent,'rpmImportSlot'));
  }
}
