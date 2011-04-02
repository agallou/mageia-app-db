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
     * This is slot connected to signal that emmited everytime
     * there is some of User-Notificated events triggered
     * 
     * @param sfEvent $event symfony event object
     */
    static function rpmEventSlot(sfEvent $event)
    {
        $eventType = $event['event'];
        $rpm = $event->getSubject();
        
        if( !($rpm instanceof Rpm) ) throw new madbException ("Typecast error. Instance of Rpm expected.", "???", "");

        $c = new Criteria();

        // package match or is null
        $crPackageID = $c->getNewCriterion(NotificationElementPeer::PACKAGE_ID, $rpm->getPackageId());
        $crPackageID->addOr($c->getNewCriterion(NotificationElementPeer::PACKAGE_ID, NULL, Criteria::ISNULL));

        // rpm group match or is null
        $crRpmGroupID = $c->getNewCriterion(NotificationElementPeer::RPM_GROUP_ID, $rpm->getRpmGroupId());
        $crRpmGroupID->addOr($c->getNewCriterion(NotificationElementPeer::RPM_GROUP_ID, NULL, Criteria::ISNULL));

        // arch match or is null
        $crArchID = $c->getNewCriterion(NotificationElementPeer::ARCH_ID, $rpm->getArchId());
        $crArchID->addOr($c->getNewCriterion(NotificationElementPeer::ARCH_ID, NULL, Criteria::ISNULL));

        // distrelease match or is null
        $crDistreleaseID = $c->getNewCriterion(NotificationElementPeer::DISTRELEASE_ID, $rpm->getDistreleaseId());
        $crDistreleaseID->addOr($c->getNewCriterion(NotificationElementPeer::DISTRELEASE_ID, NULL, Criteria::ISNULL));

        // media match or is null
        $crMediaID = $c->getNewCriterion(NotificationElementPeer::MEDIA_ID, $rpm->getMediaId());
        $crMediaID->addOr($c->getNewCriterion(NotificationElementPeer::MEDIA_ID, NULL, Criteria::ISNULL));


        $crDistreleaseID->addAnd($crMediaID);
        $crArchID->addAnd($crDistreleaseID);
        $crRpmGroupID->addAnd($crArchID);
        $crPackageID->addAnd($crRpmGroupID);

        $c->add($crPackageID);

        $notificationElements = NotificationElementPeer::doSelect($c);
        foreach($notificationElements as $notificationElement)
        {
            //do something with each matched notification element
            self::sendByMail($rpm, $notificationElement, $eventType);
        }
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
                throw new madbException("Argument is not a valid NotificationEventListener enum");
        }
    }

    /**
     * Sends a e-mail to user
     * @param Rpm $rpm Package, witch caused event
     * @param NotificationElement $notificationElement elemnt of user subscription, matched package criteria
     * @param enum $eventType type of event, that happened with the package
     */
    private static function sendByMail($rpm, $notificationElement, $eventType)
    {
            $eventText = self::getEventTextByEnum($eventType);
            
            //TODO: replace this line with settings
            $from = array(
                "madb@phobos.home" => "madb notification"
            );

            //TODO: use real user mail from db
            $to = $notificationElement->getNotification()->getUser()->getLogin()."@madb.phobos.home";
            //$to = "blinov.vyacheslav@gmail.com";

            $prefix = $notificationElement->getNotification()->getMailPrefix();
            //FIXME: set better mails here - use Settings
            $header = "[".$prefix."] Package ".$rpm->getPackage()->getName()." ".$eventText;

            $text = "You recieved this notification because RPM package ".$rpm->getName() ." ". $eventText;

            //sends mail directly
            sfContext::getInstance()->getMailer()->composeAndSend(
                $from,
                $to,
                $header,
                $text
                );
            // fancy console debug line :)
            // echo "\n\033[". "1;34" ."m". "Mailsending triggered: [$from]:[$to] h:[$header] [$text]" . "\033[0m\n";
    }
}
?>
