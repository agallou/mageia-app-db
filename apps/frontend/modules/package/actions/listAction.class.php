<?php
class listAction extends madbActions
{
  public function execute($request)
  {
    $this->t_group = $request->hasParameter('t_group') ? str_replace('|', '/', $request->getParameter('t_group')) : null;
    
    if ($request->hasParameter('page'))
    {
      $page = $request->getParameter('page');
    }
    else
    {
      $page = 1;
    }
    $criteria = $this->getCriteria(filterPerimeters::PACKAGE);
    
    // TODO : treat this temporary filter like any other filter ? (temp tables, etc.)
    if (!is_null($this->t_group))
    {
      $criteria->addJoin(PackagePeer::ID, RpmPeer::PACKAGE_ID, Criteria::JOIN);
      $criteria->addJoin(RpmPeer::RPM_GROUP_ID, RpmGroupPeer::ID, Criteria::JOIN);
      $criteria->add(RpmGroupPeer::NAME, $this->t_group . '%', Criteria::LIKE);
      $criteria->setDistinct();
    }
    
    $criteria->addAscendingOrderByColumn(PackagePeer::NAME);
    $this->pager = new PropelPager($criteria, Package::PEER, 'doSelect', $page, 50);
  }

}
