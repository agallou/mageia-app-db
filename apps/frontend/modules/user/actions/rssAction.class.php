<?php
class rssAction extends sfActions
{
  public function execute($request)
  {
    // get feed id
    $feedId = $request->getParameter("feed",0);
    $this->logMessage("Feed id is $feedId");

    //TODO: what to do if user wasn't authenticated? How to show him feed to use agregator if he isn't authenticated by agregator?
    //FIXME: use real users id here
    // get user id
    $userId = $this->getUser()->getAttribute("id", 1);

    // get all the users rss_feeds
    $rssCriteria = new Criteria();
    $rssCriteria->add(RssFeedPeer::USER_ID,$userId);
    $this->rssFeeds = RssFeedPeer::doSelect($rssCriteria);

    //no feed is selected! redirect to selecting of the feed
    if( $feedId == 0 || !is_numeric($feedId) ) return "Select";

    //feed is selected, now lets display it
    $selectedFeed = RssFeedPeer::retrieveByPK($feedId);
    // but first let's check if used "selected" his own feed :D
    // and if not show him Select
    if($selectedFeed->getUserId() != $userId)  return "Select";

    $this->feed = $selectedFeed;
    //dummy array for rss
    $this->rss  = array();

    
    foreach($this->feed->getNotifications() as $notification)
    {
        $notification instanceof Notification;
        $rpmCriteria = new Criteria();
        foreach($notification->getNotificationElements() as $notificationElement)
        {
            $notificationElement instanceof NotificationElement;
            //set here additional scope criterions
            if($notificationElement->getMediaId()       != NULL) $notificationElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::MEDIA_ID,$notificationElement->getMediaId());
            if($notificationElement->getArchId()        != NULL) 
                    if(isset($notificationElementCriterion)) $notificationElementCriterion->addAnd($rpmCriteria->getNewCriterion(RpmPeer::ARCH_ID,$notificationElement->getArchId()));
                    else $notificationElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::ARCH_ID,$notificationElement->getArchId());
            if($notificationElement->getDistreleaseId() != NULL) 
                    if(isset($notificationElementCriterion)) $notificationElementCriterion->addAnd($rpmCriteria->getNewCriterion(RpmPeer::DISTRELEASE_ID,$notificationElement->getDistreleaseId()));
                    else $notificationElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::DISTRELEASE_ID,$notificationElement->getDistreleaseId());
            if($notificationElement->getPackageId()     != NULL) 
                    if(isset($notificationElementCriterion)) $notificationElementCriterion->addAnd($rpmCriteria->getNewCriterion(RpmPeer::PACKAGE_ID,$notificationElement->getPackageId()));
                    else $notificationElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::PACKAGE_ID,$notificationElement->getPackageId());
            //and Or this to rpm criteria
            if(isset($notificationElementCriterion))
                {
                $rpmCriteria->addOr($notificationElementCriterion);
                unset($notificationElementCriterion);
                }
        }

        //setup criteria for media based on notification's settings
        if($notification->getUpdate())
        {
            $updateMediaCriterion = $rpmCriteria->getNewCriterion(MediaPeer::IS_UPDATES, true);
            $updateMediaCriterion->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, false));
            $rpmCriteria->addOr($updateMediaCriterion);
        }

        if($notification->getUpdateCandidate())
        {
            $updateCandidateMediaCriterion = $rpmCriteria->getNewCriterion(MediaPeer::IS_UPDATES, true);
            $updateCandidateMediaCriterion->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, true));
            $rpmCriteria->addOr($updateCandidateMediaCriterion);
        }

        if($notification->getNewVersion())
        {
            $newVersionMediaCriterion = $rpmCriteria->getNewCriterion(MediaPeer::IS_BACKPORTS, true);
            $newVersionMediaCriterion->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, false));
            $rpmCriteria->addOr($newVersionMediaCriterion);
        }

        if($notification->getNewVersionCandidate())
        {
            $newVersionCandidateMediaCriterion = $rpmCriteria->getNewCriterion(MediaPeer::IS_BACKPORTS, true);
            $newVersionCandidateMediaCriterion->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, true));
            $rpmCriteria->addOr($newVersionCandidateMediaCriterion);
        }

    }

    $rpmCriteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
    $rpmCriteria->addJoin(RpmPeer::ARCH_ID, ArchPeer::ID);
    $rpmCriteria->addJoin(RpmPeer::DISTRELEASE_ID, DistreleasePeer::ID);
    $rpmCriteria->addJoin(RpmPeer::PACKAGE_ID, PackagePeer::ID);
    $rpmCriteria->setLimit(20);
    $rpms[] = RpmPeer::doSelect($rpmCriteria);

    foreach($rpms as $rpmPack)
        foreach($rpmPack as $rpm)
        {
            $this->rss[] = $rpm;
            $this->logMessage("RPM added: ".$rpm->getName());
        }


    //set RSS layout
    if( $this->getContext()->getConfiguration()->isDebug()) return "Debug";

        $this->setLayout("rss");
        return "View";

    
         
  }
}
