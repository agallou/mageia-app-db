<?php
class mysqlCliWrapper 
{

  protected $dbInfos = null;
  protected $fs      = null;

  public function __construct(dbInfos $dbInfos, sfFilesystem $filesystem)
  {
    $this->dbInfos    = $dbInfos;
    $this->filesystem = $filesystem;
  }

  public function getFilesystem()
  {
    return $this->filesystem;
  }

  public function getDbInfos()
  {
    return $this->dbInfos;
  }

  protected function getArgs()
  {
    if (null !== $this->getDbInfos()->getPassword())
    {
      $password = '-p' . $this->getDbInfos()->getPassword();
    }
    else
    {
      $password = '';
    }
    return sprintf(' -h %s -u%s %s %s', $this->getDbInfos()->getHost(), $this->getDbInfos()->getUser(), $password, $this->getDbInfos()->getName());
  }

  public function executeFile($filePath)
  {
    $this->getFilesystem()->execute(sprintf('mysql %s < %s', $this->getArgs(), $filePath));
  }

  public function execute($sql)
  {
    $this->getFilesystem()->execute(sprintf('mysql %s -e "%s"', $this->getArgs(), $sql));
  }
}
