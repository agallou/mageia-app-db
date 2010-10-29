<?php
class listAction extends sfActions
{
  public function execute($request)
  {
    $this->packages = PackagePeer::doSelect(new Criteria());
    $this->title    = 'Packages';
  }

}
