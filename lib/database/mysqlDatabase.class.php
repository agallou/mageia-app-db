<?php
class mysqlDatabase extends baseDatabase
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
    return sprintf('CREATE TEMPORARY TABLE %s %s', $tablename, $query);
  }

  /**
   * disableConstraints 
   * 
   * @return databaseInterface
   */
  public function disableConstraints()
  {
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
}
