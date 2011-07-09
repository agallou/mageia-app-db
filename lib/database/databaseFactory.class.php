<?php

class databaseFactory
{

  /**
   * connection 
   * 
   * @var null|$connection
   */
  protected $connection = null;

  /**
   * __construct 
   * 
   * @param PDO $connection 
   *
   * @return void
   */
  public function __construct(PDO $connection = null)
  {
    $this->setConnection($connection);
  }

  /**
   * createDefault
   * 
   * @param PDO $connection
   *
   * @return databaseInterface
   */
  public function createDefault()
  {
    $con = Propel::getConfiguration();
    $adapter = $con['datasources']['propel']['adapter'];
    if ($adapter == 'pgsql')
    {
      $adapter = 'postgresql';
    }
    return $this->createFromType($adapter);
  }

  /**
   * getConnection 
   * 
   * @return PDO
   */
  public function getConnection()
  {
    if (null === $this->connection)
    {
      return Propel::getConnection();
    }
    return $this->connection;
  }

  /**
   * setConnection
   * 
   * @param PDO $connection
   *
   * @return databaseFactory
   */
  public function setConnection(PDO $connection = null)
  {
    $this->connection = $connection;

    return $this;
  }

  /**
   * createFromType
   * 
   * @param string $type
   *
   * @return databaseInterface
   */
  public function createFromType($type)
  {
    $class = $this->getClassnameFromType($type);
    if (!($class instanceof databaseInterface))
    {
    //  throw new databaseFactoryException(sprintf('class "%s" does not implements databaseInterface', $class));
    }
    return new $class($this->getConnection());
  }

  /**
   * getClassnameFromType 
   * 
   * @param string $type 
   *
   * @return string
   */
  protected function getClassnameFromType($type)
  {
    return $type . 'Database';
  }

}
