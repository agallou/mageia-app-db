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
    $this->forward404Unless(in_array($this->listtype, array('updates', 'testing', 'backports')), 'listtype value \'' . $this->listtype . '\' is not valid.');
    
    $criteria = $this->getCriteria(filterPerimeters::RPM);
    switch ($this->listtype)
    {
      case 'updates':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        // TODO : use media.is_updates when the field will be available
        $criteria->add(MediaPeer::NAME, '%updates', Criteria::LIKE);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        break;
      case 'backports':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        // TODO : use media.is_backport when the field will be available
        $criteria->add(MediaPeer::NAME, '%backports', Criteria::LIKE);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        break;
      case 'testing':
        $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
        // TODO : use media.is_testing when the field will be available
        $criteria->add(MediaPeer::NAME, '%testing', Criteria::LIKE);
        $criteria->addDescendingOrderByColumn(RpmPeer::BUILD_TIME);
        break;
      default : 
        throw new Exception('Unknown value for listtype : \'' . $this->listtype . '\'');
    }
    
    $this->pager = new PropelPager($criteria, Rpm::PEER, 'doSelect', $page, 50);
  }

}
