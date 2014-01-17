<?php
class diffAction extends madbActions
{
  public function execute($request)
  {
    $this->forward404Unless($request->hasParameter('name') or $request->hasParameter('pkgid'), 'RPM name or pkgid is required');
    $name = $request->getParameter('name');
    $pkgid = $request->getParameter('pkgid');

    $madbcontext_package = clone $this->madbcontext;
    $madbcontext_package->removeParameter('t_media');
    
    $criteriaFactory = new criteriaFactory();
    $criteria = $criteriaFactory->createFromContext($madbcontext_package, filterPerimeters::RPM, false);
    
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

    $madbConfig = new madbConfig();
    $this->allow_install = $madbConfig->get('allow_install');

    $this->rpms = RpmPeer::doSelect($criteria);
    $this->forward404Unless($this->rpms, 'No RPM found for this name or pkgid');
    if (count($this->rpms) > 1)
    {
      $this->forward404("Missing parameter(s)");
    }
    else
    {
      $this->rpm = $this->rpms[0];
    }
    
    // Find the latest rpm for this package, if there's one, except the current rpm we are analyzing
    $this->package = $this->rpm->getPackage();

    $criteria = $criteriaFactory->createFromContext($madbcontext_package, filterPerimeters::RPM, false);
    $rpms = array();
    foreach ($this->package->getRpms($criteria) as $rpm)
    {
      if ($rpm->getName() != $this->rpm->getName())
      {
        $rpms[] = $rpm;
      }
    }
    $rpms = RpmPeer::sortByEvrAndDistrelease($rpms);
    
    if (!empty($rpms))
    {
      $this->rpm_for_comparison = $rpms[count($rpms)-1];
      $command = "bash ../bin/qarpmdiff.sh " .
        $this->rpm->getDistrelease()->getName() . " " .
        ($this->rpm->getIsSource() ? 'SRPMS' : $this->rpm->getArch()->getName()) . " " .
        str_replace('-', '/', $this->rpm_for_comparison->getMedia()->getName()) . " " .
        $this->rpm_for_comparison->getName() . " " .
        str_replace('-', '/', $this->rpm->getMedia()->getName()) . " " .
        $this->rpm->getName();
      
      $this->output = shell_exec($command);
      
//      echo $command;
    }
    else
    {
      return "Error";
    }
  }
}
