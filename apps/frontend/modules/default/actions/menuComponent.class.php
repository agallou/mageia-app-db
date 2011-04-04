<?php 
class menuComponent extends sfComponent
{
  public function execute($request)
  {
    $this->madburl = new madbUrl($this->getContext());
    $contextFactory = new contextFactory();
    $this->madbcontext = $contextFactory->createFromRequest($this->getRequest());
    
    // Menu entries depend on the list of media
    $this->has_updates = MediaPeer::countMediaByType(true, false, false) + count(DistreleasePeer::getDevels());
    $this->has_updates_testing = MediaPeer::countMediaByType(true, false, true);
    $this->has_backports = MediaPeer::countMediaByType(false, true, false);
    $this->has_backports_testing = MediaPeer::countMediaByType(false, true, true);
  }
}
