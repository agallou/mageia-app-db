<?php

class graphivzGroupRecordsTask extends sfBaseTask
{

  protected $removeFields = false;
  protected $groupedTables = null;
  protected $tables = array();

  protected function configure()
  {
   $this->addOptions(array(
      new sfCommandOption('file', null, sfCommandOption::PARAMETER_REQUIRED, 'File'),
      new sfCommandOption('output', null, sfCommandOption::PARAMETER_REQUIRED, 'File'),
      new sfCommandOption('reverse', null, sfCommandOption::PARAMETER_NONE, 'Reverse'),
      new sfCommandOption('simple', null, sfCommandOption::PARAMETER_NONE, 'simple'),
      new sfCommandOption('groups-file', null, sfCommandOption::PARAMETER_REQUIRED, 'groups file'),
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
    $file                = $options['file'];
    $this->groupedTables =  $options['groups-file'];
    $this->initializeTables($file);
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
    foreach ($this->getGroups($this->groupedTables) as $name => $tables)
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

  protected function initializeTables($file)
  {
    $dotFile = new splFileObject($file);
    $tables   = '';
    foreach ($dotFile as $line)
    {
      if (substr($line, 0, 4) == 'node' && strpos($line, '<table>'))
      {
        $tables[] = substr($line, 4, strpos($line, ' ') - 4);
      }
    }
    $this->tables = $tables;
  }

  protected function getTables()
  {
    return $this->tables;
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
    foreach ($this->getGroups($this->groupedTables) as $tables)
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

  protected function getGroups($file)
  {
    if (!is_file($file))
    {
      throw new sfException('grouped tables files does not exists');
    }
    $loader = sfYaml::load($file);
    $groups = array();
    $tables = $this->getTables();
    foreach ($loader['groups'] as $name => $items)
    {
      $groupTables = array();
      foreach ($items['allow'] as $allowedPattern)
      {
        foreach ($tables as $table)
        {
          if (preg_match($allowedPattern, $table))
          {
            $groupTables[] = $table;
          }
        }
      }
      if (isset($items['deny']))
      {
        foreach ($items['deny'] as $denyPattern)
        {
          foreach ($groupTables as $key => $table)
          {
            if (preg_match($denyPattern, $table))
            {
              unset($groupTables[$key]);
            }
          }
        }
      }
      $groups[$name] = $groupTables;
    }
    return $groups;
  }

}
