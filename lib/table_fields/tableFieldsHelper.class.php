<?php
class tableFieldsHelper
{
  /**
   * tablename 
   * 
   * @var string
   */
  protected $tablename;

  public function __construct($tablename)
  {
    $this->tablename = $tablename;
  }

  /**
   * getTablename 
   * 
   * @return string
   */
  public function getTablename()
  {
    return $this->tablename;
  }

  /**
   * getField 
   * 
   * @param string $name
   *
   * @return string
   */
  public function getField($name)
  {
    return sprintf('%s.%s', $this->getTablename(), $name);
  }

}
