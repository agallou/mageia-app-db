<?php

class criteriaHelperMysql implements criteriaHelperInterface
{

  /**
   * substringIndex
   * 
   * @param string $text
   * @param string $delimiter
   * @param string $count
   *
   * @return void
   */
  public function substringIndex($text, $delimiter, $count)
  {
    return sprintf('SUBSTRING_INDEX(%s, \'%s\', %s)', $text, $delimiter, $count);
  }

}
