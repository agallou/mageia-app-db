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

  // FIXME? non static function for non instanciable class?
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
  static public function rpmImportSlot(sfEvent $event)
  {
    $eventType = $event['event'];
    $rpm = $event->getSubject();

    if( !($rpm instanceof Rpm) )
      throw new madbException ("Typecast error. Instance of Rpm expected as event subject.");

    $c = new Criteria();

    // package matches or is null
    $crPackageID = $c->getNewCriterion(SubscriptionElementPeer::PACKAGE_ID, $rpm->getPackageId());
    $crPackageID->addOr($c->getNewCriterion(SubscriptionElementPeer::PACKAGE_ID, NULL, Criteria::ISNULL));

    // rpm group matches or is null
    $crRpmGroupID = $c->getNewCriterion(SubscriptionElementPeer::RPM_GROUP_ID, $rpm->getRpmGroupId());
    $crRpmGroupID->addOr($c->getNewCriterion(SubscriptionElementPeer::RPM_GROUP_ID, NULL, Criteria::ISNULL));

    // arch matches or is null
    $crArchID = $c->getNewCriterion(SubscriptionElementPeer::ARCH_ID, $rpm->getArchId());
    $crArchID->addOr($c->getNewCriterion(SubscriptionElementPeer::ARCH_ID, NULL, Criteria::ISNULL));

    // distrelease matches or is null
    $crDistreleaseID = $c->getNewCriterion(SubscriptionElementPeer::DISTRELEASE_ID, $rpm->getDistreleaseId());
    $crDistreleaseID->addOr($c->getNewCriterion(SubscriptionElementPeer::DISTRELEASE_ID, NULL, Criteria::ISNULL));

    // media matches or is null
    $crMediaID = $c->getNewCriterion(SubscriptionElementPeer::MEDIA_ID, $rpm->getMediaId());
    $crMediaID->addOr($c->getNewCriterion(SubscriptionElementPeer::MEDIA_ID, NULL, Criteria::ISNULL));

    // is_source matches or is null
    $crSource = $c->getNewCriterion(SubscriptionElementPeer::IS_SOURCE, $rpm->getPackage()->getIsSource());
    $crSource->addOr($c->getNewCriterion(SubscriptionElementPeer::IS_SOURCE, NULL, Criteria::ISNULL));

    // is_application matches or is null
    $crApplication = $c->getNewCriterion(SubscriptionElementPeer::IS_APPLICATION, $rpm->getPackage()->getIsApplication());
    $crApplication->addOr($c->getNewCriterion(SubscriptionElementPeer::IS_APPLICATION, NULL, Criteria::ISNULL));

    $crSource->addAnd($crApplication);
    $crMediaID->addAnd($crSource);    
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
  static public function packageCommentsSlot(sfEvent $event)
  {
    //TODO: implement comments subscriptions here
  }

  /**
   * This function returns what to say about event.
   * @param Package $package Package that triggered this event
   */
   //TODO check for calls
  static private function getEventTextByEnum($enum)
  {
    switch($enum)
    {
      case NotificationEvent::UPDATE:
        return "Update";
      case NotificationEvent::NEW_VERSION:
        return "Backport";
      case NotificationEvent::UPDATE_CANDIDATE:
        return "Update candidate";
      case NotificationEvent::NEW_VERSION_CANDIDATE:
        return "Backport candidate";
      case NotificationEvent::COMMENTS:
        return "New comment";
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
  static private function createNotification($rpm, $subscription, $eventType)
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
  static public function sendMail(Rpm $rpm, Subscription $subscription, $eventType)
  {
    //get text explanation about that happened with RPM
    $eventText = self::getEventTextByEnum($eventType);
    $madbConfig = new madbConfig();
    $mailparams = $madbConfig->get('notifications_mail');
    
    if (!isset($mailparams['address']) or !isset($mailparams['name']))
    {
      throw new madbException("Missing notifications/mail/address and/or notifications/mail/name from madbconf.yml config file.");
    }
    
    $from = array(
      $mailparams['address'] => $mailparams['name']
    );

    $to = array(
      $subscription->getUser()->getMail() => $subscription->getUser()->getFirstName()." ".$subscription->getUser()->getLastName()
    );

    if(key($to) !== NULL)
    {
      $package = $rpm->getPackage();
      
      //get mailing prefix for users to sort incoming mails by filter
      $prefix = isset($mailparams['prefix']) ? $mailparams['prefix'] : "";
      $prefix .= $subscription->getMailPrefix();
    
      // mail subject
      $header = "$prefix $eventText: %%%RPM%%% (%%%DISTRIBUTION%%% %%%DISTRELEASE%%% %%%ARCH%%% %%%MEDIA%%%)";
      
      // URL to package view
      $url = 'http://' . $madbConfig->get('host') . '/package/show/name/' . $package->getName() 
              . '/distrelease/' . $rpm->getDistreleaseId() 
              . '/source/' . ($rpm->getIsSource() ? 1 : 0)
              . '/arch/' . ($rpm->getArchId()) 
              . '/application/0';

      // contextual message
      switch ($eventType)
      {
        case NotificationEvent::UPDATE:
          $context_msg = (isset($mailparams['messages']) and isset($mailparams['messages']['update']))
                         ? $mailparams['messages']['update']
                         : "";
          break;
        case NotificationEvent::NEW_VERSION:
          $context_msg = (isset($mailparams['messages']) and isset($mailparams['messages']['new_version']))
                         ? $mailparams['messages']['new_version']
                         : "";
          break;
        case NotificationEvent::UPDATE_CANDIDATE:
          $context_msg = (isset($mailparams['messages']) and isset($mailparams['messages']['update_candidate']))
                         ? $mailparams['messages']['update_candidate']
                         : "This package is an update candidate. You can help your distribution by testing it and reporting any bugs to the bug tracker before it becomes an official update.";
          break;
        case NotificationEvent::NEW_VERSION_CANDIDATE:
          $context_msg = (isset($mailparams['messages']) and isset($mailparams['messages']['new_version_candidate']))
                         ? $mailparams['messages']['new_version_candidate']
                         : "This package is a backport candidate. You can help your distribution by testing it and reporting any bugs to the bug tracker before it becomes an official backport.";
          break;
        case NotificationEvent::COMMENTS:
         //TODO
        default:
          throw new madbException("Argument is not a valid NotificationEvent enum");
      }
      $context_msg = ($context_msg) ? "$context_msg\n\n" : $context_msg;
      
      $source_rpm_msg = ($rpm->getIsSource()) ? "This package is a source RPM.\n\n" : "";
      
      // mail contents
      $text = <<<EOF
Distribution: %%%DISTRIBUTION%%% %%%DISTRELEASE%%% (%%%ARCH%%%), Media: %%%MEDIA%%%

$url

${context_msg}${source_rpm_msg}Name         : %%%NAME%%%
Version      : %%%VERSION%%%
Release      : %%%RELEASE%%%
Group        : %%%GROUP%%%
Size         : %%%SIZE%%%
License      : %%%LICENSE%%%
URL          : %%%URL%%%
Summary      : %%%SUMMARY%%%
Description  :
%%%DESCRIPTION%%%

______
You subscribed to receive mail notifications from %%%MADB%%%. You can change subscription options in your account settings.

EOF;
      
      $matching = array(
        'ARCH'          => $rpm->getArch()->getName(),
        'DESCRIPTION'   => $rpm->getDescription(),
        'DISTRELEASE'   => $rpm->getDistrelease()->getName(),  
        'DISTRIBUTION'  => $madbConfig->get('distribution'),  
        'GROUP'         => $rpm->getRpmGroup()->getName(),
        'LICENSE'       => $rpm->getLicence(),
        'MADB'          => $madbConfig->get('name'),  
        'MEDIA'         => $rpm->getMedia()->getName(),  
        'NAME'          => $package->getName(),
        'RELEASE'       => $rpm->getRelease(),
        'RPM'           => $rpm->getFilename(),  
        'SIZE'          => $rpm->getSize(),
        'SUMMARY'       => $rpm->getSummary(),
        'URL'           => $rpm->getUrl(),  
        'VERSION'       => $rpm->getVersion(),
      );
      
      foreach ($matching as $match => $replace)
      {
        $header = str_replace("%%%$match%%%", $replace, $header);
        $text = str_replace("%%%$match%%%", $replace, $text);
      }

      // Send mails
      $mailer = sfContext::getInstance()->getMailer();
      $message = $mailer->compose(
        $from,
        $to,
        $header,
        $text
      );
      $headers = $message->getHeaders();
      $headers->addTextHeader('Auto-Submitted', 'auto-generated');
      $headers->addTextHeader('Precedence', 'bulk');
      $mailer->send($message);

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
