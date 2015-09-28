<?php
class madbUpdateMaintainersTask extends madbBaseTask
{
  protected $propel = true;

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'update-maintainers';
    $this->addOption('url', null, sfCommandOption::PARAMETER_REQUIRED, 'URL to the maintainers database in TXT form', null);
    $this->aliases = array($this->name);
  }
  protected function execute($arguments = array(), $options = array())
  {
    if ($options['url'] == "")
    {
      throw new madbException("Empty URL");
    }
    
    sfContext::createInstance($this->createConfiguration('frontend', 'prod'));
//
//    $madbConfig = new madbConfig();
//    $madbDistroConfigFactory = new madbDistroConfigFactory();
//    $madbDistroConfig = $madbDistroConfigFactory->getCurrentDistroConfig($madbConfig);
    
    // TODO : replace with configured tmp dir or unique tmp files
    $this->getFilesystem()->mkdirs('tmp/');
    $filename = 'tmp/maintdb.txt';
    $this->getFilesystem()->execute("rm -f $filename");
    passthru('wget ' . $options['url'] . ' -O ' . $filename);
    passthru("sed -i 's/ \\+/\\t/' $filename");
    
    $this->updateMaintainersFromFile($filename);
  }
  
  protected function updateMaintainersFromFile($filename)
  {
    $con = Propel::getConnection();
    $databaseFactory = new databaseFactory($con);
    $database = $databaseFactory->createDefault();

    $sql = "DROP TABLE IF EXISTS tmpmaintainers";
    $con->exec($sql);

    // not temporary so that we can load data from CLI
    $sql = "CREATE TABLE tmpmaintainers (name VARCHAR(255), maint VARCHAR(255), PRIMARY KEY (name))";
    $con->exec($sql);

    $database->loadData('tmpmaintainers', $filename, false);

    // Reset maint db 
    $database->prepareAndExecuteQuery("UPDATE package SET maintainer='nobody'");

    // Update source packages first
    $database->updateWithJoin(
      'package',
      '',
      'maintainer=tmpmaintainers.maint',
      'tmpmaintainers',
      'package.name=tmpmaintainers.name AND package.is_source=TRUE'
    );

    // Update non-source packages too
    $database->updateWithJoin(
      'package',
      '',
      'maintainer=source_package.maintainer',
      'rpm AS source_rpm, rpm, package AS source_package',
      'source_package.ID = source_rpm.PACKAGE_ID
        AND source_rpm.ID = rpm.SOURCE_RPM_ID
        AND rpm.is_source = FALSE
        AND rpm.PACKAGE_ID = package.ID'
    );

    $sql = "DROP TABLE IF EXISTS tmpmaintainers";
    $con->exec($sql);
  }
}
