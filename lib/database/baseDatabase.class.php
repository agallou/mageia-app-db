<?php
abstract class baseDatabase implements databaseInterface
{

  /**
   * connection
   * 
   * @var PDO
   */
  protected $connection;

  /**
   * __construct
   * 
   * @param PDO $connection
   *
   * @return void
   */
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
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
      throw new sfException('unable to find connection');
    }
    return $this->connection;
  }

  /**
   * setConnection 
   * 
   * @param PDO $connection

   * @return databaseInterface
   */
  public function setConnection(PDO $connection)
  {
    $this->connection = $connection;

    return $this;
  }

  /**
   * createTableFromCriteria
   * 
   * @param Criteria $criteria
   * @param mixed $name
   * @param mixed $temporary
   *
   * @return tableFieldsHelper
   */
  public function createTableFromCriteria(Criteria $criteria, $name, $temporary = true)
  {
    $params = array();
    $sql    = BasePeer::createSelectSql($criteria, $params);
    $params = $this->prepareCreateSelectSqlParamsForBind($params);
    $query  = $this->createTableFromQuerySyntax($name, $sql);
    $this->prepareAndExecuteQuery($query, $params);
    return new tableFieldsHelper($name);
  }

  /**
   * prepareCreateSelectSqlParamsForBind 
   * 
   * @param array $params
   *
   * @return array
   */
  protected function prepareCreateSelectSqlParamsForBind(array $params)
  {
    $bindedParams = array();
    foreach ($params as $key => $param)
    {
      $bindedParams[':p' . ($key + 1)] = $param['value'];
    }
    return $bindedParams;
  }

  /**
   * createTableFromQuerySyntax
   * 
   * @param string $tablename
   * @param string $query
   *
   * @return string
   */
  abstract protected function createTableFromQuerySyntax($tablename, $query);

  /**
   * prepareAndExecuteQuery
   * 
   * @param string $query
   * @param array  $params
   *
   * @return void
   */
  public function prepareAndExecuteQuery($query, array $params = array())
  {
    $stmt = $this->getConnection()->prepare($query);
    foreach ($params as $name => $p)
    {
       $stmt->bindValue($name, $p);
    }
    try
    {
      $ret = $stmt->execute();
    }
    catch (PDOException $e)
    {
      throw new databaseException(sprintf('Error executing query : "%s" (%s)', $sql, $e->getMessage()));
    }
    return $ret;
  }

}
