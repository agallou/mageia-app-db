<?php
class postgresqlDatabase extends baseDatabase
{

  /**
   * createTableFromQuerySyntax 
   * 
   * @param string $tablename 
   * @param string $query 
   *
   * @return string
   */
  protected function createTableFromQuerySyntax($tablename, $query)
  {
    return sprintf('CREATE TEMPORARY TABLE %s AS %s', $tablename, $query);
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
  public function loadData($tablename, $filename)
  {
    $query = "COPY $tablename FROM '$filename'";
    $this->prepareAndExecuteQuery($query);
    
    // Update the sequence
    // FIXME : should be cleaner, using propel methods and all
    $query = "SELECT setval('${tablename}_id_seq', max(id)) FROM $tablename";
    $this->prepareAndExecuteQuery($query);

    return $this;
  }

}
