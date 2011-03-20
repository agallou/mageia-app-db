<?php
class listComponent extends madbComponent
{

  public function getRequiredVars()
  {
    return array('listtype', 'page', 'showpager', 'display_header', 'limit');
  }

  public function execute($request)
  {
    $criteria = $this->getCriteria(filterPerimeters::RPM);
    switch ($this->listtype)
    {
      case 'updates':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        $criteria->add(MediaPeer::IS_UPDATES, true, Criteria::EQUAL);
        $criteria->add(MediaPeer::IS_TESTING, false, Criteria::EQUAL);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        $this->title = 'Updates (security and bugfix)';
        break;
      case 'updates_testing':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        $criteria->add(MediaPeer::IS_UPDATES, true, Criteria::EQUAL);
        $criteria->add(MediaPeer::IS_TESTING, true, Criteria::EQUAL);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        $this->title = 'Updates awaiting your testing';
        break;
      case 'backports':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        $criteria->add(MediaPeer::IS_BACKPORTS, true, Criteria::EQUAL);
        $criteria->add(MediaPeer::IS_TESTING, false, Criteria::EQUAL);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        $this->title = 'Backports (new soft versions)';
        break;
      case 'backports_testing':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        $criteria->add(MediaPeer::IS_BACKPORTS, true, Criteria::EQUAL);
        $criteria->add(MediaPeer::IS_TESTING, true, Criteria::EQUAL);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        $this->title = 'Backports awaiting your testing';
        break;
      default : 
        throw new Exception('Unknown value for listtype : \'' . $this->listtype . '\'');
        break;
    }
    $this->pager = new PropelPager($criteria, 'RpmPeer', 'doSelect', $this->page, $this->limit);
  }

}
