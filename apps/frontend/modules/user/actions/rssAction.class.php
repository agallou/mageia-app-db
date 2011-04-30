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
    // TODO: see previous TODO and FIXME
    // if($selectedFeed->getUserId() != $userId)  return "Select";

    $this->feed = $selectedFeed;
    //dummy array for rss
    $this->rss  = array();

    
    foreach($this->feed->getSubscriptions() as $subscription)
    {
        $subscription instanceof Subscription;
        $rpmCriteria = new Criteria();
        foreach($subscription->getSubscriptionElements() as $subscriptionElement)
        {
            $subscriptionElement instanceof SubscriptionElement;
            //set here additional scope criterions
            if($subscriptionElement->getMediaId()       != NULL) $subscriptionElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::MEDIA_ID,$subscriptionElement->getMediaId());
            if($subscriptionElement->getArchId()        != NULL) 
                    if(isset($subscriptionElementCriterion)) $subscriptionElementCriterion->addAnd($rpmCriteria->getNewCriterion(RpmPeer::ARCH_ID,$subscriptionElement->getArchId()));
                    else $subscriptionElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::ARCH_ID,$subscriptionElement->getArchId());
            if($subscriptionElement->getDistreleaseId() != NULL) 
                    if(isset($subscriptionElementCriterion)) $subscriptionElementCriterion->addAnd($rpmCriteria->getNewCriterion(RpmPeer::DISTRELEASE_ID,$subscriptionElement->getDistreleaseId()));
                    else $subscriptionElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::DISTRELEASE_ID,$subscriptionElement->getDistreleaseId());
            if($subscriptionElement->getPackageId()     != NULL) 
                    if(isset($subscriptionElementCriterion)) $subscriptionElementCriterion->addAnd($rpmCriteria->getNewCriterion(RpmPeer::PACKAGE_ID,$subscriptionElement->getPackageId()));
                    else $subscriptionElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::PACKAGE_ID,$subscriptionElement->getPackageId());
            //and Or this to rpm criteria
            if(isset($subscriptionElementCriterion))
                {
                $rpmCriteria->addOr($subscriptionElementCriterion);
                unset($subscriptionElementCriterion);
                }
        }

        //setup criteria for media based on subscription's settings
        if($subscription->getUpdate())
        {
            $subscriptionCriterion = $rpmCriteria->getNewCriterion(MediaPeer::IS_UPDATES, true);
            $subscriptionCriterion->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, false));
        }

        if($subscription->getUpdateCandidate())
        {
            if(isset($subscriptionCriterion))
            {
            $subscriptionCriterion2 = $rpmCriteria->getNewCriterion(MediaPeer::IS_UPDATES, true);
            $subscriptionCriterion2->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, true));
            $subscriptionCriterion->addOr($subscriptionCriterion2);
            }
            else
            {
            $subscriptionCriterion = $rpmCriteria->getNewCriterion(MediaPeer::IS_UPDATES, true);
            $subscriptionCriterion->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, true));
            }
        }

        if($subscription->getNewVersion())
        {
            if(isset($subscriptionCriterion))
            {
            $subscriptionCriterion2 = $rpmCriteria->getNewCriterion(MediaPeer::IS_BACKPORTS, true);
            $subscriptionCriterion2->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, false));
            $subscriptionCriterion->addOr($subscriptionCriterion2);
            }
            else
            {
            $subscriptionCriterion = $rpmCriteria->getNewCriterion(MediaPeer::IS_UPDATES, true);
            $subscriptionCriterion->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, false));
            }
        }

        if($subscription->getNewVersionCandidate())
        {
            if(isset($subscriptionCriterion))
            {
            $subscriptionCriterion2 = $rpmCriteria->getNewCriterion(MediaPeer::IS_BACKPORTS, true);
            $subscriptionCriterion2->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, true));
            $subscriptionCriterion->addOr($subscriptionCriterion2);
            }
            else
            {
            $subscriptionCriterion = $rpmCriteria->getNewCriterion(MediaPeer::IS_UPDATES, true);
            $subscriptionCriterion->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, true));
            }
        }
        if(isset($subscriptionCriterion))
            $rpmCriteria->addOr($subscriptionCriterion);

    }

    $rpmCriteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
    $rpmCriteria->addJoin(RpmPeer::ARCH_ID, ArchPeer::ID);
    $rpmCriteria->addJoin(RpmPeer::DISTRELEASE_ID, DistreleasePeer::ID);
    $rpmCriteria->addJoin(RpmPeer::PACKAGE_ID, PackagePeer::ID);

    $rpmCriteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
    $rpmCriteria->setLimit(20);
    $rpms = RpmPeer::doSelect($rpmCriteria);

        foreach($rpms as $rpm)
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
