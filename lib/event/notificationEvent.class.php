<?php

class NotificationEvent
{
  // event types constants
  const UPDATE = 1;
  const NEW_VERSION = 2;
  const UPDATE_CANDIDATE = 3;
  const NEW_VERSION_CANDIDATE = 4;
  const COMMENTS = 5;
  // add here more later


  protected $logger = null;

  public function setLogger(sfLoggerInterface $logger)
  {
    $this->logger = $logger;
  }

  /**
    *
    * This is slot connected package.import signal
    * it is executed each time there are some new rpm imported in a package $package
    * @param sfEvent $event symfony event object
    */
  public function rpmImportSlot(sfEvent $event)
  {
    $eventType = $event['event'];
    $rpm = $event->getSubject();

    if( !($rpm instanceof Rpm) )
      throw new madbException ("Typecast error. Instance of Rpm expected as event subject.");

    $c = new Criteria();

    // package match or is null
    $crPackageID = $c->getNewCriterion(SubscriptionElementPeer::PACKAGE_ID, $rpm->getPackageId());
    $crPackageID->addOr($c->getNewCriterion(SubscriptionElementPeer::PACKAGE_ID, NULL, Criteria::ISNULL));

    // rpm group match or is null
    $crRpmGroupID = $c->getNewCriterion(SubscriptionElementPeer::RPM_GROUP_ID, $rpm->getRpmGroupId());
    $crRpmGroupID->addOr($c->getNewCriterion(SubscriptionElementPeer::RPM_GROUP_ID, NULL, Criteria::ISNULL));

    // arch match or is null
    $crArchID = $c->getNewCriterion(SubscriptionElementPeer::ARCH_ID, $rpm->getArchId());
    $crArchID->addOr($c->getNewCriterion(SubscriptionElementPeer::ARCH_ID, NULL, Criteria::ISNULL));

    // distrelease match or is null
    $crDistreleaseID = $c->getNewCriterion(SubscriptionElementPeer::DISTRELEASE_ID, $rpm->getDistreleaseId());
    $crDistreleaseID->addOr($c->getNewCriterion(SubscriptionElementPeer::DISTRELEASE_ID, NULL, Criteria::ISNULL));

    // media match or is null
    $crMediaID = $c->getNewCriterion(SubscriptionElementPeer::MEDIA_ID, $rpm->getMediaId());
    $crMediaID->addOr($c->getNewCriterion(SubscriptionElementPeer::MEDIA_ID, NULL, Criteria::ISNULL));


    $crDistreleaseID->addAnd($crMediaID);
    $crArchID->addAnd($crDistreleaseID);
    $crRpmGroupID->addAnd($crArchID);
    $crPackageID->addAnd($crRpmGroupID);

    $c->add($crPackageID);
    $c->addJoin(SubscriptionPeer::ID, SubscriptionElementPeer::SUBSCRIPTION_ID);
    
    // Select only notification elements watching a given event type
    switch ($eventType)
    {
      case self::UPDATE:
        $c->add(SubscriptionPeer::UPDATE, 1);
        break;
      case self::UPDATE_CANDIDATE:
        $c->add(SubscriptionPeer::UPDATE_CANDIDATE, 1);
        break;
      case self::NEW_VERSION:
        $c->add(SubscriptionPeer::NEW_VERSION, 1);
        break;
      case self::NEW_VERSION_CANDIDATE:
        $c->add(SubscriptionPeer::NEW_VERSION_CANDIDATE, 1);
        break;
      default:
        throw new madbException ("Unknown event type : '$eventType'");
    }

    $subscriptions = SubscriptionPeer::doSelect($c);
    foreach($subscriptions as $subscription)
    {
      //do something with each matched subscription element
      $this->createNotification($rpm, $subscription, $eventType);
    }
  }

  /**
   * This slot is called each time package.comment signal is emmited
   * @param sfEvent $event symfony event object
   */
   //TODO check for calls
  public  function packageCommentsSlot(sfEvent $event)
  {
    //TODO: implement comments subscriptions here
  }

  /**
   * This function returns what to say about event.
   * @param Package $package Package that triggered this event
   */
   //TODO check for calls
  private function getEventTextByEnum($enum)
  {
    switch($enum)
    {
      case NotificationEvent::UPDATE:
        return "has been updated";
      case NotificationEvent::NEW_VERSION:
        return "has a new version";
      case NotificationEvent::UPDATE_CANDIDATE:
        return "has an update candidate";
      case NotificationEvent::NEW_VERSION_CANDIDATE:
        return "has a new version candidate";
      case NotificationEvent::COMMENTS:
        return "has new comments on its page";
      default:
        throw new madbException("Argument is not a valid NotificationEvent enum");
    }
  }

  /**
   * Creates Notification object
   * @param Rpm $rpm Package, witch caused event
   * @param Subscription $subscription element of user subscription, matched package criteria
   * @param enum $eventType type of event, that happened with the package
   */
   //TODO check for calls
  private function createNotification($rpm, $subscription, $eventType)
  {
    //put a notification in a notification spool
    $notification = new Notification();
    $notification->setSubscriptionId($subscription->getId());
    $notification->setRpmId($rpm->getId());
    $notification->setEventType($eventType);
    $notification->save();

    $this->log("\n\033[". "1;34" ."m". "Notification triggered." . "\033[0m\n");
  }


  /**
   * @brief Sends mail
   * Used by notifications sending task to send email, based on params
   * @param Rpm          $rpm
   * @param Subscription $subscription
   * @param              $eventType
   *
   * @return bool
   **/
   //TODO check for calls
  public function sendMail(Rpm $rpm, Subscription $subscription, $eventType)
  {
    //get text explanation about that happened with RPM
    $eventText = self::getEventTextByEnum($eventType);
      $mail = sfConfig::get('app_notifications_mail', array (
        "address" => "madb@localhost",
        "name"    => "madb notification")
      );
    $from = array(
      $mail["address"] => $mail["name"]
    );

    $to = array(
      $subscription->getUser()->getMail() => $subscription->getUser()->getFirstName()." ".$subscription->getUser()->getLastName()
    );

    //get mailing prefix 4 user to sort incoming mails by filter
    $prefix = $subscription->getMailPrefix();
    //FIXME: set better mails here, maybe use Settings
    $header = "[".$prefix."] Package ".$rpm->getPackage()->getName()." ".$eventText;

    $text = "Package ".$rpm->getPackage()->getName() ." ". $eventText . "

    You recieved this message because you are subscribed to get mail notifications from
    madb. If you don't want to recieve any more of these, you can change subscription
    options in your account settings.

    ";

    if(key($to) !== NULL)
    {
    //sends mail
      $message = sfContext::getInstance()->getMailer()->compose(
      $from,
      $to,
      $header,
      $text
    );
    $headers = $message->getHeaders();
    $headers->addTextHeader('Auto-Submitted', 'auto-generated');
    $headers->addTextHeader('Precedence', 'bulk');
    $message->send();

    //TODO: return real result here
    return true;
    }
  }

  /**
   * log 
   * 
   * @param string $message 
   * @param int    $priority 
   *
   * @return void
   */
  public function log($message, $priority = sfLogger::INFO)
  {
    if (null !== $this->logger)
    {
      $this->logger->log($message, $priority);
    }
  }

}
