<?php


require_once(dirname(__FILE__) . '/../../../lib/event/notificationEvent.class.php');
require_once(dirname(__FILE__) . '/../../../lib/config/madbConfig.class.php');

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    $madbConfig = new madbConfig();
    // Doesn't work, the madbconf.yml file hasn't been loaded yet at this stage apparently
//    if ($madbConfig->get('notifications_display_notice', false))
//    {
//      NotificationEvent::setLogger(new sfLoggerToSfLoggerInterface(new sfConsoleLogger($this->getEventDispatcher())));
//    }
    $this->dispatcher->connect('rpm.import', array('NotificationEvent','rpmImportSlot'));
    include($this->getConfigCache()->checkConfig('config/madbconf.yml'));
  }
}
