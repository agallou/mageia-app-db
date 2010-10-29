<?php
class listAction extends sfActions
{
  public function execute($request)
 {
    $criteria = new Criteria();
    $criteria->add(PackagePeer::IS_APPLICATION, true);
    $this->packages = PackagePeer::doSelect($criteria);
    $this->title    = 'Applications';
    $this->setTemplate('list', 'package');
  }
}
