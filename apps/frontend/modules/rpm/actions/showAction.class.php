<?php
class showAction extends madbActions
{
  public function execute($request)
  {
    $this->forward404Unless($request->hasParameter('name') or $request->hasParameter('pkgid'), 'RPM name or pkgid is required');
    $name = $request->getParameter('name');
    $pkgid = $request->getParameter('pkgid');

    $criteriaFactory = new criteriaFactory();
    $criteria = $criteriaFactory->createFromContext($this->madbcontext, filterPerimeters::RPM, false);
    
    if ($pkgid !== null)
    {
      $criteria->add(RpmPeer::RPM_PKGID, $pkgid);
    }
    elseif ($name !== null)
    {
      $criteria->add(RpmPeer::NAME, $name);
    }
    $criteria->addAscendingOrderByColumn(RpmPeer::DISTRELEASE_ID); // should be useless, but can't hurt
    $criteria->addAscendingOrderByColumn(RpmPeer::IS_SOURCE);  
    $criteria->addAscendingOrderByColumn(RpmPeer::MEDIA_ID);  
    $criteria->addAscendingOrderByColumn(RpmPeer::ARCH_ID);  

    $this->rpms = RpmPeer::doSelect($criteria);
    $this->forward404Unless($this->rpms, 'No RPM found for this name or pkgid');
    if (count($this->rpms) > 1) 
    {
      return 'Multi';
    }
    else
    {
      $this->rpm = $this->rpms[0];
      $this->sophie = new SophieClient();
    }
  }
}
