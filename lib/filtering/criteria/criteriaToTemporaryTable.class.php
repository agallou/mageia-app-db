<?php
class criteriaToTemporaryTable
{
  protected $connection = null;

  public function __construct(Criteria $criteria, $tablename)
  {
    $this->criteria = $criteria;
    $this->tablename = $tablename;
  }

  public function getConnection()
  {
    if (null === $this->connection)
    {
      throw new sfException('unable to find connection');
    }
    return $this->connection;
  }

  public function setConnection(PDO $connection)
  {
    $this->connection = $connection;
  }

  public function getTablename()
  {
    return $this->tablename;
  }

  public function getField($name)
  {
    return sprintf('%s.%s', $this->getTablename(), $name);
  }

  public function execute()
  {
    $params = array();
    $sql = BasePeer::createSelectSql($this->criteria, $params);
    $sql = sprintf('CREATE TEMPORARY TABLE %s %s', $this->getTablename(), $sql);
    $bindedParams = array();
    foreach ($params as $key => $param)
    {
      $bindedParams[':p' . ($key + 1)] = $param['value'];
    }
    $stmt =  $this->getConnection()->prepare($sql);
    foreach ($bindedParams as $name => $p)
    {
       $stmt->bindValue($name, $p);
    }
    return $stmt->execute();
  }
}
