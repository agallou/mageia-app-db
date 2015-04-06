<?php
class madbInsertTestDataTask extends madbBaseTask
{

  protected $propel = true;

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'insert-test-data';
    $this->defaultUrl = 'http://stormi.lautre.net/fichiers/mageia/test-data-mageia.zip';
    $this->addOption('url', null, sfCommandOption::PARAMETER_OPTIONAL, 'url where test data are stored. Setting this option forces the download even if test data already are on the local system.', null);

    $this->propel = true;
    $this->aliases = array($this->name);
  }
  protected function execute($arguments = array(), $options = array())
  {
    sfContext::createInstance($this->createConfiguration('frontend', 'prod'));
    $con = Propel::getConnection();

    // TODO : replace with configured tmp dir
    $this->getFilesystem()->mkdirs('tmp/');
    $archive_name = 'tmp/data.zip';
    $content_dir = 'tmp/test-data';
    $this->getFilesystem()->mkdirs($content_dir);
    $this->getFilesystem()->execute("rm -f $content_dir/*");


    // Download test data if they are absent from the local system, or if the --url option was used
    if (!file_exists($archive_name) or $options['url']!==null)
    {
      $url = ($options['url']!==null) ? $options['url'] : $this->defaultUrl;
      passthru('wget ' . $url . ' -O ' . $archive_name);
    }

    $databaseFactory = new databaseFactory($con);
    $database = $databaseFactory->createDefault();

    if (file_exists($archive_name))
    {
      $this->getFilesystem()->execute("unzip -o -d $content_dir/ " . $archive_name);
      $this->getFilesystem()->rename($content_dir . '/rpm_group.txt', $content_dir . '/00_rpm_group.txt');

      $database->getConnection()->beginTransaction();
      $database->disableConstraints();

      // FIXME :hard-code insert order
      foreach (sfFinder::type("file")->sort_by_name()->in($content_dir) as $file)
      {
        $table = preg_replace('/\.txt$/', '', basename($file));
        if ($table == '00_rpm_group')
        {
          $table = 'rpm_group';
        }

        $this->log("Inserting values into table $table");
        $database->truncateTable($table);

        $database->loadData($table, $file);
      }
      $database->getConnection()->commit();
    }
    else
    {
      echo "No file named $archive_name found, aborting test data insertion.";
      return false;
    }
  }
}
