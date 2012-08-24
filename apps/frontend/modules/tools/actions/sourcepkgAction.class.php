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
    // a defined parameter without a value returns true, hence the test on true
    if (!$q or $q === true)
    {
      $this->renderText('NOTFOUND');
      return sfView::NONE;
    }
    
    if ($source_pkg = PackagePeer::retrieveSourcePackageFromString($q, true))
    {
      $this->renderText($source_pkg->getName());
      return sfView::NONE;
    }

    $this->renderText('NOTFOUND');
    return sfView::NONE;
  }
  
  
}
