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
    
    $sql = "UPDATE package SET description=NULL, summary=NULL;";
    $con->exec($sql);
/*    
    for ($i=1; $i<11;$i++)
    {
    $package = PackagePeer::doSelectOne(new Criteria());
var_dump($package->getName());    
    $package->updateSummaryAndDescription();
    }
    */
    
    echo memory_get_usage() . "\n";
    foreach (PackagePeer::doSelect(new Criteria()) as $package)
    {
      try
      {
        $package->updateSummaryAndDescription();
      }
      catch (Exception $e)
      {
        echo $e->getMessage() . "\n";
      }
    }
    
    echo memory_get_usage() . "\n";
    
    
  }
}
