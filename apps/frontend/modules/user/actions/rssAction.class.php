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
    $c = new Criteria();
    $c->add(RssFeedPeer::USER_ID,$userId);
    $this->rssFeeds = RssFeedPeer::doSelect($c);

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
        if($notification->getUpdate() != NULL)
        {
            $updateCriteria = new Criteria();
            $updateCriteria->addJoin(RpmPeer::MEDIA_ID,MediaPeer::ID);
            $updateCriteria->addJoin(RpmPeer::DISTRELEASE_ID,DistreleasePeer::ID);
            $criterion = $updateCriteria->getNewCriterion(MediaPeer::IS_UPDATES, true, Criteria::EQUAL);
            $criterion->addOr($updateCriteria->getNewCriterion(DistreleasePeer::IS_DEV_VERSION, true, Criteria::EQUAL));
            $updateCriteria->add($criterion);
            $updateCriteria->add(MediaPeer::IS_TESTING, false, Criteria::EQUAL);
        }
        /*
        else $updateCriteria = NULL;
        if($notification->getUpdateCandidate() != NULL)
        {
            $updateCandidateCriteria = $this->getCriteria(filterPerimeters::RPM);
            $updateCandidateCriteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
            $updateCandidateCriteria->add(MediaPeer::IS_UPDATES, true, Criteria::EQUAL);
            $updateCandidateCriteria->add(MediaPeer::IS_TESTING, true, Criteria::EQUAL);
        }
        else $updateCandidateCriteria = NULL;
        if($notification->getNewVersion() != NULL)
        {
            $newVersionCriteria = $this->getCriteria(filterPerimeters::RPM);
            $newVersionCriteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
            $newVersionCriteria->add(MediaPeer::IS_BACKPORTS, true, Criteria::EQUAL);
            $newVersionCriteria->add(MediaPeer::IS_TESTING, false, Criteria::EQUAL);
        }
        else $newVersionCriteria = NULL;
        if($notification->getNewVersionCandidate() != NULL)
        {
            $newVersionCandidateCriteria = $this->getCriteria(filterPerimeters::RPM);
            $newVersionCandidateCriteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
            $newVersionCandidateCriteria->add(MediaPeer::IS_BACKPORTS, true, Criteria::EQUAL);
            $newVersionCandidateCriteria->add(MediaPeer::IS_TESTING, true, Criteria::EQUAL);
        }
        else $newVersionCandidateCriteria = NULL;
        */

        
        $updateCriteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        $updateCriteria->setLimit("10");
        $rpms = RpmPeer::doSelect($updateCriteria);
        $this->updateCr = $updateCriteria;
        foreach($rpms as $rpm)
        {
            $this->rss[] = $rpm;
            $this->logMessage("RPM added: ".$rpm->getName());
        }
    }

    //set RSS layout
    $this->setLayout("rss");
    return "View";
  }
}
