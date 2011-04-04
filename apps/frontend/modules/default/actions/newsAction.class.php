<?php
class newsAction extends madbActions
{
  public function execute($request)
  {
    $criteria = $this->getCriteria(filterPerimeters::RPM);
    $criteria->addJoin(RpmPeer::RPM_GROUP_ID, RpmGroupPeer::ID, Criteria::JOIN);
    $criteria->clearSelectColumns();
    $criteria->addAsColumn(
      'the_name',
      sprintf("SUBSTRING_INDEX(%s, '/',". 1 . ")", RpmGroupPeer::NAME)
    );  
    $criteria->addGroupByColumn('the_name');
    $criteria->addAsColumn('nb_of_packages', 'COUNT(DISTINCT(' . RpmPeer::PACKAGE_ID . '))');
    $criteria->addAscendingOrderByColumn('the_name');

    $stmt         = RpmGroupPeer::doSelectStmt($criteria);
    $this->groups = $stmt->fetchAll();
    
    // Menu entries depend on the list of media
    $this->has_updates = MediaPeer::countMediaByType(true, false, false) + count(DistreleasePeer::getDevels());
    $this->has_backports = MediaPeer::countMediaByType(false, true, false);
  }
}
