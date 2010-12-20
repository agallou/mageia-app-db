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
    $criteria = $this->getCriteria(filterPerimeters::PACKAGE);
    $criteria->addAscendingOrderByColumn(PackagePeer::NAME);
    $this->pager = new PropelPager($criteria, Package::PEER, 'doSelect', $page, 50);
  }

}
