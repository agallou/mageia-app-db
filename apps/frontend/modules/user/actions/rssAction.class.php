<?php
class rssAction extends sfActions
{
  public function execute($request)
  {
    // get feed id
    $feedId = $request->getParameter("feed",0);

    //TODO: what to do if user wasn't authenticated? How to show him feed to use agregator if he isn't authenticated by agregator?
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
    // but first let's check if user "selected" his own feed :D
    // and if not show him Select
    // TODO: see previous TODO
    // if($selectedFeed->getUserId() != $userId)  return "Select";

    $this->feed = $selectedFeed;
    //dummy array for rss
    $this->rss  = array();

    // dummy array to store rpms we found via subscription details
    $rpmCriteria = new Criteria();
    $rpmCriterions = array();
    
    foreach($this->feed->getSubscriptions() as $subscription)
    {
      $subscriptionElementsCriterions = array();
      foreach($subscription->getSubscriptionElements() as $subscriptionElement)
      {
        //set here additional scope criterions
        if($subscriptionElement->getMediaId()       !== null) 
        {
          if(isset($subscriptionElementCriterion))
          {
            $subscriptionElementCriterion->addAnd($rpmCriteria->getNewCriterion(RpmPeer::MEDIA_ID,$subscriptionElement->getMediaId()));
          }
          else
          {
            $subscriptionElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::MEDIA_ID,$subscriptionElement->getMediaId());
          }
        }
        if($subscriptionElement->getArchId()        !== null)
        {
          if(isset($subscriptionElementCriterion))
          {
            $subscriptionElementCriterion->addAnd($rpmCriteria->getNewCriterion(RpmPeer::ARCH_ID,$subscriptionElement->getArchId()));
          }
          else
          {
            $subscriptionElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::ARCH_ID,$subscriptionElement->getArchId());
          }
        }
        if($subscriptionElement->getDistreleaseId() !== null)
        {
          if(isset($subscriptionElementCriterion))
          {
            $subscriptionElementCriterion->addAnd($rpmCriteria->getNewCriterion(RpmPeer::DISTRELEASE_ID,$subscriptionElement->getDistreleaseId()));
          }
          else
          {
            $subscriptionElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::DISTRELEASE_ID,$subscriptionElement->getDistreleaseId());
          }
        }
          
        if($subscriptionElement->getPackageId()     !== null)
        {
          if(isset($subscriptionElementCriterion))
          {
            $subscriptionElementCriterion->addAnd($rpmCriteria->getNewCriterion(RpmPeer::PACKAGE_ID,$subscriptionElement->getPackageId()));
          }
          else
          {
            $subscriptionElementCriterion = $rpmCriteria->getNewCriterion(RpmPeer::PACKAGE_ID,$subscriptionElement->getPackageId());
          }
        }
          
        //and addOr this to rpm criteria
        if(isset($subscriptionElementCriterion))
        {
          $subscriptionElementsCriterions[] = $subscriptionElementCriterion;
          unset($subscriptionElementCriterion);
        }
      }
      //eof foreach element

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
          $subscriptionCriterion = $rpmCriteria->getNewCriterion(MediaPeer::IS_BACKPORTS, true);
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
          $subscriptionCriterion = $rpmCriteria->getNewCriterion(MediaPeer::IS_BACKPORTS, true);
          $subscriptionCriterion->addAnd($rpmCriteria->getNewCriterion(MediaPeer::IS_TESTING, true));
        }
      }
      
      if(isset($subscriptionCriterion))
      {
        if(!empty($subscriptionElementsCriterions))
          foreach($subscriptionElementsCriterions as $subscriptionElementsCriterion)
            $subscriptionCriterion->addAnd($subscriptionElementsCriterion);

        $rpmCriterions[] = $subscriptionCriterion;
        unset($subscriptionCriterion);
      }
    }

    if(!empty($rpmCriterions))
      {
      $first = true;
      foreach($rpmCriterions as $rpmCriterion)
        {
          if($first === true)
          {
            $criterions = $rpmCriterion;
            $first = false;
          }
          else
          {
            $criterions->addOr($rpmCriterion);
          }
        }
        $rpmCriteria->addAnd($criterions);
      }
    
    $rpmCriteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID);
    $rpmCriteria->addJoin(RpmPeer::ARCH_ID, ArchPeer::ID);
    $rpmCriteria->addJoin(RpmPeer::DISTRELEASE_ID, DistreleasePeer::ID);
    $rpmCriteria->addJoin(RpmPeer::PACKAGE_ID, PackagePeer::ID);

    $rpmCriteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
    $rpmCriteria->setLimit(20);

    $rpms = RpmPeer::doSelect($rpmCriteria);
    foreach($rpms as $rpm)
      $this->rss[] = $rpm;

    //set RSS layout
    $this->setLayout("rss");
    return "View";
    
  }
}
