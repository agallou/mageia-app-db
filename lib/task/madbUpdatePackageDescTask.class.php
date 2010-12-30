<?php
class madbUpdatePackageDesc extends madbBaseTask
{

  protected $propel = true;

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'update-package-desc';
  }
  protected function execute($arguments = array(), $options = array())
  {
    sfContext::createInstance($this->createConfiguration('frontend', 'prod'));
    $con = Propel::getConnection();

    Propel::disableInstancePooling();
    
    $sql = "UPDATE package SET description=NULL, summary=NULL;";
    $con->exec($sql);
    
    $stmt = PackagePeer::doSelectStmt(new Criteria());
    foreach ($stmt as $rs)
    {
      $package = new Package();
      $package->hydrate($rs);
      
      try
      {
        $package->updateSummaryAndDescription();
      }
      catch (PackageException $e)
      {
        echo $e->getMessage() . "\n";
      }
//      $package->clearAllReferences(true);
//      unset($package);
    }
  }
}
