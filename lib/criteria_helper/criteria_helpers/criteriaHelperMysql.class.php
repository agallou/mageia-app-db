<?php

class criteriaHelperMysql implements criteriaHelperInterface
{

  /**
   * splitPart
   * 
   * @param string $text
   * @param string $delimiter
   * @param string $count
   *
   * @return void
   */
  public function splitPart($text, $delimiter, $count)
  {
    //TODO implement this !
  }

  /**
   * createTableFromCriteria 
   * 
   * @param Criteria $criteria 
   * @param string   $tablename 
   * @param bool     $temporary 
   *
   * @return string
   */
  public function createTableFromCriteria(Criteria $criteria, $tablename, $temporary = true)
  {
    $params = array();
    $sql    = BasePeer::createSelectSql($criteria, $params);
    $sql    = sprintf('CREATE TEMPORARY TABLE %s AS %s', $this->getTablename(), $sql);
    return $sql;
  }

}
