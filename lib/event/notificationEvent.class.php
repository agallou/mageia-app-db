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

    /**
     *
     * This is slot connected package.import signal
     * it is executed each time there are some new rpm imported in a package $package
     * @param sfEvent $event symfony event object
     */
    public static function rpmImportSlot(sfEvent $event)
    {
        $eventType = $event['event'];
        $rpm = $event->getSubject();

        if( !($rpm instanceof Rpm) ) throw new madbException ("Typecast error. Instance of Rpm expected as event subject.");

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

        $subscriptions = SubscriptionPeer::doSelect($c);
        foreach($subscriptions as $subscription)
        {
            //do something with each matched subscription element
            self::sendByMail($rpm, $subscription, $eventType);
        }
    }

    /**
     * This slot is called each time package.comment signal is emmited
     * @param sfEvent $event symfony event object
     */
    public static function packageCommentsSlot(sfEvent $event)
    {
        //TODO: implement comments subscriptions here
    }

    /**
     * This function returns what to say about event.
     * @param Package $package Package that triggered this event
     */
    private static function getEventTextByEnum($enum)
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
     * Sends a e-mail to user
     * @param Rpm $rpm Package, witch caused event
     * @param SubscriptionElement $subscriptionElement element of user subscription, matched package criteria
     * @param enum $eventType type of event, that happened with the package
     */
    private static function sendByMail($rpm, $subscription, $eventType)
    {
            //get text explanation about that happened with RPM
            $eventText = self::getEventTextByEnum($eventType);
            
            $from = array(
                sfConfig::get('app_notifications_mail_address', "madb@localhost") => sfConfig::get('app_notifications_mail_name', "madb notification")
            );

            //TODO: use real user mail from db
            $to = array(
                $subscription->getUser()->getMail() => $subscription->getUser()->getFirstName()." ".$subscription->getUser()->getLastName()
            );

            //get mailing prefix 4 user to sort incoming mails by filter
            $prefix = $subscription->getMailPrefix();
            //FIXME: set better mails here - use Settings
            $header = "[".$prefix."] Package ".$rpm->getPackage()->getName()." ".$eventText;

            $text = "You recieved this notification because package ".$rpm->getPackage()->getName() ." ". $eventText;

            if(key($to) !== NULL)
            {
            //sends mail directly
            sfContext::getInstance()->getMailer()->composeAndSend(
                $from,
                $to,
                $header,
                $text
                );
            //TODO: fancy console notice line, should be configurable :)
             echo "\n\033[". "1;34" ."m". "Mailsending triggered: from:[".$from[key($from)]." <".key($from).">]->to:[$to] h:$header b:[$text]" . "\033[0m\n";
            }
    }
}
?>
