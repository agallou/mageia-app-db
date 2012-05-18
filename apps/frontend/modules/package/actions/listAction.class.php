<?php
class listAction extends madbActions
{
  public function execute($request)
  {
    $this->t_group = $request->hasParameter('t_group') ? $request->getParameter('t_group') : null;
    $this->rpm_group = !is_null($this->t_group) ? RpmGroupPeer::retrieveByPK($this->t_group) : null;
    
    list($this->application) = $this->madbcontext->getRealFilterValue('application');
    $this->other_madbcontext = clone $this->getMadbContext();
    if ($this->application == 1)
    {
      $this->other_madbcontext->getParameterHolder()->set('application', 0);
    }
    else
    {
      $this->other_madbcontext->getParameterHolder()->set('application', 1);
    }
    
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
    $this->pager = new PropelPager($criteria, 'PackagePeer', 'doSelect', $page, 50);
  }

}
