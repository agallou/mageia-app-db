<?php
class madbInitTask extends madbBaseTask
{

  protected function configure()
  {
    $this->namespace = 'madb';
    $this->name      = 'init';
    $this->aliases   = array('init');
    $this->addOption('insert-test-data', null, sfCommandOption::PARAMETER_NONE, 'insert test data');
    $this->addOption('reinit', null, sfCommandOption::PARAMETER_NONE, 'reconfigure database connection information');
    $this->addOption('no-confirmation', null, sfCommandOption::PARAMETER_NONE, 'do not ask any confirmation');
    $this->addOption('admin-password', null, sfCommandOption::PARAMETER_OPTIONAL, 'do not ask any confirmation', 'admin');
  }
  protected function execute($arguments = array(), $options = array())
  {
    ini_set('memory_limit', '128M'); //we need this because we load a lot of propel classes.
    if (!file_exists(sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'databases.yml')
    || !file_exists(sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'propel.ini'))
    {
      $options['reinit'] = true;
    }

    if ($options['reinit'])
    {
      $databases = file_get_contents(sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'databases.yml-dist');
      $propel    = file_get_contents(sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'propel.ini-dist');

      if (!isset($options['db_host']))
      {
        $options['db_host'] = $this->ask('host (localhost):', 'QUESTION_LARGE', 'localhost');
      }
      $databases = str_replace('%%host%%', $options['db_host'], $databases);
      $propel    = str_replace('%%host%%', $options['db_host'], $propel);

      if (!isset($options['db_name']))
      {
        $options['db_name'] = $this->ask('database name:', 'QUESTION_LARGE');
      }
      $databases = str_replace('%%database%%', $options['db_name'], $databases);
      $propel    = str_replace('%%database%%', $options['db_name'], $propel);

      if (!isset($options['db_user']))
      {
        $options['db_user'] = $this->ask('database user name (root):', 'QUESTION_LARGE', 'root');
      }
      $databases = str_replace('%%user%%', $options['db_user'], $databases);
      $propel    = str_replace('%%user%%', $options['db_user'], $propel);

      if (!isset($options['db_pass']))
      {
        $options['db_pass'] = $this->ask('database password (""):', 'QUESTION_LARGE', '');
      }
      $databases = str_replace('%%pass%%', $options['db_pass'], $databases);
      $propel    = str_replace('%%pass%%', $options['db_pass'], $propel);

      file_put_contents(sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'databases.yml', $databases);
      file_put_contents(sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'propel.ini', $propel);
    }

    $task = new sfPropelBuildSqlTask($this->dispatcher, $this->formatter);
    $task->run();

    $task = new sfPropelBuildModelTask($this->dispatcher, $this->formatter);
    $task->run();

    $task = new sfPropelInsertSqlTask($this->dispatcher, $this->formatter);
    $tOptions = array();
    if ($options['no-confirmation'])
    {
      $tOptions[] = 'no-confirmation';
    }
    $task->run(array(), $tOptions);

    $task = new sfPropelDataLoadTask($this->dispatcher, $this->formatter);
    $task->run();

    if ($options['insert-test-data'])
    {
      $task = new madbInsertTestDataTask($this->dispatcher, $this->formatter);
      $task->run();
    }
    $task = new sfCacheClearTask($this->dispatcher, $this->formatter);
    $task->run();
    $task = new sfGuardCreateUserTask($this->dispatcher, $this->formatter);
    $task->run(array('username' => 'admin', 'password' => $options['admin-password']));
    $task = new sfGuardPromoteSuperAdminTask($this->dispatcher, $this->formatter);
    $task->run(array('username' => 'admin'));

  }
}
