<?php
interface databaseInterface
{
  public function __construct(PDO $connection);

  public function getConnection();
  public function setConnection(PDO $connection);

  public function disableConstraints();

  public function createTableFromCriteria(Criteria $criteria, $name, $temporary = true);
  public function prepareAndExecuteQuery($query, array $params = array());

  public function truncateTable($name);
  public function loadData($tablename, $filename);

  public function updateWithJoin($table, $alias, $update, $from, $where);
}
