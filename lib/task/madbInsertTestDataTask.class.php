<?php
class madbInsertTestDataTask extends sfBaseTask
{

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'insert-test-data';
    $defaultUrl = 'http://stormi.lautre.net/fichiers/mageia/sophie-dump.gz';
    $this->addOption('url', null, sfCommandOption::PARAMETER_OPTIONAL, 'url where test data are stored', $defaultUrl);
    $this->addOption('limit', null, sfCommandOption::PARAMETER_OPTIONAL, 'number of files to keep in the imported file', false);
  }
  protected function execute($arguments = array(), $options = array())
  {
    $this->getFilesystem()->mkdirs('tmp/');
    $filename = 'tmp/tmp_dump_sophie.gz';
    if (!file_exists($filename))
    {
      passthru('wget ' . $options['url'] . ' -O ' . $filename);
    }
    $filenameGunzip = 'tmp/tmp_dump_sophie';
    if (!file_exists($filenameGunzip))
    {
      $this->getFilesystem()->execute('gunzip ' . $filename . ' -c > ' . $filenameGunzip);
    }
    if ($options['limit'] !== false)
    {
      $this->getFilesystem()->execute(sprintf('head -n %s %s > tmp/reduced_file', $options['limit'], $filenameGunzip));
    }
    else
    {
      $this->getFilesystem()->execute(sprintf('cat %s > tmp/reduced_file', $filenameGunzip));
    }
    //TODO improve this
    $this->getFilesystem()->execute('mysql -u root mageiaappdb < doc/import_from_sophie_dump.sql', array($this, 'log'), array($this, 'log'));

   
  }
}
