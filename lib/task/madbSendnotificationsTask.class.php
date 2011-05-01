<?php

class madbSendnotificationsTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      // add your own options here
    ));

    $this->namespace        = 'madb';
    $this->name             = 'send-notifications';
    $this->briefDescription = 'Sends spooled sendable notifications to users';
    $this->detailedDescription = <<<EOF
The [madb:send-notifications|INFO] task does things.
Call it with:

  [php symfony madb:send-notifications|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection and application configuration
    sfContext::createInstance($this->createConfiguration('frontend', 'prod'));
    $con = Propel::getConnection();
    Propel::disableInstancePooling();
    
    //get all the notifications:
    $c = new Criteria();
    $notifications = NotificationPeer::doSelect($c);
    
    //work on every found notification
    foreach($notifications as $notification)
    {
      //just debug log notify
      $this->logSection('', sprintf( 'Found notification #%s for subscription #%s with rpm #%s and event #%s' , $notification->getId() , $notification->getSubscriptionId() , $notification->getRpmId() , $notification->getEventType() ));
      
      //send mail to user if mailing is on in subscription
      if($notification->getSubscription()->getMailNotification())
      {
        if(NotificationEvent::sendMail($notification->getRpm(),$notification->getSubscription(),$notification->getEventType() ) )
        $this->logSection('mail', 'Message sent');
      }
      
      // TODO: maybe we can create a cached feeds here and forget about rss view task?
      //find feed, linked with subscription and update it
      // $this->logSection('rss+', sprintf( 'Updating cache of feed #%s for subscription #%s with rpm #%s and event #%s' , $notification->getSubscription()->getRssFeedId() , $notification->getSubscriptionId() , $notification->getRpmId() , $notification->getEventType() ));
      
      //finished to work with notification object
      //now it should be deleted
      $nofitication->delete();
    }
  }
}
