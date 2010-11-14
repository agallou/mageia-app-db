<?php
class listAction extends sfActions
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
    $criteria = new Criteria();
    $criteria->addAscendingOrderByColumn(PackagePeer::NAME);
    $this->pager = new PropelPager($criteria, Package::PEER, 'doSelect', $page, 50);
    $this->title = 'Packages';
  }

}
