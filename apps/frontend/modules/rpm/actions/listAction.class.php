<?php
class listAction extends madbActions
{
  public function execute($request)
  {
    if ($request->hasParameter('page'))
    {
      $page = $request->getParameter('page');
    }
    else
    {
      $page = 1;
    }

    $this->forward404Unless($request->hasParameter('listtype'), 'listtype parameter is required.');
    $this->listtype = $request->getParameter('listtype');
    $this->forward404Unless(in_array($this->listtype, array('updates', 'updates_testing', 'backports', 'backports_testing')), 'listtype value \'' . $this->listtype . '\' is not valid.');
    
    $criteria = $this->getCriteria(filterPerimeters::RPM);
    switch ($this->listtype)
    {
      case 'updates':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        $criteria->add(MediaPeer::IS_UPDATES, true, Criteria::EQUAL);
        $criteria->add(MediaPeer::IS_TESTING, false, Criteria::EQUAL);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        break;
      case 'updates_testing':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        $criteria->add(MediaPeer::IS_UPDATES, true, Criteria::EQUAL);
        $criteria->add(MediaPeer::IS_TESTING, true, Criteria::EQUAL);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        break;
      case 'backports':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        $criteria->add(MediaPeer::IS_BACKPORTS, true, Criteria::EQUAL);
        $criteria->add(MediaPeer::IS_TESTING, false, Criteria::EQUAL);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        break;
      case 'backports_testing':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        $criteria->add(MediaPeer::IS_BACKPORTS, true, Criteria::EQUAL);
        $criteria->add(MediaPeer::IS_TESTING, true, Criteria::EQUAL);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        break;
      default : 
        throw new Exception('Unknown value for listtype : \'' . $this->listtype . '\'');
    }
    
    $this->pager = new PropelPager($criteria, Rpm::PEER, 'doSelect', $page, 50);
  }

}
