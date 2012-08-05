<?php
class sourcepkgAction extends sfActions
{
  public function execute($request)
  {
    // Get the source package name from a string that could represent many things (RPM, SRPM, package, partil RPM name...)

    // Input: package name, source package name, RPM name, SRPM name, or part of RPM/SRPM name
    // Output: source package name

    $this->forward404Unless($request->hasParameter('q'));
    $q = $request->getParameter('q');

    if ($name = $this->match($q))
    {
      $this->renderText($name);
      return sfView::NONE;
    }

    // Else we try to deduce the package name
    // just in case, only keep the package name
    // x11-driver-video-ati-6.14.1-4.mga1.src.rpm => x11-driver-video-ati
    $ptemp = explode('-', $q);
    $pkg   = array();
    foreach ($ptemp as $pi) 
    {
      if (is_int(substr($pi, 0, 1)))
      {
        break;
      }
      $pkg[] = $pi;
    }
    $pkg = implode('-', $pkg);
    
    if ($name = $this->match($pkg))
    {
      $this->renderText($name);
      return sfView::NONE;
    }
    
    $this->renderText('NOTFOUND');
    return sfView::NONE;
  }
  
  private function match($q)
  {
    // Try to match exact SRPM name
    $criteria = new Criteria();
    $criteria->add(RpmPeer::NAME, $q);
    $criteria->add(RpmPeer::IS_SOURCE, true);
    if ($source_rpm = RpmPeer::doSelectOne($criteria))
    {
      return $source_rpm->getPackage()->getName();
    }

    // Try to match exact RPM name
    $criteria = new Criteria();
    $criteria->add(RpmPeer::NAME, $q);
    $criteria->add(RpmPeer::IS_SOURCE, false);
    if ($rpm = RpmPeer::doSelectOne($criteria))
    {
      if ($source_rpm = $rpm->getRpmRelatedBySourceRpmId())
      {
        return $source_rpm->getPackage()->getName();
      }
    }
    
    // Try to match a source package name
    if (PackagePeer::retrieveByNameAndIsSource($q, true))
    {
      return $q;
    }
    
    // Else let's see if it's a non-source package name
    if ($package = PackagePeer::retrieveByNameAndIsSource($q, false))
    {
      // Get its last RPM
      $criteria = new Criteria();
      $criteria->add(RpmPeer::PACKAGE_ID, $package->getId());
      $criteria->addDescendingOrderByColumn(RpmPeer::ID);
      if ($rpm = RpmPeer::doSelectOne($criteria))
      {
        if ($source_rpm = $rpm->getRpmRelatedBySourceRpmId())
        {
          return $source_rpm->getPackage()->getName();
        }
      }
    }
    
    // Else try to match partial SRPM name
    $criteria = new Criteria();
    $criteria->add(RpmPeer::NAME, $q . "%", Criteria::LIKE);
    $criteria->add(RpmPeer::IS_SOURCE, true);
    if ($source_rpm = RpmPeer::doSelectOne($criteria))
    {
      return $source_rpm->getPackage()->getName();
    }

    // Else try to match partial RPM name
    $criteria = new Criteria();
    $criteria->add(RpmPeer::NAME, $q . "%", Criteria::LIKE);
    $criteria->add(RpmPeer::IS_SOURCE, false);
    if ($source_rpm = RpmPeer::doSelectOne($criteria))
    {
      return $source_rpm->getPackage()->getName();
    }
    
    return false;
  }
}
