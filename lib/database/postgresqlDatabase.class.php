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

}
