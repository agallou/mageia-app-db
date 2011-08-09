<?php

class graphivzGroupRecordsTask extends sfBaseTask
{

  protected $removeFields = false;

  protected function configure()
  {
   $this->addOptions(array(
      new sfCommandOption('file', null, sfCommandOption::PARAMETER_REQUIRED, 'File'),
      new sfCommandOption('output', null, sfCommandOption::PARAMETER_REQUIRED, 'File'),
      new sfCommandOption('reverse', null, sfCommandOption::PARAMETER_NONE, 'Reverse'),
      new sfCommandOption('simple', null, sfCommandOption::PARAMETER_NONE, 'simple'),
    ));

    $this->namespace        = '';
    $this->name             = 'graphivz-group-records';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
./symfony propel:graphivz
./symfony graphivz-group-records --file=graph/propel.schema.dot --output=test.out
dot -Tpng test.out > test.png && gnome-open test.png
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $file = $options['file'];

    $writedFile = new splFileObject($options['output'], 'w');
    $writedFile->fwrite('digraph G {' . PHP_EOL);
    if ($options['reverse'])
    {
      $writedFile->fwrite(sprintf('rankdir="LR";'));
    }
    if ($options['simple'])
    {
      $this->removeFields = true;
    }
    foreach ($this->getGroups() as $name => $tables)
    {
      $writedFile->fwrite(sprintf('subgraph cluster_%s', sfInflector::camelize(str_replace(' ', '', $name))));
      $writedFile->fwrite('{' . PHP_EOL);
      $writedFile->fwrite($this->getClusterDefinition($name));
      foreach ($tables as $table)
      {
        $toWrite = $this->getNodeLineFromTable($file, $table) . PHP_EOL;
        $toWrite = $this->removeFields($toWrite);
        $writedFile->fwrite($toWrite);
      }
      $writedFile->fwrite('}' . PHP_EOL);
    }

    $toWrite = $this->getGrouplessNodes($file);
    $toWrite = $this->removeFields($toWrite);
    $writedFile->fwrite($toWrite);

    $writedFile->fwrite('}');
  }

  protected function removeFields($lines)
  {
    if (!$this->removeFields)
    {
      return $lines;
    }
    $lines = preg_replace('/\|<cols>.*", shape=record/', '"', $lines);
    $lines = preg_replace('/\{<table>/', '', $lines);
    $lines = preg_replace('/:cols ->/', '->', $lines);
    $lines = preg_replace('/:table.*;/', ';', $lines);
    return $lines;
  }

  protected function getClusterDefinition($name)
  {
    $ret = <<<EOF
  node [style=filled];
  color=blue;

EOF;
    $ret .= sprintf('label = "%s"', $name) . PHP_EOL;
    return $ret;
  }

  protected function getNodeLineFromTable($file, $table)
  {
    $dotFile = new splFileObject($file);
    foreach ($dotFile as $line)
    {
      $lineTable = $this->getTableFromNodeLine($line);
      if ($lineTable == $table)
      {
        return $line;
      }
    }
    throw new sfException(sprintf('table "%s" not found', $table));
  }

  protected function getGrouplessNodes($file)
  {
    $dotFile = new splFileObject($file);
    $nodes   = '';
    foreach ($dotFile as $line)
    {
      $table = $this->getTableFromNodeLine($line);
      if ($this->isLineNode($line) && $this->isTableGroupless($table))
      {
        $nodes .= $line;
      }
    }
    return $nodes;
  }

  protected function isTableGroupless($table)
  {
    foreach ($this->getGroups() as $tables)
    {
      if (in_array($table, $tables))
      {
        return false;
      }
    }
    return true;
  }

  protected function isLineNode($line)
  {
    return substr($line, 0, 4) == 'node';
  }

//TODO rename to getTableFromLine
  protected function getTableFromNodeLine($line)
  {
    if ($this->isLineNode($line))
    {
      return substr($line, 4, strpos($line, ' ') - 4);
    }
    //TODO exception
  }

  protected function getGroups()
  {
    return array(
      'rpm' => array(
        'distrelease',
        'rpm',
        'media',
        'rpm_group',
        'arch',
      ),
      'packages' => array(
        'package',
        'package_links',
      ),
      'see_later' => array(
        'user_comments_package',
        'package_screenshots',
        'package_description',
      ),
      'software request' => array(
        'user_comments_software_request',
        'software_request',
        'user_has_software_request',
      ),
      'new version request' => array(
        'user_comments_new_version_request',
        'new_version_request',
        'user_has_new_version_request',
      ),
      'following and notifications' => array(
        'notification',
        'rss_feed',
        'subscription_element',
        'subscription',
      ),
      'sf_guard' => array(
        'sf_guard_remember_key',
        'sf_guard_user',
        'sf_guard_user_permission',
        'sf_guard_permission',
        'sf_guard_group',
        'sf_guard_group_permission',
        'sf_guard_user_group',
      ),
    );
  }

}
