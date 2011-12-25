<?php


require_once(dirname(__FILE__) . '/../../../lib/event/notificationEvent.class.php');
require_once(dirname(__FILE__) . '/../../../lib/config/madbConfig.class.php');

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    $notificationEvent = new NotificationEvent();
    $madbConfig = new madbConfig();
    if ($madbConfig->get('notifications_display_notice', false))
    {
//      $notificationEvent->setLogger(new sfLoggerToSfLoggerInterface(new sfConsoleLogger($this->getEventDispatcher())));
    }
    $this->dispatcher->connect('rpm.import', array($notificationEvent,'rpmImportSlot'));
    include($this->getConfigCache()->checkConfig('config/madbconf.yml'));
  }
}
