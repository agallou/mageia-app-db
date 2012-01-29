<?php
class postgresqlDatabase extends baseDatabase
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
    return sprintf('CREATE %s TABLE %s AS %s', $temporary_sql, $tablename, $query);
  }

  /**
   * disableConstraints 
   * 
   * @return databaseInterface
   */
  public function disableConstraints()
  {
    $this->getConnection()->exec('SET CONSTRAINTS ALL DEFERRED');

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
    $query = "TRUNCATE TABLE $name" . " CASCADE";
    return $this->prepareAndExecuteQuery($query);
  }

  /**
   * loadData 
   * 
   * @param mixed $tablename 
   * @param mixed $filename 
   * @return void
   */
  public function loadData($tablename, $filename, $update_sequence=true)
  {
    $query = "COPY $tablename FROM '$filename'";
    $this->prepareAndExecuteQuery($query);
    
    // Update the sequence
    // FIXME : should be cleaner, using propel methods and all
    if ($update_sequence)
    {
      $query = "SELECT setval('${tablename}_id_seq', max(id)) FROM $tablename";
      $this->prepareAndExecuteQuery($query);
    }
    
    return $this;
  }
  
  /**
   * update request with join to other tables.
   * 
   * @param string $table table name
   * @param string $update the part that comes after "SET" in a query
   * @param string $from other table(s), comma-separated
   * @param string $where the where part
   * @return bool
   */
  public function updateWithJoin($table, $alias, $update, $from, $where)
  {
    $alias = $alias ? $alias : $table;
    
    $query = <<<EOF
UPDATE $table AS $alias
SET $update
FROM $from
WHERE $where
EOF;
    return $this->prepareAndExecuteQuery($query);
  }  


}
