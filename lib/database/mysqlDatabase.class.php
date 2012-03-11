<?php
class mysqlDatabase extends baseDatabase
{

  /**
   * createTableFromQuerySyntax 
   * 
   * @param string $tablename 
   * @param string $query 
   * @param bool   $temporary
   *
   * @return string
   */
  protected function createTableFromQuerySyntax($tablename, $query, $temporary=true)
  {
    $temporary_sql = $temporary ? 'TEMPORARY' : '';
    return sprintf('CREATE %s TABLE %s %s', $temporary_sql, $tablename, $query);
  }

  /**
   * disableConstraints 
   * 
   * @return databaseInterface
   */
  public function disableConstraints()
  {
    $this->getConnection()->exec('SET FOREIGN_KEY_CHECKS=0;');
    return $this;
  }

  /**
   * truncateTable 
   * 
   * @param mixed $name 
   * @return void
   */
  public function truncateTable($name)
  {
    $query = "TRUNCATE TABLE $name";
    return $this->prepareAndExecuteQuery($query);
  }

  /**
   * loadData 
   * 
   * @param mixed $tablename 
   * @param mixed $filename 
   * @return void
   */
  public function loadData($tablename, $filename)
  {
    $query = "LOAD DATA LOCAL INFILE '$filename' INTO TABLE $tablename";
    $this->prepareAndExecuteQuery($query);

    return $this;
  }
  
  /**
   * update request with join to other tables.
   * 
   * @param string $table table name
   * @param string $alias table alias
   * @param string $update the part that comes after "SET" in a query
   * @param string $from other table(s), comma-separated
   * @param string $where the where part
   * @return bool
   */
  public function updateWithJoin($table, $alias, $update, $from, $where)
  {
    $alias = $alias ? $alias : $table;
    
    $query = <<<EOF
UPDATE $table AS $alias, $from
SET $alias.$update
WHERE $where
EOF;
    return $this->prepareAndExecuteQuery($query);
  }   
}
