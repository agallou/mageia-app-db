<?php
class madbInsertTestDataTask extends madbBaseTask
{

  protected $propel = true;

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'insert-test-data';
    $this->defaultUrl = 'http://stormi.lautre.net/fichiers/mageia/test-data-mandriva.zip';
    $this->addOption('url', null, sfCommandOption::PARAMETER_OPTIONAL, 'url where test data are stored. Setting this option forces the download even if test data already are on the local system.', null);
    $this->addOption('limit', null, sfCommandOption::PARAMETER_OPTIONAL, 'number of lines to keep in the imported file', false);
    $this->propel = true;
    $this->aliases = array($this->name);
  }
  protected function execute($arguments = array(), $options = array())
  {
    sfContext::createInstance($this->createConfiguration('frontend', 'prod'));
    // TODO : replace relative paths with absolute paths from dirname(__FILE__) ?
    $this->getFilesystem()->mkdirs('tmp/');
    $archive_name = 'tmp/test-data.zip';
    $filename = 'tmp/dump_sophie.gz';
    $filenameGunzip = 'tmp/dump_sophie';
    $reduced_file = 'tmp/reduced_file';
    
    // Download test data if they are absent from the local system, or if the --url option was used
    if (!file_exists($archive_name) or $options['url']!==null)
    {
      $url = ($options['url']!==null) ? $options['url'] : $this->defaultUrl;
      // TODO : why passthru and not $this->getFilesystem()->execute() ? 
      passthru('wget ' . $url . ' -O ' . $archive_name);
    }
    
    if (file_exists($archive_name))
    {
      $this->getFilesystem()->execute("rm -f $filename $filenameGunzip $reduced_file");
      $this->getFilesystem()->execute('unzip -o -d tmp/ ' . $archive_name);
      
      $this->getFilesystem()->execute('gunzip ' . $filename . ' -c > ' . $filenameGunzip);
      if ($options['limit'] !== false)
      {
        $this->getFilesystem()->execute(sprintf('head -n %s %s > tmp/reduced_file', $options['limit'], $filenameGunzip));
      }
      else
      {
        $this->getFilesystem()->execute(sprintf('cat %s > tmp/reduced_file', $filenameGunzip));
      }
      
      $dbCli = new mysqlCliWrapper(dbInfosFactory::getDefault(), $this->getFilesystem());
      $dbCli->executeFile('doc/import_test_data-step1.sql');
      $dbCli->executeFile('tmp/import_test_data-step2.sql');
      $dbCli->executeFile('doc/import_test_data-step3.sql');
      $dbCli->executeFile('tmp/import_test_data-step4.sql');
      $dbCli->executeFile('doc/import_test_data-step5.sql');
      $dbCli->executeFile('tmp/import_test_data-step6.sql');
      $dbCli->executeFile('doc/import_test_data-step7.sql');
      
      $task = new madbUpdatePackageDescTask($this->dispatcher, $this->formatter);
      $task->run();
    }
    else 
    {
      echo "No file named $archive_name found, aborting test data insertion.";
      return false;
    }
    
    $dbCli->execute("insert into user(name, login) values ('admin', 'admin');");
  }
}
