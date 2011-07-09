<?php
interface databaseInterface
{
  public function __construct(PDO $connection);

  public function getConnection();
  public function setConnection(PDO $connection);

  public function createTableFromCriteria(Criteria $criteria, $name, $temporary = true);
  public function prepareAndExecuteQuery($query, array $params = array());
}
