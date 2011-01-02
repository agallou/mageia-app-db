<?php
class listAction extends madbActions
{
  public function execute($request)
  {
    $this->t_group = $request->hasParameter('t_group') ? $request->getParameter('t_group') : null;
    $this->rpm_group = !is_null($this->t_group) ? RpmGroupPeer::retrieveByPK($this->t_group) : null;
    
    if ($request->hasParameter('page'))
    {
      $page = $request->getParameter('page');
    }
    else
    {
      $page = 1;
    }
    $criteria = $this->getCriteria(filterPerimeters::PACKAGE);
    
    $criteria->addAscendingOrderByColumn(PackagePeer::NAME);
    $this->pager = new PropelPager($criteria, Package::PEER, 'doSelect', $page, 50);
  }

}
